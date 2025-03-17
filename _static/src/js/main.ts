import "../scss/_style.scss";
import Logger from "./components/Logger";
import Mapbox from "./components/Map";
import { Router } from "./components/Router";
// Controllers
import { BaseController } from "./controllers/BaseController";
import { PagesController } from "./controllers/PagesController";

const router = new Router();

router.register({
	Base: BaseController,
	Pages: PagesController,
});

interface ClusteringOption {
	maxCount: number;
	color: string;
	size: number;
}
interface Options {
	containerId: string;
	mapboxKey: string;
	mapOptions: Partial<mapboxgl.MapOptions>;
	geoJsonUrl: string;
	enableClustering: boolean;
	clusteringOptions?: ClusteringOption[];
	customMapOptions?: {
		zoom: boolean;
		fullscreen: boolean;
	};
}

// Update MapConfiguration interface
interface GeoJsonPostsConfig {
	postType: string;
	postCategory?: string;
	latitudeField: string;
	longitudeField: string;
	popupTemplate: string;
	customFields: string[];
}

export interface GeoJSONFeature {
	type: "Feature";
	geometry: {
		type: "Point";
		coordinates: [number, number];
	};
	properties: {
		id?: number;
		title?: string;
		popupContent?: string;
		customFields?: Record<string, string | number | boolean>;
	};
}

export interface GeoJSON {
	type: "FeatureCollection";
	features: GeoJSONFeature[];
}

interface MapConfiguration {
	containerId: string;
	mapboxKey: string;
	mapOptions: {
		style: string;
		center: [number, number];
		zoom: number;
		pitch: number;
		bearing: number;
		interactive: boolean;
	};
	enableClustering: boolean;
	customMapOptions: {
		zoom: boolean;
		fullscreen: boolean;
	};
	geoJsonMode?: "direct" | "posts";
	geoJsonUrl: string;
	geoJsonPosts?: GeoJsonPostsConfig;
	geoJson?: GeoJSON;
	clusteringOptions?: ClusteringOption[];
}

export async function loadGeoJson(config: MapConfiguration): Promise<GeoJSON> {
	try {
		// If geoJsonMode is posts and we have geoJsonPosts config
		if (config.geoJsonMode === "posts" && config.geoJsonPosts) {
			// Use the geoJson directly if it's provided in the config
			if (config.geoJson) {
				Logger.log("Using provided geoJson from config");
				return config.geoJson;
			}

			// Otherwise fetch from URL
			const postsUrl = new URL(config.geoJsonUrl);
			postsUrl.searchParams.append("mode", "posts");
			postsUrl.searchParams.append(
				"post_type",
				config.geoJsonPosts.postType,
			);
			if (config.geoJsonPosts.postCategory) {
				postsUrl.searchParams.append(
					"category",
					config.geoJsonPosts.postCategory,
				);
			}

			Logger.log("Fetching GeoJSON from:", postsUrl.toString());

			const response = await fetch(postsUrl.toString(), {
				headers: {
					Accept: "application/json",
					"Content-Type": "application/json",
				},
			});

			if (!response.ok) {
				const text = await response.text();
				Logger.error(
					"Server response:",
					new Error(
						`HTTP error! status: ${response.status.toString()}, contentType: ${response.headers.get("content-type") ?? "null"}`,
					),
				);
				throw new Error(
					`HTTP error! status: ${response.status.toString()}`,
				);
			}

			const contentType = response.headers.get("content-type");
			if (!contentType?.includes("application/json")) {
				const text = await response.text();
				Logger.error(
					"Invalid content type:",
					new Error(`Expected JSON but got ${contentType ?? "null"}`),
				);
				throw new Error(
					`Expected JSON but got ${contentType ?? "null"}`,
				);
			}

			return (await response.json()) as GeoJSON;
		} else {
			// Use direct GeoJSON data if provided
			if (config.geoJson) {
				Logger.log("Using provided geoJson from config");
				return config.geoJson;
			}

			// Otherwise fetch from URL
			Logger.log("Fetching GeoJSON from:", config.geoJsonUrl);
			const response = await fetch(config.geoJsonUrl);

			if (!response.ok) {
				const text = await response.text();
				const error = new Error(response.statusText);
				(error as Error & { details?: { body: string } }).details = {
					body: text.substring(0, 500),
				};
				Logger.error("Server response:", error);
				throw new Error(
					`HTTP error! status: ${response.status.toString()}`,
				);
			}

			return (await response.json()) as GeoJSON;
		}
	} catch (error) {
		Logger.error(
			"Error loading GeoJSON:",
			error instanceof Error ? error : new Error(String(error)),
		);
		throw error;
	}
}

function generateMap(config: MapConfiguration) {
	// If we have direct GeoJSON data in the config, create a data URL
	const geoJsonUrl = config.geoJson
		? `data:application/json;charset=utf-8,${encodeURIComponent(JSON.stringify(config.geoJson))}`
		: config.geoJsonUrl;

	if (!geoJsonUrl) {
		Logger.error("No GeoJSON URL or data provided in configuration");
		return;
	}

	Mapbox.loadMap(
		config.containerId,
		config.mapboxKey,
		config.mapOptions,
		geoJsonUrl,
		config.enableClustering,
		config.clusteringOptions,
		config.customMapOptions,
	).catch((error: unknown) => {
		Logger.error(
			"Error loading map:",
			error instanceof Error ? error : new Error(String(error)),
		);
	});
}
/**
 * Mapbox.loadMap(http://localhost/test/?mapbox_configuration&map_name=new2)
 */
function parseConfigurationFromUrl(url: string): Promise<MapConfiguration> {
	const fullUrl = new URL(url);
	const mapName = fullUrl.searchParams.get("map_name");

	if (!mapName) {
		throw new Error("Missing map_name parameter in URL");
	}

	Logger.log("Fetching configuration from:", url);

	return fetch(url, {
		method: "GET",
		headers: {
			Accept: "application/json",
			"Content-Type": "application/json",
		},
		mode: "cors",
		credentials: "same-origin",
	}).then(async (response) => {
		const text = await response.text();

		// Detailed logging of the response
		Logger.log("Server Response:", {
			url: response.url,
			status: response.status,
			statusText: response.statusText,
			headers: Object.fromEntries(response.headers.entries()),
			contentType: response.headers.get("content-type"),
			bodyPreview: text.substring(0, 200),
		});

		if (!response.ok) {
			throw new Error(
				`HTTP error! status: ${response.status.toString()}, body: ${text.substring(0, 100)}`,
			);
		}

		try {
			const data = JSON.parse(text) as MapConfiguration;
			Logger.log("Parsed JSON data:", data);
			return data;
		} catch (e) {
			class CustomError extends Error {
				public details?: { receivedData: string };
				constructor(
					message: string,
					details?: { receivedData: string },
				) {
					super(message);
					this.name = "CustomError";
					this.details = details;
				}
			}

			Logger.error(
				"JSON Parse Error:",
				new CustomError(String(e), {
					receivedData: text.substring(0, 200),
				}),
			);
			throw new Error(`Invalid JSON response: ${text.substring(0, 100)}`);
		}
	});
}
/**
 *
 * TODO:
 *
 * 1] Connect it to wordpressData
 * 2] Napojit nastavení mapy na můj plugin -- HOTOVO
 * 3] Fix while clustering it will show markes not only dots
 * 4] Filters in typescript
 *
 * ---
 * *) Custom filetrs
 */

document.addEventListener("DOMContentLoaded", () => {
	Logger.log("----------------------------------");

	parseConfigurationFromUrl(
		"http://localhost/test/?mapbox_configuration&map_name=locations",
	)
		.then((config) => {
			Logger.log("----------------------------------");
			Logger.log("Parsed configuration:", config);
			// Ensure mapOptions is correctly structured
			config.mapOptions = { ...config.mapOptions };
			if (typeof config.mapOptions === "object") {
				config.mapOptions = { ...config.mapOptions };
			}

			generateMap(config);
		})
		.catch((error: unknown) => {
			if (error instanceof Error) {
				Logger.error("Error parsing configuration:", error);
			} else {
				Logger.error(
					"Error parsing configuration:",
					new Error(String(error)),
				);
			}
		});
	Logger.log("----------------------------------");

	// TODO: Generate map instance from URL
	/**  http://localhost/test/?mapbox_configuration&map_name=mapbox_real_test*/
	/**
	 * const config = parseConfigurationFromUrl(
	 * 	"http://localhost/test/?mapbox_configuration&map_name=test",
	 * )
	 * 	.then((config) => {
	 * 		Logger.log("Parsed configuration:", config);
	 * 	})
	 * 	.catch((error: unknown) => {
	 * 		Logger.error("Error parsing configuration:", error as Error);
	 * 	});
	 * Logger.log("Map CONFIG:");
	 * Logger.log(config);
	 */
});

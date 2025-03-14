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
	if (config.geoJsonMode === "posts" && config.geoJsonPosts) {
		// Load from WordPress posts
		const postsUrl = new URL(config.geoJsonUrl);
		postsUrl.searchParams.append("mode", "posts");
		postsUrl.searchParams.append("post_type", config.geoJsonPosts.postType);
		if (config.geoJsonPosts.postCategory) {
			postsUrl.searchParams.append(
				"category",
				config.geoJsonPosts.postCategory,
			);
		}

		try {
			const response = await fetch(postsUrl.toString(), {
				headers: {
					Accept: "application/json",
				},
			});

			if (!response.ok) {
				throw new Error(
					`HTTP error! status: ${response.status.toString()}`,
				);
			}

			return (await response.json()) as GeoJSON;
		} catch (error) {
			Logger.error(
				"Error loading GeoJSON from posts:",
				error instanceof Error ? error : new Error(String(error)),
			);
			throw error;
		}
	} else {
		// Load direct GeoJSON
		try {
			const response = await fetch(config.geoJsonUrl);
			if (!response.ok) {
				throw new Error(
					`HTTP error! status: ${response.status.toString()}`,
				);
			}
			return (await response.json()) as GeoJSON;
		} catch (error) {
			Logger.error(
				"Error loading GeoJSON:",
				error instanceof Error ? error : new Error(String(error)),
			);
			throw error;
		}
	}
}

function generateMap(options: Options) {
	router.run();

	Mapbox.loadMap(
		options.containerId,
		options.mapboxKey,
		options.mapOptions,
		options.geoJsonUrl,
		options.enableClustering,
		options.clusteringOptions?.map((cluster) => ({
			maxCount: cluster.maxCount,
			color: cluster.color,
			size: cluster.size,
		})),
		options.customMapOptions, // Pass customMapOptions here
	).catch((error: unknown) => {
		Logger.error(
			"Error loading map:",
			error instanceof Error ? error : new Error(String(error)),
		);
	});

	/**
	 * Mapbox.loadMap(http://localhost/test/?mapbox_configuration&map_name=new2)
	 */
}

function parseConfigurationFromUrl(url: string): Promise<MapConfiguration> {
	const urlParams = new URLSearchParams(url.split("?")[1]);
	const mapName = urlParams.get("map_name");

	if (!mapName) {
		throw new Error("Missing map_name parameter in URL");
	}

	return fetch(url, {
		method: "GET",
		mode: "cors",
		credentials: "same-origin",
		headers: {
			"Content-Type": "application/json",
		},
	})
		.then((response) => {
			if (!response.ok) {
				throw new Error(
					`HTTP error! status: ${response.status.toString()}`,
				);
			}
			return response.json();
		})
		.then((data: MapConfiguration) => data);
}
/**
 *
 * TODO:
 *
 * 1] Connect it to wordpressData
 * 2] Napojit nastavení mapy na můj plugin
 * 3] Fix while clustering it will show markes not only dots
 * 4] Filters in typescript
 *
 * ---
 * *) Custom filetrs
 */

document.addEventListener("DOMContentLoaded", () => {
	// Generate map instance from code settings
	/**
	 * generateMap({
	 * 	containerId: "mapContainer",
	 * 	mapboxKey:
	 * 		"pk.eyJ1Ijoib3ZhbmV0LW1hcCIsImEiOiJjbDVtYjB4ZHkwczBwM2RvNGZ4Nmh1MDhtIn0.ixRzP7HDbiFv0kgxQVPzgg",
	 * 	mapOptions: {
	 * 		style: "mapbox://styles/mapbox/dark-v11",
	 * 		center: [18.2951, 49.835],
	 * 		zoom: 14,
	 * 		pitch: 45,
	 * 		bearing: 0,
	 * 		interactive: true, // Enabled dragging
	 * 	},
	 * 	geoJsonUrl: "/map.geojson",
	 * 	enableClustering: true,
	 * 	clusteringOptions: [
	 * 		{ maxCount: 2, color: "#4287f5", size: 25 },
	 * 		{ maxCount: 5, color: "#44a637", size: 25 },
	 * 		{ maxCount: 12, color: "#4f328c", size: 25 },
	 * 	],
	 * 	customMapOptions: {
	 * 		zoom: true, // Show +/- icons for zoom and compass
	 * 		fullscreen: true, // Show fullscreen options
	 * 	},
	 * });
	 */
	// localhost/test.json
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

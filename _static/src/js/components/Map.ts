import mapboxgl, { Map as MapboxMap } from "mapbox-gl";
import Logger from "./Logger";

// Define types for GeoJSON structure
interface GeoJSONFeature {
	type: "Feature";
	geometry: {
		type: "Point";
		coordinates: [number, number]; // Longitude, Latitude
	};
	properties: {
		popupText?: string; // Optional popup text
	};
}

interface GeoJSON {
	type: "FeatureCollection";
	features: GeoJSONFeature[];
}

class Mapbox {
	private mapInstance: MapboxMap | null = null;
	private readonly mapboxKey =
		"pk.eyJ1Ijoib3ZhbmV0LW1hcCIsImEiOiJjbDVtYjB4ZHkwczBwM2RvNGZ4Nmh1MDhtIn0.ixRzP7HDbiFv0kgxQVPzgg";

	constructor() {
		mapboxgl.accessToken = this.mapboxKey;
	}

	public async loadMap(
		containerId: string,
		options: Partial<mapboxgl.MapOptions> = {},
		geoJsonUrl: string,
	): Promise<void> {
		if (this.mapInstance) {
			Logger.log(
				"Map instance already exists. Destroying previous instance...",
			);
			this.mapInstance.remove();
		}

		const defaultOptions: mapboxgl.MapOptions = {
			container: containerId,
			style: "mapbox://styles/mapbox/streets-v11",
			center: [18.2924, 49.8345],
			zoom: 12,
		};

		try {
			this.mapInstance = new mapboxgl.Map({
				...defaultOptions,
				...options,
			});

			await new Promise<void>((resolve) => {
				if (this.mapInstance) {
					this.mapInstance.on("load", () => {
						resolve();
					});
				} else {
					Logger.error(
						"Map instance is null when attempting to load.",
					);
					resolve();
				}
			});

			await this.loadGeoJSONData(geoJsonUrl);
		} catch (error: unknown) {
			Logger.error(
				"Error loading the map:",
				error instanceof Error ? error : new Error("Unknown error"),
			);
		}
	}

	public async loadGeoJSONData(geoJsonUrl: string): Promise<void> {
		if (!this.mapInstance) {
			Logger.error(
				"Cannot load GeoJSON: Map instance is not initialized.",
			);
			return;
		}

		try {
			const response = await fetch(geoJsonUrl);

			if (!response.ok) {
				throw new Error(
					`Failed to fetch GeoJSON file: ${response.statusText}`,
				);
			}

			const geojsonData: GeoJSON = (await response.json()) as GeoJSON;
			this.addMarkersFromGeoJSON(geojsonData);
		} catch (error: unknown) {
			Logger.error(
				"Error loading GeoJSON data:",
				error instanceof Error ? error : new Error(String(error)),
			);
		}
	}
	public addMarkersFromGeoJSON(geojson: GeoJSON): void {
		if (!this.mapInstance) {
			Logger.error(
				"Cannot add markers: Map instance is not initialized.",
			);
			return;
		}

		geojson.features.forEach((feature) => {
			const { coordinates } = feature.geometry;
			const { popupText } = feature.properties;

			const markerIcon =
				"http://localhost/nove_projekty/fajnovysport/_static/src/img/custom_marker.png";
			const markerElement = document.createElement("div");
			markerElement.className = "custom-marker";
			markerElement.style.backgroundImage = `url(${markerIcon})`;
			markerElement.style.width = "30px";
			markerElement.style.height = "50px";
			markerElement.style.backgroundSize = "cover";

			if (this.mapInstance) {
				const marker = new mapboxgl.Marker(markerElement)
					.setLngLat(coordinates)
					.addTo(this.mapInstance);

				if (popupText) {
					const popup = new mapboxgl.Popup({ offset: 25 }).setText(
						popupText,
					);
					marker.setPopup(popup);
				}
			}
		});
	}
}

export default new Mapbox();

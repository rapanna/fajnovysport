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
	custom_markers?: Record<string, string>; // Add this line
}

class Mapbox {
	private mapInstance: MapboxMap | null = null;

	public async loadMap(
		containerId: string,
		mapboxKey: string,
		options: Partial<mapboxgl.MapOptions> = {},
		geoJsonUrl: string,
		enableClustering: boolean,
	): Promise<void> {
		if (this.mapInstance) {
			Logger.log(
				"Map instance already exists. Destroying previous instance...",
			);
			this.mapInstance.remove();
		}

		mapboxgl.accessToken = mapboxKey;

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

			await this.loadGeoJSONData(geoJsonUrl, enableClustering);
		} catch (error: unknown) {
			Logger.error(
				"Error loading the map:",
				error instanceof Error ? error : new Error("Unknown error"),
			);
		}
	}

	public async loadGeoJSONData(
		geoJsonUrl: string,
		enableClustering: boolean,
	): Promise<void> {
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

			const geojsonData = (await response.json()) as GeoJSON;
			const sourceId = "places";

			if (this.mapInstance.getSource(sourceId)) {
				this.mapInstance.removeSource(sourceId);
			}

			this.mapInstance.addSource(sourceId, {
				type: "geojson",
				data: geojsonData,
				cluster: enableClustering,
				clusterMaxZoom: 14,
				clusterRadius: 50,
			});

			["clusters", "cluster-count", "unclustered-point"].forEach(
				(layer) => {
					if (this.mapInstance?.getLayer(layer)) {
						this.mapInstance.removeLayer(layer);
					}
				},
			);

			// ✅ Ensure cluster layers are added first
			if (enableClustering) {
				this.mapInstance.addLayer({
					id: "clusters",
					type: "circle",
					source: sourceId,
					filter: ["has", "point_count"],
					paint: {
						"circle-color": [
							"step",
							["get", "point_count"],
							"#3f83cc",
							3,
							"#d1c51f",
							5,
							"#1f993f",
						],
						"circle-radius": [
							"step",
							["get", "point_count"],
							15,
							10,
							20,
							50,
							30,
						],
					},
				});

				this.mapInstance.addLayer({
					id: "cluster-count",
					type: "symbol",
					source: sourceId,
					filter: ["has", "point_count"],
					layout: {
						"text-field": "{point_count_abbreviated}",
						"text-font": [
							"DIN Offc Pro Medium",
							"Arial Unicode MS Bold",
						],
						"text-size": 12,
					},
				});
			}

			// ✅ Unclustered points should be added *only* if clustering is enabled
			this.mapInstance.addLayer({
				id: "unclustered-point",
				type: "circle",
				source: sourceId,
				filter: ["!", ["has", "point_count"]], // Show markers only when not in cluster
				layout: {
					"icon-image": ["get", "markerStyle"],
					"icon-size": 5,
				},
			});

			// ✅ Hide or show clusters based on zoom
			this.mapInstance.on("zoomend", () => {
				const zoom = this.mapInstance?.getZoom();
				if (zoom !== undefined) {
					const showMarkers = zoom >= 14;

					if (this.mapInstance?.getLayer("clusters")) {
						this.mapInstance.setLayoutProperty(
							"clusters",
							"visibility",
							showMarkers ? "none" : "visible",
						);
					}

					if (this.mapInstance?.getLayer("cluster-count")) {
						this.mapInstance.setLayoutProperty(
							"cluster-count",
							"visibility",
							showMarkers ? "none" : "visible",
						);
					}

					if (this.mapInstance?.getLayer("unclustered-point")) {
						this.mapInstance.setLayoutProperty(
							"unclustered-point",
							"visibility",
							showMarkers ? "visible" : "none",
						);
					} else {
						Logger.error("unclustered-point layer is missing!");
					}
				}
			});

			// ✅ Expand cluster on click
			if (enableClustering) {
				this.mapInstance.on("click", "clusters", (event) => {
					const features = this.mapInstance?.queryRenderedFeatures(
						event.point,
						{
							layers: ["clusters"],
						},
					);
					if (!features || features.length === 0) {
						return;
					}

					const clusterId = features[0].properties
						?.cluster_id as number;
					const source = this.mapInstance?.getSource(
						sourceId,
					) as mapboxgl.GeoJSONSource | null;

					source?.getClusterExpansionZoom(clusterId, (err, zoom) => {
						if (err) {
							return;
						}
						if (
							features[0].geometry.type === "Point" &&
							zoom !== null
						) {
							this.mapInstance?.easeTo({
								center: features[0].geometry.coordinates as [
									number,
									number,
								],
								zoom,
							});
						}
					});
				});
			}

			// 🔄 Ensure the correct initial visibility state
			const initialZoom = this.mapInstance.getZoom();
			const showMarkers = initialZoom >= 14;

			if (enableClustering) {
				this.mapInstance.setLayoutProperty(
					"clusters",
					"visibility",
					showMarkers ? "none" : "visible",
				);
				this.mapInstance.setLayoutProperty(
					"cluster-count",
					"visibility",
					showMarkers ? "none" : "visible",
				);
			}

			this.mapInstance.setLayoutProperty(
				"unclustered-point",
				"visibility",
				showMarkers ? "visible" : "none",
			);

			// ✅ Ensure markers are added only when clustering is disabled
			if (!enableClustering) {
				this.addMarkersFromGeoJSON(geojsonData);
			}
		} catch (error) {
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

		interface GeoJSONWithCustomMarkers {
			custom_markers: Record<string, string>;
			features: GeoJSONFeature[];
		}

		const { custom_markers, features } =
			geojson as unknown as GeoJSONWithCustomMarkers;

		features.forEach((feature: GeoJSONFeature) => {
			const { coordinates } = feature.geometry;
			const { popupText, markerStyle } = feature.properties as {
				popupText?: string;
				markerStyle: string;
			};

			// Get the correct marker icon from the custom_markers object
			const markerIcon =
				custom_markers[markerStyle] || custom_markers.red;

			// Create a custom marker element
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

				// Set popup with text when clicked
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

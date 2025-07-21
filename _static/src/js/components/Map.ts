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
		cluster?: boolean; // Indicates if the feature is a cluster
		cluster_id?: number; // Optional cluster ID for clustering
	};
}

interface GeoJSON {
	type: "FeatureCollection";
	features: GeoJSONFeature[];
	custom_markers?: Record<string, string>;
}

interface GeoJSONWithCustomMarkers extends GeoJSON {
	custom_markers: Record<string, string>;
}

interface ClusteringOption {
	maxCount: number;
	color: string;
	size: number;
}

class Mapbox {
	private mapInstance: MapboxMap | null = null;

	// Method to clear existing map data
	private clearExistingMapData(sourceId: string): void {
		if (this.mapInstance) {
			// Remove layers associated with the source
			const layers = this.mapInstance.getStyle()?.layers ?? [];
			layers.forEach((layer) => {
				if (layer.source === sourceId) {
					this.mapInstance?.removeLayer(layer.id);
				}
			});

			// Remove the source
			if (this.mapInstance.getSource(sourceId)) {
				this.mapInstance.removeSource(sourceId);
			}
			try {
				// Remove layers associated with the source
				const layers = this.mapInstance.getStyle()?.layers ?? [];
				layers.forEach((layer) => {
					if (layer.source === sourceId) {
						this.mapInstance?.removeLayer(layer.id);
					}
				});

				// Remove the source
				if (this.mapInstance.getSource(sourceId)) {
					this.mapInstance.removeSource(sourceId);
				}
			} catch (error) {
				Logger.error(
					"Error processing GeoJSON data:",
					error instanceof Error ? error : new Error(String(error)),
				);
			}
		}
	}

	public async loadMap(
		containerId: string,
		mapboxKey: string,
		options: Partial<mapboxgl.MapOptions> = {},
		geoJsonUrl: string,
		enableClustering: boolean,
		clusteringOptions?: ClusteringOption[],
		customMapOptions?: {
			zoom: boolean;
			fullscreen: boolean;
		},
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

			this.addMapControls(customMapOptions);

			// Check if geoJsonUrl is provided and not empty
			if (!geoJsonUrl) {
				Logger.error("No GeoJSON URL provided");
				return;
			}

			// Logger.log("Loading GeoJSON from URL:", geoJsonUrl);
			await this.loadGeoJSONData(
				geoJsonUrl,
				enableClustering,
				clusteringOptions,
			);
		} catch (error: unknown) {
			Logger.error(
				"Error loading the map:",
				error instanceof Error ? error : new Error("Unknown error"),
			);
		}
	}

	// Function to add custom controls
	private addMapControls(customMapOptions?: {
		zoom: boolean;
		fullscreen: boolean;
	}): void {
		if (this.mapInstance) {
			// Zoom Control (including +/- icons)
			if (customMapOptions?.zoom) {
				this.mapInstance.addControl(
					new mapboxgl.NavigationControl(),
					"top-right",
				);
			}

			// Fullscreen Control
			if (customMapOptions?.fullscreen) {
				this.mapInstance.addControl(
					new mapboxgl.FullscreenControl(),
					"top-right",
				);
			}
		}
	}

	public async loadGeoJSONData(
		geoJsonUrl: string,
		enableClustering: boolean,
		clusteringOptions?: ClusteringOption[],
	): Promise<void> {
		if (!this.mapInstance) {
			Logger.error(
				"Cannot load GeoJSON: Map instance is not initialized.",
			);
			return;
		}

		try {
			// Handle both URL and direct data
			let geojsonData: GeoJSON;
			if (geoJsonUrl.startsWith("data:")) {
				// Parse the data URL
				const decodedData = decodeURIComponent(
					geoJsonUrl.split(",")[1],
				);
				geojsonData = JSON.parse(decodedData) as GeoJSON;
			} else {
				const response = await fetch(geoJsonUrl);
				if (!response.ok) {
					throw new Error(
						`Failed to fetch GeoJSON file: ${response.statusText}`,
					);
				}
				geojsonData = (await response.json()) as GeoJSON;
			}

			const sourceId = "places";

			// Remove previous source, layers, and markers
			this.clearExistingMapData(sourceId);

			// Add GeoJSON source
			this.mapInstance.addSource(sourceId, {
				type: "geojson",
				data: geojsonData,
				cluster: enableClustering,
				clusterMaxZoom: 14,
				clusterRadius: 50,
			});

			if (enableClustering) {
				// Add cluster layers
				this.mapInstance.addLayer({
					id: "clusters",
					type: "circle",
					source: sourceId,
					filter: ["has", "point_count"],
					paint: {
						"circle-color": "#3f83cc",
						"circle-radius": 20,
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

				// Add click handler for clusters
				this.mapInstance.on("click", "clusters", (e) => {
					const features = this.mapInstance?.queryRenderedFeatures(
						e.point,
						{
							layers: ["clusters"],
						},
					);
					if (!features || features.length === 0) {
						return;
					}

					const clusterId = (
						features[0].properties as { cluster_id: number }
					).cluster_id;
					if (!this.mapInstance) {
						Logger.error("Map instance is not initialized.");
						return;
					}
					const source = this.mapInstance.getSource(sourceId);
					if (!source || source.type !== "geojson") {
						Logger.error("Failed to retrieve GeoJSON source.");
						return;
					}

					source.getClusterExpansionZoom(clusterId, (err, zoom) => {
						if (err || features[0].geometry.type !== "Point") {
							return;
						}
						this.mapInstance?.easeTo({
							center: features[0].geometry.coordinates as [
								number,
								number,
							],
							zoom:
								typeof zoom === "number" && !isNaN(zoom)
									? zoom
									: 14,
						});
					});
				});

				// Change cursor on cluster hover
				this.mapInstance.on("mouseenter", "clusters", () => {
					if (this.mapInstance) {
						this.mapInstance.getCanvas().style.cursor = "pointer";
					}
				});

				this.mapInstance.on("mouseleave", "clusters", () => {
					if (this.mapInstance) {
						this.mapInstance.getCanvas().style.cursor = "";
					}
				});
			}
		} catch (error) {
			Logger.error(
				"Error adding cluster layers:",
				error instanceof Error ? error : new Error(String(error)),
			);
		} // Closing the try block

		// Add markers for non-clustered points
		try {
			// Initial marker creation
			this.addMarkersFromGeoJSON(geojsonData);
			// Update markers on map movement
			const geojsonDataCopy = geojsonData; // Fix: declare geojsonDataCopy for use in handler
			this.mapInstance.on("moveend", () => {
				// Clear existing markers
				const existingMarkers =
					document.querySelectorAll(".custom-marker");
				existingMarkers.forEach((marker) => {
					marker.remove();
				});

				// Get current visible features
				const bounds = this.mapInstance?.getBounds();
				const features =
					bounds && this.mapInstance
						? this.mapInstance.queryRenderedFeatures(
								[
									this.mapInstance.project([
										bounds.getWest(),
										bounds.getSouth(),
									]),
									this.mapInstance.project([
										bounds.getEast(),
										bounds.getNorth(),
									]),
								],
								{ layers: ["clusters"] },
							)
						: [];
				const visibleClusters = new Set(
					features.map(
						(f) =>
							(f.properties as { cluster_id?: number })
								.cluster_id,
					),
				);

				// Add markers for non-clustered points
				geojsonDataCopy.features.forEach((feature) => {
					const bounds = this.mapInstance?.getBounds();
					const [lng, lat] = feature.geometry.coordinates;

					// Check if point is within current bounds and not in a cluster
					if (
						bounds?.contains([lng, lat]) &&
						!visibleClusters.has(feature.properties?.cluster_id)
					) {
						this.addMarkerToMap(feature);
					}
				});
			});
		} catch (error: Error | null | undefined) {
			Logger.error(
				"Error processing GeoJSON data:",
				error instanceof Error ? error : new Error(String(error)),
			);
		}
	}

	// Function to add a single marker to the map
	public addMarkerToMap(feature: GeoJSONFeature): void {
		if (!this.mapInstance) {
			Logger.error("Map instance is not initialized.");
			return;
		}

		const { coordinates } = feature.geometry;
		const { popupText } = feature.properties;

		// Create a custom marker element
		const markerElement = document.createElement("div");
		markerElement.className = "custom-marker";

		// Add marker to the map
		new mapboxgl.Marker(markerElement)
			.setLngLat(coordinates)
			.setPopup(new mapboxgl.Popup().setText(popupText ?? ""))
			.addTo(this.mapInstance);
	}

	// Function to add markers from GeoJSON data
	private addMarkersFromGeoJSON(geojsonData: GeoJSON): void {
		if (!this.mapInstance) {
			Logger.error("Map instance is not initialized.");
			return;
		}

		geojsonData.features.forEach((feature) => {
			this.addMarkerToMap(feature);
		});
	}
}
export default Mapbox;

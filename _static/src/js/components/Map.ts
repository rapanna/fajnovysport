/* eslint-disable @typescript-eslint/strict-boolean-expressions */
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
	custom_markers?: Record<string, string>;
}

interface ClusteringOption {
	maxCount: number;
	color: string;
	size: number;
}
class Mapbox {
	private mapInstance: MapboxMap | null = null;

	public async loadMap(
		containerId: string,
		mapboxKey: string,
		options: Partial<mapboxgl.MapOptions> = {},
		geoJsonUrl: string,
		enableClustering: boolean,
		clusteringOptions?: ClusteringOption[],
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
			const response = await fetch(geoJsonUrl);
			if (!response.ok) {
				throw new Error(
					`Failed to fetch GeoJSON file: ${response.statusText}`,
				);
			}

			const geojsonData = (await response.json()) as GeoJSON;
			Logger.log("Fetched GeoJSON:", geojsonData); // ✅ Debugging: Log fetched data

			const sourceId = "places";

			// ✅ Remove previous source if it exists
			if (this.mapInstance.getSource(sourceId)) {
				this.mapInstance.removeSource(sourceId);
			}

			// ✅ Add GeoJSON source with clustering support
			this.mapInstance.addSource(sourceId, {
				type: "geojson",
				data: geojsonData,
				cluster: enableClustering,
				clusterMaxZoom: 14, // Stop clustering at zoom level 14
				clusterRadius: 50, // Cluster points within this radius (in pixels)
			});

			// ✅ Ensure clusteringOptions has default values
			if (!clusteringOptions || clusteringOptions.length === 0) {
				clusteringOptions = [
					{ maxCount: 3, color: "#3f83cc", size: 25 },
				];
			}

			// ✅ Remove old layers if they exist
			["clusters", "cluster-count", "unclustered-point"].forEach(
				(layer) => {
					if (this.mapInstance?.getLayer(layer)) {
						this.mapInstance.removeLayer(layer);
					}
				},
			);

			if (enableClustering) {
				// ✅ Create dynamic cluster styling
				const clusterColors: (string | number)[] = ["#3f83cc"]; // Default
				const clusterSizes: (string | number)[] = [20]; // Default

				clusteringOptions.forEach(({ maxCount, color, size }) => {
					clusterColors.push(maxCount, color);
					clusterSizes.push(maxCount, size);
				});

				// ✅ Delay layer addition to ensure the source is loaded
				setTimeout(() => {
					// ✅ Add Cluster Layer
					this.mapInstance?.addLayer({
						id: "clusters",
						type: "circle",
						source: sourceId,
						filter: ["has", "point_count"],
						paint: {
							"circle-color": [
								"step",
								["get", "point_count"],
								...clusterColors,
							],
							"circle-radius": [
								"step",
								["get", "point_count"],
								...clusterSizes,
							],
						},
					});

					// ✅ Add Cluster Count Labels
					this.mapInstance?.addLayer({
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

					// ✅ Add Cluster Expansion on Click
					this.mapInstance?.on("click", "clusters", (event) => {
						const features =
							this.mapInstance?.queryRenderedFeatures(
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

						source?.getClusterExpansionZoom(
							clusterId,
							(err, zoom) => {
								if (err) {
									return;
								}

								if (
									features[0].geometry.type === "Point" &&
									zoom !== null
								) {
									this.mapInstance?.easeTo({
										center: features[0].geometry
											.coordinates as [number, number],
										zoom,
									});
								}
							},
						);
					});
				}, 500);
			}

			// ✅ Add Unclustered Points Layer (Markers)
			this.mapInstance.addLayer({
				id: "unclustered-point",
				type: "circle",
				source: sourceId,
				filter: ["!", ["has", "point_count"]], // Only show when NOT clustered
				paint: {
					"circle-color": "#ff0000", // Example color (adjust if needed)
					"circle-radius": 6,
					"circle-stroke-width": 2,
					"circle-stroke-color": "#ffffff",
				},
			});

			// ✅ If clustering is disabled, add individual markers instead
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

import mapboxgl, { Map as MapboxMap } from "mapbox-gl";
import Logger from "./Logger";

class Mapbox {
	private mapInstance: MapboxMap | null = null;
	private mapboxKey =
		"pk.eyJ1Ijoib3ZhbmV0LW1hcCIsImEiOiJjbDVtYjB4ZHkwczBwM2RvNGZ4Nmh1MDhtIn0.ixRzP7HDbiFv0kgxQVPzgg";
	private templateData: Record<string, unknown> | null = null;

	constructor() {
		this.loadTemplateData();
		if (this.mapboxKey) {
			mapboxgl.accessToken = this.mapboxKey;
		} else {
			Logger.error("Mapbox key is not set.");
		}
	}

	public setKey(key: string): void {
		if (!key) {
			Logger.error("Invalid Mapbox API key.");
			return;
		}
		this.mapboxKey = key;
		mapboxgl.accessToken = key;
	}

	public loadMap(
		containerId: string,
		options: Partial<mapboxgl.MapOptions> = {},
	): void {
		if (!this.mapboxKey) {
			Logger.error("Cannot load map: Mapbox key is missing.");
			return;
		}
		if (this.mapInstance) {
			Logger.log(
				"Map instance already exists. Destroying previous instance...",
			);
			this.mapInstance.remove();
		}

		const defaultOptions: mapboxgl.MapOptions = {
			container: containerId,
			style: "mapbox://styles/mapbox/streets-v11",
			center: [0, 0],
			zoom: 2,
		};

		try {
			// eslint-disable-next-line @typescript-eslint/no-unsafe-assignment
			this.mapInstance = new mapboxgl.Map({
				...defaultOptions,
				...options,
			});
		} catch (error) {
			if (error instanceof Error) {
				Logger.error("Error loading the map", error);
			} else {
				Logger.error("Unknown error map:", error as Error);
			}
		}
	}

	private loadTemplateData(): void {
		const script = document.querySelector(
			'script[type="application/json"][data-template="src/templates/404.twig"]',
		);
		if (script) {
			try {
				// todo better type
				this.templateData = JSON.parse(script.textContent || "{}");
			} catch (error) {
				Logger.error(
					"Failed to parse template data:",
					error instanceof Error ? error : (error as Error),
				);
			}
		}
	}

	public getMapInstance(): MapboxMap | null {
		return this.mapInstance;
	}
}

export default new Mapbox();

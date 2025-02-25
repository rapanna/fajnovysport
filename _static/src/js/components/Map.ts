import mapboxgl from "mapbox-gl";

class Mapbox {
	private mapInstance: mapboxgl.Map | null = null;
	private mapboxKey: string =
		"pk.eyJ1Ijoib3ZhbmV0LW1hcCIsImEiOiJjbDVtYjB4ZHkwczBwM2RvNGZ4Nmh1MDhtIn0.ixRzP7HDbiFv0kgxQVPzgg";
	private templateData: Record<string, unknown> | null = null;

	constructor() {
		this.loadTemplateData();
		if (this.mapboxKey) {
			mapboxgl.accessToken = this.mapboxKey;
		} else {
			console.error("Mapbox key is not set.");
		}
	}

	public setKey(key: string): void {
		if (!key) {
			console.error("Invalid Mapbox API key.");
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
			console.error("Cannot load map: Mapbox key is missing.");
			return;
		}
		if (this.mapInstance) {
			console.warn(
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
			this.mapInstance = new mapboxgl.Map({
				...defaultOptions,
				...options,
			});
		} catch (error) {
			console.error(
				"Error loading the map:",
				error instanceof Error ? error.message : error,
			);
		}
	}

	private loadTemplateData(): void {
		const script = document.querySelector(
			'script[type="application/json"][data-template="src/templates/404.twig"]',
		);
		if (script) {
			try {
				this.templateData = JSON.parse(script.textContent || "{}");
			} catch (error) {
				console.error(
					"Failed to parse template data:",
					error instanceof Error ? error.message : error,
				);
			}
		}
	}

	public getMapInstance(): mapboxgl.Map | null {
		return this.mapInstance;
	}
}

export default new Mapbox();

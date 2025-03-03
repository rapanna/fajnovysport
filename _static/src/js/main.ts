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

function initApp(
	containerId: string,
	mapboxKey: string,
	mapOptions: Partial<mapboxgl.MapOptions>,
	geoJsonUrl: string,
	enableClustering: boolean, // New parameter
) {
	router.run();

	Mapbox.loadMap(
		containerId,
		mapboxKey,
		mapOptions,
		geoJsonUrl,
		enableClustering,
	).catch((error: unknown) => {
		Logger.error(
			"Error loading map:",
			error instanceof Error ? error : new Error(String(error)),
		);
	});
}

document.addEventListener("DOMContentLoaded", () => {
	initApp(
		"mapContainer",
		"pk.eyJ1Ijoib3ZhbmV0LW1hcCIsImEiOiJjbDVtYjB4ZHkwczBwM2RvNGZ4Nmh1MDhtIn0.ixRzP7HDbiFv0kgxQVPzgg",
		{
			style: "mapbox://styles/mapbox/dark-v11",
			center: [18.2951, 49.835],
			zoom: 14,
			pitch: 45,
			bearing: 0,
		},
		"/map.geojson",
		true, // Enable clustering
	);
});

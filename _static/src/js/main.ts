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

function generateMap(options: {
	containerId: string;
	mapboxKey: string;
	mapOptions: Partial<mapboxgl.MapOptions>;
	geoJsonUrl: string;
	enableClustering: boolean;
}) {
	router.run();

	Mapbox.loadMap(
		options.containerId,
		options.mapboxKey,
		options.mapOptions,
		options.geoJsonUrl,
		options.enableClustering,
	).catch((error: unknown) => {
		Logger.error(
			"Error loading map:",
			error instanceof Error ? error : new Error(String(error)),
		);
	});
}
/**
 *
 * TODO:
 *
 * 1] Add clustering options:
 *
 * clusteringOptions: {
 *		clusters: {
 *			{
 *            maxCount: 10,
 *            color: #3f83cc,
 * 			  size: 25
 *			},
 *			{
 *            maxCount: 25,
 *            color: #d1c51f,
 * 			  size: 25
 *			},
 *			{
 *            maxCount: 50,
 *            color: #1f993f,
 * 			  size: 25
 *			}
 * }
 *
 * 2] Fix while clustering it will show markes not only dots
 * 3] Add options to function generate map to have there +-
 */

document.addEventListener("DOMContentLoaded", () => {
	generateMap({
		containerId: "mapContainer",
		mapboxKey:
			"pk.eyJ1Ijoib3ZhbmV0LW1hcCIsImEiOiJjbDVtYjB4ZHkwczBwM2RvNGZ4Nmh1MDhtIn0.ixRzP7HDbiFv0kgxQVPzgg",
		mapOptions: {
			style: "mapbox://styles/mapbox/dark-v11",
			center: [18.2951, 49.835],
			zoom: 14,
			pitch: 0,
			bearing: 0,
			interactive: true /* enabled dragging */,
		},
		geoJsonUrl: "/map.geojson",
		enableClustering: true,
	});
});

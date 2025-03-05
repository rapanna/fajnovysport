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
	// ...
	containerId: string;
	mapboxKey: string;
	mapOptions: Partial<mapboxgl.MapOptions>;
	geoJsonUrl: string;
	enableClustering: boolean;
	clusteringOptions?: ClusteringOption[];
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
 * 2] Fix while clustering it will show markes not only dots
 * 3] Add options to function generate map to have there +-
 * 4] Connect it to wordpressData
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
		enableClustering: false,
		clusteringOptions: [
			{ maxCount: 2, color: "#4287f5", size: 25 },
			{ maxCount: 5, color: "#44a637", size: 25 },
			{ maxCount: 12, color: "#4f328c", size: 25 },
		],
	});
});

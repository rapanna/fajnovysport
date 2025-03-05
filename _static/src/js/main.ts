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
}

/**
 *
 * TODO:
 *
 * 1] Connect it to wordpressData
 * 2] Fix while clustering it will show markes not only dots
 * 3] Nastavení mapy dát do administrace - vytvořit tam něco jako repeater, který tam bude moc tvrořit něco jako více typů map třeba pro více stránek
 *
 * ---
 * *) Custom filetrs
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
			pitch: 45,
			bearing: 0,
			interactive: true, // Enabled dragging
		},
		geoJsonUrl: "/map.geojson",
		enableClustering: true,
		clusteringOptions: [
			{ maxCount: 2, color: "#4287f5", size: 25 },
			{ maxCount: 5, color: "#44a637", size: 25 },
			{ maxCount: 12, color: "#4f328c", size: 25 },
		],
		customMapOptions: {
			zoom: true, // Show +/- icons for zoom and compass
			fullscreen: true, // Show fullscreen options
		},
	});
});

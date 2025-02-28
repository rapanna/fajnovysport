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

function initApp() {
	router.run();

	Mapbox.loadMap("mapContainer", {
		style: "mapbox://styles/mapbox/light-v11", // Custom light mode style
		center: [18.2951, 49.835], // Custom center
		zoom: 14, // Custom zoom level
		pitch: 45, // Tilted view
		bearing: 30, // Rotated view
	})
		.then(() => {
			Logger.error("Map loaded with custom settings!");
		})
		.catch((error: unknown) => {
			Logger.error(
				"Error loading map:",
				error instanceof Error ? error : new Error(String(error)),
			);
		});
}
if (document.readyState === "loading") {
	document.addEventListener("DOMContentLoaded", () => {
		initApp();
	});
} else {
	initApp();
}

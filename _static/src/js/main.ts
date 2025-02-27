import "../scss/_style.scss";
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

	Mapbox.loadMap("mapContainer", {})
		.then(() => {
			// You can put code here that should run after the map is loaded
		})
		.catch((error: unknown) => {
			// Handle the error here
		});
}
if (document.readyState === "loading") {
	document.addEventListener("DOMContentLoaded", () => {
		initApp();
	});
} else {
	initApp();
}

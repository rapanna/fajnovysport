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

if (document.readyState === "loading") {
	document.addEventListener("DOMContentLoaded", () => {
		router.run();
	});
} else {
	router.run();
}
document.addEventListener("DOMContentLoaded", () => {
	Mapbox.loadMap("mapContainer", {
		center: [12.4964, 41.9028], // Example: Rome, Italy
		zoom: 10,
		style: "mapbox://styles/mapbox/streets-v11",
	});
});

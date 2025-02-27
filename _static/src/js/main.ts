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

	Mapbox.loadMap("mapContainer", {
		center: [18.2820444, 49.84006444], // Ostrava coordinates
		zoom: 10, // Zoom level
	});

	// Add markers at specified coordinates
	Mapbox.addMarker(18.2920444, 49.84006444, "City Center");
	Mapbox.addMarker(18.292884, 49.833855, "Silesian Ostrava");
	Mapbox.addMarker(18.292489, 49.806401, "Poruba");
	Mapbox.addMarker(18.291004, 49.77905, "Vítkovice");
	Mapbox.addMarker(18.289343, 49.834928, "Karolina");
	Mapbox.addMarker(18.318753, 49.839224, "Hranice");
	Mapbox.addMarker(18.354577, 49.798871, "Klimkovice");
	Mapbox.addMarker(18.292509, 49.832877, "Zábřeh");
}

if (document.readyState === "loading") {
	document.addEventListener("DOMContentLoaded", initApp);
} else {
	initApp();
}

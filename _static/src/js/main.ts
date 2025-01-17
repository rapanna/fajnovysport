import "../scss/_style.scss";
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

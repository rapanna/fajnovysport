import Swiper from "../components/Swiper";
import { BaseController } from "./BaseController";

export class PagesController extends BaseController {
	public renderHomepage(): void {
		// TODO
		console.log("Initialized Homepage");
		void Swiper.init();
	}

	public renderContact(): void {
		// TODO
		console.log("Initialized Contact");
	}
}

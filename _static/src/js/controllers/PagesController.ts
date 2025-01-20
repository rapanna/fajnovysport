import Swiper from "../components/Swiper";
import { BaseController } from "./BaseController";

export class PagesController extends BaseController {
	public renderHomepage(): void {
		void Swiper.init();
	}

	public renderContact(): void {
		// TODO
	}
}

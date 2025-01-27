import Swiper from "../components/Swiper";
import { BaseController } from "./BaseController";

export class PagesController extends BaseController {
	public renderHomepage(): void {
		void Swiper.init();
		// TODO
		// eslint-disable-next-line no-console
		console.log("init homepage page");
	}

	public renderContacts(): void {
		// TODO
		// eslint-disable-next-line no-console
		console.log("init contacts page");
	}

	public renderDefault(): void {
		// TODO
		// eslint-disable-next-line no-console
		console.log("init default page");
	}
}

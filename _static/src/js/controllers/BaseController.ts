import Form from "../components/Form";
import Keyboard from "../components/Keyboard";
import Utils from "../components/Utils";

export class BaseController {
	// eslint-disable-next-line @typescript-eslint/no-empty-function
	public beforeRender(): void {}

	public afterRender(): void {
		document.querySelector("html")?.classList.add("after-load");

		Keyboard.init();
		Form.init();
		Utils.calcHeight();
	}
}

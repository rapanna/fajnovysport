export class BaseController {
	// eslint-disable-next-line @typescript-eslint/no-empty-function
	public beforeRender(): void {}

	public afterRender(): void {
		document.querySelector("html")?.classList.add("after-load");
	}
}

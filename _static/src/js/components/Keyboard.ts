class Keyboard {
	public init(): void {
		window.addEventListener("keydown", this.detectFirstTab.bind(this));
		window.addEventListener("keydown", this.handleFirstTab.bind(this));
	}

	private handleFirstTab(event: KeyboardEvent): void {
		if (event.key === "Tab") {
			document.body.classList.add("keyboard");
			window.removeEventListener(
				"keydown",
				this.handleFirstTab.bind(this),
			);
			window.addEventListener(
				"mousedown",
				this.handleMouseDownOnce.bind(this),
			);
		}
	}

	private detectFirstTab(event: KeyboardEvent): void {
		if (event.key === "Tab") {
			document.body.classList.add("keyboard");
			window.removeEventListener(
				"keydown",
				this.detectFirstTab.bind(this),
			);
			window.addEventListener(
				"mousedown",
				this.handleMouseDownOnce.bind(this),
			);
		}
	}

	private handleMouseDownOnce(): void {
		document.body.classList.remove("keyboard");
		window.removeEventListener(
			"mousedown",
			this.handleMouseDownOnce.bind(this),
		);
		window.addEventListener("keydown", this.detectFirstTab.bind(this));
	}
}
export default new Keyboard();

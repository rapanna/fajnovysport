class Utils {
	public calcHeight(): void {
		const windowHeight = ((window.innerWidth / 4) * 294) / 476;

		document.querySelectorAll(".news__item").forEach((element) => {
			(element as HTMLElement).style.height =
				`${windowHeight.toString()}px`;
		});

		window.addEventListener("resize", this.calcHeight.bind(this));
	}
}

export default new Utils();

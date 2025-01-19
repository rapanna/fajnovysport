class Swiper {
	public async init(): Promise<void> {
		const glides = Array.from(
			document.querySelectorAll<HTMLElement>(".js-sliders"),
		);
		if (glides.length > 0) {
			const { default: Glide } = await import("@glidejs/glide");
			for (const glide of glides) {
				new Glide(glide, {
					perView: 1,
					bound: true,
					type: "carousel",
					keyboard: true,
					animationDuration: 300,
					animationTimingFunc: "ease-in-out",
					gap: 20,
				}).mount();
			}
		}
	}
}
export default new Swiper();

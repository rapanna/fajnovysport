class Swiper {
	public async init(): Promise<void> {
		const glides = Array.from(
			document.querySelectorAll<HTMLElement>(".js-sliders"),
		);
		if (glides.length > 0) {
			const {
				default: Glide,
				Controls,
				Autoplay,
			} = await import("@glidejs/glide/dist/glide.modular.esm");
			for (const glide of glides) {
				const slider = new Glide(glide, {
					perView: 1,
					bound: true,
					type: "carousel",
					keyboard: true,
					autoplay: 1000,
					animationDuration: 300,
					animationTimingFunc: "ease-in-out",
					gap: 20,
				}).mount({ Controls, Autoplay });

				const playButton = glide.querySelector(".slider-buttons__play");
				const pauseButton = glide.querySelector(
					".slider-buttons__pause",
				);

				if (playButton && pauseButton) {
					playButton.addEventListener("click", () => {
						slider.play();
						playButton.classList.add("slider-buttons__play--hide");
						pauseButton.classList.remove(
							"slider-buttons__pause--hide",
						);
					});
					pauseButton.addEventListener("click", () => {
						slider.pause();
						playButton.classList.remove(
							"slider-buttons__play--hide",
						);
						pauseButton.classList.add(
							"slider-buttons__pause--hide",
						);
					});
				}
			}
		}
	}
}
export default new Swiper();

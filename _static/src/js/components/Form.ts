class Form {
	public init(): void {
		const buttonElement = document.querySelector(".button");
		buttonElement?.addEventListener("click", this.inputCheck.bind(this));
	}

	private inputCheck(e: Event): void {
		e.preventDefault(); // Prevents form submission or default button behavior

		const alertElement = document.getElementById("error");
		const buttonElement = document.querySelector(".button");
		const inputElement = document.getElementById(
			"search",
		) as HTMLInputElement;

		if (alertElement && buttonElement && inputElement.value) {
			alertElement.innerHTML = ""; // Clears previous messages

			if (inputElement.value === "") {
				const span = document.createElement("span");
				span.textContent =
					"You need to enter a search term before pressing submit";
				alertElement.appendChild(span);
				inputElement.setAttribute("aria-invalid", "true");
				inputElement.focus(); // Sets attribute and returns focus to the input field
			}
		}
	}
}
export default new Form();

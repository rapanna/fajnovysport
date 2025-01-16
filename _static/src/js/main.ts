import "../scss/_style.scss";

const appElement = document.querySelector<HTMLDivElement>("#app");
if (appElement) {
	appElement.innerHTML = `
  <div>
    <a href="https://vite.dev" target="_blank">
    </a>

    <h1>Vite + TypeScript</h1>

  </div>
  `;
}

/* eslint-disable no-undef */
import fs from "node:fs";
import { resolve } from "node:path";
import path from "node:path";
import twig from "@fulcrumsaas/vite-plugin-twig";
import { defineConfig } from "vite";

/**
 * Dynamically generates a list of HTML inputs from the `html` folder.
 * @returns {Record<string, string>}
 */
function getHtmlInputs() {
	const htmlDir = resolve(__dirname, "src");
	const files = fs.readdirSync(htmlDir);
	const htmlFiles = files.filter((file) => file.endsWith(".html"));

	return htmlFiles.reduce((inputs, file) => {
		const name = file.replace(/\.html$/u, "");
		inputs[name] = resolve(htmlDir, file);
		return inputs;
	}, {});
}

export default defineConfig({
	root: path.resolve(__dirname, "src"),
	plugins: [twig()],

	publicDir: "../public",
	build: {
		outDir: "../.build/",
		emptyOutDir: true,
		rollupOptions: {
			input: getHtmlInputs(),
		},
	},
	server: {
		open: "/html/index.html",
	},
	css: {
		preprocessorOptions: {
			scss: {
				additionalData: `@use 'global.scss' as *;`,
			},
		},
	},
});

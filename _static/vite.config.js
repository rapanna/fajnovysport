/* eslint-disable no-undef */
import fs from "node:fs";
import { resolve } from "node:path";
import path from "node:path";
import { defineConfig } from "vite";
import twig from "vite-plugin-twig";

const twigExtensions = {
	trans: (value) => {
		return value;
	},
};
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
	plugins: [
		twig({
			extensions: {
				filters: twigExtensions,
			},
		}),
	],

	publicDir: "../public",
	build: {
		outDir: "../.build/",
		emptyOutDir: true,
		rollupOptions: {
			input: getHtmlInputs(),
			output: {
				assetFileNames: "assets/[name].[ext]",
				entryFileNames: "assets/[name].js",
				chunkFileNames: "assets/[name].js",
			},
		},
	},

	server: {
		open: "/index.html",
	},
	css: {
		preprocessorOptions: {
			scss: {
				additionalData: `@use 'global.scss' as *;`,
			},
		},
	},
});

import { translations } from "./src/templates/translations.js";

const twigExtensions = {
	trans: (value, args) => {
		let translation = translations[value] || `LANG_${value}`;

		if (args && typeof args === "object") {
			Object.keys(args).forEach((key) => {
				translation = translation.replace(`{{ ${key} }}`, args[key]);
			});
		}

		return translation;
	},
};
const config = {
	extensions: {
		filters: twigExtensions,
	},
};

export default config;

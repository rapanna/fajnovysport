import fs from "fs";
import gettextParser from "gettext-parser";

const translateData = gettextParser.po.parse(
	fs.readFileSync("./src/languages/my-theme-cs_CZ.po", {
		encoding: "utf-8",
	}),
	"utf-8",
);

const twigExtensions = {
	trans: (value, args) => {
		const translations = translateData.translations[""];
		let translation = translations[value]?.msgstr[0] || `${value}`;

		if (
			args &&
			Array.isArray(args) &&
			args.length > 0 &&
			typeof args[0] === "object"
		) {
			const [argObj] = args;
			Object.keys(argObj).forEach((key) => {
				if (key !== "_keys") {
					translation = translation.replace(`${key}`, argObj[key]);
				}
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

import { dirname, join } from "node:path";
import { fileURLToPath } from "node:url";
import eslint from "@eslint/js";
import tsPlugin from "@typescript-eslint/eslint-plugin";
import tsParser from "@typescript-eslint/parser";
import prettierConfig from "eslint-config-prettier";

const possibleProblemRules = {
	"array-callback-return": "error",
	"no-constant-binary-expression": "error",
	"no-constructor-return": "error",
	"no-new-native-nonconstructor": "error",
	"no-promise-executor-return": "error",
	"no-self-compare": "error",
	"no-template-curly-in-string": "warn",
	"no-unmodified-loop-condition": "error",
	"no-unreachable-loop": "error",
	"no-unused-private-class-members": "warn",
	"no-unused-vars": [
		"warn",
		{
			argsIgnorePattern: "^_",
			varsIgnorePattern: "^_",
		},
	],
	"no-use-before-define": "error",
	"require-atomic-updates": "error",
};

const suggestionRules = {
	curly: "error",
	eqeqeq: "error",
	"multiline-comment-style": "error",
	"no-alert": "error",
	"no-bitwise": "error",
	"no-console": "error",
	"no-empty-static-block": "error",
	"no-eval": "error",
	"no-extend-native": "error",
	"no-extra-bind": "error",
	"no-extra-label": "error",
	"no-implicit-coercion": "error",
	"no-invalid-this": "error",
	"no-labels": "error",
	"no-loop-func": "error",
	"no-multi-assign": "error",
	"no-multi-str": "error",
	"no-new": "error",
	"no-new-func": "error",
	"no-new-object": "error",
	"no-new-wrappers": "error",
	"no-return-assign": "error",
	"no-sequences": "error",
	"no-unneeded-ternary": "error",
	"no-unused-expressions": "error",
	"no-useless-call": "error",
	"no-useless-computed-key": "error",
	"no-useless-concat": "error",
	"no-useless-rename": "error",
	"no-useless-return": "error",
	"no-var": "error",
	"no-warning-comments": "warn",
	"object-shorthand": "error",
	"prefer-const": "error",
	"prefer-destructuring": "error",
	"prefer-exponentiation-operator": "error",
	"prefer-named-capture-group": "error",
	"prefer-numeric-literals": "error",
	"prefer-object-has-own": "error",
	"prefer-object-spread": "error",
	"prefer-promise-reject-errors": "error",
	"prefer-regex-literals": "error",
	"prefer-rest-params": "error",
	"prefer-spread": "error",
	"prefer-template": "error",
	"require-unicode-regexp": "error",
	"spaced-comment": "error",
	"symbol-description": "error",
};

const tsRules = {
	"@typescript-eslint/consistent-type-exports": "error",
	"@typescript-eslint/explicit-function-return-type": "warn",
	"@typescript-eslint/explicit-member-accessibility": [
		"error",
		{
			accessibility: "explicit",
			overrides: {
				accessors: "off",
				constructors: "off",
				methods: "explicit",
				properties: "explicit",
				parameterProperties: "explicit",
			},
		},
	],
	"@typescript-eslint/unbound-method": "off",
	"@typescript-eslint/no-unsafe-call": "off",
	"@typescript-eslint/no-unsafe-member-access": "off",
	"@typescript-eslint/explicit-module-boundary-types": "error",
	"@typescript-eslint/method-signature-style": ["error", "method"],
	"@typescript-eslint/no-confusing-void-expression": "error",
	"@typescript-eslint/no-import-type-side-effects": "error",
	"@typescript-eslint/no-require-imports": "error",
	"@typescript-eslint/no-unnecessary-qualifier": "error",
	"@typescript-eslint/no-useless-empty-export": "error",
	"@typescript-eslint/parameter-properties": [
		"error",
		{
			prefer: "parameter-property",
		},
	],
	"@typescript-eslint/prefer-readonly": "error",
	"@typescript-eslint/require-array-sort-compare": "error",
	"@typescript-eslint/strict-boolean-expressions": [
		"error",
		{
			allowNullableString: true,
			allowNullableBoolean: true,
		},
	],
	"@typescript-eslint/switch-exhaustiveness-check": "error",
};

const tsExtensionRules = {
	"@typescript-eslint/no-invalid-this": "error",
	"@typescript-eslint/no-loop-func": "error",
	"@typescript-eslint/no-unused-expressions": "error",
	"@typescript-eslint/no-unused-vars": [
		"warn",
		{
			argsIgnorePattern: "^_",
			varsIgnorePattern: "^_",
		},
	],
	"@typescript-eslint/no-use-before-define": "error",
};

const tsOverrideEslintRules =
	tsPlugin.configs["eslint-recommended"].overrides[0].rules;
const tsStrictRules = tsPlugin.configs["strict-type-checked"].rules;
const tsStylisticRules = tsPlugin.configs["stylistic-type-checked"].rules;

function createRepositoryConfig(rel) {
	const abs = join(dirname(fileURLToPath(import.meta.url)), rel);
	const tsFiles = [`${rel}/**/*.ts`, `${rel}/**/*.mts`];
	const jsFiles = [`${rel}/**/*.js`];
	const mtsFiles = [`${rel}/**/*.mts`];

	const parserOptions = {
		ecmaFeatures: {
			modules: true,
		},
		sourceType: "module",
		ecmaVersion: 2022,
		project: `${abs}/tsconfig.json`,
	};

	return [
		{ files: jsFiles, rules: { ...possibleProblemRules, ...suggestionRules } },
		{ files: mtsFiles, rules: { ...possibleProblemRules, ...suggestionRules } },
		{
			files: tsFiles,
			plugins: {
				"@typescript-eslint": tsPlugin,
			},
			languageOptions: {
				parser: tsParser,
				parserOptions,
			},
			rules: {
				...possibleProblemRules,
				...suggestionRules,
				...tsOverrideEslintRules,
				...tsStrictRules,
				...tsStylisticRules,
				...tsExtensionRules,
				...tsRules,
			},
		},
	];
}

const folders = ["_static"];

export default [
	{ ignores: ["*/.*/**/*"] },
	eslint.configs.recommended,
	prettierConfig,
	{ files: ["*.js"], rules: { ...possibleProblemRules, ...suggestionRules } },
	...folders.map(createRepositoryConfig).flat(),

	{
		ignores: [
			"fajnovy-sport-template/src/assets/js/*",
			"fajnovy-sport-template/jest.config.js",
		],
	},
];

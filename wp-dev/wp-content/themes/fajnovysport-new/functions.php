<?php
require_once trailingslashit(get_template_directory()) . "inc/acf.php";
require_once trailingslashit(get_template_directory()) . "inc/breadcrumbs.php";
require_once trailingslashit(get_template_directory()) . "inc/enqueue.php";
require_once trailingslashit(get_template_directory()) . "inc/setup.php";
require_once __DIR__ . "/vendor/autoload.php";

// Initialize Timber.
Timber\Timber::init();

function isLocal()
{
	return getenv("WORDPRESS_DB_USER") === "root";
}

/**
 * Adding replacement of images from upload to noImage.jpg if they do not exist
 */
add_action("template_redirect", function () {
	$request_uri = $_SERVER["REQUEST_URI"];

	// Check if the request is targeting uploads/ and ends with an image
	if (
		preg_match(
			'/wp-content\/uploads\/.*\.(jpg|jpeg|png|gif)$/',
			$request_uri
		)
	) {
		$file_path = ABSPATH . ltrim($request_uri, "/");

		// If the file does not exist, redirect to noImage.jpg
		if (!file_exists($file_path)) {
			wp_redirect(
				get_template_directory_uri() . "/images/noImage.jpg",
				302
			);
			exit();
		}
	}
});

/**
 * Change template directory uri for local development
 */
add_filter(
	"template_directory_uri",
	function ($uri, $template) {
		if (isLocal()) {
			return $uri . "/../../../_static/public";
		}
		return $uri;
	},
	10,
	2
);

/**
 * Adding redirection twig template for local development
 */
add_filter("timber/locations", function ($paths) {
	$paths[0][] = isLocal()
		? __DIR__ . "/../../../_static/src/templates"
		: get_template_directory() . "/templates";
	$paths[0][] = isLocal()
		? __DIR__ . "/../../../_static/src/templates/components"
		: get_template_directory() . "/components";
	return $paths;
});

/**
 * Removing default WP styles
 */
function dequeue_wp_block_library_css()
{
	wp_dequeue_style("wp-block-library"); // Odstraní hlavní blokový styl
	wp_dequeue_style("wp-block-library-theme"); // Odstraní blokový styl pro téma
}
add_action("wp_enqueue_scripts", "dequeue_wp_block_library_css", 100);

function getVersion()
{
	$path = isLocal()
		? get_template_directory() . "/../../../_static/public/version.txt"
		: get_template_directory() . "/version.txt";
	$version = file_get_contents($path);
	return $version;
}

function defaultTwigConfig()
{
	return [
		"VERSION" => getVersion(),
		"templateDirectory" => get_template_directory_uri(),
		"scriptDirectory" => isLocal()
			? str_replace(
				"_static/public",
				"_static/.build/assets",
				get_template_directory_uri()
			)
			: get_template_directory_uri(),
	];
}

<?php
require_once trailingslashit(get_template_directory()) . "inc/acf.php";
require_once trailingslashit(get_template_directory()) . "inc/breadcrumbs.php";
require_once trailingslashit(get_template_directory()) . "inc/enqueue.php";
require_once trailingslashit(get_template_directory()) . "inc/setup.php";
require_once __DIR__ . "/vendor/autoload.php";

// Initialize Timber.
Timber\Timber::init();

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

if (getenv("WORDPRESS_DB_USER") === "root") {
	add_filter("timber/locations", function ($paths) {
		$paths[0][] = __DIR__ . "/../../../_static/src/templates/components";
		return $paths;
	});
} else {
	add_filter("timber/locations", function ($paths) {
		$paths[0][] = get_template_directory() . "/templates";
		return $paths;
	});
}

<?php
function theme_enqueue_scripts()
{
	if (isLocal()) {
		$VERSION = file_get_contents(
			get_template_directory() . "/../../../_static/version.txt"
		);
		print_r($VERSION);
	}

	wp_localize_script("map", "theme_directory", [
		"theme_directory" => get_template_directory_uri(),
	]);
}

add_action("wp_enqueue_scripts", "theme_enqueue_scripts");

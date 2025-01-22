<?php
$context = Timber::context();
$context += [
	"templateDirectory" => get_template_directory_uri(),
	"scriptDirectory" => isLocal()
		? str_replace(
			"_static/public",
			"_static/.build/assets",
			get_template_directory_uri()
		)
		: get_template_directory_uri(),
	"controller" => "Pages",
	"action" => "homepage",
];
Timber::render("base.twig", $context);

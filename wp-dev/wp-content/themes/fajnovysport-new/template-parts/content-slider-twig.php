<?php
// Získání základního kontextu Timber
$context = Timber::context();

// Přidejte data pro slider (například z ACF nebo staticky)
$context["sliders"] = [
	[
		"block_class" => "slider__block",
		"image_url" =>
			get_template_directory_uri() . "/_statika/img/univerzal.png",
		"red_class" => "slider__red",
		"orange_class" => "slider__orange",
		"icon_class" => "slider__icona slider__icona--beh",
		"text" => null,
	],
	[
		"block_class" => "slider__block slider__block--bezkyne",
		"image_url" => get_template_directory_uri() . "/_statika/img/beh.jpg",
		"red_class" => "slider__top",
		"orange_class" => "slider__bottom",
		"icon_class" => "slider__icona",
		"text" => [
			"title" =>
				"Ostrava pořádá první ročník mezinárodního maratonu Emila Zátopka!",
			"link" => "",
			"button" => "Číst více",
		],
	],
	// Přidejte další slider...
];

// Vykreslení šablony slider.twig pomocí Timber
Timber::render("slider.twig", $context);

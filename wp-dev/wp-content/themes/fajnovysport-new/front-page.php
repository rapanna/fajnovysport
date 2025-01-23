<?php
$context = Timber::context();

$context = array_merge($context, defaultTwigConfig(), [
	"controller" => "Pages",
	"action" => "homepage",
]);
Timber::render("homepage.twig", $context);

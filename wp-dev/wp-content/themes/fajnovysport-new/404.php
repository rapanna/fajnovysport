<?php
$context = Timber::context();

$context = array_merge($context, defaultTwigConfig(), [
	"controller" => "Pages",
	"action" => "default",
]);
Timber::render("404.twig", $context);

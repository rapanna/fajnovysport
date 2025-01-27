<?php
$context = Timber::context();

$context = array_merge($context, defaultTwigConfig(), [
	"controller" => "Pages",
	"action" => "contacts",
]);
Timber::render("contacts.twig", $context);

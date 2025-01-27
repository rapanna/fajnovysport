<?php
echo "aa";
// Získání základního kontextu Timber
$context = Timber::context();

$context["templateDirectory"] = get_template_directory_uri();

Timber::render("base.twig", $context);

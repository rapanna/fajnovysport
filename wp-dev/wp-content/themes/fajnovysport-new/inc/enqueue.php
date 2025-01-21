<?php
function theme_enqueue_scripts()
{
    wp_enqueue_style('theme-main-style', get_template_directory_uri() . '/css/index.sass.min.css', [], '1.0', 'all');
    
    wp_enqueue_style('theme-style', get_stylesheet_uri());
    
    wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.js', [], '1.0');
    wp_enqueue_script('theme-main-script', get_template_directory_uri() . '/js/custom-script.js', [], '1.0', true);
    
    wp_enqueue_script('map', get_template_directory_uri() . '/js/map.js', [], '1.0', true);
    wp_enqueue_script('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v3.9.2/mapbox-gl.js',array( 'jquery' ), '2.2.0');
    wp_enqueue_style( 'mapbox',	'https://api.mapbox.com/mapbox-gl-js/v3.9.2/mapbox-gl.css');

    wp_localize_script('map', 'theme_directory' , array(
      'theme_directory' => get_template_directory_uri() 
    ));
  
}

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
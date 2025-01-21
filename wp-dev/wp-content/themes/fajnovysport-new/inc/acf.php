<?php
function add_opt_page()
{
    $parent = acf_add_options_page([
        'page_title' => 'Nastavení šablony',
        'menu_title' => 'Nastavení šablony',
        'menu_slug'  => 'options-menu',
        'capability' => 'manage_options',
        'icon_url'   => 'dashicons-admin-customizer',
    ]);
}

add_action('admin_menu', 'add_opt_page');
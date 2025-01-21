<?php
function theme_setup()
{
    $post_formats = ['aside', 'image', 'gallery', 'video', 'audio', 'link', 'quote', 'status', 'chat', 'code', 'review', 'recipe', 'event', 'poll', 'tutorial', 'faq'];
    add_theme_support('post-formats', $post_formats);

    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('align-wide');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');

    add_theme_support('woocommerce');

    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);

    add_theme_support('editor-styles');
    add_post_type_support('page', 'excerpt');

    register_nav_menus([
        'menu-1' => esc_html__('Navbar', 'wpde'),
        'menu-2' => esc_html__('Footer 1', 'wpde'),
        'menu-3' => esc_html__('Footer 2', 'wpde'),
    ]);

    add_image_size('thumb-event', 500, 200, true);
}

add_action('after_setup_theme', 'theme_setup');

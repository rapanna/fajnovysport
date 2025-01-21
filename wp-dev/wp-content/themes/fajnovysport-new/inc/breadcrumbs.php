<?php
function breadcrumbs() {
    if (is_front_page()) {
        return;
    }

    global $post;
    $custom_taxonomy = '';

    $defaults = [
        'home' => esc_html(__('Hlavní stránka', 'wpde')),
        'id' => 'breadcrumbs',
    ];

    // Start breadcrumb with a link to your homepage
    echo '<nav class="breadcrumbs" role="navigation" aria-label="drobečková navigace">';
    echo '<ol class="breadcrumbs__list">';

    // Creating home link
    echo "<li class='breadcrumbs__item'><a href='" . get_home_url() . "' class='breadcrumbs__link'>" . $defaults['home'] . '</a><span aria-hidden="true">|</span></li>';

    // Single
    if (is_single()) {
        $post_type = get_post_type();

        // If post type is not 'post'
        if ($post_type != 'post') {
            $post_type_object = get_post_type_object($post_type);
            $post_type_link = get_post_type_archive_link($post_type);
            echo "<li class='breadcrumbs__item'><a href='" . $post_type_link . "' class='breadcrumbs__link'>" . $post_type_object->labels->name . '</a><span aria-hidden="true">|</span></li>';
        }

        // Get categories
        $category = get_the_category($post->ID);

        // If category not empty
        if (!empty($category)) {
            // Arrange category parent to child
            $category_values = array_values($category);
            $get_last_category = end($category_values);
            $get_parent_category = rtrim(get_category_parents($get_last_category->term_id, true, ','), ',');
            $cat_parent = explode(',', $get_parent_category);

            // Store category in $display_category
            $display_category = '';
            foreach ($cat_parent as $p) {
                $display_category .= "<li class='breadcrumbs__item'><a href='#' class='breadcrumbs__link'>" . $p . "</a><span aria-hidden='true'>|</span></li>";
            }
        }

        // If it's a custom post type within a custom taxonomy
        $taxonomy_exists = taxonomy_exists($custom_taxonomy);

        if (empty($get_last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
            $taxonomy_terms = get_the_terms($post->ID, $custom_taxonomy);
            $cat_id = $taxonomy_terms[0]->term_id;
            $cat_link = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
            $cat_name = $taxonomy_terms[0]->name;
        }

        // Check if the post is in a category
        if (!empty($get_last_category)) {
            echo $display_category;
            echo "<li class='breadcrumbs__item breadcrumbs__item--current'><a href='#' class='breadcrumbs__link' aria-current='page'>" . get_the_title() . '</a></li>';
        } elseif (!empty($cat_id)) {
            echo "<li class='breadcrumbs__item'><a href='" . $cat_link . "' class='breadcrumbs__link'>" . $cat_name . '</a><span aria-hidden="true">|</span></li>';
            echo "<li class='breadcrumbs__item breadcrumbs__item--current'><a href='#' class='breadcrumbs__link' aria-current='page'>" . get_the_title() . '</a></li>';
        } else {
            echo '<li class="breadcrumbs__item breadcrumbs__item--current"><a href="#" class="breadcrumbs__link" aria-current="page">' . get_the_title() . '</a></li>';
        }
    } elseif (is_post_type_archive('product')) {
        $post_type = get_post_type();
        $post_type_object = get_post_type_object($post_type);
        echo "<li class='breadcrumbs__item breadcrumbs__item--current'>" . $post_type_object->labels->name . '</li>';
    } elseif (is_archive()) {
        // Taxonomy
        if (is_tax()) {
            $post_type = get_post_type();

            if ($post_type != 'post') {
                $post_type_object = get_post_type_object($post_type);
                $post_type_link = get_post_type_archive_link($post_type);
                echo "<li class='breadcrumbs__item'><a href='" . $post_type_link . "' class='breadcrumbs__link'>" . $post_type_object->labels->name . '</a><span aria-hidden="true">|</span></li>';
            }

            $custom_tax_name = get_queried_object()->name;
            echo "<li class='breadcrumbs__item'>" . $custom_tax_name . '</li>';

        } elseif (is_category()) {
            $parent = get_queried_object()->category_parent;
            if ($parent !== 0) {
                $parent_category = get_category($parent);
                $category_link = get_category_link($parent);
                echo "<li class='breadcrumbs__item'><a href='" . esc_url($category_link) . "' class='breadcrumbs__link'>" . $parent_category->name . '</a><span aria-hidden="true">|</span></li>';
            }
            echo "<li class='breadcrumbs__item breadcrumbs__item--current'>" . single_cat_title('', false) . '</li>';
        } elseif (is_tag()) {
            $term_id = get_query_var('tag_id');
            $taxonomy = 'post_tag';
            $args = 'include=' . $term_id;
            $terms = get_terms($taxonomy, $args);
            $get_term_name = $terms[0]->name;
            echo "<li class='breadcrumbs__item breadcrumbs__item--current'>" . $get_term_name . '</li>';
        } elseif (is_day()) {
            echo "<li><a href='" . get_year_link(get_the_time('Y')) . "' class='breadcrumbs__link'>" . get_the_time('Y') . ' Archiv</a></li>';
            echo "<li><a href='" . get_month_link(get_the_time('Y'), get_the_time('m')) . "' class='breadcrumbs__link'>" . get_the_time('M') . ' Archiv</a></li>';
            echo "<li class='breadcrumbs__item breadcrumbs__item--current'>" . get_the_time('jS') . ' ' . get_the_time('M') . ' Archiv</li>';
        } elseif (is_month()) {
            echo "<li class='breadcrumbs__item'><a href='" . get_year_link(get_the_time('Y')) . "' class='breadcrumbs__link'>" . get_the_time('Y') . ' Archiv</a></li>';
            echo "<li class='breadcrumbs__item breadcrumbs__item--current'>" . get_the_time('M') . ' Archiv</li>';
        } elseif (is_year()) {
            echo "<li class='breadcrumbs__item breadcrumbs__item--current'>" . get_the_time('Y') . ' Archiv</li>';
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo "<li class='breadcrumbs__item breadcrumbs__item--current'>" . $userdata->display_name . '</li>';
        } else {
            echo "<li class='breadcrumbs__item breadcrumbs__item--current'>" . post_type_archive_title() . '</li>';
        }
    } elseif (is_page()) {
        if ($post->post_parent) {
            $anc = get_post_ancestors($post->ID);
            $anc = array_reverse($anc);
            $parents = null;
            foreach ($anc as $ancestor) {
                $parents .= "<li class='breadcrumbs__item'><a href='" . get_permalink($ancestor) . "' class='breadcrumbs__link'>" . get_the_title($ancestor) . "</a><span aria-hidden='true'>|</span></li>";
            }
            echo $parents;
            echo "<li class='breadcrumbs__item breadcrumbs__item--current'>" . get_the_title() . '</li>';
        } else {
            echo "<li class='breadcrumbs__item breadcrumbs__item--current'>" . get_the_title() . '</li>';
        }
    } elseif (is_search()) {
        echo "<li class='breadcrumbs__item breadcrumbs__item--current'>" . __('Search results for:', 'wpde') . " <strong>" . get_search_query() . '</strong></li>';
    } elseif (is_404()) {
        echo "<li class='breadcrumbs__item breadcrumbs__item--current'>" . 'Error 404' . '</li>';
    }

    echo '</ol>';
    echo '</nav>';
}

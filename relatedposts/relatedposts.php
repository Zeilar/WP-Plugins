<?php

/**
 * Plugin Name: Related Posts
 * Plugin URI:
 * Description: Shows related posts.
 * Version:     0.1
 * Author:      Philip Angelin
 * Author URI:
 * License:     WTFPL
 * License URI: www.wtfpl.net
 * Text Domain: relatedposts
 * Domain Path: /languages
 */

function relatedposts($user_atts = [], $content = null, $tag = '') {

    $default_atts = [
        'posts_per_page' => 3,
        'title' => __('Related Posts', 'relatedposts'),
    ];

    $atts = shortcode_atts($default_atts, $user_atts, $tag);

    $current_post_id = get_the_ID();
    $category_ids = wp_get_post_terms($current_post_id, 'category', ['fields' => 'ids']);

    $posts = new WP_Query([
        'posts_per_page' => $atts['posts_per_page'],
        'post__not_in' => [$current_post_id],
        'category__in' => $category_ids,
    ]);
    
    $output = "<h1>" . $atts['title'] . "</h1>";

    if ($posts->have_posts()) {

        $output .= "<ul>";

        while ($posts->have_posts()) {
            $posts->the_post();
            $output .= "<li>";
            $output .= "<a href='" . get_the_permalink() . "'>";
            $output .= get_the_title();
            $output .= "</a>";
            $output .= ' by <a href="' . get_the_author_link() . '">';
            $output .= get_the_author() . '</a> in ';
            $output .= get_the_category_list(', ');
            $output .= '<br>';
            $output .= 'Posted: ' . human_time_diff(get_the_time('U')) . ' ago'; 
            $output .= "</li>";
        }
        
        wp_reset_postdata();
        $output .= "</ul>";

    } else {
        $output .= "No posts were found :(";
    }

    return $output;
}

function relatedposts_init() {
    add_shortcode('related-posts', 'relatedposts');
}
add_action('init', 'relatedposts_init');
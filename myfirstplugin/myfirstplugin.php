<?php

/**
 * Plugin Name: My First Plugin
 * Plugin URI:
 * Description: My first plugin.
 * Version:     0.1
 * Author:      Philip Angelin
 * Author URI:
 * License:     WTFPL
 * License URI: www.wtfpl.net
 * Text Domain: myfirstplugin
 * Domain Path: /languages
 */

function mfp_latest_posts($atts) {
    $atts = shortcode_atts([
        'posts_per_page' => 3,
        'title' => false,
    ], $atts);
    $posts = new WP_Query([
        'posts_per_page' => $atts['posts_per_page'],
    ]);
    $output = "<h1>Latest Posts</h1>";
    if ($posts->have_posts()) {
        $today = new DateTime($today);
        $output .= "<ul>";
        while ($posts->have_posts()) {
            $posts->the_post();
            $output .= "<li>";
            $output .= "<a href='" . get_the_permalink() . "'>";
            if (!$atts['title']) {
                $output .= get_the_title();
            } else {
                $output .= $atts['title'];
            }
            $output .= "</a>";
            $output .= ' by <a href="' . get_the_author_link() . '">';
            $output .= get_the_author() . '</a> in ';
            $output .= get_the_category_list(', ');
            $output .= '<br>';
            $post_date = new DateTime(get_the_date());
            $age = date_diff($today, $post_date);
            $years = $age->y . ' years ';
            $months = $age->m . ' months ';
            $days = $age->d . ' days ';
            $age = $years . $months . $days;
            $output .= 'Posted: ' . $age . ' ago'; 
            $output .= "</li>";
        }
        wp_reset_postdata();
        $output .= "</ul>";
    } else {
        $output .= "No posts were found :(";
    }

    return $output;
}

function mfp_init() {
    add_shortcode('latest-posts', 'mfp_latest_posts');
}
add_action('init', 'mfp_init');
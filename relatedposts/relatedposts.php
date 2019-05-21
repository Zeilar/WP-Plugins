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

// Gets Posts Related To The Current One
function get_related_posts($user_atts = [], $content = null, $tag = '') {

    // Default Attributes (If User Makes No Input)
    $default_atts = [
        'posts_per_page' => 3,
        'title' => __('Related Posts', 'relatedposts'),
    ];

    // Combines Default And User Provided Attributes
    $atts = shortcode_atts($default_atts, $user_atts, $tag);

    $current_post_id = get_the_ID();
    $category_ids = wp_get_post_terms($current_post_id, 'category', ['fields' => 'ids']);

    // Query Includes Filtering Of Posts That Are Same As Current In Either ID/Category
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
            $output .= "<a href='" . get_the_permalink() . "'>" . get_the_title() . "</a>";
            $output .= ' by <a href="' . get_the_author_link() . '">' . get_the_author() . '</a>';
            $output .= ' in ' . get_the_category_list(', ');
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

// Shortcode: [related-posts]
function relatedposts_shortcode($user_atts = [], $content = null, $tag = '') {
    return get_related_posts($user_atts, $content, $tag);
}

// Load All The Stuff Here
function relatedposts_init() {
    add_shortcode('related-posts', 'relatedposts_shortcode');
}
add_action('init', 'relatedposts_init');

// Filters The $content
function relatedposts_the_content($content) {
    if(is_single() && is_main_query() && in_the_loop() && !has_shortcode($content, 'related-posts')) {
        $content .= get_related_posts();
    }

    return $content;
}
add_filter('the_content', 'relatedposts_the_content');

// Latest Posts Widget
require("class.LatestPostsWidget.php");

// Load Widgets
function latestposts_widgets_init() {
    register_widget('LatestPostsWidget');
}
add_action('widgets_init', 'latestposts_widgets_init');
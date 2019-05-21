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

require("functions.php");
require("filters.php");
require_once("class.latestpostswidget.php");


// Shortcode: [related-posts]
function relatedposts_shortcode($user_atts = [], $content = null, $tag = '') {
    return get_related_posts($user_atts, $content, $tag);
}

// Load All The Stuff Here
function relatedposts_init() {
    add_shortcode('related-posts', 'relatedposts_shortcode');
}
add_action('init', 'relatedposts_init');


// Load Widgets
function latestposts_widgets_init() {
    register_widget('LatestPostsWidget');
}
add_action('widgets_init', 'latestposts_widgets_init');
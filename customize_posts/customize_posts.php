<?php

/**
 * Plugin Name: Customize Posts
 * Plugin URI:
 * Description: Customize how and which posts are displayed.
 * Version:     0.1
 * Author:      Philip Angelin
 * Author URI:
 * License:     WTFPL
 * License URI: www.wtfpl.net
 * Text Domain: customize_posts
 * Domain Path: /languages
 */

require("functions.php");
require("filters.php");
require("shortcodes.php");
require("widgets2.php");
require("settings.php");

function cp_enqueue_styles() {
    wp_enqueue_style('customize_posts', plugin_dir_url(__FILE__) . 'assets/css/customize_posts.css');

    wp_enqueue_script('customize_posts', plugin_dir_url(__FILE__) . 'assets/js/customize_posts.js', ['jquery'], false, true);
}
add_action('wp_enqueue_scripts', 'cp_enqueue_styles');

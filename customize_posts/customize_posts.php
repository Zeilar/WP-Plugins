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

    wp_localize_script('customize_posts', 'cp_ajaxobj', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
    wp_localize_script('customize_posts', 'cp_ol_settings', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
}
add_action('wp_enqueue_scripts', 'cp_enqueue_styles');

function cp_ajax_get_current_weather() {
    $current_weather = owm_get_current_weather($_POST['city'], $_POST['country']);
    wp_send_json($current_weather);
}
add_action('wp_ajax_get_current_weather', 'cp_ajax_get_current_weather');
add_action('wp_ajax_nopriv_get_current_weather', 'cp_ajax_get_current_weather');

function cp_ajax_get_oneliner() {
    global $oneliners;

    $oneliner_index = array_rand($oneliners);
    $oneliner = $oneliners[$oneliner_index];

    echo $oneliner;

    wp_die();
}
add_action('wp_ajax_get_oneliner', 'cp_ajax_get_oneliner');
add_action('wp_ajax_nopriv_get_oneliner', 'cp_ajax_get_oneliner');
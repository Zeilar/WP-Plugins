<?php

/**
 * Plugin Name: Cool Plugin
 * Plugin URI:
 * Description: Does a lot of cool things!
 * Version:     0.9
 * Author:      Philip Angelin
 * Author URI:
 * License:     WTFPL
 * License URI: www.wtfpl.net
 * Text Domain: cool_plugin
 * Domain Path: /languages
 */

require("functions.php");
require("filters.php");
require("shortcodes.php");
require("widgets2.php");
require("settings.php");

function cp_enqueue_styles() {
    wp_enqueue_style('cool_plugin', plugin_dir_url(__FILE__) . 'assets/css/cool_plugin.css');
    wp_enqueue_script('cool_plugin', plugin_dir_url(__FILE__) . 'assets/js/cool_plugin.js', ['jquery'], false, true);

    wp_localize_script('cool_plugin', 'cp_ajaxobj', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
    wp_localize_script('cool_plugin', 'cp_ol_settings', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
}
add_action('wp_enqueue_scripts', 'cp_enqueue_styles');

function cp_ajax_get_current_weather() {
    $current_weather_request = owm_get_current_weather($_POST['city'], $_POST['country']);

    if ($current_weather_request['success']) {
        wp_send_json_success($current_weather_request['data']);
    } else {
        wp_send_json_error($current_weather_request['error']);
    }
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
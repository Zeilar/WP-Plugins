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
require("widget.php");
require("settings.php");
require("ajax.php");

function cp_enqueue_styles() {
    wp_enqueue_style('cool_plugin', plugin_dir_url(__FILE__) . 'assets/css/cool_plugin.css');
    wp_enqueue_script('cool_plugin', plugin_dir_url(__FILE__) . 'assets/js/cool_plugin.js', ['jquery'], false, true);

    wp_localize_script('cool_plugin', 'cp_ajax_obj', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
}
add_action('wp_enqueue_scripts', 'cp_enqueue_styles');
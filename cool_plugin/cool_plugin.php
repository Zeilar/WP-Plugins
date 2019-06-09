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

cp_enqueue_styles();
cp_enqueue_scripts();
cp_localize_script(
    'cool_plugin', 
    'cp_ajax_obj', 
    [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]
);

function cp_enqueue_styles() {
    add_action('wp_enqueue_scripts', function() {
        wp_enqueue_style('cool_plugin', plugin_dir_url(__FILE__) . 'assets/css/cool_plugin.css');
    });
}

function cp_enqueue_scripts() {
    add_action('wp_enqueue_scripts', function() {
        wp_enqueue_script('cool_plugin', plugin_dir_url(__FILE__) . 'assets/js/cool_plugin.js', ['jquery'], false, true);
    });
}

/**
 * Transfer data into scriptfile
 * 
 * $handle (string) (required) the script to transfer this data to
 * $name (string) (required) name of the object that will contain the data
 * $data (string) (required) the data to send, can be array
 */
function cp_localize_script(string $handle, string $name, $data) {
    add_action('wp_enqueue_scripts', function() use ($handle, $name, $data) {
        wp_localize_script($handle, $name, $data);
    });
}
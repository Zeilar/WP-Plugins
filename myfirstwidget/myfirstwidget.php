<?php
/**
 * Plugin Name: My First Widget
 * Plugin URI:
 * Description: My first widget.
 * Version:     0.1
 * Author:      Philip Angelin
 * Author URI:
 * License:     WTFPL
 * License URI: www.wtfpl.net
 * Text Domain: myfirstwidget
 * Domain Path: /languages
 */

require("class.MyFirstWidget.php");
require("class.LatestPostsWidget.php");

function mfw_widgets_init() {
    register_widget('MyFirstWidget');
    register_widget('LatestPostsWidget');
}
add_action('widgets_init', 'mfw_widgets_init');
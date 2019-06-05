<?php

// Load all the required widget files
require("class.latestpostswidget.php");
require("class.starwarswidget.php");
require("class.weatherwidget.php");
require("class.onelinerwidget.php");
require("swapi.php");
require("owmapi.php");
require("oneliners.php");

// Load Latest Posts Widget
function latestposts_widget_init() {
    register_widget('LatestPostsWidget');
}
add_action('widgets_init', 'latestposts_widget_init');

// Load Star Wars Widget
function starwars_widget_init() {
    register_widget('StarWarsWidget');
}
add_action('widgets_init', 'starwars_widget_init');

// Load Weather Widget
function weather_widget_init() {
    register_widget('WeatherWidget');
}
add_action('widgets_init', 'weather_widget_init');

// Load OneLiner Widget
function oneliner_widget_init() {
    register_widget('OneLinerWidget');
}
add_action('widgets_init', 'oneliner_widget_init');
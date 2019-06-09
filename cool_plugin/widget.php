<?php

// Load all the required widget files
require("widgets/class.latestpostswidget.php");
require("widgets/class.starwarswidget.php");
require("widgets/class.weatherwidget.php");
require("widgets/class.onelinerwidget.php");
require("widgets/swapi.php");
require("widgets/owmapi.php");
require("widgets/oneliners.php");

// Register widgets
cp_register_widget('LatestPostsWidget');
cp_register_widget('StarWarsWidget');
cp_register_widget('WeatherWidget');
cp_register_widget('OneLinerWidget');

/**
 * $widget (required) class name of the widget
 */
function cp_register_widget(string $widget) {
    add_action('widgets_init', function() use ($widget){
        register_widget($widget);
    });
}
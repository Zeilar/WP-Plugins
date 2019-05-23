<?php

require("class.latestpostswidget.php");
require("class.starwarswidget.php");

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
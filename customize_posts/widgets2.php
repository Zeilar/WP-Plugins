<?php

require("class.latestpostswidget.php");

// Load Widgets
function latestposts_widget_init() {
    register_widget('LatestPostsWidget');
}
add_action('widgets_init', 'latestposts_widget_init');
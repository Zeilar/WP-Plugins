<?php

// Shortcode: [related-posts]
function cool_plugin_shortcode($user_atts = [], $content = null, $tag = '') {
    return get_related_posts($user_atts, $content, $tag);
}

// Load All The Stuff Here
function cool_plugin_init() {
    add_shortcode('related-posts', 'cool_plugin_shortcode');
}
add_action('init', 'cool_plugin_init');
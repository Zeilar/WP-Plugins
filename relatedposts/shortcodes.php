<?php

// Shortcode: [related-posts]
function relatedposts_shortcode($user_atts = [], $content = null, $tag = '') {
    return get_related_posts($user_atts, $content, $tag);
}

// Load All The Stuff Here
function relatedposts_init() {
    add_shortcode('related-posts', 'relatedposts_shortcode');
}
add_action('init', 'relatedposts_init');
<?php

// Shortcode: [related-posts]
function cp_posts_shortcode($user_atts = [], $content = null, $tag = '') {
    return get_related_posts($user_atts, $content, $tag);
}

// Load All The Stuff Here
function cp_posts_init() {
    add_shortcode('related-posts', 'cp_posts_shortcode');
}
add_action('init', 'cp_posts_init');
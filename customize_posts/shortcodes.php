<?php

// Shortcode: [related-posts]
function customize_posts_shortcode($user_atts = [], $content = null, $tag = '') {
    return get_related_posts($user_atts, $content, $tag);
}

// Load All The Stuff Here
function customize_posts_init() {
    add_shortcode('related-posts', 'customize_posts_shortcode');
}
add_action('init', 'customize_posts_init');
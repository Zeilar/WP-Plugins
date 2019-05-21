<?php

// Filters The $content
function cp_posts_the_content($content) {
    if(is_single() && is_main_query() && in_the_loop() && !has_shortcode($content, 'related-posts')) {
        $content .= get_related_posts();
    }

    return $content;
}
add_filter('the_content', 'cp_posts_the_content');
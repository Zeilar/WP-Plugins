<?php

// filters the $content
add_filter('the_content', function($content) {
    if (
        is_single() && 
        is_main_query() && 
        in_the_loop() && 
        !has_shortcode($content, 'related-posts') &&
        get_option('cp_append_related_posts') == 1
    ) 
        {
        $content .= get_related_posts();
    }
    
    return $content;
});
<?php

// Filters The $content
function customize_posts_the_content($content) {
    if(
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
}
add_filter('the_content', 'customize_posts_the_content');
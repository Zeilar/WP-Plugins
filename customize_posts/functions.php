<?php 

// Gets Posts Related To The Current One
function get_related_posts($user_atts = [], $content = null, $tag = '') {

    $default_title = get_option('cp_related_posts_title', __('Related Posts', 'cool_plugin'));
    $default_post_amount = get_option('cp_related_posts_amount', __('Amount of related posts', 'cool_plugin'));

    // Default Attributes (If user makes no input)
    $default_atts = [
        'posts_per_page' => $default_post_amount,
        'title' => $default_title,
    ];
    
    // Combines default and user provided attributes
    $atts = shortcode_atts($default_atts, $user_atts, $tag);

    $current_post_id = get_the_ID();
    $category_ids = wp_get_post_terms($current_post_id, 'category', ['fields' => 'ids']);

    // Query includes filtering if posts that are the same as current in either ID/category
    $posts = new WP_Query([
        'posts_per_page' => $atts['posts_per_page'],
        'post__not_in' => [$current_post_id],
        'category__in' => $category_ids,
    ]);
    
    $output = "<h1>" . $atts['title'] . "</h1>";

    if ($posts->have_posts()) {

        $output .= "<ul>";

        while ($posts->have_posts()) {
            $posts->the_post();
            $output .= "<li>";
            $output .= "<a href='" . get_the_permalink() . "'>" . get_the_title() . "</a>";
            $output .= ' by <a href="' . get_the_author_link() . '">' . get_the_author() . '</a>';
            $output .= ' in ' . get_the_category_list(', ');
            $output .= '<br>';
            $output .= 'Posted: ' . human_time_diff(get_the_time('U')) . ' ago'; 
            $output .= "</li>";
        }
        
        wp_reset_postdata();
        $output .= "</ul>";

    } else {
        $output .= __('No posts were found :(', 'cool_plugin');
    }

    return $output;
}
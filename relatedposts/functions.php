<?php 

// Gets Posts Related To The Current One
function get_related_posts($user_atts = [], $content = null, $tag = '') {

    // Default Attributes (If User Makes No Input)
    $default_atts = [
        'posts_per_page' => 3,
        'title' => __('Related Posts', 'relatedposts'),
    ];
    
    // Combines Default And User Provided Attributes
    $atts = shortcode_atts($default_atts, $user_atts, $tag);

    $current_post_id = get_the_ID();
    $category_ids = wp_get_post_terms($current_post_id, 'category', ['fields' => 'ids']);

    // Query Includes Filtering Of Posts That Are Same As Current In Either ID/Category
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
        $output .= "No posts were found :(";
    }

    return $output;
}
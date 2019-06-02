<?php

// Add settings page to the dashboard menu
function cp_add_settings_page_to_menu() {

    add_submenu_page(
        'options-general.php', // Parent page
        'Customize Posts Settings', // Settings page title
        'Customize Posts', // Menu title
        'manage_options', // User capability requirement
        'cool_plugin', // Slug for settings page URL
        'cp_settings_page' // Callback to render function
    );
}
add_action('admin_menu', 'cp_add_settings_page_to_menu');

// Render settings page
function cp_settings_page() {
    ?>
        <div class="wrap">

            <h1><?php echo __(esc_html(get_admin_page_title())) ?></h1>
        
            <form method="post" action="options.php">
                <?php
                    settings_fields("cp_general_options");
                    do_settings_sections("cool_plugin");
                    submit_button();
                ?>
            </form> <!-- options form -->
        </div> <!-- wrap -->
    <?php
}

// Settings section, good place to put text in
function cp_general_options_section() {
    ?>
        <p>This is general options section (test)</p>
    <?php
}

// Edits title of related posts section
function cp_related_posts_title() {
    ?>
        <input 
            type="text" 
            name="cp_related_posts_title" 
            id ="cp_related_posts_title"
            value="<?php echo get_option('cp_related_posts_title', __('Related Posts', 'cool_plugin')); ?>"
        >
    <?php
}

// Edits amount of related posts
function cp_related_posts_amount() {
    ?>
        <input 
            type="number" 
            name="cp_related_posts_amount" 
            id="cp_related_posts_amount"
            min="0"
            max="10"
            value="<?php echo get_option('cp_related_posts_amount', 3); ?>"
        >
    <?php
}

// Puts related posts section at the end of blog posts
function cp_append_related_posts() {
    ?>
        <input type="checkbox" 
            name="cp_append_related_posts" 
            id ="cp_append_related_posts" 
            value="1" 
            <?php checked(1, get_option('cp_append_related_posts')); ?>
        >
    <?php
}

// Register settings
function cp_settings_init() {

    add_settings_section(
        'cp_general_options', 
        __('General Options', 'cool_plugin'), 
        'cp_general_options_section', 
        'cool_plugin'
    );

    // Edit blog posts title
    add_settings_field(
        'cp_related_posts_title', 
        'Edit post title', 
        'cp_related_posts_title', 
        'cool_plugin', 
        'cp_general_options'
    );

    // Edit amount of related posts
    add_settings_field(
        'cp_related_posts_amount', 
        'Amount of related posts', 
        'cp_related_posts_amount', 
        'cool_plugin', 
        'cp_general_options'
    );

    // Puts related posts section at the end of blog posts
    add_settings_field(
        'cp_append_related_posts', 
        __('Add related posts automatically to all blog posts?', 'cool_plugin'), 
        'cp_append_related_posts', 
        'cool_plugin', 
        'cp_general_options'
    );

    register_setting('cp_general_options', 'cp_related_posts_title');
    register_setting('cp_general_options', 'cp_related_posts_amount');
    register_setting('cp_general_options', 'cp_append_related_posts');
}
add_action('admin_init', 'cp_settings_init');
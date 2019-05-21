<?php

// Add settings page to the dashboard menu
function cp_add_settings_page_to_menu() {
    add_submenu_page(
        'options-general.php', // Parent page
        'Customize Posts', // Settings page title
        'Customize Posts', // Menu title
        'manage_options', // User capability requirement
        'customize_posts', // Slug for settings page URL
        'cp_settings_page' // Callback to render function
    );
}
add_action('admin_menu', 'cp_add_settings_page_to_menu');

// Add settings
function cp_settings_init() {
    //register_setting();
}
add_action('admin_init', 'cp_settings_init');

// Render settings page
function cp_settings_page() {
    
}
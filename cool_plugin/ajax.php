<?php

function cp_ajax_get_current_weather() {

    $current_weather_request = owm_get_current_weather($_POST['city'], $_POST['country']);

    if ($current_weather_request['success']) {
        wp_send_json_success($current_weather_request['data']);
    } else {
        wp_send_json_error($current_weather_request['error']);
    }
}
add_action('wp_ajax_get_current_weather', 'cp_ajax_get_current_weather');
add_action('wp_ajax_nopriv_get_current_weather', 'cp_ajax_get_current_weather');

function cp_ajax_get_oneliner() {

    global $oneliners;

    $oneliner_index = array_rand($oneliners);
    $oneliner       = $oneliners[$oneliner_index];

    echo $oneliner;

    wp_die();
}
add_action('wp_ajax_get_oneliner', 'cp_ajax_get_oneliner');
add_action('wp_ajax_nopriv_get_oneliner', 'cp_ajax_get_oneliner');

function cp_ajax_get_starwars_films() {
    wp_send_json(swapi_get_films());
}
add_action('wp_ajax_get_starwars_films', 'cp_ajax_get_starwars_films');
add_action('wp_ajax_nopriv_get_starwars_films', 'cp_ajax_get_starwars_films');

function cp_ajax_get_starwars_characters() {
    wp_send_json(swapi_get_characters());
}
add_action('wp_ajax_get_starwars_characters', 'cp_ajax_get_starwars_characters');
add_action('wp_ajax_nopriv_get_starwars_characters', 'cp_ajax_get_starwars_characters');

function cp_ajax_get_starwars_vehicles() {
    wp_send_json(swapi_get_vehicles());
}
add_action('wp_ajax_get_starwars_vehicles', 'cp_ajax_get_starwars_vehicles');
add_action('wp_ajax_nopriv_get_starwars_vehicles', 'cp_ajax_get_starwars_vehicles');
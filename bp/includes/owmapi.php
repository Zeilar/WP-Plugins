<?php

function owm_get_current_weather($city, $country, $measurement = 'metric') {

    $response = wp_remote_get("http://api.openweathermap.org/data/2.5/weather?q={$city},
    {$country}&units={$measurement}&appid=5ae275d1a0023fc435486dc31a45cd67");

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
        return [
            'success' => false,
            'error' => wp_remote_retrieve_response_code($response)
        ];
    }
    $response = json_decode(wp_remote_retrieve_body($response));

    $current_weather = [];
    $current_weather['temperature'] = $response->main->temp;
    $current_weather['humidity'] = $response->main->humidity;
    $current_weather['city'] = $response->name;
    $current_weather['country'] = $response->sys->country;
    $current_weather['conditions'] = $response->weather;

    return [
        'success' => true,
        'data' => $current_weather
    ];
}
<?php

function owm_get_current_weather($city, $country, $measurement = 'metric') {

    $request = wp_remote_get("http://api.openweathermap.org/data/2.5/weather?q={$city},
    {$country}&units={$measurement}&appid=5ae275d1a0023fc435486dc31a45cd67");

    if (is_wp_error($request) || wp_remote_retrieve_response_code($request) !== 200) {
        return false;
    }
    $request = json_decode(wp_remote_retrieve_body($request));

    $current_weather = [];
    $current_weather['temperature'] = $request->main->temp;
    $current_weather['humidity'] = $request->main->humidity;
    $current_weather['city'] = $request->name;
    $current_weather['country'] = $request->sys->country;
    $current_weather['conditions'] = $request->weather;

    return $current_weather;
}
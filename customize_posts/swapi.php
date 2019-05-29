<?php

function swapi_get_url($url) {
    $request = wp_remote_get($url);
    if (is_wp_error($request)) {
        return false;
    }
    return json_decode(wp_remote_retrieve_body($request));
}

function swapi_get($endpoint, $expiration = 3600) {
    if (!$endpoint) {
        return false;
    }
    $transient_key = "swapi_get_{$endpoint}";
    $items = get_transient($transient_key);
    if (!$items) {    
        $items = [];
        $url = "https://swapi.co/api/{$endpoint}";
        while ($url) {
            $data = swapi_get_url($url);
            if (!$data) {
                return false;
            }
            $items = array_merge($items, $data->results);
            $url = $data->next;
        }
        set_transient($transient_key, $items, $expiration);
    }
    return $items;
}

function swapi_get_films() {
    return swapi_get('films', 1);
}

function swapi_get_characters() {
    return swapi_get('people', 1);
}

function swapi_get_vehicles() {
    return swapi_get('vehicles', 1);
}
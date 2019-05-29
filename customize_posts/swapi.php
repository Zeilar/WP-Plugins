<?php

function swapi_get_url($url) {
    $request = wp_remote_get($url);
    if (is_wp_error($request)) {
        return false;
    }
    return json_decode(wp_remote_retrieve_body($request));
}

function swapi_get($endpoint) {
    if (!$endpoint) {
        return false;
    }
    $items = [];
    $url = "https://swapi.co/api/{$endpoint}/";
    while ($url) {
        $data = swapi_get_url($url);
        if (!$data) {
            return false;
        }
        $items = array_merge($items, $data->results);
        $url = $data->next;
    }
    return $items;
}

function swapi_get_films() {
    $films = get_transient('swapi_get_films');
    if ($films) {
        return $films;
    } else {
        $items = swapi_get('films');
        set_transient('swapi_get_films', $items, 60*30);

        return $items;
    }
}

function swapi_get_characters() {
    $characters = get_transient('swapi_get_characters');
    if ($characters) {
        return $characters;
    } else {
        $items = swapi_get('people');
        set_transient('swapi_get_characters', $items, 60*30);

        return $items;
    }
}

function swapi_get_vehicles() {
    $vehicles = get_transient('swapi_get_vehicles');
    if ($vehicles) {
        return $vehicles;
    } else {
        $items = swapi_get('vehicles');
        set_transient('swapi_get_vehicles', $items, 60*30);

        return $items;
    }
}
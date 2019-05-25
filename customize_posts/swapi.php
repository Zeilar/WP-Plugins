<?php

function swapi_get_films() {

    $films = get_transient('swapi_get_films');

    if ($films) {
        return $films;
    } else {

        $request = wp_remote_get("https://swapi.co/api/films/");

        if (wp_remote_retrieve_response_code($request) === 200) {

            $body = json_decode(wp_remote_retrieve_body($request));
            $films = $body->results;
            set_transient('swapi_get_films', $films, 60*15);

            return $films;
        } else {
            return false;
        }
    }
}
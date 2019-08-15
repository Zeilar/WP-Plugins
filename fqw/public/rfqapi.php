<?php

// Gets quotes via HTTP API
function rfq_get_quotes(string $query = '?cat=famous') {
    return json_decode(
        wp_remote_retrieve_body(
            wp_remote_get(
                'https://andruxnet-random-famous-quotes.p.mashape.com/' . $query,
                [
                    'headers' => [
                        'X-Mashape-Key' => 'oTEGnlmaNq2QWB1BfUPqhGyqNmL9UrJ5',
                        'X-Mashape-Host' => 'andruxnet-random-famous-quotes.p.mashape.com'
                    ]
                ]
            )
        )
    );
}
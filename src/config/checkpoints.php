<?php

return [
    // default recaptcha
    'default' => [
        // Paths are the URL paths needed to be checked by Recaptcha middleware
        'paths' => [
            'success'
        ]
    ],

    // invisible recaptcha
    'invisible' => [
        // Paths are the URL paths needed to be checked by InvisibleRecaptcha middleware
        'paths' => [
            'success'
        ]
    ],

];

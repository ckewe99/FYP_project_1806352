<?php

return [
    'name' => 'Sin-Min-Food-Ordering-System',
    'manifest' => [
        'name' => env('APP_NAME', 'Sin-Min-Food-Ordering-System'),
        'short_name' => 'Sin-Min-FOS',
        'start_url' => '/home',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => 'black',
        'icons' => [
            '128x128' => [
                'path' => '/images/icons/school_logo-128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/images/icons/school_logo-144.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/images/icons/school_logo-192.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/images/icons/school_logo-384.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/images/icons/school_logo-512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/images/icons/splash-640x1136.png',
            '750x1334' => '/images/icons/splash-750x1334.png',
            '828x1792' => '/images/icons/splash-828x1792.png',
            '1125x2436' => '/images/icons/splash-1125x2436.png',
            '1242x2208' => '/images/icons/splash-1242x2208.png',
            '1242x2688' => '/images/icons/splash-1242x2688.png',
            '1536x2048' => '/images/icons/splash-1536x2048.png',
            '1668x2224' => '/images/icons/splash-1668x2224.png',
            '1668x2388' => '/images/icons/splash-1668x2388.png',
            '2048x2732' => '/images/icons/splash-2048x2732.png',
        ],
        'custom' => []
    ]
];

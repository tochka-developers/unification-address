<?php

return [
    'logChannel'         => config('logging.default'),
    'pre_filter_handler' => null /*AddressPreFilter::class*/,
    'processing_sources' => [
        \Tochka\Unif\Address\Sources\RusPost::class => [
            'token' => env('RusPost_ACCESS_TOKEN'),
            'user'  => env('RusPost_USER'),
            'pass'  => env('RusPost_PASS'),
        ],
        \Tochka\Unif\Address\Sources\DaData::class => [
            'token'  => env('DADATA_TOKEN'),
            'secret' => env('DADATA_SECRET'),
        ],
    ],
];
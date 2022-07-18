<?php

return [
    'logChannel'         => config('logging.default'),
    'pre_filter_handler' => null /*AddressPreFilter::class*/,
    'processing_sources' => [
        \Tochka\Unif\Address\Sources\RusPost::class => [
            'token' => env('RUSPOST_ACCESS_TOKEN'),
            'user'  => env('RUSPOST_USER'),
            'pass'  => env('RUSPOST_PASS'),
        ],
        \Tochka\Unif\Address\Sources\DaData::class => [
            'token'  => env('DADATA_TOKEN'),
            'secret' => env('DADATA_SECRET'),
        ],
    ],
];
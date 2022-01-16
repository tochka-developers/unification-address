<?php

return [
    'pre_filter_handler' => null /*AddressPreFilter::class*/,
    'processing_sources' => [
        \Tochka\Unif\Address\Sources\DaData::class => [
            'token' => env('DADATA_TOKEN'),
            'secret' => env('DADATA_SECRET')
        ]
    ]
];
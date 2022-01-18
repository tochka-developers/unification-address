<?php

declare(strict_types=1);

namespace Tochka\Unif\Address;

use Carbon\Carbon;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Cache;
use Tochka\Unif\Address\Handlers\PreFilter;
use Tochka\Unif\Address\Handlers\Processing;

class UnifAddress
{
    /**
     * @param null|string $str
     * @return void
     */
    public function parsing(string $str): ?array
    {
        $key = str_replace(' ', '', class_basename(__CLASS__) . $str);

        return Cache::remember($key, (new Carbon())->addMonth(), function () use ($str) {
            return app(Pipeline::class)
                ->send($str)
                ->through([
                    PreFilter::class,
                    Processing::class,
                ])
                ->thenReturn();
        });
    }
}
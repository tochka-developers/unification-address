<?php

declare(strict_types=1);

namespace Tochka\Unif\Address\Handlers;

class PreFilter
{
    public function handle($address, \Closure $next)
    {
        $address = trim($address);

        if (($class = config('unif.pre_filter_handler')) !== null && class_exists($class)) {
            $address = (new $class())->handle($address);
        }

        return $next($address);
    }
}
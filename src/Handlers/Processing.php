<?php

namespace Tochka\Unif\Address\Handlers;

use Tochka\Unif\Address\Contracts\SourceInterface;

class Processing
{
    public function handle($address, \Closure $next)
    {
        $handlers = config('unif.processing_sources');

        if (!empty($handlers)) {
            foreach ($handlers as $handler => $authData) {
                if (class_exists($handler)) {
                    $parseAddress = (new $handler($authData))->processing($address);
                    if (isset($parseAddress['quality'])
                        && $parseAddress['quality'] === SourceInterface::QUALITY_GOOD) {
                        return $next($parseAddress);
                    }
                }
            }
        }

        return $next(null);
    }
}
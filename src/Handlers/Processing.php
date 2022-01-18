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
                    $address = (new $handler($authData))->processing($address);

                    if (isset($address['quality']) && $address['quality'] === SourceInterface::QUALITY_GOOD) {
                        return $next($address);
                    }
                }
            }
        }

        return $next($address);
    }
}
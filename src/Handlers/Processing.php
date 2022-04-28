<?php

namespace Tochka\Unif\Address\Handlers;

use Illuminate\Support\Facades\Log;
use Tochka\Unif\Address\Contracts\SourceInterface;

class Processing
{
    public function handle($address, \Closure $next)
    {
        $handlers = config('unif.processing_sources');

        if (!empty($handlers)) {
            foreach ($handlers as $handler => $authData) {
                if (class_exists($handler)) {
                    try {
                        $parseAddress = (new $handler($authData))->processing($address);
                    } catch (\Exception $e) {
                        Log::channel(config('unif.logChannel'))->error($e->getMessage(), [
                            'code' => $e->getCode(),
                            'file' => $e->getFile() . ':' . $e->getLine(),
                        ]);
                    }
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
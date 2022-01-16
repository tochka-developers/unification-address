<?php

declare(strict_types=1);

namespace Tochka\Unif\Address;

use Illuminate\Support\ServiceProvider;

class UnifAddressServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(UnifAddress::class, function () {
            return new UnifAddress();
        });
    }

    public function boot(): void
    {
        // публикуем конфигурации
        $this->publishes([__DIR__ . '/../config/unif.php' => config_path('unif.php')]);
    }
}
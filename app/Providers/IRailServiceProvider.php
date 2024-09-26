<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\IRail\APIService;
use App\Services\IRail\IRailApi;
use Illuminate\Support\ServiceProvider;

class IRailServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            IRailApi::class,
            fn () => new APIService(
                baseUri: config('services.iRail.uri'),
                timeout: config('services.iRail.timeout')
            )
        );
    }

    public function boot(): void
    {
    }
}

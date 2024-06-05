<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Services\TariffProvider\Api\TariffProviderApiService;

class TariffProviderServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TariffProviderApiService::class, fn () => new TariffProviderApiService(
            baseUrl: config('tariff_comparison.baseUrl')
        ));
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            TariffProviderApiService::class,
        ];
    }
}

<?php

namespace App\Providers;

use App\Contracts\Service\PostalCodeServiceInterface;
use App\Service\CepService\BrasilApiService;
use App\Service\CepService\ViaCepService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $cepClass = BrasilApiService::class;

        if ((new ViaCepService())->testApi()) {
            $cepClass = ViaCepService::class;
        }

        $this->app->bind(
            PostalCodeServiceInterface::class,
            $cepClass
        );
    }
}

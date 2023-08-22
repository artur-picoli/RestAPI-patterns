<?php

namespace App\Providers;

use App\Contracts\Repository\BrandRepositoryInterface;
use App\Contracts\Repository\CarRepositoryInterface;
use App\Contracts\Repository\CustomerRepositoryInterface;
use App\Contracts\Repository\SaleRepositoryInterface;
use App\Repository\SaleRepository;
use App\Repository\BrandRepository;
use App\Repository\CarRepository;
use App\Repository\CustomerRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public $bindings = [
        BrandRepositoryInterface::class => BrandRepository::class,
        CarRepositoryInterface::class => CarRepository::class,
        CustomerRepositoryInterface::class => CustomerRepository::class,
        SaleRepositoryInterface::class => SaleRepository::class
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     */
    public function boot(): void
    {
        // $this->app->bind(
        //     BrandRepositoryInterface::class,
        //     BrandRepository::class
        // );
        // $this->app->bind(
        //     CarRepositoryInterface::class,
        //     CarRepository::class
        // );
        // $this->app->bind(
        //     CustomerRepositoryInterface::class,
        //     CustomerRepository::class
        // );
        // $this->app->bind(
        //     SaleRepositoryInterface::class,
        //     SaleRepository::class
        // );
    }
}

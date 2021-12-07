<?php

namespace App\Providers;

use App\Services\ApiService;
use App\Interfaces\ApiInterface;
use App\Services\ProductService;
use App\Repositories\ApiRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\ApiRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\ProductServiceInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ApiRepositoryInterface::class, ApiRepository::class);
        $this->app->bind(ApiInterface::class, ApiService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

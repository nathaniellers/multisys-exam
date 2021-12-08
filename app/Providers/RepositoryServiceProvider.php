<?php

namespace App\Providers;

use App\Services\ApiService;
use App\Interfaces\Service\ApiServiceInterface;
use App\Services\ProductService;
use App\Repositories\ApiRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Repository\ApiRepositoryInterface;
use App\Interfaces\Repository\ProductRepositoryInterface;
use App\Interfaces\Service\EmailServiceInterface;
use App\Interfaces\Service\ProductServiceInterface;
use App\Services\Emailservice;

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
        $this->app->bind(ApiServiceInterface::class, ApiService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(EmailServiceInterface::class, Emailservice::class);
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

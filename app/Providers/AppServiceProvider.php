<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\ProductOrderServiceInterface;
use App\Services\ProductOrderService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(ProductOrderServiceInterface::class, ProductOrderService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

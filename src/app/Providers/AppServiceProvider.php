<?php

namespace App\Providers;

use App\Repositories\Eloquent\WagerRepository;
use App\Repositories\Eloquent\WagerTransactionRepository;
use App\Repositories\WagerRepositoryInterface;
use App\Repositories\WagerTransactionRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(WagerRepositoryInterface::class, WagerRepository::class);
        $this->app->bind(WagerTransactionRepositoryInterface::class, WagerTransactionRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

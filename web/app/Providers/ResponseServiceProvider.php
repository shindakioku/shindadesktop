<?php

namespace App\Providers;

use App\Services\Response\ResponseApi;
use App\Services\Response\ResponseContract;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ResponseContract::class, ResponseApi::class
        );
    }
}

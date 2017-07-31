<?php

namespace App\Providers;

use App\Services\Music\MusicContract;
use App\Services\Music\MusicService;
use Illuminate\Support\ServiceProvider;

class MusicServiceProvider extends ServiceProvider
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
            MusicContract::class,
            MusicService::class
        );
    }
}

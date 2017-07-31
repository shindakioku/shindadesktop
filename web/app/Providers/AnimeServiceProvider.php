<?php

namespace App\Providers;

use App\Services\Anime\AnimeContract;
use App\Services\Anime\AnimeService;
use Illuminate\Support\ServiceProvider;

class AnimeServiceProvider extends ServiceProvider
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
            AnimeContract::class,
            AnimeService::class
        );
    }
}

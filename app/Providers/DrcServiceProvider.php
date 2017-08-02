<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Drc\Drc;

class DrcServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Service
        $this->app->bind('drc', function ($app) {
            return new Drc($app);
        });

        //Facade
        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Drc', \App\Services\Drc\Facades\DrcFacade::class);
        });
    }
}
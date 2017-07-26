<?php

namespace Modules\User;

use Illuminate\Support\ServiceProvider;
use Route;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        // $this->loadRoutesFrom(__DIR__.'/routes.php');
        Route::middleware(['web', 'auth'])
             ->namespace('Modules\User\Controllers')
             ->group(__DIR__.'/routes.php');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'user');
        $this->loadViewsFrom(__DIR__.'/Views', 'user');

        // publish config file
        $this->publishes([
            __DIR__.'/../config' => config_path()
        ], 'config');

        // publish migration file
        $this->publishes([
            __DIR__.'/../resources/migrations' => database_path('migrations')
        ], 'migrations');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function info()
    {
        return [
            "name"=> "User",
            "slug"=> "user",
            "version"=> "1.0",
            "description"=> "Module: the user module (sns system).",
            "enabled"=> true,
        ];
    }
}

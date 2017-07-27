<?php

namespace Modules\Srch;

use Illuminate\Support\ServiceProvider;
use Route;
use View;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        View::share('module', 'srch');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');
        Route::middleware('web')
             ->namespace('Modules\Srch\Controllers')
             ->group(__DIR__.'/routes.php');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'srch');
        $this->loadViewsFrom(__DIR__.'/Views', 'srch');

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
            "name"=> "Srch",
            "slug"=> "srch",
            "version"=> "1.0",
            "description"=> "Module: the srch module.",
            "enabled"=> true,
        ];
    }
}

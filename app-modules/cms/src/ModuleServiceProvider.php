<?php

namespace Modules\Cms;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes.php');
        $this->loadViewsFrom(__DIR__.'/Views', 'base');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'base');

        // publish config file
        $this->publishes([
            __DIR__.'/../config' => config_path()
        ], 'config');

        // publish migration file
        $this->publishes([
            __DIR__.'/../migrations' => database_path('migrations')
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
            "name"=> "Cms",
            "slug"=> "cms",
            "version"=> "1.0",
            "description"=> "Module: the cms module.",
            "enabled"=> true,
        ];
    }
}

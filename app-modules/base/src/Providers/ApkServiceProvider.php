<?php

namespace Apk\Base\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class ApkServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        // Set views path
        $this->loadViewsFrom(__DIR__ . '/../Views', 'sec_base');

        // Publish views
        $this->publishes([
            __DIR__ . '/../Views' => base_path('resources/views/vendor/sec_base'),
        ]);
        
        $this->publishes([
            __DIR__.'/../app.php' => config_path('sec_base.php')
        ]);

        $this->publishes([
            __DIR__.'/../Database/Migrations/' => database_path('migrations')
        ]);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        App::register('Apk\Base\Providers\RouteServiceProvider');
    }
}

<?php

namespace Modules\Base;

use Illuminate\Support\ServiceProvider;
use Blade;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes.php');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'base');
        $this->loadViewsFrom(__DIR__.'/Views', 'base');

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
        // 1.注册别名
//        AliasLoader::getInstance([
//            'BaseController'    => \Apk\Base\Libraries\BaseController::class,
//            'BaseLogic'         => \Apk\Base\Libraries\BaseLogic::class,
//            'BaseModel'         => \Apk\Base\Libraries\BaseModel::class,
//            'BaseService'       => \Apk\Base\Libraries\BaseService::class,
//        ])->register();
    }

    public function info()
    {
        return [
            "name"=> "Base",
            "slug"=> "base",
            "version"=> "1.0",
            "description"=> "BaseModule: the base of all module.",
            "enabled"=> true,
        ];
    }
}

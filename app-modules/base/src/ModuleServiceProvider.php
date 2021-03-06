<?php

namespace Modules\Base;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Modules\Base\Models\SiteSetting;
use App;
use Config;
use Schema;
use Route;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        // 1.把setting注册进config
        if (!App::runningInConsole() && count(Schema::getColumnListing('settings'))) {
            // get all settings from the database
            $settings = SiteSetting::all();

            // bind all settings to the Laravel config, so you can call them like
            // Config::get('settings.contact_email')
            foreach ($settings as $key => $setting) {
                Config::set('settings.'.$setting->key, $setting->value);
            }
        }

        // 2.注册中间件别名
        Route::aliasMiddleware('admin', \Modules\Base\Middleware\Admin::class);
        Route::aliasMiddleware('admin.logined', \Modules\Base\Middleware\AdminLogined::class);

        // $this->loadRoutesFrom(__DIR__.'/routes.php');
        Route::middleware('web')
             ->namespace('Modules\Base\Controllers')
             ->group(__DIR__.'/routes.php');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'base');
        $this->loadViewsFrom(__DIR__.'/Views', 'base');

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
        // 1.注册别名
        AliasLoader::getInstance([
            'BaseController'    => \Modules\Base\Libraries\BaseController::class,
            'BaseLogic'         => \Modules\Base\Libraries\BaseLogic::class,
            'BaseModel'         => \Modules\Base\Libraries\BaseModel::class,
//            'BaseService'       => \Apk\Base\Libraries\BaseService::class,
        ])->register();
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

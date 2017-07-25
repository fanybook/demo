<?php

namespace Apk\Base\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * 定义路由的命名空间前缀
     */
    protected $namespace = 'Apk\Base\Controllers';

    /**
     * 定义模块路由.
     */
    public function map()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');
    }
}

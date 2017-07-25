<?php

namespace Apk\Base\Facades;

use Illuminate\Support\Facades\Facade;

class Storage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mystorage';
    }
}

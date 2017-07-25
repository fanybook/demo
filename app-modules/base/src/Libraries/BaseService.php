<?php

namespace Apk\Base\Libraries;

class BaseService
{
    public function __construct()
    {
        //dd(explode('\\', get_class($this)));
    }

    public function set($key, $value)
    {
        $this->$key = $value;
    }
}

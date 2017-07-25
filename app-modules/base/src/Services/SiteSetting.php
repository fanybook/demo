<?php

namespace Apk\Base\Services;

use Apk\Base\Models;
use Cache;

class SiteSetting extends \BaseService
{
    public function getSiteSetting()
    {
        if (Cache::has('site_setting')) {
            return Cache::get('site_setting');
        }

        $result  = Models\SiteSetting::all();
        $setting = [];
        foreach ($result as $item) {
            $setting[$item->key] = $item->value;
        }

        Cache::forever('site_setting', $setting);

        return $setting;
    }
}

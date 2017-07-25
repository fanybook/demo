<?php

namespace Apk\Base\Logics\Admin\SiteSetting;

use Apk\Base\Models;
use Exception;
use Request;
use Validator;
use Cache;

class PostIndex extends \BaseLogic
{
    protected function execute()
    {
        try {

            $this->validate();

            $this->setting();

            $this->result['result'] = true;

        } catch (Exception $e) {
            $this->result['result']     = false;
            $this->result['message']    = $e->getMessage();
        }
    }

    protected function validate ()
    {
        $validator = Validator::make(Request::all(), [
            'setting_key'       => 'required|max:255',
            'setting_value'     => 'required',
            'setting_memo'      => 'max:255',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages()->first());
        }
    }


    protected function setting()
    {
        $get_setting = Models\SiteSetting::where('key', trim(Request::input('setting_key')))->first();

        if ($get_setting) {
            $this->setting = $get_setting;
        } else {
            $this->setting = new Models\SiteSetting();
        }

        $this->setting->key   = trim(Request::input('setting_key'));
        $this->setting->value = Request::input('setting_value');

        if (Request::has('setting_memo')) {
            $this->setting->memo  = Request::input('setting_memo');
        }

        $this->setting->save();

        // 更新缓存中的setting
        $result  = Models\SiteSetting::all();

        $setting = [];
        foreach ($result as $item) {
            $setting[$item->key] = $item->value;
        }

        Cache::forever('site_setting', $setting);

        $this->result['message'] = $this->setting->key . '：设置成功';
    }
}

<?php

namespace Apk\Navi\Logics\Admin\Navi;

use Apk\Navi\Models;
use Exception;
use Request;
use Validator;

class PostAdd extends \BaseLogic
{
    protected function execute()
    {
        try {

            $this->validate();

            $this->add();

            $this->result['result'] = true;

        } catch (Exception $e) {
            $this->result['result']  = false;
            $this->result['message'] = $e->getMessage();
        }
    }

    protected function validate ()
    {
        $validator = Validator::make(Request::all(), [
            'navi_name'     => 'required|max:20',
            'navi_slug'     => 'required|max:20',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages()->first());
        }

        // 判断导航名称是否已经存在
        $get_navi = Models\Navi::where('navi_name', Request::input('navi_name'))
                               ->orWhere('navi_slug', Request::input('navi_slug'))
                               ->first();

        if ($get_navi) {
            throw new Exception('导航名称已经存在');
        }
    }


    protected function add()
    {
        $this->navi = new Models\Navi();
        $this->navi->navi_name      = Request::input('navi_name');
        $this->navi->navi_slug      = Request::input('navi_slug');

        $this->navi->save();

        $this->result['message'] = '导航添加成功';
    }
}

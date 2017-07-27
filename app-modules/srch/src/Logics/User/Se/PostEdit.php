<?php

namespace Modules\Srch\Logics\User\Se;

use Modules\Srch\Models;
use Exception;
use Request;
use Validator;

class PostEdit extends \BaseLogic
{
    protected function execute()
    {
        try {

            $this->validate();

            $this->edit();

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

        // 判断id是否存在
        $this->navi = Models\Se::find($this->seId);
        if (!$this->navi) {
            throw new Exception('导航不存在');
        }

        // 判断导航名称和slug是否已经存在
        $get_navi = Models\Se::whereRaw('id != '.$this->seId)
                             ->where(function($q) {
                                 $q->where('navi_name', Request::input('navi_name'))
                                   ->orWhere('navi_slug', Request::input('navi_slug'));
                             })
                             ->first();

        if ($get_navi) {
            throw new Exception('导航名称已经存在');
        }
    }


    protected function edit()
    {
        $this->navi->navi_name      = Request::input('navi_name');
        $this->navi->navi_slug      = Request::input('navi_slug');

        $this->navi->save();

        $this->result['message'] = '导航编辑成功';
    }
}

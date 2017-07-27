<?php

namespace Apk\Navi\Controllers\Admin;

use Apk\Navi\Logics;
use Apk\Navi\Models;
use Request;

class CateGoodsController extends \BaseController
{
    public function getIndex()
    {
        $logic = new Logics\Admin\CateGoods\GetIndex();
        $result = $logic->run();

        return view('sec_navi::admin.cate_goods.index')->with('result', $result);
    }

    public function postAdd()
    {
        $logic = new Logics\Admin\CateGoods\PostAdd();
        $result = $logic->run();

        return $result;
    }

    public function postEdit($id)
    {
        $logic = new Logics\Admin\CateGoods\PostEdit();
        $logic->set('naviItemId', $id);
        $result = $logic->run();

        return $result;
    }

    public function apiGetInfo()
    {
        $result = ['result' => true, 'message' => '分类信息获取成功'];
        $result['info'] = Models\NaviItemGoods::find(Request::input('navi_item_id'));
        return $result;
    }

    public function apiDelete()
    {
        $result = ['result' => true, 'message' => '分类项删除成功'];
        Models\NaviItemGoods::destroy(Request::input('navi_item_id'));
        return $result;
    }
}

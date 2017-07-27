<?php

namespace Modules\Srch\Controllers\User;

use Modules\Srch\Logics;
use Modules\Srch\Models;
use Request;

class SeItemController extends \BaseController
{
    public function postAdd()
    {
        $logic = new Logics\User\SeItem\PostAdd();
        $result = $logic->run();

        return $result;
    }

    public function postEdit($id)
    {
        $logic = new Logics\User\SeItem\PostEdit();
        $logic->set('seItemId', $id);
        $result = $logic->run();

        return $result;
    }

    public function apiDetail()
    {
        $result = ['result' => true, 'message' => '信息获取成功'];
        $result['info'] = Models\SeItem::find(Request::input('navi_item_id'));
        return $result;
    }

    public function apiDelete()
    {
        $result = ['result' => true, 'message' => '导航项删除成功'];
        Models\SeItem::destroy(Request::input('navi_item_id'));
        return $result;
    }
}

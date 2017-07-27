<?php

namespace Modules\Srch\Controllers\User;

use Modules\Srch\Logics;
use Modules\Srch\Models;

class SeController extends \BaseController
{
    public function index()
    {
        $logic = new Logics\User\Se\GetIndex();
        $result = $logic->run();

        return view('srch::user.se.index')->with('result', $result);
    }

    public function add()
    {
        return view('sec_navi::admin.navi.add');
    }

    public function edit($id)
    {
        $logic = new Logics\User\Se\GetEdit();
        $logic->set('seId', $id);
        $result = $logic->run();

        return view('srch::user.se.edit')->with('result', $result);
    }

    public function postAdd()
    {
        $logic = new Logics\Admin\Navi\PostAdd();
        $result = $logic->run();

        return $result;
    }

    public function postEdit($id)
    {
        $logic = new Logics\User\Se\PostEdit();
        $logic->set('seId', $id);
        $result = $logic->run();

        return $result;
    }
}

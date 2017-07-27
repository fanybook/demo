<?php

namespace Modules\Srch\Controllers\Front;

use Modules\Srch\Logics;
use Input;
use View;

class SeController extends \BaseController
{
    public function show($id)
    {
        dd($id);
        $model = new Logics\Front\Index();
        $result = $model->run();
        return View::make('srch::front.index')->with('result', $result);
    }
}
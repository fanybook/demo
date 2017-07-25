<?php

namespace Apk\Base\Controllers\Admin;

class HomeController extends \BaseController
{
    public function getIndex()
    {
        return view('sec_base::admin.index');
    }
}

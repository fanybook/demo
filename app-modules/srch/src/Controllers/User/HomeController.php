<?php

namespace Modules\Srch\Controllers\User;

use App\Http\Controllers\Controller;
use App;
use Request;

class HomeController extends Controller
{
    /*
     * Get Method
     */
    public function index()
    {
        return view('srch::user.home.index');
    }
}

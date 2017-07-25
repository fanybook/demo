<?php

namespace Apk\Base\Libraries;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Mobile_Detect;

abstract class BaseController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->detect = new Mobile_Detect();
    }
}
//class BaseController
//{
//  public function __construct()
//  {
//      dd(explode('\\', get_class($this)));
//  }
//}
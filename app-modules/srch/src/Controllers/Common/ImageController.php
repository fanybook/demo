<?php

namespace Apk\Base\Controllers\Common;

use Apk\Base\Libraries\File\Storage;
use Apk\Base\Logics\Common\Image;

class ImageController extends \BaseController
{
    public function __construct()
    {
    }

    public function getTest()
    {
        $storage = new Storage();
        dd($storage->lists('data'));
    }

    public function postUpload()
    {
        $logic = new Image\PostUpload();
        $result = $logic->run();

        return $result;
    }

    public function postDelete()
    {
        $logic = new Image\PostDelete();
        $result = $logic->run();

        return $result;
    }
}

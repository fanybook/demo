<?php

namespace Apk\Base\Logics\Common\Image;

use Apk\Base\Libraries\Image;
use Exception;
use Request;
use Validator;
use Storage;

class PostDelete extends \BaseLogic
{
    protected function execute()
    {
        try {

            $this->validate();

            $this->delete();

            $this->result['result'] = true;

        } catch (\Exception $e) {

            $this->result['result']  = false;
            $this->result['message'] = $e->getMessage();

        }
    }

    protected function validate ()
    {
        if (Storage::exists('file.jpg'))
        {
            //
        }
    }

    protected function delete()
    {
        // 上传图片
        $fu = new Image\Upload();
        $ret = $fu->upload($_FILES['imageData']);

        $this->result['imgInfo'] = $ret;
    }
}

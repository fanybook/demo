<?php

namespace Apk\Base\Logics\Common\Image;

use Apk\Base\Libraries\Image;
use Config;

class PostUpload extends \BaseLogic
{
    protected function execute()
    {
        try {

            $this->validate();

            $this->upload();

            $this->result['result'] = true;

        } catch (\Exception $e) {

            $this->result['result']  = false;
            $this->result['message'] = $e->getMessage();

        }
    }

    protected function validate ()
    {
        //
    }

    protected function upload()
    {
        // 上传图片
        $fu = new Image\Upload();
        $ret = $fu->upload($_FILES['imageData']);

        $this->result['imgInfo'] = $ret;
    }
}

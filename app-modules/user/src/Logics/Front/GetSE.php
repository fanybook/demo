<?php namespace SearchBox\Model\Front;

use \Input;
use \Tag;

class GetSE extends \BaseModel
{
    protected function execute()
    {
        try {
            $this->getSE();
            $this->result['result'] = true;
        } catch (\Exception $e) {
            $this->result['result']  = false;
            $this->result['message'] = $e->getMessage();
        }
    }

    protected function getSE()
    {
        $this->result['se'] = array();
        $getTag = Tag::find(Input::get('tag'));

        if ($getTag) {
            foreach ($getTag->ses as $item) {
                $this->result['se']['se' . $item->id] = $item->toArray();
            }
        }
    }
}
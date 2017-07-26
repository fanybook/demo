<?php namespace SearchBox\Model\Front;

use \Input;

class BtMagnet extends \BaseModel
{
    protected function execute()
    {
        try {
            $this->getBtMagnet();
            $this->result['result'] = true;
        } catch (\Exception $e) {
            $this->result['result']  = false;
            $this->result['message'] = $e->getMessage();
        }
    }

    protected function getBtMagnet()
    {
        if (Input::get('wd')) {
            $sc = new \Fanybook\SingleCurllor();

            $sc->setRulePath('btspread.xml');
            $rules = $sc->getRules();

            $sc->setUrl('http://www.btspread.com/search/'.urlencode(Input::get('wd')));
            $html = $sc->doCurl();

            $this->result['res'] = $sc->parseHtml($html, $rules);
        }
    }
}
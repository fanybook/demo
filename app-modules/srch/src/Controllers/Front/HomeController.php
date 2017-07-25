<?php

namespace Modules\Srch\Controllers\Front;

use Modules\Srch\Logics;
use Fanybook\SingleCurllor;
use Input;
use View;

class HomeController extends \BaseController
{
    public function __construct()
    {
        $model = new Logics\Front\Index();
        $result = $model->run();

        View::share('seConfig',$result['seConfig']);
    }

    public function getIndex()
    {
        $model = new Logics\Front\Index();
        $result = $model->run();
        return View::make('srch::front.index')->with('result', $result);
    }

    public function getPan()
    {
        list($wd) = explode(' more:', Input::get('wd'));
        $page = (int) Input::get('page') ? Input::get('page') : 1;

        $num = 10;
        $start = ($page - 1) * $num;
        $start = $start > 90 ? 90 : $start;

        $curllor = new SingleCurllor();
        $url = sprintf('%s?key=%s&hl=%s&cx=%s&num=%d&start=%d&q=%s'
                     , 'https://www.googleapis.com/customsearch/v1element'
                     , 'AIzaSyCVAXiUzRYsML1Pv6RwSG1gunmMikTzQqY'
                     , 'zh_CN'
                     , '009672497761265033620:sb5r5ccmf-i'
                     , $num
                     , $start
                     , urlencode (Input::get('wd')));

        $curllor->setUrl($url);
        $result = $curllor->run();

        $tags = array (
            array (
                'label' => '百度网盘',
                'label_with_op' => 'more:百度网盘',
            ),
            array (
                'label' => '115礼包',
                'label_with_op' => 'more:115礼包',
            ),
            array (
                'label' => '腾讯微云',
                'label_with_op' => 'more:腾讯微云',
            ),
            array (
                'label' => '新浪微盘',
                'label_with_op' => 'more:新浪微盘',
            ),
            array (
                'label' => 'dbank',
                'label_with_op' => 'more:dbank',
            ),
            array (
                'label' => '作为补充',
                'label_with_op' => 'more:作为补充',
            ),
        );

        $result = json_decode($result, true);
        if (!isset($result['results'])) {
            $items = \Paginator::make(array(), 0, $num);
        } else {
            $totalConut = $result['cursor']['resultCount'] > 100 ? 100 : $result['cursor']['resultCount'];
            $items = \Paginator::make($result['results'], $totalConut, $num);
        }

        return View::make('srch::front.pan')->with('tags', $tags)
                                                 ->with('items', $items)
                                                 ->with('wd', $wd);
    }

    public function getAddSE()
    {
        return View::make('sbox::front.addSE');
    }

    public function postAddSE()
    {
        $model = new Logics\Front\AddSE();
        $result = $model->run();

        return $result;
    }

    public function postGetSE()
    {
        $model = new Logics\Front\GetSE();
        $result = $model->run();

        return $result;
    }

    public function getBtMagnet()
    {
        $model = new Logics\Front\BtMagnet();
        $result = $model->run();

        return View::make('srch::front.index')->with('result', $result);
    }
}
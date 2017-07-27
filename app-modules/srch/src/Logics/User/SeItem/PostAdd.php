<?php

namespace Apk\Navi\Logics\Admin\NaviItem;

use Apk\Base\Facades\Storage;
use Apk\Navi\Models;
use Exception;
use Request;
use Validator;

class PostAdd extends \BaseLogic
{
    protected function execute()
    {
        try {

            $this->validate();

            $this->add();

            $this->result['result'] = true;

        } catch (Exception $e) {
            $this->result['result']     = false;
            $this->result['message']    = $e->getMessage();
        }
    }

    protected function validate ()
    {
        $validator = Validator::make(Request::all(), [
            'navi_id'       => 'required|integer',
            'navi_title'    => 'required|max:50',
            'navi_link'     => 'max:255',
            'navi_image'    => 'max:255',
            'parent_id'     => 'required',
            'sort_order'    => 'required|integer',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages()->first());
        }

        // 判断导航项title是否已经存在
        $get_navi_item = Models\NaviItem::where('navi_id', Request::input('navi_id'))
                                        ->where('navi_title', Request::input('navi_title'))->first();

        if ($get_navi_item) {
            throw new Exception('导航项已经存在，请更换标题');
        }

        // 判断上级导航项是否存在
        if (Request::input('parent_id') > 0) {
            $this->parent = Models\NaviItem::find(Request::input('parent_id'));

            if (!$this->parent) {
                throw new Exception('上级导航项不存在');
            }
        }
    }

    protected function add()
    {
        $this->naviItem = new Models\NaviItem();
        $this->naviItem->navi_id        = Request::input('navi_id');
        $this->naviItem->navi_title     = Request::input('navi_title');
        $this->naviItem->parent_id      = Request::input('parent_id');
        $this->naviItem->sort_order     = Request::input('sort_order');

        if (Request::has('navi_link')) {
            $this->naviItem->navi_link      = Request::input('navi_link');
        }

        if (!Request::has('is_show')) {
            $this->naviItem->is_show    = 0;
        }

        if (Request::has('navi_link') && Request::has('new_window_open')) {
            $this->naviItem->new_window_open    = Request::input('new_window_open');
        }

        $this->naviItem->save();

        if (!$this->naviItem->id) {
            throw new Exception('导航项添加失败');
        }

        if (Request::has('navi_image')) {
            if (Storage::exists(Request::input('navi_image'))) {
                $new_image = sprintf('/data/navi/img_%d%s', $this->naviItem->id, strtolower(strrchr(Request::input('navi_image'), '.')));
                $result = Storage::move(Request::input('navi_image'), $new_image);

                if ($result) {
                    $this->naviItem->navi_image     = $new_image;
                    $this->naviItem->save();
                }
            }
        }

        $this->result['message'] = '导航项添加成功';
    }
}

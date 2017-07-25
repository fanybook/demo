<?php namespace SearchBox\Model\Front;

use \Input;
use \Validator;
use \Auth;
use \DB;
use \Se;
use \Tag;

class AddSE extends \BaseModel
{
    protected function preExecute () {
        Input::merge(array_map('trim', Input::all()));
    }

    protected function execute()
    {
        try {
            $this->validate();

            $this->addSE();
            if (Input::has('tags')) $this->addTags();

            $this->result['result'] = true;
        } catch (\Exception $e) {
            $this->result['result']  = false;
            $this->result['message'] = $e->getMessage();
        }
    }

    protected function validate () {
        $this->result['message'] = '';

        $rules = array(
            'name' => 'required',
            'url' => 'required|url',
            'parameter' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            throw new \Exception($validator->messages()->first());
        }

        // 判断name是否已经存在
        $getSe = Se::where('name', Input::get('name'))->first();

        if ($getSe) {
            throw new \Exception('名字已经存在');
        }

        // mbl的URL不能和pc的相同
        if (Input::get('url_mbl') === Input::get('url')) {
            throw new \Exception('移动版的URL重复了，请再核对一下');
        }
    }


    protected function addSE()
    {
        $se = new Se;
        $se->name = Input::get('name');
        $se->url = Input::get('url');
        $se->parameter = Input::get('parameter');
        $se->created_id = Auth::user()->id;

        if (Input::has('method') && ucwords(Input::has('method')) == 'POST') {
            $se->method = 'POST';
        } else {
            $se->method = 'GET';
        }

        if (Input::has('url_mbl'))     $se->url_mbl     = Input::get('url_mbl');
        if (Input::has('btnText'))     $se->btnText     = Input::get('btnText');
        if (Input::has('placeholder')) $se->placeholder = Input::get('placeholder');
        if (Input::has('description')) $se->description = Input::get('description');
        if (Input::has('hidden'))      $se->hidden      = Input::get('hidden');

        $se->save();

        $getSe = Se::where('name', Input::get('name'))->first();

        if (!$getSe) {
            throw new \Exception('搜索框创建失败');
        }

        $this->result['message'] = '搜索框创建成功';

        $this->se_id = $getSe->id;
    }

    /**
     * 添加tag标签，先删除原有tag，再添加新tag
     */
    protected function addTags()
    {
        // 替换全角空格，再trim，再去除空tag
        $tags = strtr(Input::get('tags'), array('　' => ''));
        $tags = explode(' ', trim($tags));
        $tags = array_diff($tags, array(''));

        foreach ($tags as $name) {
            // 判断tag是否已经存在了
            $getTag = Tag::where('name', $name)->first();

            // 如果tag存在，在关系表中插入关系
            if ($getTag) {
                $tag_id = $getTag->id;
            // 如果tag不存在，先插tag再插关系
            } else {
                $tag = new Tag;
                $tag->name= $name;
                $tag->save();
                $tag_id = $tag->id;
            }

            DB::table('r_tag_se')->insert(array(
                'tag_id'     => $tag_id,
                'se_id'      => $this->se_id,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ));
        }
    }
}
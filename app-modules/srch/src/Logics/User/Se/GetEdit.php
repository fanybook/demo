<?php

namespace Modules\Srch\Logics\User\Se;

use Modules\Srch\Models;

class GetEdit extends \BaseLogic
{
    protected function execute()
    {
        $this->getSe();
        $this->getSeTree();
    }

    protected function getSe()
    {
        $this->result['se'] = Models\Se::find($this->seId);
    }

    protected function getSeTree()
    {
        $result = Models\SeItem::where('navi_id', $this->seId)
                          ->where('parent_id', 0)
                          ->orderBy('sort_order')
                          ->get();

        $this->html = '';
        $this->option = '';
        $this->makeHtml($result);

        $this->result['se_html'] = $this->html;
        $this->result['se_option'] = $this->option;
    }

    protected function makeHtml($items, $depth = 0)
    {
        $this->html .= '<ul>';

        foreach ($items as $item) {

            $children = $item->children;
            if ($depth == 0) {
                $this->option .= '<option value="' . $item->id . '">' . str_pad('', $depth * 3 , '　') . $item->navi_title . '</option>';
            }

            $this->html .= '    <li rel="' . $item->id . '">';
            $tmp_class   = $children->count() > 0 ? ' glyphicon-minus-sign' : '';
            $tmp_title   = $item->is_show ? $item->navi_title : '<s>' . $item->navi_title . '</s>';
            $this->html .= '        <span><i class="glyphicon' . $tmp_class . '"></i> ' . $tmp_title . '</span>';

            if ($item->navi_link) {
                $this->html .= ' <a href="' . $item->navi_link . '" title="' . $item->navi_link . '" target="_blank"><i class="glyphicon glyphicon-globe"></i></a>';
            } else {
                $this->html .= ' <a href="javascript:void(0);" class="icon-disabled"><i class="glyphicon glyphicon-globe"></i></a>';
            }

            if ($item->new_window_open) {
                $this->html .= ' <i class="glyphicon glyphicon-new-window"></i>';
            } else {
                $this->html .= ' <i class="glyphicon glyphicon-new-window icon-disabled"></i>';
            }

            if ($item->navi_image) {
                $this->html .= ' <a href="' . $item->navi_image . '" class="show-img"><i class="glyphicon glyphicon-picture"></i></a>';
            } else {
                $this->html .= ' <a href="javascript:void(0);" class="icon-disabled"><i class="glyphicon glyphicon-picture"></i></a>';
            }

            $this->html .= ' <a href="#" data-toggle="modal" data-target="#myModal" data-id="' . $item->id . '" data-action="edit"><i class="glyphicon glyphicon-edit"></i></a>';

            if ($depth == 0) {
                $this->html .= ' <a href="#" data-toggle="modal" data-target="#myModal" data-id="' . $item->id . '" data-action="add"><i class="glyphicon glyphicon-plus"></i></a>';
            }

            if ($children->count() > 0) {
                $this->makeHtml($children, $depth + 1);
            }

            $this->html .= '    </li>';
        }

        $this->html .= '</ul>';
    }
}

@extends('user::_layouts.user')
@php
  $unfolded = 'srch_setting'; $active = 'srch_setting_se';
@endphp

@section('title', '引擎方案编辑')

@section('content-header')
引擎方案编辑
@endsection

@section('breadcrumb')
<li><a href="/user/srch/se">引擎方案</a></li>
<li class="active">编辑</li>
@endsection

@section('main-content')
<div class="panel panel-default">
    <div class="panel-body">
        <form method="POST" class="main-form form-horizontal" accept-charset="UTF-8" autocomplete="off" novalidate="novalidate">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="col-sm-2 control-label">导航名称</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="navi_name" value="{{ $result['se']->navi_name }}">
                </div>
<!--                <label class="col-sm-2 control-label">导航slug</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="navi_slug" value="{{ $result['se']->navi_slug }}">
                </div>-->
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
        </form>
    </div>
</div><!-- /.panel -->

<div class="toolbar row">
    <div class="col-xs-12 text-center">
        <button type="button" class="btn btn-success btn-sm show-all"><i class="fa fa-plus"></i> 展开所有</button>
        <button type="button" class="btn btn-danger btn-sm show-first"><i class="fa fa-minus"></i> 收至首层</button>
    </div>
</div><!-- /.toolbar -->

<div class="box" style="margin-top: 15px;margin-bottom: 0;">
    <div class="box-body">
        <div class="tree">
        <ul>
            <li rel="0">
                {{ $result['se']->navi_name }} <a href="#" data-toggle="modal" data-target="#myModal" data-id="0" data-action="add"><i class="glyphicon glyphicon-plus"></i></a>
                {!! $result['se_html'] !!}
            </li>
        </ul>
        </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>
@endsection

@section('hidden-items')
<div id="tpl-modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
    </div>

    <form method="POST" action="" class="main-form form-horizontal" accept-charset="UTF-8" autocomplete="off" novalidate="novalidate">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="navi_id" value="{{ $result['se']->id }}">
        <div class="modal-body">
            <div class="form-group">
                <label class="col-sm-2 control-label">名称</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="navi_title">
                </div>
                <label class="col-sm-3 checkbox" style="padding-left: 20px;"><input type="checkbox" name="is_show" value="1" checked> 是否显示</label>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">链接</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="navi_link">
                </div>
                <label class="col-sm-3 checkbox" style="padding-left: 20px;"><input type="checkbox" name="new_window_open" value="1"> 新窗口打开</label>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">父级导航</label>
                <div class="col-sm-7">
                    <select name="parent_id">
                        <option value="0">顶级分类</option>
                        {!! $result['se_option'] !!}
                    </select>
                </div>
                <div class="col-sm-3" style="padding-left: 0;">
                    <input type="text" class="form-control" name="sort_order" placeholder="排序">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left">删除</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-primary">保存</button>
        </div>
    </form>
</div>
@endsection

@section('head-assets')
{!! style('/assets/third-party/bootstrap-tree/bootstrap-tree.css') !!}

<style>
.tree {
    background-color: #fff !important;
    border: none !important;
    box-shadow: none !important;
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
}

.tree > ul {
    padding-left: 0 !important;
}

.tree ul {
    padding-left: 40px;
}

.tree i {
    color: #f4645f;
}

.tree li.parent_li > span:hover,
.tree li.parent_li > span:hover ~ ul li span {
    background: #ddd !important;
}

.tree a.icon-disabled i,
.tree i.icon-disabled {
    color: #999;
}

i.glyphicon:after {
    content: " ";
    width: 5px;
    height: 10px;
}

.form-group img {
    max-width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
}
</style>
@endsection

@section('foot-assets')
{!! script('/assets/third-party/jquery-colorbox/js/jquery.colorbox-min.js') !!}
{!! style('/assets/third-party/jquery-colorbox/css/colorbox.css') !!}

{!! script('/assets/srch/js/user/se_item.edit.js') !!}

<script type="text/javascript">
$(function(){
    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', '收起目录');
    $('.tree li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(':visible')) {
            children.hide('fast');
            $(this).attr('title', '展开目录').find(' > i').addClass('glyphicon-plus-sign').removeClass('glyphicon-minus-sign');
        } else {
            children.show('fast');
            $(this).attr('title', '收起目录').find(' > i').addClass('glyphicon-minus-sign').removeClass('glyphicon-plus-sign');
        }
        e.stopPropagation();
    });

    $('.show-all').on('click', function () {
        $('.tree li').show('fast');
        $('.tree i.glyphicon-plus-sign').addClass('glyphicon-minus-sign').removeClass('glyphicon-plus-sign');
    });

    $('.show-first').on('click', function () {
        $('.tree > ul > li > ul > li > span i').each(function() {
            if ($(this).hasClass('glyphicon-minus-sign')) {
                $(this).addClass('glyphicon-plus-sign').removeClass('glyphicon-minus-sign')
            }
        });
        $('.tree > ul > li > ul > li li').hide('fast');
    });

    $('.show-img').colorbox({maxWidth: "90%", maxHeight: "90%"});

    var base = new Base();
    base.initForm(window.location.href);

    $('#myModal').on('show.bs.modal', function (e) {
        if ($(e.relatedTarget).data('action') == 'add') {
            var parent_id = $(e.relatedTarget).data('id');

            var tpl_content = $('#tpl-modal-content').clone();
            tpl_content.find('form').attr('action', '/user/srch/se-item/add');
            tpl_content.find('.modal-title').text('添加分类/sbox');
            tpl_content.find('.modal-footer button:first').hide();
            $('.modal-content').html(tpl_content.html());

            $('.modal-content .select-group li[data-value="' + parent_id + '"]').click();
            $('.modal-content input[name="sort_order"]').val($('li[rel="' + parent_id + '"] > ul > li').size());
        } else {
            var se_item_id = $(e.relatedTarget).data('id');

            var tpl_content = $('#tpl-modal-content').clone();
            tpl_content.find('form').attr('action', '/user/srch/se-item/' + se_item_id + '/edit');
            tpl_content.find('.modal-title').text('编辑');
            $('.modal-content').html(tpl_content.html());

            var se_item = new SeItem();
            se_item.getDetail(se_item_id, $(this));
        }
    });

    $(document).on('click', '.modal-content .modal-footer .btn-danger', function() {
        var se_item_id = $(this).data('id');

        var se_item = new SeItem();
        se_item.deleteSeItem(se_item_id);
    });
});
</script>
@endsection

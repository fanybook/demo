@extends('searchbox::_layout.master')
@section('title')新建搜索框@stop

@section('styles')
<style type="text/css">
    body {
        background-color: #eee;
    }

    .form-signin {
        max-width: 330px;
        padding: 15px;
    }
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
        margin-bottom: 10px;
    }
    .form-signin .checkbox {
        font-weight: normal;
    }
    .form-signin .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
          -moz-box-sizing: border-box;
            box-sizing: border-box;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="text"] {
        margin-bottom: -1px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>
@stop

@section('content')
{{ Form::open(array('url' => '/addSE', 'class' => 'form-signin', 'autocomplete' => 'off')) }}
    <h2 class="form-signin-heading">新建搜索框</h2>
    <input type="text" class="form-control" name="name" placeholder="搜索框的名字" autofocus>
    <input type="text" class="form-control" name="url" placeholder="提交时请求的URL">
    <input type="text" class="form-control" name="url_mbl" placeholder="提交时请求的URL（移动版）">
    <input type="text" class="form-control" name="parameter" placeholder="搜索关键词在URL里的参数名">
    <input type="text" class="form-control" name="btnText" placeholder="搜索按钮的文字">
    <input type="text" class="form-control" name="placeholder" placeholder="搜索框内说明">
    <textarea class="form-control" rows="3" name="description" placeholder="搜索框的描述"></textarea>
    <textarea class="form-control" rows="2" name="tags" placeholder="搜索框的标签，多个标签之间用半角空格分开"></textarea>
    <textarea class="form-control" rows="2" name="hidden" placeholder="隐藏提交项"></textarea>
    <button class="btn btn-lg btn-primary btn-block" type="submit">创建</button>
{{ Form::close() }}
@stop

@section('scripts')
{{ HTML::script('/assets/js/front/search.addSE.js') }}
@stop
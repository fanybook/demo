@extends('sec_base::_layout.admin')

@section('title', '导航添加')

@section('breadcrumbs')
<strong>导航</strong>
/ <small>添加</small>
@endsection

@section('main-contents')
<div class="panel panel-default">
    <div class="panel-body">
        <form method="POST" class="main-form form-horizontal" accept-charset="UTF-8" autocomplete="off" novalidate="novalidate">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label class="col-sm-2 control-label">导航名称</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="navi_name">
                </div>
                <label class="col-sm-2 control-label">导航slug</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="navi_slug">
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
        </form>
    </div>
</div><!-- /.panel -->
@endsection

@section('foot-assets')
<script type="text/javascript">
$(function(){
    var base = new Base();
    base.initForm('./');
});
</script>
@endsection

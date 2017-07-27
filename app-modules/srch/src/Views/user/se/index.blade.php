@extends('user::_layouts.user')
@php
  $unfolded = 'srch_setting'; $active = 'srch_setting_se';
@endphp

@section('title', '引擎方案列表')

@section('content-header')
引擎方案管理<small>新增，编辑和删除方案。</small>
@endsection

@section('breadcrumb')
<li><a href="/user/srch/se">引擎方案</a></li>
<li class="active">列表</li>
@endsection

@section('main-content')
<div class="toolbar row">
    <div class="col-sm-12 col-md-12">
        <button type="button" class="btn btn-success btn-sm" onclick="javascript:location.href='/admin/navi/add';"><i class="fa fa-plus"></i> 新增</button>
        <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> 删除</button>
    </div>
</div><!-- /.toolbar -->

<div class="box" style="margin-top: 15px;margin-bottom: 0;">
    <div class="box-body">
        <form class="am-form">
            <table class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th class="table-check"><input type="checkbox"></th>
                        <th class="table-id">ID</th>
                        <th class="table-title">导航名称</th>
                        <th class="table-author">导航slug</th>
                        <th class="table-date">添加日期</th>
                        <th class="table-set">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($result['se_list'] as $se)
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>{{ $se->id }}</td>
                        <td><a href="/user/srch/se/{{ $se->id }}/edit">{{ $se->navi_name }}</a></td>
                        <td>{{ $se->navi_slug }}</td>
                        <td>{{ $se->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>
                            <a href="/user/srch/se/{{ $se->id }}/edit" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"></i> 编辑</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="nodata" colspan="6">
                            <div class="alert alert-danger">未未找到符合条件的导航数据。</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </form>
    </div><!-- /.box-body -->
</div><!-- /.box -->

{!! $result['se_list']->render() !!}
@endsection

@section('foot-assets')
<script type="text/javascript">
$(function() {
//    $('#filter').on('click', function() {
//        $('#filter-panel').toggle();
//    });
});
</script>
@endsection

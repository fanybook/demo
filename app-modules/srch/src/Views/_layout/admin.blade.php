@extends('admin::_layout.admin')
@section('sub-admin-menu')
<li{{ $action == 'searchbox' ? ' class="active"' : ''; }}><a href="/searchbox/admin/searchbox-index">搜索框管理</a></li>
<li{{ $action == 'tag' ? ' class="active"' : ''; }}><a href="/searchbox/admin/tag-index">标签管理</a></li>
@stop
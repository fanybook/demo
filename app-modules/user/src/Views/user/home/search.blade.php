@extends('_layouts.front')
@php($unfolded = 'home')

@section('content-wrapper')
    <!-- Content Header (Page header) -->
    <section class="content-header clearfix">
      <h1 class="pull-left">
        搜索
        <small>结果</small>
      </h1>
      <div class="btn-group pull-right" style="margin-top: -2px;">
        <a href="{{ route('front.home.index') }}" class="btn btn-default"><i class="fa fa-reply"></i> 返回</a>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <p><em>范书为您找到<span class="text-danger"> <b>{{ config('const.search_type.' . Request::input('type')) }}
        @if (Request::has('wd'))
        :{{ Request::input('wd') }}</b> </span>被举报了 {{ $events->total() }} 次</em>
        @else
        </b> </span>的相关举报 {{ $events->total() }} 条</em>
        @endif
      </p>
      <!-- info row -->
      <div class="row">
        <div class="col-sm-9">
          <div class="panel panel-info{{ $events->lastPage() > 1 ? ' margin-bottom-none' : '' }}">
            <table class="table" style="color: #aaa;">
              <tbody>
                @foreach ($events as $event)
                <tr>
                  <td width="50"><span class="badge bg-gray" title="回复">{{ $event->comment_cnt }}</span></td>
                  <td>
                    <div><a href="{{ route('front.report.detail', $event->id) }}">{{ $event->title }}</a><span class="visible-xs-inline pull-right">{{ smart_time($event->created_at) }}</span></div>

                    @if ($event->body)
                    <p class="margin">{!! ellipsis(html_to_text($event->body), 36) !!}</p>
                    @endif
                  </td>
                  <td width="100" class="hidden-xs">
                    <i class="fa fa-user" style="width: 16px;"></i> u{{ $event->id }}<br>
                    @if ($recent_comment = $event->recent_comment())<i class="fa fa-comment" style="width: 16px;"></i> u{{ $recent_comment->user_id }}@endif
                  </td>
                  <td width="100" class="hidden-xs">{{ smart_time($event->created_at) }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <!--分页-->
          {!! $events->render() !!}
        </div>
        <!-- /.col -->
        <div class="col-sm-3 hxs-padding-left-none">
          <div class="panel panel-danger">
            <div class="panel-heading">广告位招租</div>
            <div class="panel-body">
            </div>
          </div>

          <div class="panel panel-warning">
            <div class="panel-heading">谷歌广告</div>
            <div class="panel-body">
              支持我们，看广告，我们会发展的更好
            </div>
          </div>
        </div>
        <!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->
@endsection

@section('head-assets')
<style>
  .bg-gray {
    color: #666;
  }
</style>
@endsection

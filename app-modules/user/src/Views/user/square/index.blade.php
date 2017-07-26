@extends('_layouts.front')
@php($unfolded = 'square')

@section('content-wrapper')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        广场
        <small>看看大家刚举报了什么</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- info row -->
      <div class="row">
        <div class="col-sm-9">
          <div class="panel panel-info margin-bottom-none">
            <div class="panel-heading">最新举报</div>
            <table class="table" style="color: #aaa;">
              <tbody>
                @foreach ($events as $event)
                <tr>
                  <td width="50"><span class="badge bg-gray" title="回复">{{ $event->comments->count() }}</span></td>
                  <td>
                    <div><a href="{{ route('front.report.detail', $event->id) }}">{{ $event->title }}</a></div>

                    @if ($event->body)
                    <p class="margin">{!! ellipsis(html_to_text($event->body), 36) !!}</p>
                    @endif
                    
                    @if ($event->images)
                      <div class="event-images">
                        @php($images = explode("\n", $event->images))
                        @foreach ($images as $image_path)
                        <a href="{{ $image_path }}" rel="group{{ $event->id }}"><img src="{{ $image_path }}" style="max-width: 150px;" class="margin"></a>
                        @endforeach
                      </div>
                    @endif
                    
                    @if ($event->video)
                      <div class="event-video margin">
                        <iframe src="http://player.youku.com/embed/{{ $event->video_code }}" frameborder=0 allowfullscreen height=240 width=360></iframe>
                      </div>
                    @endif
                  </td>
                  <td width="100">
                    <i class="fa fa-user" style="width: 16px;"></i> u{{ $event->id }}<br>
                    @if ($recent_comment = $event->recent_comment())<i class="fa fa-comment" style="width: 16px;"></i> u{{ $recent_comment->user_id }}@endif
                  </td>
                  <td width="100">{{ smart_time($event->created_at) }}</td>
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
            <div class="panel-heading">热门事件</div>
            <div class="panel-body">
              <ul style="margin: 0; padding: 0; list-style-type: none; color: #aaa;">
                @foreach ($hot_events as $event)
                <li>
                  <a href="{{ route('front.report.detail', $event->id) }}">{{ ellipsis($event->title, 12) }}</a><span class="pull-right">{{ $event->created_at->format('n-d') }}</span>
                </li>
                @endforeach
              </ul>
            </div>
          </div>

          <div class="panel panel-warning">
            <div class="panel-heading">谷歌广告</div>
            <div class="panel-body">
              支持我们，看广告，我们会发展的更好
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">套路云</div>
            <div class="panel-body">
              未被整理的套路也会显示出来，点击后显示套路的举报事件
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

@section('foot-assets')
<script src="/plugins/jquery-colorbox/js/jquery.colorbox-min.js"></script>
<link href="/plugins/jquery-colorbox/css/colorbox.css" rel="stylesheet">


<!-- Page script -->
<script>
  $(function () {
    $('.event-images a').colorbox();
  });
</script>
@endsection

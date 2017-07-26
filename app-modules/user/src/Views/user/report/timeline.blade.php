@extends('_layouts.front')
@php($unfolded = 'report')

@section('content-wrapper')
    <!-- Content Header (Page header) -->
    <section class="content-header clearfix">
      <h1 class="pull-left">
        我的举报
        <small>历程</small>
      </h1>
      <div class="btn-group pull-right" style="margin-top: -2px;">
        <a href="{{ Request::server('REDIRECT_URL') }}" class="btn btn-default{{ Request::has('sort') ? '' : ' active' }}"><i class="fa fa-hand-paper-o"></i><span class="hidden-xs"> 按举报时间排序</span></a>
        <a href="?sort=happen" class="btn btn-default{{ (Request::has('sort') && Request::input('sort') == 'happen') ? ' active' : '' }}"><i class="fa fa-camera-retro"></i><span class="hidden-xs"> 按事件时间排序</span></a>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- row -->
      <div class="row">
        <div class="col-md-12">
          <!-- The time line -->
          <ul class="timeline">
          @php($time_label = null)
          @foreach ($events as $event)
            @if ($loop->first || $event->created_at->format('Y年m月d日') != $time_label)
            <li class="time-label">
                  <span class="bg-gray">
                    2016年12月20日
                  </span>
            </li>
            @endif

            @php($fa_class = 'fa-file-text bg-yellow')
            @php(if ($event->images) $fa_class = 'fa-camera bg-purple')
            @php(if ($event->video) $fa_class = 'fa-video-camera bg-maroon')

            <li>
              <i class="fa {{ $fa_class }}"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> {{ $event->created_at->format('H:i') }}</span>

                <h3 class="timeline-header"><a href="{{ route('front.report.detail', $event->id) }}">{{ $event->title }}</a></h3>

                <div class="timeline-body">
                  @if ($event->body)
                  <div class="alert bg-gray-light margin">
                    {!! $event->body !!}
                  </div>
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
                </div>
                <div class="timeline-footer text-right">
                  <a href="{{ route('front.report.detail', $event->id) }}" class="btn btn-xs btn-default">查看详情</a>
                  <a href="{{ route('front.report.detail', $event->id) }}#comments" class="btn btn-xs btn-info">查看评论 ({{ $event->comments->count() }}条)</a>
                  <a href="javascript:void(0);" class="btn btn-xs btn-danger">删除</a>
                </div>
              </div>
            </li>

            @if ($loop->last)
            <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>
            @endif
            @php($time_label = $event->created_at->format('Y年m月d日'))
          @endforeach
          </ul>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->
    <div class="content-header text-right" style="padding-right: 40px;">
      {!! $events->render() !!}
    </div>
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

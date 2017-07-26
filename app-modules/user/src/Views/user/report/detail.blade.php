@extends('_layouts.front')
@php($unfolded = 'report')

@section('content-wrapper')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        举报详情
        <small>内容只做参考，证据越多越可信！请自行判断~</small>
      </h1>
    </section>

<!--    <section class="invoice">
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header"><i class="fa fa-balance-scale"></i> 统计：供您参考判断</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <span class="label label-success">微信号：kk5201314(被举报2次)</span> <span class="label label-danger">QQ号：167XXX(被举报50次)</span> <span class="label label-info">手机号：130XXX(被举报50次)</span> <span class="label label-warning">微博帐号：fany(被举报50次)</span>
        </div>
      </div>
    </section>-->

    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-hand-paper-o"></i> 事件：{{ $event->title or '发布者未填写标题' }}
            <small class="pull-right">@if ($event->happened_at != $event->created_at)（发生于: {{ smart_time($event->happened_at) }}）@endif发布于: {{ smart_time($event->created_at) }}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-12">
            <div class="invoice-body">
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
        </div>
      </div>
      <hr>
      <div class="row">
<!--        <div class="col-sm-6" style="font-size: 18px; line-height: 36px;">
          <a><i class="fa fa-thumbs-o-up"></i>同情</a>(56)&nbsp;&nbsp;｜
          <a><i class="fa fa-thumbs-o-down"></i>不信</a>(56)
        </div>-->
        <div class="col-sm-12">
          <div class="bdsharebuttonbox pull-right" style="white-space: nowrap;"><!--<a href="#" class="bds_more" data-cmd="count"></a>--><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tieba" data-cmd="tieba" title="分享到百度贴吧"></a></div>
          <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
          <div class="pull-right" style="font-size: 16px; color: #ccc; line-height: 36px; margin-right: 15px;">
            <a><i class="fa fa-thumbs-o-up"></i>同情</a>(56)&nbsp;&nbsp;
            <a><i class="fa fa-thumbs-o-down"></i>不信</a>(56)
          </div>
        </div>
      </div>
    </section>

    <section class="invoice" id="comments">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-commenting-o"></i> 评论：38条
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row">
        <div class="col-sm-8 hxs-padding-right-none">
          <div class="panel panel-info">
            <div class="panel-heading">最新评论</div>
            <ul class="list-group">
              <li class="list-group-item">
                <div class="media">
                  <div class="media-left">
                    <a href="#" class="pull-left" style="padding: 1px; border: 1px solid #ccc;">
                      <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGRlZnMvPjxyZWN0IHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjEzLjQ2ODc1IiB5PSIzMiIgc3R5bGU9ImZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0O2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjY0eDY0PC90ZXh0PjwvZz48L3N2Zz4=" data-holder-rendered="true" style="width: 32px; height: 32px;">
                    </a>
                  </div>
                  <div class="media-body">
                    <a href="#">u56: </a>
                    <div style="min-height: 100px;">
                    卖家真不是东西
                    </div>
                    <div class="text-right" style="color: #ccc;">
                      <a href="#"><i class="fa fa-commenting-o"></i> 回复</a>(4)&nbsp;&nbsp;
                      <a href="#"><i class="fa fa-thumbs-o-up"></i>点赞</a>(56)&nbsp;&nbsp;
                      <a href="#"><i class="fa fa-thumbs-o-down"></i>反对</a>(3)
                    </div>
                    <div class="bg-gray-light" style="padding: 10px; border: 1px solid #f0f1f2;">
                      <div class="media">
                        <div class="media-left">
                          <a href="#" class="pull-left" style="padding: 1px; border: 1px solid #ccc;">
                            <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGRlZnMvPjxyZWN0IHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjEzLjQ2ODc1IiB5PSIzMiIgc3R5bGU9ImZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0O2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjY0eDY0PC90ZXh0PjwvZz48L3N2Zz4=" data-holder-rendered="true" style="width: 32px; height: 32px;">
                          </a>
                        </div>
                        <div class="media-body">
                          <a href="#">u74: </a>你别误会，我不是为了钱，真的，只是如果我买回来，我老公也喜欢，会更好，我不是那个意思。
                          <div class="text-right" style="color: #ccc;">
                            2017-1-14 01:38
                            <a href="#">回复</a>
                          </div>
                        </div>
                      </div><!-- /.media -->
                      <hr style="margin-top: 5px; margin-bottom: 5px;">
                      <div class="media">
                        <div class="media-left">
                          <a href="#" class="pull-left" style="padding: 1px; border: 1px solid #ccc;">
                            <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGRlZnMvPjxyZWN0IHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjEzLjQ2ODc1IiB5PSIzMiIgc3R5bGU9ImZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0O2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjY0eDY0PC90ZXh0PjwvZz48L3N2Zz4=" data-holder-rendered="true" style="width: 32px; height: 32px;">
                          </a>
                        </div>
                        <div class="media-body">
                          <a href="#">u1037: </a>回复 婚後尕娘 ： 有些人就是喜欢自以为是 别理他们
                          <div class="text-right" style="color: #ccc;">
                            2017-1-14 01:38
                            <a href="#">回复</a>
                          </div>
                        </div>
                      </div><!-- /.media -->
                      <hr style="margin-top: 5px; margin-bottom: 5px;">
                      <div class="comment-block clearfix">
                        <button class="btn btn-xs btn-default pull-right">我也说一句</button><br><br>
                        <textarea class="form-control" rows="3" name="event_body" style="margin-bottom: 5px;"></textarea>
                        <button class="btn btn-xs btn-info pull-right">发 表</button>
                      </div>
                    </div>
                  </div>
                </div><!-- /.media -->
              </li>
              <li class="list-group-item">
                <div class="media">
                  <div class="media-left">
                    <a href="#" class="pull-left" style="padding: 1px; border: 1px solid #ccc;">
                      <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGRlZnMvPjxyZWN0IHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjEzLjQ2ODc1IiB5PSIzMiIgc3R5bGU9ImZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0O2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjY0eDY0PC90ZXh0PjwvZz48L3N2Zz4=" data-holder-rendered="true" style="width: 32px; height: 32px;">
                    </a>
                  </div>
                  <div class="media-body">
                    <a href="#">婚後尕娘: </a>
                    <div style="min-height: 100px;">
                    你别误会，我不是为了钱，真的，只是如果我买回来，我老公也喜欢，会更好，我不是那个意思。
                    </div>
                    <div class="text-right" style="color: #ccc;">
                      <a href="#"><i class="fa fa-commenting-o"></i> 回复</a>(4)&nbsp;&nbsp;
                      <a href="#"><i class="fa fa-thumbs-o-up"></i>点赞</a>(56)&nbsp;&nbsp;
                      <a href="#"><i class="fa fa-thumbs-o-down"></i>反对</a>(3)
                    </div>
                    <div class="bg-gray-light" style="padding: 10px; border: 1px solid #f0f1f2;">
                      <div class="media">
                        <div class="media-left">
                          <a href="#" class="pull-left" style="padding: 1px; border: 1px solid #ccc;">
                            <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGRlZnMvPjxyZWN0IHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjEzLjQ2ODc1IiB5PSIzMiIgc3R5bGU9ImZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0O2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjY0eDY0PC90ZXh0PjwvZz48L3N2Zz4=" data-holder-rendered="true" style="width: 32px; height: 32px;">
                          </a>
                        </div>
                        <div class="media-body">
                          <a href="#">婚後尕娘: </a>你别误会，我不是为了钱，真的，只是如果我买回来，我老公也喜欢，会更好，我不是那个意思。
                          <div class="text-right" style="color: #ccc;">
                            2017-1-14 01:38
                            <a href="#">回复</a>
                          </div>
                        </div>
                      </div><!-- /.media -->
                      <hr style="margin-top: 5px; margin-bottom: 5px;">
                      <div class="media">
                        <div class="media-left">
                          <a href="#" class="pull-left" style="padding: 1px; border: 1px solid #ccc;">
                            <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGRlZnMvPjxyZWN0IHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjEzLjQ2ODc1IiB5PSIzMiIgc3R5bGU9ImZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0O2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjY0eDY0PC90ZXh0PjwvZz48L3N2Zz4=" data-holder-rendered="true" style="width: 32px; height: 32px;">
                          </a>
                        </div>
                        <div class="media-body">
                          <a href="#">不瘦十斤不改ID: </a>回复 婚後尕娘 ： 有些人就是喜欢自以为是 别理他们
                          <div class="text-right" style="color: #ccc;">
                            2017-1-14 01:38
                            <a href="#">回复</a>
                          </div>
                        </div>
                      </div><!-- /.media -->
                      <hr style="margin-top: 5px; margin-bottom: 5px;">
                      <div class="comment-block clearfix">
                        <button class="btn btn-xs btn-default pull-right">我也说一句</button><br><br>
                        <textarea class="form-control" rows="3" name="event_body" style="margin-bottom: 5px;"></textarea>
                        <button class="btn btn-xs btn-info pull-right">发 表</button>
                      </div>
                    </div>
                  </div>
                </div><!-- /.media -->
              </li>
              <li class="list-group-item">Morbi leo risus</li>
              <li class="list-group-item">
                <div class="media">
                  <div class="media-left">
                    <a href="#" class="pull-left" style="padding: 1px; border: 1px solid #ccc;">
                      <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGRlZnMvPjxyZWN0IHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjEzLjQ2ODc1IiB5PSIzMiIgc3R5bGU9ImZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0O2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjY0eDY0PC90ZXh0PjwvZz48L3N2Zz4=" data-holder-rendered="true" style="width: 32px; height: 32px;">
                    </a>
                  </div>
                  <div class="media-body">
                    <a href="#">婚後尕娘: </a>
                    <div style="min-height: 100px;">
                    你别误会，我不是为了钱，真的，只是如果我买回来，我老公也喜欢，会更好，我不是那个意思。
                    </div>
                    <div class="text-right" style="color: #ccc;">
                      <a href="#"><i class="fa fa-commenting-o"></i> 回复</a>(4)&nbsp;&nbsp;
                      <a href="#"><i class="fa fa-thumbs-o-up"></i>点赞</a>(56)&nbsp;&nbsp;
                      <a href="#"><i class="fa fa-thumbs-o-down"></i>反对</a>(3)
                    </div>
                  </div>
                </div><!-- /.media -->
              </li>
              <li class="list-group-item">Vestibulum at eros</li>
              <li class="list-group-item">Cras justo odio</li>
              <li class="list-group-item">Dapibus ac facilisis in</li>
              <li class="list-group-item">Morbi leo risus</li>
              <li class="list-group-item">Porta ac consectetur ac</li>
              <li class="list-group-item">Vestibulum at eros</li>
            </ul>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-sm-4">
          <div class="panel panel-danger">
            <div class="panel-heading">热门评论</div>
            <div class="panel-body">
              <div class="media">
                <div class="media-left">
                  <a href="#" class="pull-left" style="padding: 1px; border: 1px solid #ccc;">
                    <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGRlZnMvPjxyZWN0IHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjEzLjQ2ODc1IiB5PSIzMiIgc3R5bGU9ImZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0O2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjY0eDY0PC90ZXh0PjwvZz48L3N2Zz4=" data-holder-rendered="true" style="width: 32px; height: 32px;">
                  </a>
                </div>
                <div class="media-body">
                  <a href="#">婚後尕娘: </a>你别误会，我不是为了钱，真的，只是如果我买回来，我老公也喜欢，会更好，我不是那个意思。
                  <div class="text-right" style="color: #ccc;">
                    2017-1-14 01:38
                    <a href="#">回复</a>
                  </div>
                </div>
              </div><!-- /.media -->
              <hr style="margin-top: 5px; margin-bottom: 5px;">
              <div class="media">
                <div class="media-left">
                  <a href="#" class="pull-left" style="padding: 1px; border: 1px solid #ccc;">
                    <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGRlZnMvPjxyZWN0IHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjEzLjQ2ODc1IiB5PSIzMiIgc3R5bGU9ImZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0O2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjY0eDY0PC90ZXh0PjwvZz48L3N2Zz4=" data-holder-rendered="true" style="width: 32px; height: 32px;">
                  </a>
                </div>
                <div class="media-body">
                  <a href="#">婚後尕娘: </a>你别误会，我不是为了钱，真的，只是如果我买回来，我老公也喜欢，会更好，我不是那个意思。
                  <div class="text-right" style="color: #ccc;">
                    2017-1-14 01:38
                    <a href="#">回复</a>
                  </div>
                </div>
              </div><!-- /.media -->
              <hr style="margin-top: 5px; margin-bottom: 5px;">
              <div class="media">
                <div class="media-left">
                  <a href="#" class="pull-left" style="padding: 1px; border: 1px solid #ccc;">
                    <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGRlZnMvPjxyZWN0IHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjEzLjQ2ODc1IiB5PSIzMiIgc3R5bGU9ImZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0O2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjY0eDY0PC90ZXh0PjwvZz48L3N2Zz4=" data-holder-rendered="true" style="width: 32px; height: 32px;">
                  </a>
                </div>
                <div class="media-body">
                  <a href="#">婚後尕娘: </a>你别误会，我不是为了钱，真的，只是如果我买回来，我老公也喜欢，会更好，我不是那个意思。
                  <div class="text-right" style="color: #ccc;">
                    2017-1-14 01:38
                    <a href="#">回复</a>
                  </div>
                </div>
              </div><!-- /.media -->
              <hr style="margin-top: 5px; margin-bottom: 5px;">
              <div class="media">
                <div class="media-left">
                  <a href="#" class="pull-left" style="padding: 1px; border: 1px solid #ccc;">
                    <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGRlZnMvPjxyZWN0IHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjEzLjQ2ODc1IiB5PSIzMiIgc3R5bGU9ImZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0O2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjY0eDY0PC90ZXh0PjwvZz48L3N2Zz4=" data-holder-rendered="true" style="width: 32px; height: 32px;">
                  </a>
                </div>
                <div class="media-body">
                  <a href="#">婚後尕娘: </a>你别误会，我不是为了钱，真的，只是如果我买回来，我老公也喜欢，会更好，我不是那个意思。
                  <div class="text-right" style="color: #ccc;">
                    2017-1-14 01:38
                    <a href="#">回复</a>
                  </div>
                </div>
              </div><!-- /.media -->
            </div>
          </div>

          <div class="panel panel-warning">
            <div class="panel-heading">谷歌广告</div>
            <div class="panel-body">
              支持我们，看广告，我们会发展的更好
            </div>
          </div>
        </div><!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-sm-1">
        </div><!-- /.col -->
        <div class="col-sm-7 hxs-padding-right-none">
          <p><b>发表回复</b><span class="pull-right text-muted">评论请遵守我们的 <a href="#">服务条款</a></span></p>
          <textarea class="form-control" rows="5" name="event_body" style="margin-bottom: 10px;"></textarea>
          <button class="btn btn-sm btn-info pull-right">发 表</button>
        </div><!-- /.col -->
        <div class="col-sm-4">
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section>

    <!-- /.content -->
    <div class="clearfix"></div>
@endsection

@section('head-assets')
<style>
  textarea {
    resize: vertical;
  }
</style>
@endsection

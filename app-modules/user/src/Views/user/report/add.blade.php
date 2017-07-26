@extends('_layouts.front')
@php($unfolded = 'report')

@section('content-wrapper')
  <form class="main-form form-horizontal" method="POST" accept-charset="UTF-8" autocomplete="off" novalidate="novalidate">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        举报
        <small>某某人</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="callout callout-warning">
        <h4>有理有据！拒绝网络暴力~</h4>

        <p>举报不是诬陷，要有理有据，提交有力的证据，使你的举报更可信~</p>
      </div>
      <!-- Default box -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">要举报的</h3>
        </div>
        <div class="box-body">
          <div class="form-group">
            <label for="input-weixin" class="col-sm-2 control-label">微信号</label>

            <div class="col-sm-10">
              <input type="text" class="form-control" id="input-weixin" placeholder="微信号，是在微信头像下方的那个（不是手机号和QQ号，因为都可以换绑）" name="weixin">
            </div>
          </div>
          <div class="form-group">
            <label for="input-qq" class="col-sm-2 control-label">QQ号</label>

            <div class="col-sm-10">
              <input type="text" class="form-control" id="input-qq" placeholder="QQ号" name="qq">
            </div>
          </div>
          <div class="form-group">
            <label for="input-mobile" class="col-sm-2 control-label">手机号</label>

            <div class="col-sm-10">
              <input type="text" class="form-control" id="input-mobile" placeholder="手机号" name="mobile">
            </div>
          </div>
          <div class="form-group">
            <label for="input-weibo" class="col-sm-2 control-label">微博帐号</label>

            <div class="col-sm-10">
              <input type="text" class="form-control" id="input-weibo" placeholder="微博帐号" name="weibo">
            </div>
          </div>
          <div class="form-group">
            <label for="input-tel400" class="col-sm-2 control-label">400电话</label>

            <div class="col-sm-10">
              <input type="text" class="form-control" id="input-tel400" placeholder="400企业电话号" name="tel400">
            </div>
          </div>
          <div class="form-group">
            <label for="input-email" class="col-sm-2 control-label">电子邮箱</label>

            <div class="col-sm-10">
              <input type="email" class="form-control" id="input-email" placeholder="Email" name="email">
            </div>
          </div>
          <div class="form-group">
            <label for="input-shop" class="col-sm-2 control-label">网店地址</label>

            <div class="col-sm-4 hxs-padding-right-none">
              <input type="text" class="form-control" id="input-shop" placeholder="URL地址，最好是唯一标识，比如淘宝二级域名" name="shop_url">
            </div>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="网店名，防止改URL" name="shop_name">
            </div>
          </div>
          <div class="form-group">
            <label for="input-company" class="col-sm-2 control-label">企业产品</label>

            <div class="col-sm-4 hxs-padding-right-none">
              <input type="text" class="form-control" id="input-company" placeholder="举报的公司（尽量把城市写全，因为有同名公司）" name="company">
            </div>
            <div class="col-sm-6">
              <input type="text" class="form-control" placeholder="举报的产品，招聘欺诈可不填产品" name="product">
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-danger text-right">
          ※公示社交ID，抬高行骗成本！
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">这家伙做了什么</h3>
          <div class="box-tools">
            <div class="btn-group">
              <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-bullhorn"></i> 提交举报</button>
            </div>
          </div>
        </div>
        <div class="box-body">
          <div class="form-group">
            <div class="col-sm-8 hxs-padding-right-none">
              <input type="text" class="form-control" placeholder="标题" name="event_title">
            </div>
            <div class="col-sm-4">
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-clock-o"></i>
                </div>
                <input type="text" class="form-control pull-right" placeholder="发生时间，默认是现在" id="event-time" name="event_time">
              </div>
            </div>
          </div>

<!--          <div class="form-group">
            <div class="col-sm-8 hxs-padding-right-none">
              <input type="text" class="form-control" placeholder="骗局的套路">
            </div>
            <div class="col-sm-4">
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-search"></i>
                </div>
                <input type="text" class="form-control pull-right" placeholder="搜索已有的套路">
              </div>
            </div>
          </div>-->

          <div class="nav-tabs-custom">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#event-body" data-toggle="tab">文本</a></li>
                <li><a href="#event-image" data-toggle="tab">图片</a></li>
                <li><a href="#event-video" data-toggle="tab">视频</a></li>
            </ul>
            
            <!-- Tab panes -->
            <div class="tab-content" style="padding: 0; postion:relative; z-index: 50px;">
                <div class="tab-pane active" id="event-body">
                    <textarea class="form-control" rows="8" placeholder="记录事件经过" name="event_body"></textarea>
                </div>
                <div class="tab-pane" id="event-image">
                    <input class="fileinput" type="file" name="event_images[]" multiple>
                </div>
                <div class="tab-pane" id="event-video">
                    <textarea class="form-control" rows="8" placeholder="视频URL，暂只支持优酷，请从优酷视频页地址栏复制" name="event_video"></textarea>
                </div>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-danger text-right">
          ※视频不能和图片一起存在，填了视频URL将自动忽略上传的图片！
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
    </section><!-- /.content -->
  </form>
@endsection

@section('head-assets')
<style>
  textarea {
    resize: vertical;
  }
  .file-preview {
    border: none !important;
    padding: 0 !important;
    margin: 0 !important;
  }
  .file-drop-zone {
    margin: 0 0 12px !important;
    min-height: 253px;
    border-radius: 0 !important;
    -moz-border-radius: 0 !important;
    -webkit-border-radius: 0 !important;
  }
  .kv-file-upload,
  .kv-fileinput-upload {
    display: none !important;
  }
  .file-upload-indicator {
    display: none !important;
  }
  .nav-tabs-custom > .nav-tabs > li.active > a {
    border-left: 1px solid #d2d6de !important;
    border-right: 1px solid #d2d6de !important;
  }
</style>
@endsection

@section('foot-assets')
<script src="/plugins/layer/laydate/laydate.js"></script>

<script src="/plugins/bootstrap-fileinput/js/fileinput.js"></script>
<script src="/plugins/bootstrap-fileinput/js/fileinput_locale_zh.js"></script>
<link href="/plugins/bootstrap-fileinput/css/fileinput.css" rel="stylesheet">

<!-- Page script -->
<script>
  $(function () {
    var lay_time = {
        elem: '#event-time',
        format: 'YYYY-MM-DD hh:mm:ss',
        istime: true,
        istoday: false,
        choose: function (datas) {
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    laydate(lay_time);

    // 文件上传框
    $('input.fileinput').fileinput({
        'uploadUrl': '#',
        'previewFileType':'any'
    });

    var base = new Base();
    base.initForm();
  });
</script>
@endsection

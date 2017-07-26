@extends('_layouts.front')
@php($unfolded = 'trick')

@section('content-wrapper')
    <!-- Content Header (Page header) -->
    <section class="content-header clearfix">
      <h1 class="pull-left">
        套路
        <small>揭示圈套骗术</small>
      </h1>
      <div class="btn-group pull-right" style="margin-top: -2px;">
        <a href="/trick/add" class="btn btn-default"><i class="fa fa-share-alt"></i> 分享新套路</a>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- info row -->
      <div class="row">
        <div class="col-sm-9">
          <div class="panel panel-info margin-bottom-none">
<!--            <div class="panel-heading">套路分类</div>-->
            <div class="panel-body tree">
              <ul>
                <li>
                  <span><i class="glyphicon glyphicon-minus-sign"></i> 常见套路整理<small>（整理于: 2017-05-07）</small></span>
                  <ul>
                    <li>
                        <span><i class="glyphicon glyphicon-minus-sign"></i> 第一章 为什么养猫</span>
                        <ul>
                            <li>
                                <span><i class="glyphicon glyphicon-globe"></i> <a href="/article/2">第一节 缓解压力</a></span>
                            </li>
                            <li>
                                <span><i class="glyphicon glyphicon-globe"></i> <a href="/article/2">第二节 与狗比较</a></span>
                            </li>
                            <li>
                                <span><i class="glyphicon glyphicon-globe"></i> <a href="/article/2">第三节 为什么养英短（英国短毛猫）</a></span>
                            </li>
                            <li>
                                <span><i class="glyphicon glyphicon-globe"></i> <a href="/article/2">第四节 英短（英国短毛猫）的鉴别</a></span>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <span><i class="glyphicon glyphicon-minus-sign"></i> 第二章 猫的疾病</span>
                        <ul>
                            <li>
                                <span><i class="glyphicon glyphicon-globe"></i> <a href="#">第一节 鼻支（鼻支气管炎）</a></span>
                            <li>
                                <span><i class="glyphicon glyphicon-globe"></i> <a href="#">第二节 卡路里病</a></span>
                            </li>
                            <li>
                                <span><i class="glyphicon glyphicon-globe"></i> <a href="#">第三节 猫瘟</a></span>
                            </li>
                            <li>
                                <span><i class="glyphicon glyphicon-globe"></i> <a href="#">第四节 猫肺炎</a></span>
                            </li>
                            <li>
                                <span><i class="glyphicon glyphicon-globe"></i> <a href="#">第五节 狂犬病</a></span>
                            </li>
                            <li>
                                <span><i class="glyphicon glyphicon-globe"></i> <a href="/article/1">第六节 皮肤病</a></span>
                            </li>
                            <li>
                                <span><i class="glyphicon glyphicon-globe"></i> <a href="/article/1">第七节 口炎</a></span>
                            </li>
                        </ul>
                    </li>


                    <li>
                        <span><i class="glyphicon glyphicon-minus-sign"></i> 第五章 繁育（进阶篇-猫毛色遗传规律）</span>
                        <ul>
                            <li>
                                <span><i class="glyphicon glyphicon-globe"></i> <a href="/article/7">第一节 猫毛色遗传规律</a></span>
                            </li>
                            <li>
                                <span><i class="glyphicon glyphicon-globe"></i> <a href="#">第二节 页面调用 api</a></span>
                            </li>
                        </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </div><!-- /.panel-body.tree -->
          </div><!-- /.panel -->
        </div><!-- /.col -->

        <div class="col-sm-3 hxs-padding-left-none">
          <form action="/blog" class="margin-bottom" accept-charset="UTF-8" novalidate="novalidate" autocomplete="off">
            <div id="article-search" class="input-group">
              <input type="text" class="form-control" name="kw" placeholder="搜索套路..."value="">
              <span class="input-group-btn">
                <button class="btn bg-purple" type="submit"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>

          <div class="panel panel-warning">
            <div class="panel-heading">谷歌广告</div>
            <div class="panel-body">
              支持我们，看广告，我们会发展的更好
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">套路云</div>
            <div class="panel-body">
              未被整理的套路也会显示出来，点击后跳到套路详情
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
<link href="/plugins/bootstrap-tree/bootstrap-tree.css" rel="stylesheet">

<!-- Page script -->
<script>
  $(function(){
    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', '收起目录');
    $('.tree li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).attr('title', '展开目录').find(' > i').addClass('glyphicon-plus-sign').removeClass('glyphicon-minus-sign');
        } else {
            children.show('fast');
            $(this).attr('title', '收起目录').find(' > i').addClass('glyphicon-minus-sign').removeClass('glyphicon-plus-sign');
        }
        e.stopPropagation();
    });
  });
</script>
@endsection

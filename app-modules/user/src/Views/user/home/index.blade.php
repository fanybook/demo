@extends('user::_layouts.user')
@php($unfolded = 'home')

@section('title', '用户中心 - 魔爪搜索')

@section('content-wrapper')
    <!-- Main content -->
    <section class="content main">
      <div id="logo" class="text-center">
        <h1><a href="/" title="魔爪搜索 - 专注提高搜索效率"></a></h1>
      </div>

      <ul id="tabs" class="clearfix">
        <li class="active"><a href="javascript:void(0);" data-type="weixin"><i class="fa fa-weixin"></i> 微信号</a></li>
        <li><a href="javascript:void(0);" data-type="qq"><i class="fa fa-qq"></i> QQ号</a></li>
        <li><a href="javascript:void(0);" data-type="mobile"><i class="fa fa-mobile"></i> 手机号</a></li>
        <li><a href="javascript:void(0);" data-type="weibo"><i class="fa fa-weibo"></i> 微博帐号</a></li>
        <li><a href="javascript:void(0);" data-type="tel400"><i class="fa fa-phone"></i> 400电话</a></li>
        <li><a href="javascript:void(0);" data-type="email"><i class="fa fa-envelope"></i> 邮箱</a></li>
        <li><a href="javascript:void(0);" data-type="shop"><i class="fa fa-shopping-cart"></i> 网店</a></li>
        <li><a href="javascript:void(0);" data-type="company" title="包括产品虚假宣传骗人和招聘欺诈"><i class="fa fa-users"></i> 企业产品</a></li>
      </ul>

      <form id="search-form" action="/s?type=weixin" method="GET" accept-charset="UTF-8" autocomplete="off" novalidate="novalidate">
        <input type="hidden" name="type" value="weixin">
        <div class="input-group">
          <input type="text" class="form-control" name="wd">
          <span class="input-group-btn">
            <div class="clearBtn" style="display: none;">×</div>
            <input class="btn btn-default form-submit" type="submit" value="防范一下">
          </span>
        </div>
      </form>
    </section>
@endsection

@section('head-assets')
<style>
  /* ########## main ########## */
  .main {
    width: 640px;
    margin: 0 auto;
  }

  @media (max-width: 768px) {
    .main {
        width: 90%;
    }
  }

  /* ########## logo ########## */
  #logo h1 a {
    display: inline-block;
    width: 250px;
    height: 100px;
    background: url('http://immz.qiniudn.com/assets/searchbox/images/54mz_logo_newr.png');
  }

  /* ########## tabs ########## */
  #tabs {
    margin: 10px 0;
    padding: 0;
    list-style-type: none;
  }
  
  #tabs li {
    float: left;
    margin-left: 15px;
  }
  
  #tabs li a,
  #tabs li a:hover,
  #tabs li a:focus,
  #tabs li a:visited {
    color: #3c8dbc;
    text-decoration: underline;
  }
  
  #tabs li.active a {
    color: #000;
    text-decoration: none;
  }
  
  #tabs li a span {
    display: inline-block;
    -webkit-transform: translate(0%, 0);
    transform: translate(0%, 0);
    -webkit-animation: arrowMore 0.8s infinite steps(3, end);
    animation: arrowMore 0.8s infinite steps(3, end)
  }

  /* ########## form ########## */
  #search-form {
    margin-bottom: 15px;
  }

  .input-group,
  .input-group input,
  .input-group button {
    height: 38px;
  }

  .form-control,
  .form-control:focus {
    box-shadow: none;
    -webkit-box-shadow: none;
  }

  .form-submit {
    border: 0;
    border-radius: 0;
    padding: 0 20px;
    color: #fff;
    background-color: #38f;
  }

  .form-submit:hover {
    color: #fff;
    background-color: #2a7beb;
    box-shadow: 0 1px 2px #999;
  }
</style>
@endsection

@section('foot-assets')
<!-- Page script -->
<script>
  $(function () {
    // 为切换链接添加click事件
    $(document).on('click', '#tabs a',function(){
      $(this).parent().siblings().removeClass('active');
      $(this).parent().addClass('active');

      $('#search-form input[name="type"]').val($(this).data('type'));
    });
  });
</script>
@endsection

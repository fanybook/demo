<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="keyword" content="范书, 防骗, fanybook">
<meta name="description" content="范书，专注防骗，抬高骗子行骗成本">
<meta name="author" content="fanybook.com">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp"/>
<link rel="shortcut icon" href="/favicon.ico"/>
<title>@section('title')用户中心 - 魔爪搜索@show</title>

<!-- Bootstrap -->
<link rel="stylesheet" href="/assets/third-party/bootstrap3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Theme style -->
<link rel="stylesheet" href="/assets/third-party/adminLTE/css/AdminLTE.css">
<link rel="stylesheet" href="/assets/third-party/adminLTE/css/skins/_all-skins.min.css">

<!--  <link rel="stylesheet" href="/assets/front/css/front.css">-->

<style>
body {
  overflow-y: scroll;
}
.layout-boxed .wrapper {
  max-width: 1170px;
}
.logo-lg small {
  font-size: 60%;
}
.navbar-text,
.navbar-link {
  color: #eee;
}
.navbar-link:hover {
  color: #fff;
}
@media (max-width: 767px) {
  .main-sidebar,
  .left-side {
    padding-top: 55px;
  }
  .navbar-text {
    margin-right: 15px;
    margin-left: 15px;
  }

  .event-video iframe {
    width: 100%;
  }
}
@media (min-width: 767px) {
  .hxs-padding-left-none {
    padding-left: 0;
  }
  .hxs-padding-right-none {
    padding-right: 0;
  }
}
</style>

@yield('head-assets')

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="hold-transition skin-blue layout-boxed sidebar-mini sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{ route('user.home') }}" class="logo hidden-xs">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>魔爪</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>魔爪搜索</b><small>（个人中心）</small></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <p class="navbar-text pull-left visible-xs-block"><span class="logo-lg"><b>魔爪搜索</b><small>（个人中心）</small></span></p>

      @if (Auth::check())
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li><a href="/user/sbox"><span>搜索</span></a></li>
          <li><a href="/user/mall"><span>商城</span></a></li>
          <li><a href="/user/ad"><span>广告</span></a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">返回 <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('srch.home') }}">搜索</a></li>
              <li><a href="/mall">商城</a></li>
            </ul>
          </li>

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="/assets/third-party/adminLTE/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->nickname ?: Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="/assets/third-party/adminLTE/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  我们一起努力，让更多人免于受骗</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
 <!--               <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">个人资料</a>
                </div>-->
                <div class="pull-right">
                  <a href="{{ route('user.auth.logout') }}" class="btn btn-default btn-flat">退出登录</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      @else
      <p class="navbar-text pull-right"><a href="{{ route('user.auth.login') }}" class="navbar-link">请登录</a>｜<a href="{{ route('user.auth.register') }}" class="navbar-link">注册</a></p>
      @endif
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      @php
        $unfolded = isset($unfolded) ? $unfolded : ''; $class_html[$unfolded] = ' class="active"'; $class[$unfolded] = ' active';
      @endphp
      @php
        $active = isset($active) ? $active : ''; $class[$active] = ' class="active"';
      @endphp
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li{!! $class_html['home'] or '' !!}>
          <a href="#">
            <i class="fa fa-search"></i>
            <span>搜索 <small class="text-muted">疑似骗子的ID</small></span>
          </a>
        </li>
        <li{!! $class_html['square'] or '' !!}>
          <a href="#">
            <i class="fa fa-bullhorn"></i>
            <span>广场 <small class="text-muted">看看大家刚举报了什么</small></span>
          </a>
        </li>
        <li{!! $class_html['trick'] or '' !!}>
          <a href="#">
            <i class="fa fa-quora"></i>
            <span>套路 <small class="text-muted">揭示圈套骗术</small></span>
          </a>
        </li>
        <li class="treeview{!! $class['report'] or '' !!}">
          <a href="javascript:void(0);">
            <i class="fa fa-hand-paper-o"></i>
            <span>举报 <small class="text-muted">骗子，人人有责</small></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="javascript:void(0);" onclick="auth('#')"><i class="fa fa-plus"></i> 举报某某</a></li>
            <li><a href="javascript:void(0);" onclick="auth('#')"><i class="fa fa-clock-o"></i> 我的举报</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="javascript:void(0);">
            <i class="fa fa-wrench"></i>
            <span>工具 <small class="text-muted">各种查询投诉手段</small></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="javascript:alert('我们还没来得及整理，请过段时间再看');"><i class="fa fa-circle-o"></i> 淘宝投诉卖家</a></li>
            <li><a href="javascript:alert('目前的状况是：防伪查询网站还没有官方的，也就是说查询网站也不具备公信力，有可能也会是伪造的');"><i class="fa fa-circle-o"></i> 防伪查询</a></li>
<!--            <li><a href="javascript:void(0);"><i class="fa fa-clock-o"></i> 和防伪标签造假</a></li>
            <li><a href="javascript:void(0);"><i class="fa fa-clock-o"></i> 暂无有公信力的网站</a></li>-->
          </ul>
        </li>
        <li class="treeview{!! $class['info'] or '' !!}">
          <a href="javascript:void(0);">
            <i class="fa fa-info-circle"></i>
            <span>站点 <small class="text-muted">信息</small></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="javascript:void(0);"><i class="fa fa-circle-o"></i> 免责声明</a></li>
            <li><a href="javascript:void(0);"><i class="fa fa-circle-o"></i> 关于我们</a></li>
            <li><a href="javascript:void(0);"><i class="fa fa-circle-o"></i> 服务条款</a></li>
          </ul>
        </li>
      </ul>
    </section><!-- /.sidebar -->
  </aside><!-- /.main-sidebar -->

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content-wrapper')
  </div><!-- /.content-wrapper -->

  <footer class="main-footer text-right" style="background-color: #ecf0f5; border: 0;">
    <strong>Copyright &copy; 2016 <a href="#">Fanybook.Com</a>.</strong> All rights reserved.
  </footer>
</div><!-- /.wrapper -->

<div id="hidden-items" style="display: none;">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="csrf-token">
    <input type="hidden" name="auth_check" value="{{ Auth::check() ? 'true' : 'false' }}" id="auth-check">
    <input type="hidden" name="login_url" value="#" id="login-url">
    @yield('hidden-items')
</div><!-- /#hidden-items -->

<!-- jQuery 2.2.3 -->
<script src="/assets/third-party/jquery2/jquery-2.1.1.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/assets/third-party/bootstrap3/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/assets/third-party/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/assets/third-party/adminLTE/js/app.js"></script>

<script src="/assets/third-party/jquery-form/jquery.form.min.js"></script>
<script src="/assets/third-party/jquery-toaster/jquery.toaster.js"></script>
<script src="/assets/base.js"></script>

@yield('foot-assets')
</body>
</html>

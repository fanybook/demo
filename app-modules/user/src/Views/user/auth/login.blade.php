<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>登录 - 范书</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="/plugins/bootstrap/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="/plugins/adminLTE/css/AdminLTE.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="/plugins/iCheck/square/blue.css">

<style>
body {
  overflow-y: scroll;
}
</style>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="/"><b>范书</b>（防范网）</a>
  </div>
  <!-- /.login-logo -->

  <div class="nav-tabs-custom" style="margin-bottom: 0;">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="text-center active" style="width: 50%; margin: 0;"><a href="javascript:void(0);">登录</a></li>
        <li class="text-center" style="width: 50%; margin: 0;"><a href="{{ route('front.auth.register', ['return_url' => Request::input('return_url')]) }}">注册</a></li>
    </ul>
  </div>
  <div class="login-box-body">
    <form class="main-form" method="POST" accept-charset="UTF-8" autocomplete="off" novalidate="novalidate">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="邮箱" name="email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="密码" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-6">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember_me"> 记住我
            </label>
          </div>
        </div>
        <div class="col-xs-6 text-right">
          <a href="{{ route('front.auth.find_password') }}" style="display: inline-block; margin: 10px 0;">忘记密码？</a>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 text-right">
          <button type="submit" class="btn btn-primary btn-flat">　登录　</button>
        </div>
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>

<script src="/plugins/jquery-form/jquery.form.min.js"></script>
<script src="/plugins/jquery-toaster/jquery.toaster.js"></script>
<script src="/assets/base.js"></script>

<!-- Page script -->
<script>
  $(function () {
    var base = new Base();
    base.initForm();
  });
</script>
</body>
</html>

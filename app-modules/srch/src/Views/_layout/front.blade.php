<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="description" content="专注提高搜索效率">
<meta name="author" content="fanybook@126.com">
<link rel="shortcut icon" href="/favicon.ico"/>
<title>@yield('title')</title>

<!-- Bootstrap -->
{!! style('/assets/third-party/bootstrap3/css/bootstrap.min.css') !!}

<!-- Custom styles -->
{!! style('/assets/srch/css/front.css') !!}

@yield('head-assets')

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
<!-- Wrap all page content here -->
<div id="wrap">
<!-- Fixed navbar -->
@yield('wraper-contents')
</div>

<div id="footer">
    <div class="container">
        @yield('footer-contents')
    </div>
</div>

<div id="temple" style="display: none;">
<ul id="tplUserMenu">
    <li><a href="/user">帐号设置</a></li>
    <li><a href="/logout">退出</a></li>
</ul>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
{!! script('/assets/third-party/jquery2/jquery-2.1.1.min.js') !!}
{!! script('/assets/third-party/bootstrap3/js/bootstrap.min.js') !!}

{!! script('/assets/third-party/jquery-colorbox/js/jquery.colorbox-min.js') !!}
{!! style('/assets/third-party/jquery-colorbox/css/colorbox.css') !!}

<script>
$(function(){
    var popoverShown = false;
    $('.navbar-link').popover({
        placement: 'bottom',
        html: true,
        content: $('#tplUserMenu').clone()
    }).on({
        mouseenter: function(){
            $(this).addClass('hover');
            if (popoverShown === false) {
                $(this).popover('show');
            }
        },
        mouseleave: function(){
            $(this).removeClass('hover');

            var self = this;
            setTimeout(function() {
                hidePopover(self);
            }, 200);
        }
    }).on('shown.bs.popover', function () {
        popoverShown = true;

        var self = this;
        $(this).next().on({
            mouseenter: function(){
                $(self).addClass('hover');
            },
            mouseleave: function(){
                $(self).removeClass('hover');

                setTimeout(function() {
                    hidePopover(self);
                }, 200);
            }
        });
    }).on('hidden.bs.popover', function () {
        popoverShown = false;
    });
});

function hidePopover(target) {
    if (!$(target).hasClass('hover')) {
        $(target).popover('hide');
    }
}
</script>

@yield('foot-assets')
</body>
</html>
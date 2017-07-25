<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="description" content="专注提高搜索效率">
<meta name="author" content="fanybook@126.com">
<link rel="shortcut icon" href="/favicon.ico"/>
<title>魔爪一抓，你就得道</title>

<!-- Bootstrap -->
{{ style('/assets/third-party/bootstrap3/css/bootstrap.min.css') }}

<!-- Custom styles -->
{{ style('/assets/searchbox/css/front.css') }}

<style>
.list-group-item div b {
    color: #f00;
    font-weight: normal;
}
</style>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
<div id="wrap">
    <div class="navbar navbar-default">
        <div class="navbar-collapse">
        @if (Auth::check())
            <p class="navbar-text navbar-right"><a href="#account" class="navbar-link">橡胶霸气<span class="caret"></span></a></p>
        @else
            <p class="navbar-text navbar-right"><a href="/login">登录</a> | <a href="/regist">注册</a></p>
        @endif
            <p class="navbar-text navbar-right"><a href="#follow" class="navbar-link">关注我们<span class="caret"></span></a></p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ul class="list-group">
                @foreach ($result['results'] as $item)
                    <li class="list-group-item"><a href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                        <div>{{ $item['content'] }}</div>
                    </li>
                @endforeach
                </ul>
            </div>
            <div class="col-md-4">
                自定义搜索的广告
            </div>
        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!-- /#wrap -->

<div id="footer">
    <div class="container">
        <p class="text-muted text-center">©2014 54MZ <a href="#weixin_qrcode" class="inline">免责声明</a> (我是魅族，也是米族，已入魔族)
        <br><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_2048668'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s19.cnzz.com/stat.php%3Fid%3D2048668' type='text/javascript'%3E%3C/script%3E"));</script></p>
    </div>
</div>

<div id="template" style="display: none;">
<div id="account-menu">
    <ul>
        <li><a href="/user">帐号设置</a></li>
        <li><a href="/logout">退出</a></li>
    </ul>
</div>
<div id="follow-menu">
    <ul>
        <li><a href="#weixin_qrcode" class="inline">微信公众号</a></li>
        <li><a href="#weixin_qrcode" class="inline">微博</a></li>
    </ul>
</div>
<div id='weixin_qrcode' style='background:#fff;'>
    <p><center><strong>用微信扫描二维码，或直接添加“gzefamily”!</strong></center></p>
    <img src="http://bcs.duapp.com/www-5ddian-com/blog/201311/qrcode.jpg" />
</div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
{{ script('/assets/third-party/jquery2/jquery-2.1.1.min.js') }}
{{ script('/assets/third-party/bootstrap3/js/bootstrap.min.js') }}

{{ script('/assets/searchbox/js/common.js') }}
{{ script('/assets/searchbox/js/jquery.se.js') }}
{{ script('/assets/searchbox/js/jquery.suggest.js') }}

{{ script('/assets/third-party/jquery-colorbox/js/jquery.colorbox-min.js') }}
{{ style('/assets/third-party/jquery-colorbox/css/colorbox.css') }}

<script>
$(function(){
    var seConfig = {{ json_encode($seConfig) }};
    // 实例化搜索引擎
    var SE = new SearchEngine();
    SE.position('#searchForm');

    var key = $('#tabs').find('li.active a').data('tag');
    if (key != '' && isset(seConfig[key])) {
        SE.tab(key, seConfig[key]);
    }

    // 给搜索引擎绑定tab事件
    $('#tabs li a, #sider dd a').click(function(){
        var tag = $(this).data('tag');
        var rel = $(this).data('rel');

        if (rel == 'hongbao') {
            return;
        }

        if (tag != '' && isset(seConfig[tag])) {
            var parent = $(this).parent();
            if (parent[0].tagName == 'DD') {
                $('#tabs li').removeClass('active');
            } else {
                $(this).parent().siblings().removeClass('active');
                $(this).parent().addClass('active');
            }

            SE.tab(tag, seConfig[tag]);
        }

        return false;
    });

    $('#searchForm').on('submit', function(){
        if ($(this).attr('method') == 'POST') {
            $(this).submit();
        } else {
            if (isset(SE.config['callback'])) {
                eval(SE.config['callback']);
                callback();
            }

            var goUrl = $(this).attr('action') + '?' + $(this).formSerialize();
            var joinT = $(this).find('input[name="joinT"]').val();
            if (isset(joinT) && joinT != '') {
                goUrl = $(this).attr('action') + joinT + $(this).find('.form-input').val();
            }

            if (isset(SE.config['method'])) {
                var methods = SE.config['method'].split(':');
                if (methods[0] === 'JOIN') {
                    var joinText = methods[1].replace('{$kw}', $(this).find('.form-input').val());
                    goUrl = $(this).attr('action') + joinText;
                }
            }

            window.open(goUrl);
        }

        return false;
    });

    if (isMobile()) {
        $('#searchForm').find('input[type="text"]').sug();
    } else {
        $('#searchForm').find('input[type="text"]').suggest();
    }
    initColorbox();

    var input_chg = false;
    $('#searchForm .form-control').on({
        'input': function(){
            input_chg = true;
        },
        'focus': function(){
            if (!input_chg) {
                $(this).val('');
            }
        }
    });

    var popoverShown = false;
    $('.navbar-link').popover({
        placement: 'bottom',
        html: true,
        content: function() {return $($(this).attr('href') + '-menu').clone().find('ul')}
    }).on({
        mouseenter: function(){
            $(this).addClass('hover');
            if (popoverShown === false) {
                $(this).popover('show');
                initColorbox();
            }
        },
        mouseleave: function(){
            $(this).removeClass('hover');
            hidePopover(this);
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
                hidePopover(self);
            }
        });
    }).on('hidden.bs.popover', function () {
        popoverShown = false;
    });

//    $(document).hammer().on('drag dragend', function (ev) {
//        ev.preventDefault();
//
//        if (ev.currentTarget.activeElement.className != 'form-input') {
//            if (ev.gesture.direction == 'left' && ev.gesture.distance > 3) {
//                $('#sider').animate({right:"0"}, 300);
//                $('#wrap').animate({marginLeft:"-240px"}, 300);
//                $('footer').animate({marginLeft:"-240px"}, 300);
//            }
//            if (ev.gesture.direction == 'right' && ev.gesture.distance > 3) {
//                $('#sider').animate({right:"-240px"}, 300);
//                $('#wrap').animate({marginLeft:""}, 300);
//                $('footer').animate({marginLeft:""}, 300);
//            }
//        }
//
//        return false;
//    });
});

function hidePopover(target) {
    setTimeout(function() {
        if (!$(target).hasClass('hover')) {
            $(target).popover('hide');
        }
    }, 5);
}

function initColorbox() {
    if (isMobile()) {
        $('.inline').colorbox({inline:true, width:"90%", height:"70%", initialWidth:"70%"});
        $(".iframe").colorbox({iframe:true, width:"100%", height:"100%", initialWidth:"80%"});
    } else {
        $('.inline').colorbox({inline:true, width:460});
        $(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
    }
}

var dataForWeixin = {
    MsgImg:"http://immz.qiniudn.com/assets/images/54mz_logo_newr.png",
    TLImg:"http://immz.qiniudn.com/assets/images/54mz_logo_newr.png",
    url:"http://www.54mz.com",
    title:"魔爪一抓，你就得道",
    desc:"专注提高搜索效率",
    prepare:function(argv){
    if (typeof argv.shareTo!='undefined') 
        switch(argv.shareTo) {
            case 'friend':
                //发送给朋友
                alert(argv.scene); //friend
                break;
            case 'timeline':
                //分享到朋友圈
                break;
            case 'favorite':
                //收藏
                alert(argv.scene);//favorite
                break;
            default:
                break;
        }
    }
};
</script>
{{ script('/assets/third-party/wechat/wechat.js') }}
</body>
</html>

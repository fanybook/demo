@extends('srch::_layout.front')

@section('description')专注提高搜索效率@stop

@section('title')魔爪一抓，你就得道@stop

@section('custom-styles')
{!! style('/assets/sbox/css/front.css') !!}
@stop

@section('wraper-contents')
    <div class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-collapse">
                <p class="navbar-text navbar-right"><a href="#follow" class="navbar-link">关注魔爪<span class="caret"></span></a></p>
            </div>
        </div>
    </div>

    <div class="main">
        <div id="logo" class="text-center">
            <h1><a href="/" title="魔爪搜索 - 专注提高搜索效率"></a></h1>
        </div>

        <ul id="tabs" class="clearfix">
            <li><a href="#" data-tag="1">新闻</a></li>
            <li class="active"><a href="#" data-tag="2">网页</a></li>
            <li><a href="#" data-tag="3">微信</a></li>
            <li><a href="#" data-tag="99">网盘</a></li>
            <li><a href="#" data-tag="4">网购</a></li>
            <li><a href="#" data-tag="12">应用</a></li>
            <li><a href="#" data-tag="9">翻译</a></li>
            <li><a href="#" data-tag="10">问答</a></li>
            @if (Auth::check())
            <li><a href="#" data-tag="5">BT磁力链</a></li>
            <li><a href="#" data-tag="5">更多<span>》</span></a></li>
            @endif
        </ul>

        <form id="searchForm" action="http://www.baidu.com/s" method="GET" target="_blank">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="百度更懂中文！" name="wd" value="天气">
                <span class="input-group-btn">
                    <div class="clearBtn" style="display: none;">×</div>
                    <input class="btn btn-default form-submit" type="submit" value="百度一下">
                </span>
            </div>
        </form>

        <div id="se-list" class="clearfix" style="position: relative;">
            <div class="se-item loading" style="display: none;"><img src="{{ asset('/assets/images/icon_loading.gif') }}" width="21" height="17"></div>
        </div>
    </div>
@stop

@section('footer-contents')
    <p class="text-muted text-center">©2014 54MZ <a href="#weixin_qrcode" class="inline" title="用微信扫描二维码，或添加「dy_54mz_com」">免责声明</a> (我是魅族，也是米族，已入魔族)
    <br><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_2048668'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s19.cnzz.com/stat.php%3Fid%3D2048668' type='text/javascript'%3E%3C/script%3E"));</script></p>
@stop

@section('hidden-items')
<div id="account-menu">
    <ul>
        <li><a href="/user">帐号设置</a></li>
        <li><a href="/logout">退出</a></li>
    </ul>
</div>
<div id="follow-menu">
    <ul>
        <li><a href="http://blog.54mz.com/">官方博客</a></li>
        <li><a href="#weixin_qrcode" class="inline" title="微信扫描或搜索‘dy_54mz_com’关注我们">微信公众号</a></li>
        {{--<li><a href="#weixin_qrcode" class="inline">微博</a></li>--}}
    </ul>
</div>
<div id='weixin_qrcode' style='background:#fff;'>
    <img src="/assets/searchbox/images/qrcode.jpg" />
</div>
@stop

@section('sider')
<div id="sider">
    <div id="sider-left"><span class="pull-arrow">《</span></div>
    <div id="sider-main">
        @if (Auth::check())
        <div><img src="http://immz.qiniudn.com/data/uploads/avatar/{{ Auth::user()->id }}/big.jpg?time={{ time() }}"></div>
        @endif
        <div id="cat-panel">
            <dl id="hot-cat" class="clearfix">
                <dt>热门的分类：</dt>
                <dd>图片</dd>
                <dd>地图</dd>
                @if (Auth::check())
                <dd><a href="#" data-tag="13">站长工具</a></dd>
                @endif
                <dd><a href="/more/show" class="iframe" data-rel="hongbao">更多</a></dd>
            </dl>
            @if (Auth::check())
            <dl id="fav-cat" class="clearfix">
                <dt>收藏的分类：</dt>
                <dd>图片</dd>
                <dd>地图</dd>
            </dl>
            <dl id="cus-cat" class="clearfix">
                <dt>自定义的分类：</dt>
                <dd>图片</dd>
                <dd>地图</dd>
            </dl>
            @endif
        </div>
    </div>
</div>
@stop

@section('foot-assets')
{!! script('/assets/base.js') !!}
{!! script('/assets/srch/js/helpers.js') !!}
{!! script('/assets/srch/js/jquery.searchbox.js') !!}
{!! script('/assets/srch/js/jquery.suggest.js') !!}

{!! script('/assets/third-party/bootstrap3/js/bootstrap.min.js') !!}
{!! script('/assets/third-party/jquery-form/jquery.form.min.js') !!}

{!! script('/assets/third-party/jquery-colorbox/js/jquery.colorbox-min.js') !!}
{!! style('/assets/third-party/jquery-colorbox/css/colorbox.css') !!}

{!! script('/assets/third-party/hammer/hammer.min.js') !!}

<script>
var input_chg = false;
var lte768 = isSpDevice();
$(function(){
    $(window).on('resize', function(){
        lte768 = isSpDevice();
    });

    var seConfig = {!! json_encode($seConfig) !!};
    // 实例化搜索引擎
    var sb = new SearchBox();
    sb.position('#searchForm');

    var key = $('#tabs').find('li.active a').data('tag');
    if (key != '' && isset(seConfig[key])) {
        sb.tab(key, seConfig[key]);
    }

    // 给搜索引擎绑定tab事件
    $('#tabs li a, #sider dd a').click(function(){
        var tag = $(this).data('tag');
        var rel = $(this).data('rel');

        if (rel == 'hongbao') {
            return;
        }
        if (!input_chg) {
            $('#searchForm .form-control').val('');
        }

        if (tag != '' && isset(seConfig[tag])) {
            var parent = $(this).parent();
            if (parent[0].tagName == 'DD') {
                $('#tabs li').removeClass('active');
            } else {
                $(this).parent().siblings().removeClass('active');
                $(this).parent().addClass('active');
            }

            sb.tab(tag, seConfig[tag]);
        }

        return false;
    });

    $('#searchForm').on('submit', function(){
        if ($(this).attr('method') == 'POST') {
            $(this).submit();
        } else {
            if (isset(sb.config['callback'])) {
                eval(sb.config['callback']);
                callback();
            }

            var goUrl = $(this).attr('action') + '?' + $(this).formSerialize();
            var joinT = $(this).find('input[name="joinT"]').val();
            if (isset(joinT) && joinT != '') {
                goUrl = $(this).attr('action') + joinT + $(this).find('.form-control').val();
            }

            if (isset(sb.config['method'])) {
                var methods = sb.config['method'].split(':');
                if (methods[0] === 'JOIN') {
                    var joinText = methods[1].replace('{$kw}', $(this).find('.form-control').val());
                    goUrl = $(this).attr('action') + joinText;
                }
            }

            window.open(goUrl);
        }

        return false;
    });

    $('#searchForm').find('input[type="text"]').suggest();
    initColorbox();

    $('#searchForm .form-control').on({
        'input': function(){
            input_chg = true;
            if (lte768) {
                if ($(this).val() !== '') {
                    $('.clearBtn').show();
                } else {
                    $('.clearBtn').hide();
                }
            }
        },
        'focus': function(){
            if (!input_chg) {
                $(this).val('');
            }
        }
    });

    $('.clearBtn').on('click', function() {
        $('#searchForm .form-control').val('');
        $(this).hide();
    });

    $(document).on('click', '.pull-arrow', function() {
        if ($(this).hasClass('open')) {
            pullRight();
        } else {
            pullLeft();
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

//    document.unselectable  = "on";
//    document.onselectstart = function(){   return false; }

    var Touch = function() {
        this.staElement = {};
        this.endElement = {};
        this.eleList = [];
        
        this.addElement = function(el) {
            eleList.push(el);
        }
    }

    document.onmousedown = function(evt) {
        console.log(evt);
    }

    var $el = $('.pull-arrow');
    var mc = new Hammer($el[0]);

    var panItem;
    var panStart = false;
    mc.on('swipe',function(ev){
        if (ev.deltaX < -20) {
            pullLeft();
        }
        if (ev.deltaX > 20) {
            pullRight();
        }

        return false;
    });
});

function pullLeft() {
    $('#sider').animate({right:"0"}, 300);
    $('#wraper').animate({marginLeft:"-240px"}, 300);
    $('#footer').animate({marginLeft:"-240px"}, 300);
    $('.pull-arrow').addClass('open').text('》');
}

function pullRight() {
    $('#sider').animate({right:"-240px"}, 300);
    $('#wraper').animate({marginLeft:""}, 300);
    $('#footer').animate({marginLeft:""}, 300);
    $('.pull-arrow').removeClass('open').text('《');
}

function hidePopover(target) {
    setTimeout(function() {
        if (!$(target).hasClass('hover')) {
            $(target).popover('hide');
        }
    }, 5);
}

function initColorbox() {
    if (lte768) {
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
@stop
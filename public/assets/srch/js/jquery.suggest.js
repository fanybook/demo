/**@license
This file uses Baidu Suggest for jQuery plugin (licensed under GPLv3) by FanyYang ( http://www.fanybook.com )
 */
(function($) {
    $.fn.suggest = function(opt) {
        var defaults = {
            pcSource: function(kw, func){
                        window.baidu = {};
                        window.baidu.sug = function(data){func(data);}
                        $.getScript('http://suggestion.baidu.com/su?zxmode=8&wd=' + kw);
            },
            spSource: function(kw, func){
                        window.baidu = {};
                        window.baidu.sug = function(data){func(data);}
                        $.getScript('http://m.baidu.com/su?p=3&ie=utf-8&from=wise_web&wd=' + kw);
            }
        }
        var opts = $.extend(defaults, opt),
            self = {},
            currText = '',
            keyCode  = {LEFT:'37',UP:'38',RIGHT:'39',DOWN:'40',ENTER:'13'};

        if(this.length < 1) {
            return false;
        }

        return this.each(function() {
            init(this);
        });

        function init(target) {
            self = target;

            // 关闭自动完成
            $(self).attr('autocomplete', 'off');
            // 生成suggest div
            $('<div>', {'id': 'suggest'})
                    .css({'position': 'absolute', 'cursor': 'default', 'display': 'none'})
                    .appendTo("body");
            adjustPosition();

            // ssssssssssssssssssssssssssssssssssssssssssssssssssssss
            if (isSpDevice()) {
                // 输入时，调API，生成html
                $(self).on({
                    input: function(){
                        currText = $(self).val();
                        opts.spSource(currText, createSpHtml);
                    },
                    focus: function(){
                        $('#wrap').css({'min-height': $(window).height()+150});
                        $(document).scrollTop(150);

                        if ($('#suggest .sug').length > 0) {
                            $('#suggest').show();
                        }
                    }
                });

                $('#suggest, #sider').on("click", function(e) {
                    if (e && e.stopPropagation) {
                        e.stopPropagation();
                    } else {
                        e.cancelBubble = true;
                    }
                });

                // 点击空白处隐藏suggest
                // 未使用blur隐藏，是因为点加号，要改变输入值
                $(document).on('click', function(e){
                    e.stopPropagation();

                    var $target = $(e.target);
                    if (e.target.nodeName != 'INPUT' && $target.attr('id') != "suggest"
                      && $('#wrap').css('marginLeft') == '0px') {
                        $('#wrap').removeAttr('style');
                        $(document).scrollTop(0);

                        $('#suggest').hide();
                    }
                });
            // pppppppppppppppppppppppppppppppppppppppppppppppppppppp
            } else {
                // 输入时，调API，生成html
                $(self).on({
                    input: function(){
                        currText = $(self).val();
                        opts.pcSource(currText, createPcHtml);
                    },
                    focus: function(){
                        adjustPosition();
                        if ($('#suggest li').length > 0) {
                            $('#suggest').show();
                        }
                    },
                    blur: function(){
                        $('#suggest').hide();
                    }
                });

                // 上下按键切换li
                $(document).on({
                    keydown:function(e){
                        var $current = $('#suggest li.current');
                        var $sugItems = $('#suggest li');

                        if ($sugItems.length > 0 && e.keyCode == keyCode.UP)
                        {
                            if ($current.length == 0){
                                $(self).val($sugItems.last().text());
                                $sugItems.last().addClass('current');
                            } else {
                                if ($current.prev().length > 0) {
                                    $(self).val($current.prev().text());
                                    $current.removeClass('current');
                                    $current.prev().addClass('current');
                                } else {
                                    $(self).val(currText);
                                    $sugItems.removeClass('current');
                                }
                            }
                            return false;
                        } else if ($sugItems.length > 0 && e.keyCode == keyCode.DOWN) {
                            if ($current.length == 0){
                                $(self).val($sugItems.first().text());
                                $sugItems.first().addClass('current');
                            } else if ($current.index() == $sugItems.length-1) {
                                $(self).val(currText);
                                $sugItems.removeClass('current');
                            } else {
                                $(self).val($current.next().text());
                                $current.removeClass('current');
                                $current.next().addClass('current');
                            }
                            return false;
                        }
                    }
                });
            }
        }

        // 生成电脑版suggest
        function createPcHtml(data){
            $('#suggest').hide();
            $('#suggest ul').remove();
            $('#suggest .suggest-title').remove();
            if (currText == '') {
                return;
            }

            if (data.s.length > 0) {
                $('#suggest').show();

                var sugUL = '<ul>';
//                    if (data.tzx) {
//                        var info = data.tzx.info;
//                        var drt = '<p link="'+info.siteurl+'">直达网站：'+info.site+' <span>'+info.showurl+'</span></p>';
//                        sugUL += '<li class="direct">'+drt+'</li>';
//                    }
                for (var item in data.s){
                    sugUL += '<li>'+data.s[item]+'</li>';
                }
                sugUL += '</ul>';
                $(sugUL).appendTo($('#suggest'));
                $('<div>', {'class': 'suggest-title'}).text('魔爪：告别单一，让搜索更自由！').appendTo('#suggest');

                // $('<div class="sug_copy"><a href="http://www.fanybook.com/" target="_blank">本站由 [非你不可] 开发</a></div>').appendTo(sug);

                $('#suggest li').on({
                    click:function(){
                        $(self).val($(this).text());
                        $('#suggest').hide();
                        $('form').has($(self)).submit();
                    },
                    mousedown : function(){return false;},
                    mouseenter: function(){
//                            $('#suggest li').removeClass('current');
                        $(this).addClass('current');
                    },
                    mouseleave: function(){
                        $('#suggest li').removeClass('current');
                    }
                });
            } else {
                $('#suggest').hide();
            }
        }

        // 生成手机版suggest
        function createSpHtml(data){
            $('#suggest').hide();
            $('#suggest > div').remove();
            if (currText == '') {
                return;
            }

            if (data.s.length > 0) {
                $('#suggest').show();

//                    var sdrt = $('<div>', {'class': 'suggest-direct'}).appendTo('#suggest');
                var sctt = $('<div>', {'class': 'suggest-content'}).appendTo('#suggest');
                var scls = $('<div>', {'class': 'suggest-close'}).appendTo('#suggest');
                var sttl = $('<div>', {'class': 'suggest-title'}).appendTo('#suggest');
                for (var item in data.s){
                    if (item < 6) {
                        var sugItem = '<div class="sug"><button>'+data.s[item]+'</button><div class="sug-edit">+</div></div>';
                        $(sugItem).appendTo(sctt);
                    }
                }
                $(scls).text('关闭');
                $(sttl).text('魔爪：告别单一，让搜索更自由！');

                $('#suggest .sug button').on({
                    click:function(){
                        $(self).val($(this).text());
                        $('#suggest').hide();
                        $('form').has($(self)).submit();
                    }
                });

                $('#suggest .sug .sug-edit').on({
                    click:function(){
                        currText = $(this).prev().text()
                        $(self).val(currText);
                        opts.spSource(currText, createSpHtml);
                    }
                });

                $('#suggest .suggest-close').on({
                    click:function(){
                        $('#wrap').removeAttr('style');
                        $(document).scrollTop(0);

                        $('#suggest').hide();
                    }
                });
            } else {
                $('#suggest').hide();
            }
        }

        function adjustPosition(){
            var width = $(self).parent().outerWidth(),
                top   = findRealTop(self)+$(self).outerHeight(),
                left  = findRealLeft(self);
            $('#suggest').css({'width': width, 'top': top, 'left': left});
        }
    }
})(jQuery);
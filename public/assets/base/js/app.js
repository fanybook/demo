(function($) {
    $.fn.renderSelect = function(opt) {
        var defaults = {
            btnStyle: 'default',
            maxHeight: '100'
        }

        var configs = $.extend(defaults, opt);

        if(this.length < 1) {
            return false;
        }

        return this.each(function() {
            var target = this;

            if (typeof $(target).data('config') != 'undefined') {
                var elConfig = eval('('+ $(target).data('config') +')');
                configs = $.extend(configs, elConfig);
            }

            var htmlText = '<div class="select-group">';
            htmlText += '<button type="button" class="btn btn-default btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            htmlText += '<span></span>';
            htmlText += '<i class="caret"></i>';
            htmlText += '</button>';
            htmlText += '<div class="dropdown-menu">';
            htmlText += '<input type="text" class="form-control">';
            htmlText += '<ul class="selected-list">';

            var btnText = '';
            $(target).find('option').each(function() {
                var cls = '';
                if ((typeof configs.value == 'undefined' && $(this).prop('selected'))
                  || configs.value == $(this).val()) {
                    btnText = $(this).text();
                    $(target).val($(this).val());
                    cls = ' class="checked"';
                }

                htmlText += '<li title="' + $(this).text() + '" data-value="' + $(this).val() + '"' + cls + '>';
                htmlText += '<span class="selected-text">' + $(this).text() + '</span>';
                htmlText += '<span style="display: none;">' + $(this).attr('title') + '</span>';
                htmlText += '<i class="fa fa-check"></i>';
                htmlText += '</li>';
            });
            htmlText += '</ul>';
            htmlText += '</div>';
            htmlText += '</div>';

            $el = $(htmlText);
            $el.find('button span').text(btnText);

            $(target).after($el);
        });
    }
})(jQuery);

$(function() {
    // 清除a和button标签的焦点
    $(document).on('focus', 'a, button', function() {
        this.blur();
    });

    $('select').renderSelect();

    $(document).on('click', '.dropdown-menu input', function() {
        return false;
    })

    // 通过 jQuery :contains 实现的简易搜索
    $(document).on('keyup', '.select-group input', function() {
        var keyWord = $(this).val();
        var $ul = $(this).next();

        if (keyWord.trim != '') {
            $ul.find('li').hide();
            $ul.find('li:contains("' + keyWord + '")').show();
        } else {
            $ul.find('li').show();
        }
    });

    // 禁止回车提交表单
    $(document).on('keydown', '.select-group input', function(event) {
        if (event.keyCode == 13) {
            return false;
        }
    });

    // 模拟 select 控件的选择功能
    $(document).on('click', '.select-group li', function(event) {
        $(this).addClass('checked');
        $(this).siblings().removeClass('checked');

        var $select = $(this).closest('.select-group');
        $select.find('button span').text($(this).find('.selected-text').text());
        $select.prev().val($(this).data('value'));
    });
});

// trim方法
String.prototype.trim = function() {
    return this.replace(/(^\s*)|(\s*$)/g, '');
}

// 回车转br
String.prototype.nl2br = function() {
    return this.replace(/(\r\n?|\n)/g, '<br>');
}

// 简单模板引擎
String.prototype.assign = function(replace, exclude, nl2br) {

    var placeHolder;
    var value = this;
    var list = value.match(/(\{|(%7B))\$.+?(\}|(%7D))/ig);
    var nl2br = nl2br || true;
    var isIE = /*@cc_on!@*/false;

    for (var i = 0; placeHolder = list[i]; i++)
    {
        var key = placeHolder.replace('{', '')
            .replace('}', '')
            .replace('$', '')
            .replace('%7B', '', 'i')
            .replace('%7D', '', 'i');

        if (replace[key] === false ||
            replace[key] === null  ||
            replace[key] === undefined) {

            value = value.replace(placeHolder, '');
            continue;
        } 

        if (exclude && $.inArray(key, exclude) != -1) {
            // no escape
            value = value.replace(placeHolder, replace[key], 'g');
            continue;
        } 

        if (nl2br) {
            // lineFeed replacing for IE
            if (isIE) {
                value = value.replace(placeHolder,
                            $('<div />').text(String(replace[key]).replace(/(\r\n?|\n)/g, '###lineFeed###'))
                                        .html().replace(/###lineFeed###/g, '<br>'), 'g');
            } else {
                value = value.replace(placeHolder,
                            $('<div />').text(replace[key]).html().nl2br(), 'g');
            }
            continue;
        }

        value = value.replace(placeHolder, $('<div/>').text(replace[key]).html(), 'g');
    }

    return value;
}

// 找到节点真是的顶部位置
function findRealTop(item) {
    if(!item) return 0;
    return item.offsetTop + findRealTop(item.offsetParent);
}

// 找到节点真是的底部位置
function findRealBottom(item) {
    if(!item) return 0;
    return findRealTop(item) + item.offsetHeight;
}

// 找到节点真是的左部位置
function findRealLeft(item) {
    if(!item) return 0;
    return item.offsetLeft + findRealLeft(item.offsetParent);
}

// 找到节点真是的右部位置
function findRealRight(item) {
    if(!item) return 0;
    return findRealLeft(item) + item.offsetWidth;
}

// 登录之后自动完成登录前要做的事情
var action;
function apiError(e, callback)
{
    action = callback;
    if (e.status === 401) {
        $.notifyBar({html: '未登陆', cls : 'error'});
        setTimeout(function() {
            $('.iframe.login').click();
        }, 2000);
    } else {
        $.notifyBar({html: '系统错误', cls : 'error'});
    }
}

// 检查Response的result
function checkResponse(response)
{
    if (typeof(response.result) === 'undefined') {
//        $.notifyBar({html: '登陆超时', cls : 'error'});
//        setTimeout(function() {
//            $('.iframe.login').click();
//        }, 2000);
        alert('登陆验证还没做');
        return false;
    } else if (response.result !== true) {
        $.notifyBar({html: response.message, cls : 'error'});
        return false;
    }

    return true;
}

// 改变当前页数
function change_page(page)
{
    var newUrl = change_url_arg(location.href, 'page', page);
    location.href = newUrl;
}

// 改变url里query的某个值
function change_url_arg(url, arg, arg_val)
{
    var pattern = arg + '=([^&]*)';
    var replaceText = arg + '=' + arg_val;

    if (url.match(pattern)) {
        var tmp = '/(' + arg +' =)([^&]*)/gi';
        tmp = url.replace(eval(tmp),replaceText);
        return tmp;
    } else {
        if (url.match('[\?]')) {
            return url + '&' + replaceText;
        }else{
            return url + '?' + replaceText;
        }
    }
}

String.prototype.replaceAll = function(s1,s2) { 
    return this.replace(new RegExp(s1,"gm"),s2); 
}

String.prototype.ltrim = function() {
    return this.replace(/(^\s*)/g, '');
}
String.prototype.rtrim = function() {
    return this.replace(/(\s*$)/g, '');
}

function isset(variable) {
    return typeof variable != 'undefined' ? true : false;
}

function isMobile() {
	var flag = false;
	if (/android/i.test(navigator.userAgent)){
		flag = true;
	}

	if (/ipad|iphone/i.test(navigator.userAgent)){
	    flag = true;
	}
	return flag;
}

function hasScroll() {
    var flg = $(document).scrollTop() > 0 ? true : false;

    if (!flg) {
        $(document).scrollTop(1);
        flg = $(document).scrollTop() > 0 ? true : false;
        $(document).scrollTop(0);
    }

    return flg;
}

var Base = function() {
}

Base.prototype.initForm = function(uri) {
    var self = this;
    var uri = uri || false;

    // ajax提交
    $(document).on('submit', '.main-form', function() {
        var self = $(this);
        self.find('button[type="submit"]').addClass('disabled');

        $(this).ajaxSubmit({
//            type:"post",        //提交方式
//            dataType:"json",    //数据类型
//            url:"${basePath}/login.action", //请求url
            success: function(response) {
                if (response.result !== true) {
                    self.find('button[type="submit"]').removeClass('disabled');
                    $.notifyBar({html: response.message, cls : 'error'});
                    return;
                }

                $.notifyBar({html: response.message, cls : 'success'});

                if (uri) {
                    if (uri == 'edit') {
                        uri += '/' + response.new_id;
                    }

                    setTimeout(function() {
                        window.location.href = uri;
                    }, 2000);
                }
            },
            error: function () {
                self.find('button[type="submit"]').removeClass('disabled');
                $.notifyBar({html: '请求失败请重新提交', cls : 'error'});
            }
        });

        return false;
    });
}

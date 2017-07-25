var Common = function() {}

Common.prototype.notifyBar = function(parameter) {
    cls = parameter.cls || 'success';
    message = parameter.message;
    if (cls === 'error') {
        message = message || 'システムエラーが発生しました';
    }

    $.notifyBar({html: message,
                 delay: 3000,
                 animationSpeed: 300,
                 cls: cls});
}

String.prototype.trim = function() {
    return this.replace(/(^\s*)|(\s*$)/g, '');
}

String.prototype.nl2br = function() {
    return this.replace(/(\r\n?|\n)/g, '<br>');
}

String.prototype.assign = function(replace, exclude, nl2br) {

    var placeHolder;
    var value = this;
    var list = value.match(/(\{|(%7B))\$.+?(\}|(%7D))/ig);
    var nl2br = nl2br || true;
    var isIE = /*@cc_on!@*/false;

    for (var i = 0; placeHolder = list[i]; i++) {

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

$(function() {
    $(".iframe.login").colorbox({iframe:true, width:"60%", height:"60%"});
});

function findRealTop(item) {
    if(!item) return 0;
    return item.offsetTop + findRealTop(item.offsetParent);
}

function findRealBottom(item) {
    if(!item) return 0;
    return findRealTop(item) + item.offsetHeight;
}

function findRealLeft(item) {
    if(!item) return 0;
    return item.offsetLeft + findRealLeft(item.offsetParent);
}

function findRealRight(item) {
    if(!item) return 0;
    return findRealLeft(item) + item.offsetWidth;
}

function authResponse(response)
{
    if (typeof(response.result) === 'undefined') {
        $.notifyBar({html: '登陆超时', cls : 'error'});
        setTimeout(function() {
            $('.iframe.login').click();
        }, 2000);
        return false;
    } else if (response.result === false) {
        $.notifyBar({html: response.message, cls : 'error'});
        return false;
    }

    return true;
}
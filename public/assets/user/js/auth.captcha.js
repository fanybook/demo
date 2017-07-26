var Captcha = function() {
}

Captcha.prototype.get = function(target) {
    var self = this;
    var data = {
        '_token': $('#csrfToken').val()
    };

    $.post('/captcha/get', data, function(response) {
        if (response.result === false) {
            $.notifyBar({html: '验证码获取失败', cls : 'error'});
            return false;
        }

        $('input[name="captcha"]').val('');
        $('.alert-warning p').html(response.question);
        $(target).find('span').removeClass('fa-spin');
    }).error(function(){
        $.notifyBar({html: '验证码获取失败', cls : 'error'});
    });
}
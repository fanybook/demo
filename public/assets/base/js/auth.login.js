$(function() {
    // form验证
    $('form').validate({
       rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            },
            captcha: {
                required: true
            }
       },
       messages: {
            email: {
                required: "请输入email地址",
                email: "请输入正确的email地址"
            },
            password: {
                required: "请输入密码"
            },
            captcha: {
                required: "请输入验证码"
            }
       }
    });

    // ajax提交
    $('form').ajaxForm({
        success: function(response) {
            if (response.result === false) {
                $.notifyBar({html: response.message, cls : 'error'});
                captcha.get();
                return;
            }

            $.notifyBar({html: response.message, cls : 'success'});
            setTimeout(function() {
                if (top.location !== self.location){
                    window.parent.action();
                    window.parent.$.colorbox.close();
                } else {
                    window.location.href = response.goUrl;
                }
            }, 2000);
        }
    });

    // 验证码
    var captcha = new Captcha();
    captcha.get();

    $('.alert-warning button').on('click', function() {
        $(this).find('span').addClass('fa-spin');
        captcha.get(this);
        return false;
    });
});

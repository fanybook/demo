$(function() {
    // form验证
    $('form').validate({
       rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
            password_confirmation: {
                required: true,
                minlength: 6,
                equalTo: 'input[name="password"]'
            },
            captcha: {
                required: true
            }
       },
       messages: {
            email: {
                required: '请输入email地址',
                email: '请输入正确的email地址'
            },
            password: {
                required: '请输入密码',
                minlength: $.validator.format('密码不能小于{0}个字符')
            },
            password_confirmation: {
                required: '请输入确认密码',
                minlength: $.validator.format('密码不能小于{0}个字符'),
                equalTo: '两次输入密码不一致不一致'
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
                return;
            }

            $.notifyBar({html: response.message, cls : 'success'});
            setTimeout(function() {
                window.location.href = '/';
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

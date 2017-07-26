// form验证
$('form').validate({
   rules: {
       username: {
           required: true
       },
       password: {
           required: true
       }
   },
   messages: {
       username: {
           required: "请输入管理账号"
       },
       password: {
           required: "请输入密码"
       }
   }
});

// ajax提交
$('form').ajaxForm({
    success: function(response) {
        if (response.result !== true) {
            $.notifyBar({html: response.message, cls : 'error'});
            return;
        }

        $.notifyBar({html: response.message, cls : 'success'});
        setTimeout(function() {
            window.location.href = response.goUrl;
        }, 2000);
    }
});
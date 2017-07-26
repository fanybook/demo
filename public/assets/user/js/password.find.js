// form验证
$('form').validate({
   rules: {
       email: {
           required: true,
           email: true
       }
   },
   messages: {
       email: {
           required: "请输入email地址",
           email: "请输入正确的email地址"
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
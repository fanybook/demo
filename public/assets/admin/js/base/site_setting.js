var SiteSetting = function() {
}

SiteSetting.prototype.initForm = function() {
    var self = this;

    // ajax提交
    $('.main-form').ajaxForm({
        success: function(response) {
            if (response.result !== true) {
                $.notifyBar({html: response.message, cls : 'error'});
                return;
            }

            $.notifyBar({html: response.message, cls : 'success'});
            setTimeout(function() {
                window.location.href = '/admin/setting';
            }, 2000);
        }
    });
}
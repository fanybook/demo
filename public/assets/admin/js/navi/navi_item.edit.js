var NaviItem = function()
{
    this.waiting = false;
}

NaviItem.prototype.getInfo = function(navi_item_id, target)
{
    var self = this;

    var data = {
        _token  : $('#csrfToken').val(),
        navi_item_id: navi_item_id
    };

    $.post('/admin/navi-item/info', data, function(response) {
        if (response.result !== true) {
            $.notifyBar({html: response.message, cls : 'error'});
            return false;
        }

        // 设置模态里的内容
        target.find('input[name="navi_title"]').val(response.info.navi_title);
        target.find('input[name="navi_link"]').val(response.info.navi_link);
        target.find('input[name="sort_order"]').val(response.info.sort_order);
        if (response.info.new_window_open) {    // 模板默认不选中
            target.find('input[name="new_window_open"]').attr('checked', true);
        }
        if (!response.info.is_show) {           // 模板默认选中
            target.find('input[name="is_show"]').attr('checked', false);
        }
        if (response.info.navi_image) {
            target.find('.navi-image').attr('src', response.info.navi_image);
        }
        $('.modal-content .select-group li[data-value="' + response.info.parent_id + '"]').click();
        $('.modal-content .modal-footer .btn-danger').data('id', response.info.id);
    }).complete(function(){
    }).error(function(){
        $.notifyBar({html: '导航项信息取得失败', cls : 'error'});
    });
}

NaviItem.prototype.deleteNaviItem = function(navi_item_id)
{
    var self = this;

    var data = {
        _token  : $('#csrfToken').val(),
        navi_item_id: navi_item_id
    };

    $.post('/admin/navi-item/delete', data, function(response) {
        if (response.result !== true) {
            $.notifyBar({html: response.message, cls : 'error'});
            return false;
        }

        $.notifyBar({html: response.message, cls : 'success'});

        setTimeout(function() {
            window.location.href = window.location.href;
        }, 2000);
    }).complete(function(){
    }).error(function(){
        $.notifyBar({html: '导航项删除失败', cls : 'error'});
    });
}

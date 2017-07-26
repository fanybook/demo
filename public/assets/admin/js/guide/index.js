var GuideIndex = function()
{
    this.waiting = false;
}

GuideIndex.prototype.deleteSingle = function(target)
{
    var self = this;
    var data = {
        article_id: [$(target).data('id')],
        _token  : $('#csrfToken').val()
    };

    if (!confirm('您确定要删除选中的文章吗？')) {
        return;
    }

    if (self.waiting === true) {
        alert('请稍候...有其他操作正在执行');
    }
    self.waiting = true;

    $.post('/admin/guide/delete', data, function(response) {
        if (response.result !== true) {
            $.notifyBar({html: response.message, cls : 'error'});
            return false;
        }

        $.notifyBar({html: response.message, cls : 'success'});
        window.location.reload();
    }).complete(function(){
        self.waiting = false;
    }).error(function(){
        $.notifyBar({html: '删除失败', cls : 'error'});
    });
}

GuideIndex.prototype.deleteSelected = function()
{
    var self = this;

    var selected = [];
    $('input:checked[name="article_id[]"]').each(function() {
        selected.push($(this).val());
    });

    if (selected.length < 1) {
        alert('您没有选中要删除的攻略');
        return;
    }

    var data = {
        article_id: selected,
        _token  : $('#csrfToken').val()
    };

    if (!confirm('您确定要删除选中的文章吗？')) {
        return;
    }

    if (self.waiting === true) {
        alert('请稍候...有其他操作正在执行');
    }
    self.waiting = true;

    $.post('/admin/guide/delete', data, function(response) {
        if (response.result !== true) {
            $.notifyBar({html: response.message, cls : 'error'});
            return false;
        }

        $.notifyBar({html: response.message, cls : 'success'});
        window.location.reload();
    }).complete(function(){
        self.waiting = false;
    }).error(function(){
        $.notifyBar({html: '删除失败', cls : 'error'});
    });
}

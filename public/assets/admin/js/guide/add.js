var GuideAdd = function()
{
    this.waiting = false;
}

GuideAdd.prototype.initForm = function()
{
    var self = this;
    
    // form验证
    var validator = $('.main-form').validate({
        errorPlacement: function(error, element) {
            error.addClass('errorAlert');
            if (element[0].name === 'umeditor_article_body') {
                error.removeClass('errorAlert');
                error.addClass('top-error');
                element.after(error);
            } else {
                element.after(error);
            }
        },
        rules: {
            article_title: {
                required: true,
            },
            published_at: {
                required: true,
            },
            umeditor_article_body: {
                required: function() {
                    var $el = $('#myEditor');
                    return ($el.html() == '<p><br></p>' || $el.html() == '<p>​<br></p>') ? true : false;
                }
            }
        },
        messages: {
            article_title: {
                required: '请输入文章标题',
            },
            published_at: {
                required: '请输入发布时间',
            },
            umeditor_article_body: {
                required: '请输入文章内容',
            }
        }
    });

    $('.main-form input').on('keyup', function() {
        validator.element(this);
    });

    $('.main-form input').on('change', function() {
        validator.element(this);
    });

    $('#myEditor').on('keyup', function() {
        validator.element($('input[name="umeditor_article_body"]'));
    });

    $('.edui-btn-undo, .edui-btn-redo').on('click', function() {
        validator.element($('input[name="umeditor_article_body"]'));
    });

    // ajax提交
    $('.main-form').ajaxForm({
        beforeSubmit: function() {
            if (self.waiting === true) {
                alert('请稍候...有其他操作正在执行');
                return false;
            }
            self.waiting = true;
        },
        success: function(response) {
            if (response.result !== true) {
                $.notifyBar({html: response.message, cls: 'error'});
                return;
            }

            $.notifyBar({html: response.message, cls: 'success'});
            redirect('/admin/guide');
        },
        complete: function() {
            self.waiting = false;
        },
        error: function() {
            $.notifyBar({html: '操作失败', cls: 'error'});
        }
    });
}

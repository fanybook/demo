var GuideEdit = function()
{
    this.waiting = false;
}

GuideEdit.prototype.initForm = function()
{
    var self = this;
    
    // form验证
    var validator = $('.main-form').validate({
        errorPlacement: function(error, element) {
            error.addClass('errorAlert left');
            if (element[0].type === 'file') {
                error.css('right', '-108px');
                  element.closest('.uploader').after(error);
            } else {
                element.after(error);
            }
        },
        rules: {
            article_title: {
                required: true,
            },
        },
        messages: {
            article_title: {
                required: '请输入文章标题',
            },
        }
    });

    $('.main-form input').on('keyup', function() {
        validator.element(this);
    });

    $('.main-form input[type="file"]').on('change', function() {
        validator.element(this);
    });

//  // form验证
//  var validator = $('.main-form').validate({
//      errorPlacement: function(error, element) {
//          error.addClass('errorAlert left');
//          if (element[0].type === 'file') {
//              error.css('right', '-108px');
//              element.closest('.uploader').after(error);
//          } else {
//              element.after(error);
//          }
//      },
//      rules: {
//          brand_name: {
//              required: true,
//              maxlength: 50
//          },
//          logo_file: {
//              required: function(el) {
//                  if ($('.main-form .img_view').length) {
//                      return $(el).closest('.uploader').siblings('.img_view').is(':hidden');
//                  }
//                  return true;
//              }
//          }
//      },
//      messages: {
//          brand_name: {
//              required: '请输入品牌名称',
//              maxlength: '品牌名不能超过50字符'
//          },
//          logo_file: {
//              required: '请上传品牌LOGO'
//          }
//      }
//  });
//
//  $('.main-form input').on('keyup', function() {
//      validator.element(this);
//  });
//
//  $('.main-form input[type="file"]').on('change', function() {
//      validator.element(this);
//  });

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

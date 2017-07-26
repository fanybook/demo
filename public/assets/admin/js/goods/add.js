$(function() {
    // ==========================================================================
    //                             渲染编辑器
    // ==========================================================================
    var ue = UE.getEditor('container', {
        initialFrameWidth: '100%',
        initialFrameHeight: '400',
        toolbars: [[
            'fullscreen', 'source', '|',
            'paragraph', 'fontfamily', 'fontsize', '|',
            'bold', 'italic', 'underline', '|', 'forecolor', 'backcolor', '|', 'removeformat', '|',
            'justifyleft', 'justifycenter', 'justifyright', '|', 'insertorderedlist', 'insertunorderedlist', 'horizontal', '|',
            'link', 'unlink', 'simpleupload', 'insertimage', '|',
            'undo', 'redo', '|', 'preview', 'drafts'
        ]]
    });

    // ==========================================================================
    //                             渲染标签编辑器
    // ==========================================================================
    $('#tagEditor').tagEditor({
        delimiter: ' '
    });

    // ==========================================================================
    //                             离开页面提醒（关闭模态）
    // ==========================================================================
    var formData;
    var editComplete;
    $('#publishModal').on('shown.bs.modal', function () {
        UM.getEditor('umEditor').setContent('');
        formData = $('#itemEditForm').formSerialize();
        var editComplete = false;
        $('#publishModal input[name="title"]').focus();
    });

    $('#publishModal').on('hide.bs.modal', function () {
        if (!editComplete && $('#itemEditForm').formSerialize() !== formData) {
            if (!confirm('++++++++++++++++++++\n内容有变更，关闭后数据将丢失！\n++++++++++++++++++++')) {
                return false;
            } else {
                $('#itemEditForm')[0].reset();
                UM.getEditor('umEditor').setContent('');
            }
        }
    });

    // ==========================================================================
    //                             文章做成
    // ==========================================================================
    // form验证
    var validator = $('.main-form').validate({
//        errorPlacement: function(error, element) {
//            error.addClass('errorAlert left');
//            if (element[0].type === 'file') {
//                error.css('right', '-108px');
//                element.closest('.uploader').after(error);
//            } else {
//                element.after(error);
//            }
//        },
        showErrors:function(errorMap,errorList) {
            if (this.numberOfInvalids() > 0) {
                $('.am-tabs-nav a[href="#tab1"]').find('.am-badge').text(this.numberOfInvalids()).show();
            } else {
                $('.am-tabs-nav a[href="#tab1"]').find('.am-badge').hide();
            }

            this.defaultShowErrors();
        },
       rules: {
            goods_brand: {
                required: true,
            },
            goods_name: {
                required: true,
            }
       },
       messages: {
            goods_brand: {
                required: "请输入商品品牌",
            },
            goods_name: {
                required: "请输入商品名称",
            }
       }
    });

    $('.main-form input').on('keyup', function() {
        validator.element(this);
    });

    $('.main-form input[type="file"]').on('change', function() {
        validator.element(this);
    });

    // ajax提交（后台验证）
    $('.main-form').ajaxForm({
        success: function(response) {
            if (response.result !== true) {
                $.notifyBar({html: response.message, cls : 'error'});
                return false;
            }

//            editComplete = true;
//            $('#publishModal').modal('hide');
//            $('#itemEditForm')[0].reset();
//            UM.getEditor('umEditor').setContent('');
//
//            setTimeout(function() {
//                $.notifyBar({html: response.message, cls : 'success'});
//            }, 500);

            editComplete = true;
            $('#publishModal').modal('hide');
            setTimeout(function() {
                $.notifyBar({html: response.message, cls : 'success'});
                setTimeout(function() {
                    window.location.href = '/admin/goods/edit/' + response.goodsId;
                }, 1500);
            }, 500);

        },
        error: function() {
            $.notifyBar({html: '系统错误', cls : 'error'});
        }
    });
});
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
            'bold', 'italic', 'underline', 'strikethrough', '|', 'forecolor', 'backcolor', '|', 'removeformat', '|',
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
    //                             离开页面提醒
    // ==========================================================================
//    var formData = $('.main-form').formSerialize();
//    var editComplete   = false;
//    $(window).on('beforeunload', function() {
//        if ($('.main-form').formSerialize() !== formData && !editComplete) {
//            console.log(formData);
//            console.log($('.main-form').formSerialize());
//            return "++++++++++++++++++++++++++++++\n\n文章内容有变更，点击“离开此页”数据将丢失！\n\n++++++++++++++++++++++++++++++";
//        }
//    });

    // ==========================================================================
    //                             文章做成
    // ==========================================================================
    // ajax提交（后台验证）
    $('.main-form').ajaxForm({
        success: function(response) {
            if (response.result !== true) {
                $.notifyBar({html: response.message, cls : 'error'});

                var tpl = $('#tpl-error-list').clone();
                $('#error-list ul').html('');
                $.each(response.errorList, function(idx, value) {
                    var item = tpl.html().assign({'errorMessage'    : value});
                    $('#error-list ul').append(item);
                });
                $('#error-list').show();

                return false;
            }

            $.notifyBar({html: response.message, cls : 'success'});
            setTimeout(function() {
//                editComplete = true;
                window.location.href = '/admin/page/edit/' + response.articleId;
            }, 2000);
        },
        error: function() {
            $.notifyBar({html: '系统错误', cls : 'error'});
        }
    });
});
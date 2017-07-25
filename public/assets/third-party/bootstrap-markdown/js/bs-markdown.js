(function($) {
    /**
     *bs-markdown
     *
     * @param {toolbar}
     * @param {theme}
     * @param {preview} true | false
     */

    $.fn.bsmd = function(options) {
        var settings = $.extend($.fn.bsmd.defaults, options);

        var self = this;
        var id = 'bsmd-' + (new Date).getTime();
        $('<div class="bsmd" id="' + id + '"><div class="btn-toolbar" role="toolbar"></div><div class="bsmd-editor"></div>' + (settings.preview ? '<div class="bsmd-preview"></div>' : '') + '</div>').insertAfter($(this));
        $('<div style="clear:both;"></div>').insertAfter($(this).parent()); // hack xs
        var mdText = $(this).is('textarea') ? $(this).val() : $(this).html();
        $(this).hide();

        for (var i in settings.toolbar) {
            var btnGroup = $('<div class="btn-group"></div>');
            btnGroup.appendTo($('#' + id + ' .btn-toolbar'));
            for (var j in settings.toolbar[i].group) {
                switch(settings.toolbar[i].group[j]) {
                    case 'bold':
                        btnGroup.append(settings.theme.bold);
                        $('#' + id + ' .bsmd-btn-bold').click(function() {
                            //粗体
                            addText(editor, '**粗体**');
                            reText(editor, 2, 4);
                            editor.focus();
                        });
                        break;
                    case 'italic':
                        btnGroup.append(settings.theme.italic);
                        $('#' + id + ' .bsmd-btn-italic').click(function() {
                            //斜体
                            addText(editor, '*斜体*');
                            reText(editor, 1, 3);
                            editor.focus();
                        });
                        break;
                    case 'link':
                        btnGroup.append(themeFormat(settings.theme.link, id));
                        $('#' + id + ' form.bsmd-form-link').on('show.bs.modal', function(e) {
                            var lform = $(this)[0];
                            lform.title.value = '';
                            lform.url.value = 'http://';
                        });
                        $('#' + id + ' form.bsmd-form-link').submit(function() {
                            //链接
                            var lform = $(this)[0];
                            addText(editor, '[' + lform.title.value + '](' + lform.url.value + ' "' + lform.title.value + '")');
                            $(this).modal('hide');
                            editor.focus();
                            return false;
                        });
                        break;
                    case 'quote':
                        btnGroup.append(settings.theme.quote);
                        $('#' + id + ' .bsmd-btn-quote').click(function() {
                            //引用
                            addLine(editor, 2);
                            addText(editor, '>');
                            editor.focus();
                        });
                        break;
                    case 'code':
                        btnGroup.append(settings.theme.code);
                        $('#' + id + ' a.bsmd-code').each(function(index) {
                            //代码
                            $(this).click(function() {
                                var lang = $(this).attr('lang');
                                if ('none' == lang) {
                                    addText(editor, '`代码`');
                                    reText(editor, 1, 3);
                                } else {
                                    addLine(editor, 2);
                                    addText(editor, '```' + lang);
                                    addLine(editor, 2);
                                    addText(editor, '```');
                                    editor.gotoLine(editor.getSelection().getCursor().row, 0, false);
                                }
                                editor.focus();
                            });
                        });
                        break;
                    case 'picture':
                        btnGroup.append(themeFormat(settings.theme.picture, id));
                        $('#' + id + ' form.bsmd-form-picture').on('show.bs.modal', function(e) {
                            var pform = $(this)[0];
                            pform.title.value = '';
                            pform.url.value = 'http://';
                        });
                        $('#' + id + ' form.bsmd-form-picture').submit(function() {
                            //图片
                            var pform = $(this)[0];
                            addText(editor, '![Alt ' + pform.title.value + '](' + pform.url.value + ' "' + pform.title.value + '")');
                            $(this).modal('hide');
                            editor.focus();
                            return false;
                        });
                        break;
                    case 'ol':
                        btnGroup.append(settings.theme.ol);
                        $('#' + id + ' .bsmd-btn-ol').click(function() {
                            //有序列表
                            addLine(editor, 2);
                            addText(editor, '0. ');
                            editor.focus();
                        });
                        break;
                    case 'ul':
                        btnGroup.append(settings.theme.ul);
                        $('#' + id + ' .bsmd-btn-ul').click(function() {
                            //无序列表
                            addLine(editor, 2);
                            addText(editor, '+ ');
                            editor.focus();
                        });
                        break;
                    case 'header':
                        btnGroup.append(settings.theme.header);
                        $('#' + id + ' a.bsmd-header').each(function(index) {
                            //标题
                            $(this).click(function() {
                                var c = '';

                                for (var i = 0; i < (index + 2); i++) {
                                    c += '#';
                                };

                                addText(editor, c + 'H' + (index + 2) + '标题');
                                reText(editor, 0, 4);
                                editor.focus();
                            });
                        });
                        break;
                    case 'ellipsis':
                        btnGroup.append(settings.theme.ellipsis);
                        $('#' + id + ' .bsmd-btn-ellipsis').click(function() {
                            //分割线
                            addLine(editor, 2);
                            addText(editor, '<!--more-->\n\n-------');
                            addLine(editor, 2);
                            editor.focus();
                        });
                        break;
                    case 'undo':
                        btnGroup.append(settings.theme.undo);
                        $('#' + id + ' .bsmd-btn-undo').click(function() {
                            //撤消
                            editor.undo();
                            editor.focus();
                        });
                        break;
                    case 'redo':
                        btnGroup.append(settings.theme.redo);
                        $('#' + id + ' .bsmd-btn-redo').click(function() {
                            //重置
                            editor.redo();
                            editor.focus();
                        });
                        break;
                    case 'preview':
                        btnGroup.append(settings.theme.preview);
                        $('#' + id + ' .bsmd-btn-preview').click(function() {
                            if ($('.bsmd-preview').is(":hidden")) {
                                $('#' + id + ' .bsmd-preview').html(marked(editor.getValue()));
                                // hack换行
                                $('#' + id + ' .bsmd-preview').find('p').each(function() {
                                    var temp = $(this).html().replaceAll("\n", '<br>');
                                    $(this).html(temp);
                                });
                                $('#' + id + ' .bsmd-preview pre').addClass("prettyprint");
                                prettyPrint();
                            }
                            $('.bsmd-editor').toggle();
                            $('.bsmd-preview').toggle();
                            editor.focus();
                        });
                        break;
                    case 'fullscreen':
                        btnGroup.append(settings.theme.fullscreen);
                        $('#' + id + ' .bsmd-btn-fullscreen').click(function() {
                            //全屏
                            var $editor_wrap = $('#' + id);
                            if ($editor_wrap.css("position") == 'fixed') {
                                $('#' + id + ' .bsmd-btn-preview').attr('disabled', false);
                              $("html").css("overflow-y","auto");
                              // hack webkit bug sta
                              // see http://www.zhihu.com/question/20529237
                              $editor_wrap.attr("style");
                              $('.bsmd-editor').attr("style");
                              $('.bsmd-preview').attr("style");
                              // hack webkit bug end
                              $editor_wrap.removeAttr("style");
                              $('.bsmd-editor').removeAttr("style");
                              $('.bsmd-preview').removeAttr("style").hide();
                              editor.resize(true);
                            } else {
                                $('#' + id + ' .bsmd-btn-preview').click();
                                $('.bsmd-editor').show();
                                $('.bsmd-preview').show();

                                $('#' + id + ' .bsmd-btn-preview').attr('disabled', true);
                               $("html").css("overflow-y","hidden");

                              $editor_wrap.css({
                                  "background":"#fff",
                                "position":"fixed",
                                "top":"0","left":"0",
                                "z-index":"1050"
                              });
                              $('.bsmd-editor').css({
                                  "width":"50%"
                              });
                              $('.bsmd-preview').css({
                                  "width":"50%"
                              }).show();
                              editor.resize(true);
                            }
                            editor.focus();
                        });
                        break;
                    default:
                        break;
                }
            }
        }

        var editor = ace.edit($('#' + id + ' .bsmd-editor')[0]);
        editor.setTheme('ace/theme/chrome');
        editor.getSession().setMode('ace/mode/markdown');
        editor.setShowPrintMargin(false);
        editor.focus();

        if (settings.preview) {
            $('#' + id + ' .bsmd-preview').hide();
            editor.on('change', function(e) {
                if (!$('.bsmd-preview').is(":hidden")) {
                    $('#' + id + ' .bsmd-preview').html(marked(editor.getValue()));
                    // hack换行
                    $('#' + id + ' .bsmd-preview').find('p').each(function() {
                        var temp = $(this).html().replaceAll("\n", '<br>');
                        $(this).html(temp);
                    });
                    $('#' + id + ' .bsmd-preview pre').addClass("prettyprint");
                    prettyPrint();
                }
                $(self).val(editor.getValue());
            });
        }

        if (mdText) {
            editor.setValue(mdText);
            reText(editor, -1, 0);
            editor.focus();
        }

        // 处理选择按钮上传
        $('.imageData').on('change', function(event) {
            uploadFile(event.target.files[0], this);
            $(this).val('');
            return false;
        });
    };

    function addLine(editor, num) {
        for (var i = 0; i < num; i++) {
            editor.getSession().getDocument().insertNewLine(editor.getSelection().getCursor());
        }
    }

    function addText(editor, text) {
        editor.getSession().getDocument().insertInLine(editor.getSelection().getCursor(), text);
    }

    function reText(editor, from, to) {
        var p = editor.getSelection().getCursor();
        editor.gotoLine(p.row + 1, p.column - from, false);
        editor.getSelection().selectTo(p.row, p.column - to);
    }

    function themeFormat() {
        var s = arguments[0];
        for (var i = 0; i < arguments.length - 1; i++) {
            var reg = new RegExp("\\{" + i + "\\}", "gm");
            s = s.replace(reg, arguments[i + 1]);
        }

        return s;
    }

    function uploadFile(file, target) {
        var formData = new FormData();
        formData.append('imageData', file);
        formData.append('_token', $('#csrfToken').val());
        $.notifyBar({
            html: '图片上传中，请稍候',
            cls: 'success'
        });
        $.ajax('/common/image/upload', {
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            error: function(xhr, error) {
                $.notifyBar({html: '图片上传失败', cls: 'error'});
            },
            success: function(response) {
                if (response.result != true) {
                    $.notifyBar({html: response.message, cls: 'error'});
                    return;
                }

                $.notifyBar({html: '图片上传成功', cls: 'success'});
                var parentId = $(target).closest('.bsmd').attr('id');
                $('#' + parentId + '-picture-title').val(response.imgInfo.name);
                $('#' + parentId + '-picture-url').val(response.imgInfo.uri);
//                var imageItem = '<div class="image-item">';
//                imageItem += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
//                imageItem += '<img src="' + response.imgInfo.url + '">';
//                imageItem += '<input type="hidden" name="new_images[]" value="' + response.imgInfo.uri + '">';
//                imageItem += '</div>';
//                $('#image-list').append(imageItem);
            }
        });
    }

    $.fn.bsmd.defaults = {
        toolbar : [{
            group : ['bold', 'italic']
        }, {
            group : ['header', 'link', 'picture', 'code', 'quote']
        }, {
            group : ['ol', 'ul', 'ellipsis']
        }, {
            group : ['undo', 'redo']
        }, {
            group : ['preview', 'fullscreen']
        }],
        theme : {
            bold : '<button type="button" class="btn btn-default bsmd-btn-bold" title="粗体"><i class="fa fa-bold"></i></button>',
            italic : '<button type="button" class="btn btn-default bsmd-btn-italic" title="斜体"><i class="fa fa-italic"></i></button>',
            link : '<button type="button" class="btn btn-default" title="链接" data-toggle="modal" data-target="#{0}-modal-link"><i class="fa fa-link"></i></button><form class="form-horizontal bsmd-form-link modal fade" id="{0}-modal-link" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">链接</h4></div><div class="modal-body"><div class="form-group"><label for="{0}-link-title" class="col-sm-2 control-label">标题：</label><div class="col-sm-10"><input type="text" name="title" class="form-control" id="{0}-link-title" placeholder="标题"></div></div><div class="form-group"><label for="{0}-link-url" class="col-sm-2 control-label">网址：</label><div class="col-sm-10"><input type="text" name="url" value="http://" class="form-control" id="{0}-link-url" placeholder="网址"></div></div></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">关闭</button><button type="submit" class="btn btn-primary">确定</button></div></div></div></form>',
            quote : '<button type="button" class="btn btn-default bsmd-btn-quote" title="引用"><i class="fa fa-quote-left"></i></button>',
            code : '<div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="代码"><i class="fa fa-code"></i><span class="caret"></span></button><ul class="dropdown-menu"><li><a lang="none" class="bsmd-code" href="javascript:void(0);">片段</a></li><li><a lang="html" class="bsmd-code" href="javascript:void(0);">html</a></li><li><a lang="css" class="bsmd-code" href="javascript:void(0);">css</a></li><li><a lang="javascript" class="bsmd-code" href="javascript:void(0);">javascript</a></li><li><a lang="markdown" class="bsmd-code" href="javascript:void(0);">markdown</a></li><li><a lang="php" class="bsmd-code" href="javascript:void(0);">php</a></li><li><a lang="csharp" class="bsmd-code" href="javascript:void(0);">c#</a></li><li><a lang="velocity" class="bsmd-code" href="javascript:void(0);">velocity</a></li></ul></div>',
            picture : '<button type="button" class="btn btn-default" title="图片" data-toggle="modal" data-target="#{0}-modal-picture"><i class="fa fa-picture-o"></i></button><form class="form-horizontal bsmd-form-picture modal fade" id="{0}-modal-picture" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">图片 <div class="file-group" style="display: inline-block; vertical-align: top;"><button type="button" class="btn btn-default btn-xs"><i class="fa fa-cloud-upload"></i> 本地上传</button><input class="imageData" type="file"></div></h4></div><div class="modal-body"><div class="form-group"><label for="{0}-picture-title" class="col-sm-2 control-label">标题：</label><div class="col-sm-10"><input type="text" name="title" class="form-control" id="{0}-picture-title" placeholder="标题"></div></div><div class="form-group"><label for="{0}-picture-url" class="col-sm-2 control-label">网址：</label><div class="col-sm-10"><input type="text" name="url" value="http://" class="form-control" id="{0}-picture-url" placeholder="网址"></div></div></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">关闭</button><button type="submit" class="btn btn-primary">确定</button></div></div></div></form>',
            ol : '<button type="button" class="btn btn-default bsmd-btn-ol" title="有序列表"><i class="fa fa-list-ol"></i></button>',
            ul : '<button type="button" class="btn btn-default bsmd-btn-ul" title="无序列表"><i class="fa fa-list-ul"></i></button>',
            header : '<div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="标题"><i class="fa fa-header"></i><span class="caret"></span></button><ul class="dropdown-menu"><li><a class="bsmd-header" href="javascript:void(0);"><i class="fa fa-header"></i>2</a></li><li><a class="bsmd-header" href="javascript:void(0);"><i class="fa fa-header"></i>3</a></li><li><a class="bsmd-header" href="javascript:void(0);"><i class="fa fa-header"></i>4</a></li><li><a class="bsmd-header" href="javascript:void(0);"><i class="fa fa-header"></i>5</a></li><li><a class="bsmd-header" href="javascript:void(0);"><i class="fa fa-header"></i>6</a></li></ul></div>',
            ellipsis : '<button type="button" class="btn btn-default bsmd-btn-ellipsis" title="分割线"><i class="fa fa-ellipsis-h"></i></button>',
            undo : '<button type="button" class="btn btn-default bsmd-btn-undo" title="撤消"><i class="fa fa-undo"></i></button>',
            redo : '<button type="button" class="btn btn-default bsmd-btn-redo" title="重置"><i class="fa fa-repeat"></i></button>',
            preview : '<button type="button" class="btn btn-default bsmd-btn-preview" title="预览"><i class="fa fa-eye"></i></button>',
            fullscreen : '<button type="button" class="btn btn-default bsmd-btn-fullscreen" title="全屏"><i class="fa fa-arrows-alt"></i></button>',
        },
        preview : true
    };
})(jQuery);

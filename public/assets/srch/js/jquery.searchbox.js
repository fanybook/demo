//搜索引擎对象
SearchBox = function() {
    this.loadedTag = {};
}

// 定位表单、输入框和提交按钮
SearchBox.prototype.position = function(id)
{
    if ($(id).size() > 1) {
        alert('请指定唯一的ID');
    }

    this.form   = $(id);
    this.input  = this.form.find('input[type="text"]');
    this.submit = this.form.find('input[type="submit"]');

    // 为切换链接添加click事件
    var self = this;
    $(document).on('click', '#se-list a',function(){
        var key = $(this).data('se');

        if (key != '' && isset(self.tagConfig[key])) {
            $(this).parent().siblings().removeClass("active");
            $(this).parent().addClass("active");

            self.config = self.tagConfig[key];
            self.setForm();
        }
    });
}

// tab动作
SearchBox.prototype.tab = function(tag, tagConfig)
{
    this.tag       = tag;
    this.tagConfig = tagConfig;
    for (var key in tagConfig) {
        this.config = tagConfig[key];
        break;
    }

    // 删除原有的切换链接
    $('#se-list .se-item:not(.loading)').remove();

    // 设置表单
    this.setForm();
    this.setMultiSE();
//    if (!isset(this.loadedTag[tag])) {
//        this.getMultiSE(tag);
//    }
}

// 设置首个为默认表单
SearchBox.prototype.setForm = function()
{
    // 设置表单action和关键词的name
    this.form.attr("action", '');
    this.input.attr('name', 'wd');
    if(isset(this.config.url)) {
        this.form.attr("action", this.config.url);
        if (isSpDevice() && isset(this.config.mbl)) {
            this.form.attr("action", this.config.mbl);
        }
    }
    if(isset(this.config.wd)) {
        this.input.attr('name', this.config.wd);
    }
    this.form.attr('method', 'GET');
    if(isset(this.config.method)) {
        this.form.attr('method', this.config.method);
    }

    // 设置hidden项
    this.form.find("input:hidden").remove();
    if(isset(this.config.hiddens)) {
        for (var item in this.config.hiddens) {
            if (item == 'joinM') {
                continue;
            }
            if (item == 'joinT' && isset(this.config.hiddens.joinM) && isset(this.config.mbl)) {
                if (!(isSpDevice() && this.config.hiddens.joinM == 'mbl')
                 && !(!isSpDevice() && this.config.hiddens.joinM == 'pc')) {
                    continue;
                }
            }
            var $hidden =  $("<input>", {
                type:"hidden",
                name:item,
                value:this.config.hiddens[item]
            });

            this.input.before($hidden);
        }
    }

    // 设置小提示，按钮文字，输入框占位
    this.input.attr('placeholder', '');
    this.submit.val('抓点好货');
    this.form.find('.tips').text('');

    if(isset(this.config.btn)) {
        this.submit.val(this.config.btn);
    }
    if(isset(this.config.tips)) {
        this.form.find('.tips').text(this.config.tips);
    }
    if(isset(this.config.placeholder)) {
        this.input.attr('placeholder', this.config.placeholder);
    }
}

// 设置多引擎切换链接
SearchBox.prototype.setMultiSE = function()
{
    // 设置新的下拉菜单
    var container = $('#se-list');
    var loading   = $('.loading');
    var i = 0;
    for (var key in this.tagConfig) {
        var config = this.tagConfig[key];
        if (i == 0) {
            var item = '<div class="se-item active"><a href="javascript:void(0)" data-se="' + key + '">' + config.name + '</a></div>';
        } else {
            var item = '<div class="se-item"><a href="javascript:void(0)" data-se="' + key + '">' + config.name + '</a></div>';
        }

        loading.before(item);
        i++;
    }

    var els = container.find('.se-item');
    els.css('display', 'inline');
    $('#se-list').find('.loading').css('display', 'none');

//    container.imagesLoaded(function(){
//        var els = container.find('.se-item');
//        els.css('display', 'inline');
//        $('#se-list').find('.loading').css('display', 'none');
//        container.masonry('appended', els, true);
//    });
}

SearchBox.prototype.getMultiSE = function(tag)
{
    this.loadedTag[tag] = tag;
    $('#se-list').find('.loading').css('display', 'inline').show();

    var self = this;
    var data = {
        'tag' : tag
    };
    // 设置新的下拉菜单
    $.post('/api/getSE', data, function(response) {
        for (var key in response.se) {
            var config = response.se[key];
            var item = '<div class="se-item"><a href="javascript:void(0)" data-se="' + key + '">' + config.name + '</a></div>';

            $('.loading').before(item);
        }
        jQuery.extend(self.tagConfig, response.se);
    }).complete(function(){
        var els = $('#se-list').find('.se-item');
        els.css('display', 'inline');
        $('#se-list').find('.loading').css('display', 'none');
//        $('#se-list').imagesLoaded(function(){
//            var els = $('#se-list').find('.se-item');
//            els.css('display', 'inline');
//            $('#se-list').find('.loading').css('display', 'none');
//            $('#se-list').masonry('appended', els, true);
//        });
    });;
}
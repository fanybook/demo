//jQuery 
$(function() {
    // 左导航功能
    $('.admin-sidebar-sub').on('show.bs.collapse', function() {
        $(this).prev().find('.pull-right').removeClass('fa-plus-square-o');
        $(this).prev().find('.pull-right').addClass('fa-minus-square-o');

        var self = this;
        // 收起其他
        $('.admin-sidebar-sub').each(function(key, value) {
            if (value != self && $(value).hasClass('in')) {
                $(value).collapse('hide');
            }
        });
    }).on('hide.bs.collapse', function() {
        $(this).prev().find('.pull-right').removeClass('fa-minus-square-o');
        $(this).prev().find('.pull-right').addClass('fa-plus-square-o');
    });

    // 展开左导航
//    $('#admin-sidebar li.unfolded .admin-sidebar-sub').collapse('show');

    // 搜索的显示与隐藏
    $(".show-status").click(function() {
        var bool = $(this).find("i").hasClass("fa-angle-double-down");
        console.log(bool);
        if (bool) {
            $(this).find("i").removeClass("fa-angle-double-down").addClass("fa-angle-double-up");
            $(this).parents(".content-top").find(".form-horizontal").addClass("none");
        } else {
            $(this).find("i").addClass("fa-angle-double-down").removeClass("fa-angle-double-up");
            $(this).parents(".content-top").find(".form-horizontal").removeClass("none");
        }
    });

    // (列表页，全选checkbox)
    $("table tr td input").click(function() { //点击复选框,切换样式
        //一般的复选框
        var checked = $(this).prop("checked");
//      if (checked) {
//          $(this).addClass("icheckbox-checked");
//      } else {
//          $(this).removeClass("icheckbox-checked");
//      }

        //列表中的复选框
        var len = $(this).parents("tbody").find("input").length;
        var checkLen = $(this).parents("tbody").find("input:checked").length;
        if (len == checkLen) { //判断是否选中
//          $(this).parents("tbody").siblings("thead").find(".icheckbox").addClass("icheckbox-checked")
            $(this).parents("tbody").siblings("thead").find("input").prop("checked", true);
        } else {
//          $(this).parents("tbody").siblings("thead").find(".icheckbox").removeClass("icheckbox-checked")
            $(this).parents("tbody").siblings("thead").find("input").prop("checked", false);
        }
    });

    // (列表页，全选checkbox)
    $("table tr th input").click(function() { //判断选中状态,修改样式
        var checked = $(this).prop("checked");
        if (checked) {
//          $(this).addClass("icheckbox-checked").parents("thead").siblings("tbody").find(".icheckbox").addClass("icheckbox-checked")
            $(this).parents("thead").siblings("tbody").find("tr td input").prop("checked", true);
        } else {
//          $(this).removeClass("icheckbox-checked").parents("thead").siblings("tbody").find(".icheckbox").removeClass("icheckbox-checked")
            $(this).parents("thead").siblings("tbody").find("tr td input").prop("checked", false);
        }
    });

    // 添加头像预览
    $(".load-img .uploader input").change(function() {
        $(this).parents(".load-img").find(".file-name").remove();
        //在旁边显示名称
        var v = $(this).val();
        var name = v.split("\\");
        var sp = "<span class='file-name'>" + name[name.length - 1] + "</span>";
        $(this).parents(".uploader").after(sp);
        
        //加载图片
        var s=$(this).attr("id");//取得图片的id
        var file = document.getElementById(s).files[0]; //取得DOM元素
        var pic=$(this).parents(".load-img").find(".user-image");//找到要添加的图片位置
        var reader = new FileReader(); //初始化加载文件
        reader.onload = function(e) { //加载文件的时候显示图片
            pic.find("img").attr("src", e.target.result); //改变图片的路径
        }
        reader.readAsDataURL(file); //读取文件内容
    });

    $(".load-img1 input:not(input[type=file])").keyup(function(){
        var inputV=$(this).val();
        if($(this).parent().hasClass("remark")){
            $(this).parents(".load-img1").next(".preview").find(".remarkV").text(inputV);
        }
        else if($(this).parent().hasClass("sort")){
            $(this).parents(".load-img1").next(".preview").find(".sortV").text(inputV);
        }
        else{
            $(this).parents(".load-img1").next(".preview").find(".linkV").text(inputV);
        }
    })

    $(document).on("change", ".load-img1 .uploader input[type=file]", function() {
         //显示名称信息
        var v = $(this).val();
        var name = v.split("\\");
        $(this).parents(".load-img1").next(".preview").find(".nameV").text(name[name.length-1]);
        //加载图片
        var s=$(this).attr("id");//取得图片的id
        var file = document.getElementById(s).files[0]; //取得DOM元素
        var pic=$(this).parents(".load-img1").next(".preview");//找到要添加的图片位置

        if (typeof file != 'undefined') {
            var reader = new FileReader(); //初始化加载文件
            reader.onload = function(e) { //加载文件的时候显示图片
                pic.find("img").attr("src", e.target.result); //改变图片的路径
            }
            reader.readAsDataURL(file); //读取文件内容
        } else {
            pic.find("img").attr("src", pic.find("img").data("ori")); //改变图片的路径
        }
    });

    $(".load-img2 .uploader input").change(function() {
    	$(this).parents(".load-img2").next(".img").remove();
        //显示名称
        var v = $(this).val();
        console.log(v);
        var name = v.split("\\");
        var remarkV1=$(this).parents(".form-group").find(".remark input").val();
        
        //加载图片
        var s=$(this).attr("id");//取得图片的id
        var t='<div class="form-group img"><label class="col-sm-2 control-label"></label><div class="user-image col-sm-3"><img src=""/></div>'+'<div class="col-sm-5 mt15 t1"><span>名称 : '+name[name.length - 1]+'<br />备注 : '+remarkV1+'<br /></span>'+'</div></div>';
        $(this).parents(".load-img2").after(t);
        var file = document.getElementById(s).files[0]; //取得DOM元素
        var pic=$(this).parents(".load-img2").next();//找到要添加的图片位置
        var reader = new FileReader(); //初始化加载文件
        reader.onload = function(e) { //加载文件的时候显示图片
            pic.find("img").attr("src", e.target.result); //改变图片的路径
        }
        reader.readAsDataURL(file); //读取文件内容
    });

    // 商品编辑推荐类型
    $("#baseInfo .btn-group .btn").click(function() {
        var bool = $(this).hasClass("active");
        if (bool) {
            $(this).removeClass("active");
        } else {
            $(this).addClass("active");
        }
    });

    // 树形分类
    $("tbody > tr > td > .category-name").click(function() { //根据图标显示分类
        var className = ['first-category', 'second-category', 'third-category']
        var trClass = $(this).parents("tr").attr("class");
        var trId = $(this).parents("tr").attr("id");
        var openCategory; //展开节点的class
        $.each(className, function(index, val) {
            if (val == trClass) {
                openCategory = className[index + 1]; //取得展开节点的class名称
            }
        });
        var bool = $(this).find("i").hasClass("fa-plus-square-o"); //判断图标
        if (bool) { //切换图标并把字典折叠起来
            $(this).find("i").removeClass("fa-plus-square-o").addClass("fa-minus-square-o");
            $("." + openCategory).each(function() {
                var s = $(this).attr("id");
                if (s.substring(0, s.length - 4) == trId) { //取得展开节点的父节点
                    $(this).show(150); //展开子节点
                }
            })
        } else {
            $(this).find("i").addClass("fa-plus-square-o").removeClass("fa-minus-square-o");
            $("." + openCategory).each(function() { //控制下一个节点
                var s = $(this).attr("id");
                var str = s.substring(0, s.length - 4);
                var bool1 = $(this).find("i").hasClass("fa-plus-square-o");
                if (str == trId) { //节点id是否等于父节点id
                    if (bool1) { //判断节点本身是否展开
                        $(this).hide(150);
                    } else { //没有展开就先调用click函数把节点展开
                        $(this).find(".category-name").click();
                        $(this).hide(150);
                    }
                }
            })
        }
    });

//$(".datepicker").datepicker();

//首页编辑
$(".new-name input").keyup(function(){
     selectId=$(this).parents(".form-group").siblings(".form-group").find("select").val();//取得选择的值
    if(selectId=="0"){alert("请选择模块");return false;}
    var newV=$(this).val();//取得输入的值
    $(this).parents("#admin-content").find('td.'+selectId).text(newV);//把赋值给对应的表格
    })
});

//提交编辑器输入验证
//$("button.btn").click(function(e) {
//  var str=$(".edui-container").parents(".form-group").children("label").text();
//  $(".edui-container .error").remove();
//  var err='<label class="error top-error">请输入'+str.substring(0,4)+'</label>';//提示
//  var scriptV=$(".edui-editor-body #myEditor p").html();
//  if (scriptV=="<br>") {//判断是否有内容，没有内容阻止提交
//      e.preventDefault();//阻止提交
//      $(".edui-container").append(err);//追加提示
//  }
//});
// 按钮提交的快捷键屏蔽
$('.modal').keypress(function(e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        if ($('#txtarea').is(":focus")) {
            $('#areaSearch').click();
        }
    }
});

// 活动画面
$("input[name=companion_flg]").click(function(){
    var bool=$(this).prop("checked");
    var count=$(this).parent().next().find("input")
    if (bool) {
    	count.removeAttr("disabled");
    }else{
        count.prop("disabled",true);
    }
    alert(b)
});

$("input[name=entry_count]").keyup(function(){
    if($(this).val()>0){
        $(this).parents(".form-group").siblings(".info").css("display","block");
    }else{
        $(this).parents(".form-group").siblings(".info").css("display","none");
    }
    
})

function redirect(url, delay)
{
    var url = url || '/';
    var delay = delay || 2000;

    setTimeout(function() {
        window.location.href = url;
    }, delay);
}

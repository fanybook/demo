//分页
function pagePagination(page, everyPage, maxCount) {
    var maxCount = maxCount;
    //  var maxCount = $("#admin-content table tr").length - 1; //总条数
    var page = page; //当前页
    var everyPage = everyPage; //每页个数
    var maxPage = Math.ceil(maxCount / everyPage); //总页数
    var pageCon = ""; //初始化为空
    if (maxPage > 0) { //页码大于0
        pageCon += "<div class='clearfix'><ul class='pagination pagination-lg ml10 pull-right'><li><span>共 <span>" + maxPage + "</span> 页( <span>" + maxCount + "</span> 条)</span></li><li class='page-to'><span >跳转到第 <input type='number' min=0 name='page'/> 页</span></li><li><input type='submit' class='goto' value='跳转'></li></ul>";
    }
    if (maxPage >= 1) { //页码大于1
        pageCon += "<ul class='pagination pagination-lg pull-right'>";
    }
    if(page>1) {//当前页大于1时添加后一页按钮
            pageCon+="<li><a href='#' data-page='"+(page-1)+"'>&laquo;</a></li>";
    }
    if (maxPage <= 5) {
        for (var i = 1; i <= maxPage; i++) {
            if (i == page) {
                pageCon += "<li class='active'><a href='#' data-page='"+i+"'>" + i + "</a></li>"; //显示当前页码
            } else {
                pageCon += "<li><a href='#' data-page='"+i+"'>" + i + "</a></li>"; //显示其他页码
            }
        }
    }
    
    if (maxPage > 5 && page <= 2) {
        //当前页大于2并且
        for (var i = 1; i <= 5; i++) {
            if (i == page) {
                pageCon += "<li class='active'><a href='#' data-page='"+i+"'>" + i + "</a></li>"; //显示当前页码
            } else {
                pageCon += "<li><a href='#' data-page='"+i+"'>" + i + "</a></li>"; //显示其他页码
            }
        }
    }
    if (maxPage > 5 && page > maxPage - 2) {
        for (var i = maxPage - 4; i <= maxPage; i++) {
            if (i == page) {
                pageCon += "<li class='active'><a href='#' data-page='"+i+"'>" + i + "</a></li>"; //显示当前页码
            } else {
                pageCon += "<li><a href='#' data-page='"+i+"'>" + i + "</a></li>"; //显示其他页码
            }
        }
    }
    if (maxPage > 5 && page > 2 && page <= maxPage - 2) {
        for (var i = page - 2; i <= page + 2; i++) {
            if (i == page) {
                pageCon += "<li class='active'><a href='#'  data-page='"+i+"'>" + i + "</a></li>"; //显示当前页码
            } else {
                pageCon += "<li><a href='#' data-page='"+i+"'>" + i + "</a></li>"; //显示其他页码
            }
        }
    }
    
    if (page < maxPage) {//当前页小于最后一页时添加前一页按钮
        pageCon += "<li><a href='#' data-page='"+(page+1)+"'>&raquo;</a></li></li>";
    }
    pageCon += "</ul></div>";
    $("#admin-content .page").append(pageCon);
}

function changeURLArg(url, arg, arg_val)
{
    var pattern=arg+'=([^&]*)';
    var replaceText=arg+'='+arg_val;

    if(url.match(pattern)){
        var tmp='/('+ arg+'=)([^&]*)/gi';
        tmp=url.replace(eval(tmp),replaceText);
        return tmp;
    } else {
        if(url.match('[\?]')){
            return url+'&'+replaceText;
        }else{
            return url+'?'+replaceText;
        }
    }

    return url+'\n'+arg+'\n'+arg_val; 
}

function jumpPage(page)
{
    var newUrl = changeURLArg(location.href, 'page', page);
    location.href = newUrl;
}

$(document).on('click', '.pagination a', function() {
    jumpPage($(this).data('page'));

    return false;
})

$(document).on('click', 'input.goto', function() {
    var page = $(this).closest('form').find('input[name="page"]').val();
    jumpPage(page);

    return false;
})
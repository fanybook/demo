<?php

/**
 * 通过切换命名空间，换主题
 * @param  string $view 模板的key
 * @return string       返回新的key
 */
function tpl($view = null)
{
    $theme = 'default';
    $tpl = $theme . '::' . $view;

    $factory = app('Illuminate\Contracts\View\Factory');
    if (!$factory->exists($tpl)) {
        $tpl = 'default::' . $view;
    }

    return $tpl;
}

/**
 * 切换静态文件的cdn，默认不实用cdn
 * @param  string $str 七牛的二级域名
 * @return string      服务器域名
 */
function cdn($str = '')
{
    if (!empty($str)) {
        return sprintf('http://%s.qiniudn.com', $str);
    } else {
        return '';
    }
}

/**
 * 生成css文件的引用，为了方便切换cdn
 * @param  string $asset css文件的路径
 * @return string        css的引用html
 */
function style($asset)
{
    $asset = cdn() . $asset;
    return sprintf('<link href="%s" rel="stylesheet">', asset($asset));
}

/**
 * 生成js文件的引用，为了方便切换cdn
 * @param  string $asset js文件的路径
 * @return string        js的引用html
 */
function script($asset)
{
    $asset = cdn() . $asset;
    return sprintf('<script src="%s"></script>', asset($asset));
}

/**
 * 把明确时间转化成智能时间（例如：3秒前，5天前）
 * @param  string $str 代表时间的字符串
 * @return string      智能时间（例如：3秒前，5天前）
 */
function smart_time($str)
{
    $ts = strtotime($str);
    $passed = time() - $ts;

    if ($passed < 60) {
        return $passed . '秒前';
    } elseif ($passed < 3600) {
        $minute = floor($passed / 60);
        return $minute . '分钟前';
    } elseif ($passed < 3600 * 24) {
        $hour = floor($passed / 3600);
        return $hour . '小时前';
    } else {
        $day = floor($passed / (3600 * 24));
        if ($day < 31) {
            return $day . '天前';
        }
    }

    return date('Y-m-d', $ts);
}

/**
 * 取得访客的ip地址
 * @return [type] [description]
 */
function get_client_ip()
{
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } elseif (!empty($_SERVER["REMOTE_ADDR"])) {
        $ip = $_SERVER["REMOTE_ADDR"];
    } else {
        $ip = "unknown";
    }

    return $ip;
}

/**
 * 生成网页的seo标题
 * @param  mixed  $feed      字符串或数组，组成标题的各级名称
 * @param  string $separator 标题分隔符
 * @return string            网页的标题
 */
function seo_title($feed, $separator = ' - ')
{
    if (!is_array($feed)) {
        $feed = [$feed];
    }

    $title = implode($separator, $feed);

    return $title;
}

/**
 * 生成网页的seo描述
 * @param  string $html 从富文本中截取50文字
 * @return string       网页的标题
 */
function seo_desc($html, $length = 50)
{
    $search = [
        "'<script[^>]*?>.*?</script>'si", // 去掉 javascript
        "'<[\/\!]*?[^<>]*?>'si", // 去掉 HTML 标记
        "'([\r\n])[\s]+'", // 去掉空白字符
        "'&(quot|#34);'i", // 替换 HTML 实体
        "'&(amp|#38);'i",
        "'&(lt|#60);'i",
        "'&(gt|#62);'i",
        "'&(nbsp|#160);'i",
        "'&(iexcl|#161);'i",
        "'&(cent|#162);'i",
        "'&(pound|#163);'i",
        "'&(copy|#169);'i",
//        "'&#(\d+);'e"
    ];

    $replace = [
        "",
        "",
        "\\1",
        "\"",
        "&",
        "<",
        ">",
        " ",
        chr(161),
        chr(162),
        chr(163),
        chr(169),
//        "chr(\\1)"
    ];

    $text = preg_replace($search, $replace, $html);

    return iconv_substr($text, 0, $length, 'UTF-8');
}

/**
 * 移除富文本中的javascript
 * @param  string $html 富文本
 * @return string       移除javascript的富文本
 */
function remove_js($html)
{
    $pattern = '/<script[^>]*?>.*?</script>/si';
    $replacement = '';

    return preg_replace($pattern, $replacement, $html);
}

function font_size($max, $hot)
{
    $k = (30 - 10) / ($max - 1);

    return $k * $hot + 10;
}

/**
 * 生成分页的html
 */
function render_pagination($page, $limit, $total)
{
    $maxPage = ceil($total / $limit);

    if ($maxPage < 1) {
        return;
    }

    $html = '<div class="clearfix">';

    // 跳转
    $html .= '<ul class="pagination pagination-lg pull-right">';
    $html .= '<li><span>共 <span>' . $maxPage . '</span> 页( <span>' . $total . '</span> 条)</span></li>';
    $html .= '<li class="page-to"><span >跳至 <input type="tex" name="page"> 页</span></li>';
    $html .= '<li><input type="submit" class="goto" value="跳转"></li></ul>';

    // 分页start
    $html .= '<ul class="pagination pagination-lg pull-right">';

    // 前一页按钮
    if ($page > 1) {
        $html .= '<li><a href="' . change_page($page - 1) . '">&laquo;</a></li>';
    }

    $showPage = 5;      // 必须是奇数
    $halfNumber = floor($showPage / 2);     // 2
    
    if ($maxPage <= $showPage) {
        $start_page = 1;
        $end_page = $maxPage;
    } else {
        if ($page <= $halfNumber + 1) {
            $start_page = 1;
            $end_page = $showPage;
        } elseif ($page >= $maxPage - $halfNumber) {
            $start_page = $maxPage - $showPage + 1;
            $end_page = $maxPage;
        } else {
            $start_page = $page - $halfNumber;
            $end_page = $page + $halfNumber;
        }
    }

    // 生成分页
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $page) {
            $html .= '<li class="active"><a href="' . change_page($i) . '">' . $i . '</a></li>';
        } else {
            $html .= '<li><a href="' . change_page($i) . '">' . $i . '</a></li>';
        }
    }

    // 后一页按钮
    if ($page < $maxPage) {
        $html .= '<li><a href="' . change_page($page + 1) . '">&raquo;</a></li></li>';
    }

    $html .= "</ul></div>";

    echo $html;
}

/**
 * 生成分页的html
 */
function simple_pagination($page, $limit, $total)
{
    $maxPage = ceil($total / $limit);

    if ($maxPage < 1) {
        return;
    }

    $html  = '<ul class="pager"><nav>';

    if ($page > 1) {
        $html .= '<li class="previous"><a href="' . change_page($page - 1) . '">« 上一页</a></li>';
    }

    if ($page < $maxPage) {
        $html .= '<li class="next"><a href="' . change_page($page + 1) . '">下一页 »</a></li>';
    }

    $html .= '</ul></nav>';

    echo $html;
}

/**
 * 更改url里的page值
 */
function change_page($page)
{
    return change_url_arg($_SERVER['REQUEST_URI'], 'page', $page);
}

/**
 * 更改url里的某个值
 */
function change_url_arg($url, $arg_name, $arg_val)
{
    $pattern = '/' . $arg_name . '=([^&]*)/';
    $replace = $arg_name . '=' . $arg_val;

    if (preg_match($pattern, $url)) {
        $tmp = '/(' . $arg_name . '=)([^&]*)/i';
        $tmp = preg_replace($tmp, $replace, $url);
        return $tmp;
    } else {
        if (preg_match('[\?]', $url)) {
            return $url . '&' . $replace;
        } else {
            return $url . '?' . $replace;
        }
    }
}

function rand_len_int($len = 6)
{
    $min_value = pow(10, $len - 1);
    $max_value = pow(10, $len) - 1;

    return rand($min_value, $max_value);
}

function ellipsis_len($text, $length = 20)
{
    if (mb_strlen($text, 'UTF-8') <= $length) {
        return $text;
    }

    return mb_substr($text, 0, $length, 'UTF-8') . '...';
}

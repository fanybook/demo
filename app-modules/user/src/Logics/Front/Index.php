<?php

namespace Modules\Srch\Logics\Front;

class Index extends \BaseLogic
{
    protected function execute()
    {
        try {
            $this->getSeConfig();
            $this->result['result'] = true;
        } catch (\Exception $e) {
            $this->result['result']  = false;
            $this->result['message'] = $e->getMessage();
        }
    }

    protected function getSeConfig()
    {
        // 搜索引擎配置
        $this->result['seConfig'] = array(
            '5' => array(
                'se110' => array(
                    'name' => 'btspread',
                    'url' => 'http://www.btspread.com/search',
                    'placeholder' => '邪恶的网站，想好了再搜',
                    'method' => 'JOIN:/{$kw}',
                ),
                'se111' => array(
                    'name' => 'BT樱桃',
                    'url' => 'http://www.btcherry.com/search',
                    'wd' => 'keyword',
                ),
                'se112' => array(
                    'name' => 'BT粉丝',
                    'url' => 'http://www.btfen.com/list',
                    'method' => 'JOIN:/{$kw}/1',
                ),
//                'se109' => array(
//                    'name' => '本地优化',
//                    'url' => 'bt',
//                    'placeholder' => '云播已死，老实下载！',
//                ),
            ),
            '1' => array(
                'se111' => array(
                    'name' => '百度新闻',
                    'url' => 'http://news.baidu.com/ns',
                    'mbl' => 'http://m.baidu.com/news',
                    'wd' => 'word',
                    'btn' => '百度一下',
                    'hiddens' => array(
                        'tn' => 'news',
                        'joinT' => '#search/',
                        'joinM' => 'mbl',
                    ),
                ),
                'se112' => array(
                    'name' => '搜狗新闻',
                    'url' => 'http://news.sogou.com/news',
                    'wd' => 'query',
                    'btn' => '搜狗搜搜',
                ),
            ),
            '2' => array(
                'se101' => array(
                    'name' => '百度',
                    'url' => 'http://www.baidu.com/s',
                    'btn' => '百度一下',
                    'placeholder' => '百度更懂中文！',
                ),
                'se103' => array(
                    'name' => '搜狗',
                    'url' => 'http://www.sogou.com/web',
                    'mbl' => 'http://wap.sogou.com/web/searchList.jsp',
                    'wd' => 'query',
                    'hiddens' => array(
                        'ie' => 'utf-8',
                    ),
                    'btn' => '搜狗搜索',
                    'placeholder' => '搜狗和腾讯搜搜合并了',
                ),
                'se104' => array(
                    'name' => '谷歌',
                    'url' => 'https://www.google.com.hk/search',
//                    'method' => 'JOIN:#q={$kw}',
                    'wd' => 'q',
                    'btn' => '拜托谷歌',
                    'placeholder' => '好的红杏都在墙外，有本事你也出墙~',
                ),
                'se102' => array(
                    'name' => '必应',
                    'url' => 'https://www.bing.com/search',
                    'wd' => 'q',
                    'btn' => '微软必应',
                    'placeholder' => '谷歌已死，有事找我！',
                ),
                'se121' => array(
                    'name' => '搜狗wap',
                    'url' => 'http://wap.sogou.com/web/searchList.jsp',
                    'wd' => 'keyword',
                    'hiddens' => array(
                        'ie' => 'utf-8',
                    ),
                    'btn' => '搜狗搜索',
                    'placeholder' => '搜狗和腾讯搜搜合并了',
                ),
            ),
            '3' => array(
                'se104' => array(
                    'name' => '文章',
                    'url' => 'http://weixin.sogou.com/weixin',
                    'mbl' => 'http://weixin.sogou.com/weixinwap',
                    'wd' => 'query',
                    'hiddens' => array(
                        'type' => 2,
                        'ie' => 'utf-8',
                    ),
                    'btn' => '文章搜索',
                    'placeholder' => '微信平台文章搜索',
                ),
                'se105' => array(
                    'name' => '公众号',
                    'url' => 'http://weixin.sogou.com/weixin',
                    'mbl' => 'http://weixin.sogou.com/weixinwap',
                    'wd' => 'query',
                    'hiddens' => array(
                        'type' => 1,
                        'ie' => 'utf-8',
                    ),
                    'btn' => '找公众号',
                    'placeholder' => '公众号及二维码搜索',
                ),
            ),
            '4' => array(
                'se106' => array(
                    'name' => '一帆海购',
                    'url' => 'http://www.yifanshop.com/search.php',
                    'wd' => 'keywords',
                    'hiddens' => array(
                        'imageField' => '搜索'
                    ),
                    'btn' => '一帆海购',
                    'placeholder' => '海购？就去一帆！',
                ),
                'se107' => array(
                    'name' => '淘宝',
                    'url' => 'http://s.taobao.com/search',
                    'mbl' => 'http://m.taobao.com/search',
                    'wd' => 'q',
                    'btn' => '去淘点宝',
                    'placeholder' => '去淘点便宜宝贝！',
                ),
                'se108' => array(
                    'name' => '京东',
                    'url' => 'http://search.jd.com/Search',
                    'mbl' => 'http://m.jd.com/ware/search.action',
                    'wd' => 'keyword',
                    'hiddens' => array(
                        'enc' => 'utf-8',
                    ),
                    'btn' => '京东一下',
                    'placeholder' => '这儿里都是正品！',
                ),
            ),
            '9' => array(
                'se120' => array(
                    'name' => '百度翻译',
                    'url' => 'http://fanyi.baidu.com/translate',
                    'wd' => 'query',
                    'method' => 'POST',
                    'hiddens' => array(
                        'keyfrom' => 'baidu',
                        'smartresult' => 'dict',
                        'lang' => 'auto2zh',
                    ),
                    'btn' => '百度翻译',
                    'placeholder' => '感觉百度翻译日语比谷歌准',
                ),
                'se121' => array(
                    'name' => '有道翻译',
                    'url' => 'http://fanyi.youdao.com/translate',
                    'wd' => 'i',
                    'method' => 'POST',
                    'hiddens' => array(
                        'ue' => 'utf-8',
                        'smartresult' => 'dict',
                        'keyfrom' => 'baidu',
                    ),
                    'btn' => '有道翻译',
                ),
//                'se122' => array(
//                    'name' => '爱词霸翻译',
//                    'url' => 'http://fy.iciba.com/api.php',
//                    'wd' => 'q',
//                    'method' => 'POST',
//                    'hiddens' => array(
//                        'type' => 'auto',
//                    ),
//                    'btn' => '翻译一下',
//                    'placeholder' => '感觉百度翻译日语比谷歌准',
//                ),
            ),
            '10' => array(
                'se210' => array(
                    'name' => 'SegmentFault',
                    'url' => 'http://segmentfault.com/search',
                    'wd' => 'q',
                    'btn' => '找寻答案',
                    'placeholder' => 'IT技术类问答平台',
                ),
                'se211' => array(
                    'name' => '知乎',
                    'url' => 'http://www.zhihu.com/search',
                    'wd' => 'q',
                    'hiddens' => array(
                        'type' => 'question',
                    ),
                    'btn' => '找寻答案',
                    'placeholder' => '与世界分享你的知识、经验和见解',
                ),
                'se212' => array(
                    'name' => '百度知道',
                    'url' => 'http://zhidao.baidu.com/search',
                    'wd' => 'word',
                    'hiddens' => array(
                        'ie' => 'gbk',
                    ),
                    'btn' => '百度一下',
                    'placeholder' => '全球最大中文互动问答平台',
                ),
                'se213' => array(
                    'name' => 'stackoverflow',
                    'url' => 'http://stackoverflow.com/search',
                    'wd' => 'q',
                    'btn' => '请教一下',
                    'placeholder' => '全球最大IT技术类问答平台',
                ),
            ),
            '12' => array(
                'se1201' => array(
                    'name' => '下载吧',
                    'url' => 'http://so.xiazaiba.com/route.php?ct=search_new',
                    'wd' => 'q',
                    'method' => 'POST',
                    'hiddens' => array(
                        'i' => '1',
                        'stype' => '1',
                    ),
                    'btn' => '破解软件',
                    'placeholder' => '雨林木风出品',
                ),
                'se1202' => array(
                    'name' => 'softonic',
                    'url' => 'http://www.softonic.cn/s',
                    'method' => 'JOIN:/{$kw}',
                    'btn' => '正版软件',
                    'placeholder' => '欧洲领先的软件下载网站',
                ),
            ),
            '13' => array(
                'se1301' => array(
                    'name' => '域名查询',
                    'url' => 'https://domains.dnspod.cn/main/domain_list',
                    'wd' => 'domain',
                    'method' => 'GET',
                    'btn' => '域名查询',
                    'placeholder' => 'DNSPOD出品',
                    'callback' => 'function callback(){
                                       var domain = $("#searchForm .form-input").val().split(".");
                                       $("#searchForm .form-input").val(domain[0]);
                                   };',
                ),
                'se1302' => array(
                    'name' => 'Whois',
                    'url' => 'https://domains.dnspod.cn/main/whois_query',
                    'wd' => 'domain',
                    'method' => 'GET',
                    'btn' => 'Whois查询',
                    'placeholder' => 'DNSPOD出品',
                ),
            ),
            '99' => array(
                'se9901' => array(
                    'name' => '本站特供',
                    'url' => '/pan',
                    'wd' => 'wd',
                    'method' => 'GET',
                    'btn' => '网盘搜索',
                    'placeholder' => '本站特供',
                ),
                'se9902' => array(
                    'name' => '百谷歌度',
                    'url' => 'http://baigoogledu.com/s.php',
                    'wd' => 'q',
                    'method' => 'GET',
                    'hiddens' => array(
                        'hl' => 'zh-CN',
                        'pan' => '百度网盘搜索',
                    ),
                    'btn' => '百谷歌度',
                    'placeholder' => '只能搜百度网盘',
                ),
            ),
        );
    }
}
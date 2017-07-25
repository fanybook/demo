<?php

namespace Apk\Base\Libraries\Curl;

class Curllor {

    /**
     * 采集的url
     *
     * @var array
     */
    protected $url = '';

    /**
     * 采集使用的规则列表
     *
     * @var array
     */
    protected $rules = [];

    /**
     * 规则文件所在的路径
     *
     * @var string
     */
    protected $rulePath = '';

    /**
     * 执行采集
     */
    public function run() {}

    /**
     * 执行采集
     */
    public function doCurl() {
        $ch = curl_init();

        // 设置选项
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language:zh-CN,zh", "Accept-Charset:GB2312,utf-8"));
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.getClientIp(), 'CLIENT-IP:'.getClientIp()));
        curl_setopt($ch, CURLOPT_ENCODING, "gzip"); //不开btsp就采不到
//        curl_setopt($ch, CURLOPT_PROXY, $proxy); // 设置代理服务器
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
//        curl_setopt($ch, CURLOPT_VERBOSE, true);
//        curl_setopt($ch, CURLOPT_NOBODY, true);
//        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
//        curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com.hk/');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/rules/cacert.pem');
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/rules/cookie.txt');

        $i = 0;$start = time();
        do {
            $curl_html = curl_exec($ch);
            $info = curl_getinfo($ch);
            $i++;
            $exec = time() - $start;
        } while ($exec < 2 && $info['http_code'] != 200 && $info['url'] != $this->url);

        //var_dump($info);var_dump($i);var_dump($exec);//exit();
        return $curl_html;
}

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setRulePath($path) {
    	$this->rulePath = $path;
    }

    public function getRulePath() {
        return $this->rulePath;
    }

    /**
     * 获取采集规则的方法
     *
     * @param   string  $type       要取得规则的类型
     * @param   string  $site_nm    要取得规则的站点名
     * @return  array   规则列表
     */
    public function getRules($all = FALSE)
    {
        $ruleDir = dirname(__FILE__).'/rules/';
        return $rule_arr = self::xml2arr($ruleDir.$this->rulePath);
    }

    /**
     * XML文件转成数组(使用Simplexml)
     *
     * @param   string  $xml_file   XML文件的路径
     * @return  array   转换好的数组
     */
    public static function xml2arr($xml_file)
    {
        $xmlObj = simplexml_load_file($xml_file);
        return self::_xmlObj2arr($xmlObj);
    }

    /**
     * xml2arr方法使用的递归处理
     */
    private static function _xmlObj2arr($xmlObj)
    {
        if(is_object($xmlObj)) {
            settype($xmlObj, 'Array');
        }

        if(is_array($xmlObj) && count($xmlObj) > 0) {
            foreach($xmlObj as $k => $v){
                $xmlObj[$k] = self::_xmlObj2arr($v);
            }
        }

        return $xmlObj;
    }

    /**
     * 通过给定的正则规则解析html
     *
     * @param  [HTML] $html
     * @param  array  $rule
     * @return array
     */
    public function parseHtml($html, array $rule)
    {
        // 规则分类数组
        $rule_sort = array();
        // 返回结果
        $result_list = array();

        // 对规则进行分类
        foreach($rule as $k => $v) {
            if ($k == 'feature') {
                continue;
            } elseif (preg_match ('/^\/(.+?)\/$/', $v) || preg_match ('/^\/(.+?)\/s$/', $v)) {
                $rule_sort['direct'][] = $k;
            } elseif (preg_match ('/\{\$(.+?)\}/', $v)) {
                $rule_sort['replace'][] = $k;
            }
        }

        // 先从html直接匹配所需的字符串
        if(!empty($rule_sort['direct'])) {
            foreach($rule_sort['direct'] as $v) {
                preg_match_all($rule[$v], $html, $matches);
                foreach($matches[1] as $kk => $vv) {
                    $result_list[$kk][$v] = $vv;
                }
            }
        }

        // 再根据自己所需要的进行合成
        if(!empty($rule_sort['replace'])) {
            foreach($rule_sort['replace'] as $v) {
                // 这里主要是需要chapter_arr数组的key值
                foreach($result_list as $kk => $vv) {
                    // 找到所有要替换的{$变量名}
                    preg_match_all('/\{\$(.+?)\}/', $rule[$v], $matches);
                    foreach($matches[1] as $vvv) {
                        $patterns[] = '/\{\$'.$vvv.'\}/';
                        $replacements[] = $result_list[$kk][$vvv];
                    }
                    $result_list[$kk][$v] = preg_replace($patterns, $replacements, $rule[$v]);
                    unset($patterns);
                    unset($replacements);
                }
            }
        }

        if (isset($rule['filter'])) {
            $temp_result_list = array();
            foreach ($result_list as $result) {
                if (!empty($result['filter'])) {
                    unset($result['filter']);
                    $temp_result_list[] = $result;
                }
            }
            $result_list = $temp_result_list;
        }

        return $result_list;
    }

}
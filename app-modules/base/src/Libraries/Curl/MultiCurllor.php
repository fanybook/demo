<?php
/**
 * Fanybook Core class file.
 * 
 * @author Fany Yang <fanybook@gmail.com>
 * @link http://www.fanybook.com/
 * @copyright Copyright &copy; 2010-2011 Fanybook.Com LLC
 *
 * Curl 多线程类
 * 使用方法：
 * ========================
 * $urls = array("http://baidu.com", "http://126.com", "http://google.com");
 * $cm = new Core_CurlMulti($urls, 30);
 * $cm->start();
 * ========================
 */

namespace Apk\Base\Curl;

/**
 * Curl 多线程类
 */
class Core_CurlMulti
{
    private $_urls;
    private $_timeout;
    private $_rule;
    private $_multi_rule = false;
    private $_proxy;
    private $_testspeed;

    /**
     * 构造方法
     */
    public function __construct($urls, $timeout, $rule = false, $proxy = false, $testspeed = false)
    {
        // 设置要采集的url数组
        $this->_urls = $urls;
        // 设置cURL超时时间
        $this->_timeout = $timeout;
        // 设置筛选规则(转码和特征码)
        $this->_rule = $rule;
        if ($rule && is_array(array_pop($rule)))
            $this->_multi_rule = true;
        // 设置cURL的代理
        $this->_proxy = $proxy;
        $this->_testspeed = $testspeed;
    }

    /**
     * 开始采集
     */
    public function start()
    {
        set_time_limit(0);
        ignore_user_abort(TRUE);

        if (!is_array($this->_urls))
            $this->_urls = array($this->_urls);

        // curl_handles
        $chs = array();
        // 采集结果数组
        $curl_htmls = array();
        $curl_infos = array();

        foreach ($this->_urls as $site_nm => $url)
        {
            if ($this->_testspeed)
                $chs[$site_nm] = $this->_initCHandle($url, $site_nm);  // site_nm其实是代理
            else
                $chs[$site_nm] = $this->_initCHandle($url, $this->_proxy);
        }
        // create the multiple cURL handle
        $mh = curl_multi_init();

        // add the handles
        foreach ($chs as $ch)
        {
            curl_multi_add_handle($mh, $ch);
        }

        // execute the handles
        $this->_cmExec($mh);
//        while ($done = curl_multi_info_read($mh)) {
//            $mhinfos[] = curl_getinfo($done['handle']);
//        }

        // close the handles
        foreach($this->_urls as $site_nm => $url)
        {
            if ($this->_multi_rule)
                $rule = $this->_rule[$site_nm];
            else
                $rule = $this->_rule;

            $curl_htmls[$site_nm] = curl_multi_getcontent($chs[$site_nm]);
            $curl_infos[$site_nm] = curl_getinfo($chs[$site_nm]);

            // 整理采集结果，过滤掉未完全采集和不包含特征码的结果
            if ($curl_infos[$site_nm]['http_code'] != 200)
            {
                $curl_htmls[$site_nm] = NULL;
                $curl_infos[$site_nm] = NULL;
            }
            else
            {
                // 这一步是为了防止垃圾代理，篡改DNS，性质非常恶劣
                if ($rule && !preg_match($rule['feature'], $curl_htmls[$site_nm]))
                    $curl_htmls[$site_nm] = NULL;
                else
                {
//                    if ($rule['charset'] != 'UTF-8')
//                        $curl_htmls[$site_nm] = iconv($rule['charset'], "UTF-8", $curl_htmls[$site_nm]);
                    $content_type = $curl_infos[$site_nm]['content_type'];
                    $charset = substr($content_type, strrpos($content_type, '=')+1);

                    if ($charset != 'UTF-8')
                        $curl_htmls[$site_nm] = iconv($charset, "UTF-8", $curl_htmls[$site_nm]);
                }
            }

            // 释放handle
            curl_multi_remove_handle($mh, $chs[$site_nm]);
        }
        curl_multi_close($mh);

        print_r($mhinfos);exit;

        if ($this->_testspeed)
            return array($curl_htmls, $curl_infos);
        else
            return $curl_htmls;
    }

    /**
     * 初始化cUrl handle
     */
    private function _initCHandle($url, $proxy = FALSE)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        if ($proxy) curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        return $ch;
    }

    /**
     * 执行多线程采集
     */
    private function _cmExec($mh)
    {
        // 参考PHP手册
        $active = null;

        // 3. 初始处理
        do {
            $mrc = curl_multi_exec($mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        // 4. 主循环
        while ($active && $mrc == CURLM_OK) {
            // 5. 有活动连接
            if (curl_multi_select($mh) != -1)
            {
                // 6. 干活
                do {
                    $mrc = curl_multi_exec($mh, $active);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }
    }
}
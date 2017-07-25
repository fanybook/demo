<?php

namespace Apk\Base\Curl;

/**
 * 单页面采集
 */
class SingleCurllor extends Curllor {

    /**
     * 开启监控器
     */
    public function run()
    {
		// 写入状态和时间
		if ($fp = fopen($this->state_flg, 'w'))
		{
			fwrite($fp, 'work_'.time());
			fclose($fp);
		}
		else {
			return FALSE;
		}

		// 运行无超时，忽略用户断开
        set_time_limit(0);
        ignore_user_abort(TRUE);
		register_shutdown_function(array($this, 'over'));

        // 取得采集使用的规则列表
        $this->rules = Core_Common::getRules($this->type);

//        // 采集使用的代理列表
//        $keys = require('zongheng_proxys.php');
//        $proxy_list = array_fill_keys($keys, 0);;
//        // 读取采集使用的浏览器HTTP请求头列表
//        $browser_list = require('browsers.php');

        // 读回上次停止时保存的工作状态
		$this->_readLastState();

        // 整理要采集的url
        $urls = array();
        foreach($this->rules as $site_nm => $rule) {
            $urls[$site_nm] = $rule['monitor_url'];
        }

        //************************************************************
        //          进入监控死循环，状态未变成stop前就不退出
        //************************************************************
        do {
            // 记录这次监控的开始时间
            $startTime = time();

            // 根据url的个数，设置超时时间
            $timeout = 0.2;
//            $proxy = array_rand($proxy_list);

            // 实例化CurlMulti类进行采集
            $cm = new Core_CurlMulti($urls, $timeout, $this->rules, '172.23.2.101:8080');
            $htmls_arr = $cm->start();
			unset($cm);

            // 统计采集失败的url
            $false_arr = array_keys($htmls_arr, NULL);
            if (count($false_arr) == count($urls)) {
                sleep(1);
                continue;
            }

			// 解析采集成功的html，将新章节入库
            foreach ($htmls_arr as $site_nm => $curl_html)
            {
                if (isset($false_arr[$site_nm]))
                {
                    // 采集失败时
                    continue;
                }

                // 规则解析，把采集来的html解析成所需要的章节列表
                $chapter_list = Core_Common::htmlParser($curl_html, $this->rules[$site_nm]);
                // 取得章节列表中新更新的章节，若没有返回数字，大于0时表示因站点缓存原因倒退的章节数
                $new_chapter_list = $this->_makeUpdateList($chapter_list, $site_nm);

                // 没更新继续循环，有的话进行入库
                if (!is_array($new_chapter_list))
                {
                    // 因站点缓存原因倒退的章节数或没有更新
                    sleep(2);
                    continue;
                }
                else
                {
                    // 把新的唯一码放入_chapterList，以表示监控过了
                    $new_uniques = array();
                    foreach ($new_chapter_list as $new_chapter)
                        $new_uniques[] = $new_chapter['unique'];
                    $this->_chapterList[$site_nm] = array_merge($new_uniques, $this->_chapterList[$site_nm]);
                    $this->_chapterList[$site_nm] = array_slice($this->_chapterList[$site_nm], 0, 50);

                    // 进行新章节入库
                    $this->_pushNewChapter($new_chapter_list, $site_nm);
                }

                // 检测监控器状态，状态为'stop'时及时停止监控器
                list($state) = Core_Common::getStateInfo($this->state_flg);
                if ($state == 'stop') break 2;
            }

            // 记录这次监控的结束时间
            $endTime = time();
            $exeTime = $endTime - $startTime;

Core_Common::writeLog("is OK! 本次用时 {$exeTime} 秒", $this->type .'_monitor');
			list($state) = Core_Common::getStateInfo($this->state_flg);
			if ($state == 'stop') break;

            // 根据失败的数量，决定休息时间
            if (count($false_arr) >= count($urls) / 2)
                $sleepTime = 10;
            else
                $sleepTime = 20;
            sleep($sleepTime);
        } while (TRUE);
    }

}
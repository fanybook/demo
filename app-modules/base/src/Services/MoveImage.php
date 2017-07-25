<?php

namespace Apk\Base\Services;

use Apk\Base\Facades\Storage;

class MoveImage extends \BaseService
{
    public $config = [
        'article' => ['article_body', 'thumb' => 'article_thumb'],
        'goods'   => ['goods_detail'],
    ];

    public function to($toPath, $model)
    {
        if (!isset($this->config[$toPath])) {
            return false;
        }

        foreach ($this->config[$toPath] as $filename => $col) {
            if (is_null($model->$col)) {
                continue;
            }

            $text = $model->$col;
            $new_path = sprintf('/data/%s/%d/', $toPath, $model->id);

            // 1.找出所有新上传的tmp文件
            // 2.列举旧文件，获得末尾图片idx
            // 3.生成新名字上传七牛
            // 4.用新uri替换临时uri

            // 1.找出所有新上传的tmp文件（用户上传可能多后缀或者大写后缀）
            preg_match_all('/(\/data\/tmp\/.*?\.[jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF]+)/', $text, $matches);
            $tmp_image_array = array_unique($matches[1]);

            if (count($tmp_image_array) > 0) {
                // 2.列举旧文件，获得末尾图片idx(编辑时，创建时直接置0)
                $result = Storage::lists($new_path);
                $idx = $this->getLastImageIndex($result);

                // 3.生成新名字上传七牛
                $replace_array = [];     // 用于替换
                foreach ($tmp_image_array as $tmp_image) {
                    if (!Storage::exists($tmp_image)) {
                        continue;
                    }

                    $idx++;
                    $new_image = sprintf($new_path . 'img_%d%s', $idx, strtolower(strrchr($tmp_image, '.')));

                    $result = Storage::move($tmp_image, $new_image);

                    if (!$result) {
                        // 异常处理
                        return false;
                    } else {
                        $replace_array[] = [
                            'txt' => $tmp_image,
                            'new' => $new_image,
                        ];
                    }
                }

                // 4.用新uri替换临时uri
                foreach ($replace_array as $item) {
                    $text = str_replace($item['txt'], $item['new'], $text);
                }
            }

            $model->$col  = $text;
        }

        $model->save();
    }

    protected function getLastImageIndex($itemList)
    {
        $idx_array = [];
        foreach ($itemList as $filename => $item) {
            $path_parts = pathinfo($filename);
            $temp_array = explode('_', $path_parts['filename']);
            $idx_array[] = intval(array_pop($temp_array));
        }

        return count($idx_array) ? max($idx_array) : 0;
    }
}

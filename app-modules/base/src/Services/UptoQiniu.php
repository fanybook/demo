<?php

namespace Apk\Base\Services;

use Request;

class MoveImage
{
    public function getBlogArticleList()
    {
        $now = date('Y-m-d H:i:s');
        $query = Models\Article::query();

        if (Request::has('kw')) {
            $query->whereRaw('article_title like \'%' . Request::input('kw') . '%\'');
        }

//        $articleList = Models\Article::where('article_system', 'blog')
        $article_list = $query->where('is_show', '1')
                              ->where(function($q)
                              {
                                  $q->whereNull('article_system')
                                    ->orWhere('article_system', '<>', 'page');
                              })
                              ->where('published_at', '<', $now)
                              ->where(function($query) use($now)
                              {
                                 $query->whereNull('expired_at')             // 未设置过期
                                       ->orWhere('expired_at', '>', $now);   // 或还没过期
                              })
                              ->orderBy('id', 'desc')
                              ->paginate(5);
        return $article_list;
    }

    public function getNewBlogArticle()
    {
        $now = date('Y-m-d H:i:s');
//        $articleList = Models\Article::where('article_system', 'blog')
        $articleList = Models\Article::where('is_show', '1')
                                     ->where('published_at', '<', $now)
                                     ->where(function($query) use($now)
                                     {
                                        $query->whereNull('expired_at')             // 未设置过期
                                              ->orWhere('expired_at', '>', $now);   // 或还没过期
                                     })
                                     ->orderBy('id', 'desc')
                                     ->limit(10)
                                     ->get();
        return $articleList;
    }

    public function getNewsList()
    {
        $articleList = Models\Article::where('is_show', '1')
                                     ->where('article_system', 'news')
                                     ->orderBy('id', 'desc')
                                     ->limit(10)
                                     ->get();
        return $articleList;
    }

    public function getNewsArticleList()
    {
        $articleList = Models\Article::where('is_show', '1')
                                     ->where('article_system', 'news')
                                     ->orderBy('id', 'desc')
                                     ->paginate(5);
        return $articleList;
    }
}

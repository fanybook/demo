<?php

// 网站首页
Route::get('/',                             'Shop\HomeController@getIndex');

Route::get('/common/test',                  'Common\ImageController@getTest');
Route::post('/common/image/upload',         'Common\ImageController@postUpload');

Route::group(['prefix' => 'user'], function() {
    Route::get('/',                         'User\HomeController@getIndex');
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin.auth'], function() {
    Route::get('/',                         'Admin\HomeController@getIndex');
    Route::get('/setting',                  'Admin\SiteSettingController@getIndex');
    Route::post('/setting',                 'Admin\SiteSettingController@postIndex');

    Route::get('/feedback',                 'Admin\FeedbackController@getIndex');
});

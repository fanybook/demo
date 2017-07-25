<?php

// 网站首页
//Route::get('/',                             'Shop\HomeController@getIndex');
//
//Route::get('/common/test',                  'Common\ImageController@getTest');
//Route::post('/common/image/upload',         'Common\ImageController@postUpload');
//
//Route::group(['prefix' => 'user'], function() {
//    Route::get('/',                         'User\HomeController@getIndex');
//});
//
Route::group([
    'namespace'  => 'Modules\Base\Controllers\Admin',
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', 'admin']
], function() {
    Route::resource('site-setting', 'SiteSettingCrudController');

//    Route::get('/feedback',                 'Admin\FeedbackController@getIndex');
});

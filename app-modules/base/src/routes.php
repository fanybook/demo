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
Route::group(['prefix' => config('backpack.base.route_prefix', 'admin'), 'middleware' => 'admin'], function() {
    Route::resource('site-setting', 'Admin\SiteSettingCrudController');

//    Route::get('/feedback',                 'Admin\FeedbackController@getIndex');
});

// 身份认证（登录，注册，密码找回，重置）
Route::group(['prefix' => config('const.auth_prefix', '')], function () {
    Route::get('/login',            'User\AuthController@login')->name('user.auth.login');
    Route::post('/login',           'User\AuthController@postLogin')->name('user.auth.login.post');
    Route::get('/register',         'User\AuthController@register')->name('user.auth.register');
    Route::post('/register',        'User\AuthController@postRegister')->name('user.auth.register.post');
    Route::get('/logout',           'User\AuthController@logout')->name('user.auth.logout');

    Route::get('/find-password',    'User\AuthController@findPassword')->name('user.auth.find_password');
    Route::post('/find-password',   'User\AuthController@postFindPassword')->name('user.auth.find_password.post');
});

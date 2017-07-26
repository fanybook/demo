<?php

Route::post('/captcha/get',     'Common\CaptchaController@apiGet');

Route::group(['prefix' => config('backpack.base.route_prefix', 'admin')], function() {
    Route::get('/login',            'Admin\AuthController@login');
    Route::post('/login',           'Admin\AuthController@postLogin');
    Route::get('/logout',           'Admin\AuthController@logout');

    Route::group(['middleware' => 'admin'], function() {
        Route::resource('site-setting', 'Admin\SiteSettingCrudController');

    //    Route::get('/feedback',                 'Admin\FeedbackController@getIndex');
    });
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

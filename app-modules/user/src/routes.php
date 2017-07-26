<?php

Route::group(['prefix' => 'user'], function() {
    Route::get('/',             'User\HomeController@index')->name('user.home');
});

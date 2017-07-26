<?php

Route::group(['prefix' => 'srch'], function() {
    Route::get('/',             'Front\HomeController@getIndex')->name('srch.home');
});

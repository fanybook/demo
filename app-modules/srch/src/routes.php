<?php

Route::group(['prefix' => 'srch'], function() {
    Route::get('/',             'Front\HomeController@index')->name('srch.homepage');
    Route::get('/se/{id}',      'Front\SeController@show')->name('srch.se.show');
});

Route::group(['prefix' => 'user/srch', 'middleware' => 'auth'], function() {
    Route::get('/',             'User\HomeController@index')->name('user::srch.homepage');
//    Route::get('/se',           'User\SeController@show')->name('user::srch.se.show');

    Route::get('/se',                     'User\SeController@index')->name('user::srch.se.index');
    Route::get('/se/add',                 'User\SeController@add')->name('user::srch.se.add');
    Route::get('/se/{id}/edit',           'User\SeController@edit')->name('user::srch.se.edit');
    Route::post('/se/add',                'User\SeController@postAdd');
    Route::post('/se/{id}/edit',          'User\SeController@postEdit');

    Route::post('/se-item/add',           'User\SeItemController@postAdd');
    Route::post('/se-item/{id}/edit',     'User\SeItemController@postEdit');
    Route::post('/se-item/detail',        'User\SeItemController@apiDetail');
    Route::post('/se-item/delete',        'User\SeItemController@apiDelete');


    Route::resource('sbox',     'User\SeController');
});

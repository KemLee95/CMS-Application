<?php

Route::group([
    'prefix'=> 'auth',
    'namespace'=> 'App\Http\Controllers\client'
],function() {

    Route::get('/', 'LoginController@index');
    Route::get('/register','RegisterController@index');
    Route::get('/logout', 'LoginController@logout');
    
    Route::post('/login', 'LoginController@login');
    Route::post('/save', 'RegisterController@register');

    Route::group([
        'prefix'=> 'view'
    ], function() {

        Route::post('/check-unique-user', 'RegisterController@checkUniqueUser');
    });
});
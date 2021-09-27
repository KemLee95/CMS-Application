<?php

Route::group([
    'prefix'=> 'auth',
    'namespace'=> 'App\Http\Controllers\client'
],function() {

    Route::get('/login', 'LoginController@index');
    Route::get('/register','RegisterController@create');

    Route::post('/save', 'RegisterController@store');
});
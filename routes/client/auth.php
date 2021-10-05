<?php

Route::group([
    'prefix'=> 'auth',
    'namespace'=> 'App\Http\Controllers\Auth'
],function() {

    Route::get('/', 'LoginController@index');
    Route::get('/register','RegisterController@index');
    Route::get('/logout', 'LoginController@logout');
    
    Route::post('/login', 'LoginController@login');
    Route::post('/save', 'RegisterController@save');

    Route::group([
        "middleware" => "app.auth"
    ], function(){
        Route::get("/personal-info", 'PersonalInfoController@update');
        Route::get("/verify-email", 'PersonalInfoController@verify');
        Route::post("/personal-info/save-user", 'PersonalInfoController@save');
    });
    
    Route::group([
        'prefix'=> 'view'
    ], function() {

        Route::post('/check-unique-user', 'RegisterController@checkUniqueUser');
    });
});
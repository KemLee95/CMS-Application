<?php

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix'=> "v1"
], function(){
    Route::group([
        'prefix'=> 'auth',
        'namespace' => 'App\Http\Controllers\api'
    ], function(){    
        Route::group([
            'prefix'=> 'post'
        ], function() {
    
            Route::post('login', 'UserController@login');
            Route::post('register', 'UserController@login');
        });
        Route::group([
            'prefix'=>'delete'
        ], function() {
            Route::delete('logout', 'UserController@logout');
        });
    });
});
<?php

Route::group([
  'prefix'=> 'admin',
  'middleware'=> [ 'admin.auth'],
  'namespace'=> 'App\Http\Controllers\admin'
],function() {
  
  Route::get("/", 'AdminHomeController@index');

  Route::get("/post/{id}", 'PostController@update');

  Route::post('/post/save-post', 'PostController@save');
  Route::post('/post/delete-post', 'PostController@delete');

  Route::get("/account", 'AccountController@index');
  Route::get("/account/{id}", 'AccountController@index');
  Route::post("/save-account", 'AccountController@index');
  Route::post("/delete-account", 'AccountController@index');


  
  Route::group([
    'prefix'=> 'view'
  ], function() {

    Route::post('/save-new-account', 'AdminController@saveNewAccount');
  });
});
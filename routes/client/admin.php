<?php

Route::group([
  'prefix'=> 'admin',
  'middleware'=> [ 'admin.auth'],
  'namespace'=> 'App\Http\Controllers\admin'
],function() {
  
  Route::get("/", 'AdminHomeController@index');

  Route::get("/post/{id}", [App\Http\Controllers\PostController::class, 'update']);

  Route::post('/post/save-post', [App\Http\Controllers\PostController::class, 'save']);
  Route::post('/post/delete-post', [App\Http\Controllers\PostController::class, 'delete']);

  Route::get("/account", 'AccountController@index');
  Route::get("/account/{id}", 'AccountController@update');
  Route::post("/save-account", 'AccountController@save');
  Route::post("/delete-account", 'AccountController@delete');
  
  Route::group([
    'prefix'=> 'view'
  ], function() {

    Route::post('/save-new-account', 'AdminController@saveNewAccount');
  });
});
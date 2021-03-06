<?php

Route::group([
  'prefix'=> 'admin',
  'middleware'=> [ 'admin.auth'],
  'namespace'=> 'App\Http\Controllers\Admin'
],function() {
  
  Route::get("/", 'AdminHomeController@index');

  Route::get("/post/{id}", [App\Http\Controllers\Home\PostController::class, 'update']);

  Route::post('/post/save-post', [App\Http\Controllers\Home\PostController::class, 'save']);
  Route::post('/post/delete-post', [App\Http\Controllers\Home\PostController::class, 'delete']);

  Route::get("/account", 'AccountController@index');
  Route::get("/account/{id}", 'AccountController@update');
  Route::post("/save-account", 'AccountController@save');
  Route::post("/delete-account", 'AccountController@delete');
  
  Route::get("/event", 'EventController@index');
  Route::get("/event/{id}", 'EventController@update');
  Route::get('/get-voucher-partial', 'EventController@partial');
  Route::post('/save-event', 'EventController@save');

  Route::get('/voucher/{id}', 'VoucherController@view');

  Route::group([
    'prefix'=> 'view'
  ], function() {

    Route::post('/save-new-account', 'AdminController@saveNewAccount');
    
  });
});
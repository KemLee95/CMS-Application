<?php

Route::group([
  'prefix'=> 'admin',
  'middleware'=> [ 'admin.auth'],
  'namespace'=> 'App\Http\Controllers\admin'
],function() {
  
  Route::get("/", 'AdminController@index');
  Route::get("/register", 'AdminController@register');

  Route::group([
      'prefix'=> 'view'
  ], function() {
    Route::post('save', 'AdminController@save');
  });
});
<?php
Route::group([
  'prefix'=> 'home',
  'middleware' => 'app.auth',
  'namespace'=> 'App\Http\Controllers\client'
],function() {

  Route::get("/", 'HomeController@index');
  Route::get("something", 'HomeController@something');
});
<?php
Route::group([
  'middleware' => 'app.auth',
  'namespace'=> 'App\Http\Controllers\client'
],function() {
  Route::get("/", function() {
    return "Hello world";
  });
});
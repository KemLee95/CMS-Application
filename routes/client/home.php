<?php



Route::group([
  'prefix'=> 'home',
  'namespace'=> 'App\Http\Controllers\Home'
],function() {

  Route::get("/", 'HomeController@index');
  Route::get("/post/{id}", 'PostController@update');

  Route::group([
    'middleware' =>['app.auth']
  ], function() {
    Route::get('/reader-tracking', 'PostController@track');
    Route::post('/post/save-post', 'PostController@save');
    Route::post('/post/delete-post', 'PostController@delete');
  });
});
<?php




Route::group([
  'prefix'=> 'home',
  'namespace'=> 'App\Http\Controllers\client'
],function() {

  Route::get("/", 'HomeController@index');
  Route::get("/post/{id}", [App\Http\Controllers\PostController::class, 'update']);

  Route::group([
    'middleware' =>['app.auth']
  ], function() {
    Route::get('/reader-tracking', [App\Http\Controllers\PostController::class, 'track']);

    Route::post('/post/save-post', [App\Http\Controllers\PostController::class, 'save']);
    Route::post('/post/delete-post', [App\Http\Controllers\PostController::class, 'delete']);
  });
});
<?php
Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'panel'], function () {
        Route::get('/', function () {
            return view('panel');
        });
        //Route::group(['prefix' => 'users'], function () {
            //Route::get('get', 'Admin\UserController@get');
        //});
    });
});

Route::get('/home', 'HomeController@index')->name('home');

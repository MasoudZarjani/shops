<?php
Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();
Route::group(['prefix' => 'panel'], function () {
    Route::get('/', function () {
        return view('panel');
    });
    Route::group(['prefix' => 'user'], function () {
        Route::post('index', 'Admin\UserController@index');
        Route::post('order', 'Admin\UserController@order');
        Route::post('filter', 'Admin\UserController@filter');
        Route::delete('delete/{id}', 'Admin\UserController@delete');
        Route::put('update', 'Admin\UserController@update');
        Route::post('create', 'Admin\UserController@create');
        Route::get('changeState/{id}', 'Admin\UserController@changeState');
    });

    Route::group(['prefix' => 'category'], function () {
        Route::post('index', 'Admin\CategoryController@index');
        Route::delete('delete/{id}', 'Admin\CategoryController@delete');
        Route::put('update', 'Admin\CategoryController@update');
        Route::post('create/{id_parent}', 'Admin\CategoryController@create');

        Route::post('order', 'Admin\CategoryController@order');
    });
});
Route::middleware(['auth'])->group(function () {
   
});

Route::get('/home', 'HomeController@index')->name('home');

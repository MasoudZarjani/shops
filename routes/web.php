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

        Route::group(['prefix' => 'user'], function () {
            Route::post('index', 'Admin\UserController@index');
            Route::post('order', 'Admin\UserController@order');
            Route::post('filter', 'Admin\UserController@filter');
            Route::delete('delete/{id}', 'Admin\UserController@delete');
            Route::put('update', 'Admin\UserController@update');
            Route::post('create', 'Admin\UserController@create');
            Route::get('changeState/{id}', 'Admin\UserController@changeState');
            Route::get('detail/{id}', 'Admin\UserController@detail');
        });

        Route::group(['prefix' => 'category'], function () {
            Route::post('index', 'Admin\CategoryController@index');
            Route::put('update', 'Admin\CategoryController@update');
            Route::post('filter', 'Admin\CategoryController@filter');
            Route::post('order', 'Admin\CategoryController@order');
            Route::get('changeState/{id}', 'Admin\CategoryController@changeState');
        });

        Route::group(['prefix' => 'setting'], function () {
            Route::post('index', 'Admin\SettingController@index');
            Route::delete('delete/{id}', 'Admin\SettingController@delete');
            Route::put('update', 'Admin\SettingController@update');
            Route::post('create', 'Admin\SettingController@create');
            Route::post('order', 'Admin\SettingController@order');
        });

        Route::group(['prefix' => 'color'], function () {
            Route::post('index', 'Admin\ColorController@index');
            Route::put('update', 'Admin\ColorController@update');
        });
    });
});
Route::get('/home', 'HomeController@index')->name('home');

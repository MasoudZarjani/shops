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

            Route::get('getSpecifications/{id}', 'Admin\CategoryController@getSpecifications');
            Route::post('createSpecification', 'Admin\CategoryController@createSpecification');
            Route::put('updateSpecification', 'Admin\CategoryController@updateSpecification');
            Route::delete('deleteSpecification/{id}', 'Admin\CategoryController@deleteSpecification');

            Route::get('getComments/{id}', 'Admin\CategoryController@getComments');
            Route::post('createComment', 'Admin\CategoryController@createComment');
            Route::put('updateComment', 'Admin\CategoryController@updateComment');
            Route::delete('deleteComment/{id}', 'Admin\CategoryController@deleteComment');

        });

        Route::group(['prefix' => 'setting'], function () {
            Route::post('index', 'Admin\SettingController@index');
            Route::post('order', 'Admin\SettingController@order');
            Route::put('update', 'Admin\SettingController@update');
            // Route::post('create', 'Admin\SettingController@create');
            // Route::delete('delete/{id}', 'Admin\SettingController@delete');
            Route::post('indexComment', 'Admin\SettingController@indexComment');
            //Route::post('orderComment', 'Admin\SettingController@orderComment');
        });

        Route::group(['prefix' => 'color'], function () {
            Route::post('index', 'Admin\ColorController@index');
            Route::put('update', 'Admin\ColorController@update');
        });

        Route::group(['prefix' => 'comment'], function () {
            Route::post('index', 'Admin\MessageController@indexComment');
            Route::post('order', 'Admin\MessageController@orderComment');
            Route::post('filter', 'Admin\MessageController@filterComment');
            Route::get('changeState/{id}', 'Admin\MessageController@changeStateComment');
            Route::get('detail/{id}', 'Admin\MessageController@detailComment');
        });

        Route::group(['prefix' => 'discuss'], function () {
            Route::post('index', 'Admin\MessageController@indexDiscuss');
            Route::post('order', 'Admin\MessageController@orderDiscuss');
            Route::post('filter', 'Admin\MessageController@filterDiscuss');
            Route::get('changeState/{id}', 'Admin\MessageController@changeStateDiscuss');
            Route::put('update', 'Admin\MessageController@updateDiscuss');
        });
    });
});
Route::get('/home', 'HomeController@index')->name('home');

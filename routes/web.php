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

        Route::group(['prefix' => 'product'], function () {
            Route::post('index', 'Admin\ProductController@index');
            Route::post('order', 'Admin\ProductController@order');
            Route::post('filter', 'Admin\ProductController@filter');
            Route::delete('delete/{id}', 'Admin\ProductController@delete');
            Route::put('updateDetail', 'Admin\ProductController@updateDetail');
            Route::post('create', 'Admin\ProductController@create');
            Route::get('changeState/{id}', 'Admin\ProductController@changeState');
            Route::get('detail/{id}', 'Admin\ProductController@detail');

            Route::post('uploadMultiImages', 'Admin\ProductController@uploadMultiImages');
            Route::get('removeImage/{id}', 'Admin\ProductController@removeImage');
        });

        Route::group(['prefix' => 'category'], function () {
            Route::post('index', 'Admin\CategoryController@index');
            Route::post('create', 'Admin\CategoryController@create');
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
            Route::delete('delete/{id}', 'Admin\MessageController@delete');
        });

        Route::group(['prefix' => 'brand'], function () {
            Route::post('index', 'Admin\BrandController@index');
            Route::post('create', 'Admin\BrandController@create');
            Route::put('update', 'Admin\BrandController@update');
            Route::post('filter', 'Admin\BrandController@filter');
            Route::post('order', 'Admin\BrandController@order');
            Route::get('changeState/{id}', 'Admin\BrandController@changeState');
            Route::delete('delete/{id}', 'Admin\BrandController@delete');
        });

        Route::group(['prefix' => 'seller'], function () {
            Route::post('index', 'Admin\SellerController@index');
            Route::post('create', 'Admin\SellerController@create');
            Route::put('update', 'Admin\SellerController@update');
            Route::post('filter', 'Admin\SellerController@filter');
            Route::post('order', 'Admin\SellerController@order');
            Route::get('changeState/{id}', 'Admin\SellerController@changeState');
            Route::delete('delete/{id}', 'Admin\SellerController@delete');
        });

        Route::group(['prefix' => 'warranty'], function () {
            Route::post('index', 'Admin\WarrantyController@index');
            Route::post('create', 'Admin\WarrantyController@create');
            Route::put('update', 'Admin\WarrantyController@update');
            Route::post('filter', 'Admin\WarrantyController@filter');
            Route::post('order', 'Admin\WarrantyController@order');
            Route::get('changeState/{id}', 'Admin\WarrantyController@changeState');
            Route::delete('delete/{id}', 'Admin\WarrantyController@delete');
        });
    });
});
Route::get('/home', 'HomeController@index')->name('home');

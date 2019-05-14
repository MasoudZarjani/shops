<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::post('index', 'Api\v1\HomeController@index');

    Route::group(['prefix' => 'product'], function () {
        Route::post('detail', 'Api\v1\ProductController@detail');
        Route::post('specification', 'Api\v1\ProductController@specification');
    });
    
    Route::group(['prefix' => 'user'], function () {
        Route::post('store_number', 'Api\v1\UserController@storeNumber');
        Route::post('check_code', 'Api\v1\UserController@checkCode');
    });


    Route::group(['prefix' => 'category'], function () {
        Route::post('list', 'Api\v1\CategoryController@list');
        Route::post('detail', 'Api\v1\CategoryController@detail');
    });

    Route::get('errors', 'Api\v1\HomeController@handleErrors')->name('api-errors');

    Route::group(['prefix' => 'message'], function () {
        Route::post('list', 'Api\v1\MessageController@list');
    });

    Route::middleware('auth:api')->group(function () {
        Route::group(['prefix' => 'product'], function () {
            Route::post('bookmark', 'Api\v1\ProductController@bookmark');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::post('upload', 'Api\v1\UserController@upload');
            Route::post('delete_image', 'Api\v1\UserController@deleteImage');
            Route::post('show', 'Api\v1\UserController@show');
            Route::post('update', 'Api\v1\UserController@update');
            Route::post('set_address', 'Api\v1\UserController@setAddress');
        });

        Route::group(['prefix' => 'message'], function () {
            Route::post('create', 'Api\v1\MessageController@create');
            Route::post('question', 'Api\v1\MessageController@question');
            Route::post('like', 'Api\v1\MessageController@like');
        });
    });
});

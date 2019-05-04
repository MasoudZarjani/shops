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
    });
    Route::group(['prefix' => 'category'], function () {
        Route::post('parent', 'Api\v1\CategoryController@parent');
        Route::post('detail', 'Api\v1\CategoryController@detail');
    });
    Route::get('errors', 'Api\v1\HomeController@handleErrors')->name('api-errors');
    Route::middleware('auth:api')->group(function () { });
});

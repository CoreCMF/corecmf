<?php

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
Route::group(['prefix' => 'api', 'middleware' => 'api', 'namespace' => 'CoreCMF\corecmf\Controllers\Api', 'as' => 'api.'], function () {
    /*
    |--------------------------------------------------------------------------
    | corecmf主路由设置 routes
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'install', 'as' => 'install.'], function () {
        Route::post('main', [ 'as' => 'main', 'uses' => 'InstallController@index']);
    });
});

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
Route::group(['prefix' => 'api', 'middleware' => 'api', 'namespace' => 'CoreCMF\Corecmf\App\Http\Controllers\Api', 'as' => 'api.'], function () {
    /*
    |--------------------------------------------------------------------------
    | corecmf主路由设置 routes
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'corecmf', 'as' => 'corecmf.'], function () {
        Route::post('main', [ 'as' => 'main', 'uses' => 'MainController@index']);
    });
    Route::group(['prefix' => 'install', 'as' => 'install.'], function () {
        Route::post('/', [ 'as' => 'index', 'uses' => 'InstallController@index']);
    });
});

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
|--------------------------------------------------------------------------
| corecmf路由设置 routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('install');
});
Route::group(['prefix' => 'install', 'middleware' => 'web', 'as' => 'install'], function () {
    Route::get('/{vue_capture?}', function () {
        return view('core::index', [ 'model' => 'corecmf' ]);
    })->where('vue_capture', '[\/\w\.-]*');
});

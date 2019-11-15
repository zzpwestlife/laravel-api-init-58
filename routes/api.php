<?php

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Route;

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

Route::namespace('Api')->prefix('v1')->middleware('cors')->group(function () {
    // 有绑定模型的路由，同路径的路由需要放在没绑定路由的后面！！！还可以用上路由提供的正则表达式来很好解决这个问题
    Route::post('/users', 'UserController@store')->name('users.store');
    Route::post('/login', 'UserController@login')->name('users.login');
    Route::middleware('api.refresh')->group(function () {
        Route::get('/users', 'UserController@index')->name('users.index');
        Route::post('/logout', 'UserController@logout')->name('users.logout');
        Route::get('/users/info', 'UserController@info')->name('users.info');
        Route::get('/users/{user}', 'UserController@show')->where('user', '[0-9]+')->name('users.show');
    });
});
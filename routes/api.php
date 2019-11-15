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
    Route::middleware('api.guard')->group(function () {
        Route::post('/users', 'UserController@store')->name('users.store');
        Route::post('/login', 'UserController@login')->name('users.login');
        Route::middleware('api.refresh')->group(function () {
            Route::get('/users', 'UserController@index')->name('users.index');
            Route::post('/logout', 'UserController@logout')->name('users.logout');
            Route::get('/users/info', 'UserController@info')->name('users.info');
            Route::get('/users/{user}', 'UserController@show')->where('user', '[0-9]+')->name('users.show');
        });
    });

    Route::middleware('admin.guard')->group(function () {
        // 管理员注册
        Route::post('/admins', 'AdminController@store')->name('admins.store');
        // 管理员登录
        Route::post('/admin/login', 'AdminController@login')->name('admins.login');
        Route::middleware('admin.refresh')->group(function () {
            // 当前管理员信息
            Route::get('/admins/info', 'AdminController@info')->name('admins.info');
            // 管理员列表
            Route::get('/admins', 'AdminController@index')->name('admins.index');
            // 管理员信息
            Route::get('/admins/{admin}', 'AdminController@show')->where('admin', '[0-9]+')->name('admins.show');
            // 管理员退出
            Route::get('/admins/logout', 'AdminController@logout')->name('admins.logout');
        });
    });
});
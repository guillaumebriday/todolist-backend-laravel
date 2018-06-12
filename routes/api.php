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


Route::prefix('v1')->namespace('V1')->group(function () {
    Route::middleware('guest:api')->prefix('auth')->namespace('Auth')->group(function () {
        Route::post('register', 'RegisterController@register');
        Route::post('login', 'AuthController@login');
    });

    Route::middleware('auth:api')->group(function () {
        Route::prefix('auth')->namespace('Auth')->group(function () {
            Route::delete('logout', 'AuthController@logout');
            Route::post('refresh', 'AuthController@refresh');
            Route::get('me', 'AuthController@me');
        });

        Route::ApiResource('users', 'UsersController')->only(['update', 'destroy'])->middleware('can:manage,user');
        Route::ApiResource('tasks', 'TasksController');
        Route::delete('tasks', 'TasksController@deleteCompletedTasks');
    });
});

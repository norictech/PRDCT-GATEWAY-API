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

Route::group(['prefix' => 'user'], function () {
    Route::post('register', 'Auth\RegisterController@register')->name('user.register');
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::resource('option', 'OptionController');

    Route::resource('user', 'UserController');
    Route::group(['prefix' => 'user'], function () {
        Route::post('advanced', 'UserController@advanced')->name('user.index.advanced');
        Route::post('mass_destroy', 'UserController@mass_destroy')->name('user.destroy.mass');
    });

    Route::resource('role', 'RoleController');
    Route::group(['prefix' => 'role'], function () {
        Route::post('advanced', 'RoleController@advanced')->name('role.index.advanced');
        Route::post('mass_destroy', 'RoleController@mass_destroy')->name('role.destroy.mass');
        Route::get('{id}/members', 'RoleController@members')->name('role.members');
    });

    Route::resource('access', 'AccessController');
});

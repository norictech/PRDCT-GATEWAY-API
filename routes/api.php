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

Route::post('auth/in', 'Auth\LoginController@login')->name('user.login');

Route::group(['prefix' => 'user'], function () {
    Route::post('register', 'Auth\RegisterController@register')->name('user.register');
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('me', 'UserController@me');

    Route::resource('option', 'OptionController');
    Route::group(['prefix' => 'option'], function () {
        Route::post('advanced', 'OptionController@index')->name('option.index.advanced');
        Route::post('mass_destroy', 'OptionController@mass_destroy')->name('option.destroy.mass');
    });

    Route::resource('application', 'ApplicationController');
    Route::group(['prefix' => 'application'], function () {
        Route::post('advanced', 'ApplicationController@index')->name('application.index.advanced');
        Route::post('mass_destroy', 'ApplicationController@mass_destroy')->name('application.destroy.mass');
    });

    Route::resource('package', 'PackageController');
    Route::group(['prefix' => 'package'], function () {
        Route::post('advanced', 'PackageController@index')->name('package.index.advanced');
        Route::post('mass_destroy', 'PackageController@mass_destroy')->name('package.destroy.mass');
    });

    Route::resource('group', 'GroupController');
    Route::group(['prefix' => 'group'], function () {
        Route::post('advanced', 'GroupController@index')->name('group.index.advanced');
        Route::post('mass_destroy', 'GroupController@mass_destroy')->name('group.destroy.mass');
    });

    Route::resource('user', 'UserController');
    Route::group(['prefix' => 'user'], function () {
        Route::post('advanced', 'UserController@index')->name('user.index.advanced');
        Route::post('mass_destroy', 'UserController@mass_destroy')->name('user.destroy.mass');
    });

    Route::resource('role', 'RoleController');
    Route::group(['prefix' => 'role'], function () {
        Route::post('advanced', 'RoleController@index')->name('role.index.advanced');
        Route::post('mass_destroy', 'RoleController@mass_destroy')->name('role.destroy.mass');
        Route::get('{id}/members', 'RoleController@members')->name('role.members');
    });

    Route::resource('access', 'AccessController');
});

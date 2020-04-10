<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// prefix: auth
Route::group(['prefix' => 'auth'], function () {
    Route::post('in', 'Auth\LoginController@login')->name('auth.login');
    Route::get('token/{id}', 'Auth\AuthController@token')->name('auth.token');
    Route::post('token_lifetime_check', 'Auth\AuthController@tokenLifetimeCheck')->name('auth.token.lifetime_check');
});

// prefix: user
Route::group(['prefix' => 'user'], function () {
    Route::post('register', 'Auth\RegisterController@register')->name('user.register');
});

// middleware: auth:api
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('me', 'UserController@me');

    // resource: option
    Route::resource('option', 'OptionController');
    Route::group(['prefix' => 'option'], function () {
        Route::post('advanced', 'OptionController@index')->name('option.index.advanced');
        Route::post('mass_destroy', 'OptionController@mass_destroy')->name('option.destroy.mass');
    });

    // resource: application
    Route::resource('application', 'ApplicationController');
    Route::group(['prefix' => 'application'], function () {
        Route::post('advanced', 'ApplicationController@index')->name('application.index.advanced');
        Route::post('mass_destroy', 'ApplicationController@mass_destroy')->name('application.destroy.mass');
    });

    // resource: package
    Route::resource('package', 'PackageController');
    Route::group(['prefix' => 'package'], function () {
        Route::post('advanced', 'PackageController@index')->name('package.index.advanced');
        Route::post('mass_destroy', 'PackageController@mass_destroy')->name('package.destroy.mass');
    });

    // resource: group
    Route::resource('group', 'GroupController');
    Route::group(['prefix' => 'group'], function () {
        Route::post('advanced', 'GroupController@index')->name('group.index.advanced');
        Route::post('mass_destroy', 'GroupController@mass_destroy')->name('group.destroy.mass');
    });

    // resource: user
    Route::resource('user', 'UserController');
    Route::group(['prefix' => 'user'], function () {
        Route::post('advanced', 'UserController@index')->name('user.index.advanced');
        Route::post('mass_destroy', 'UserController@mass_destroy')->name('user.destroy.mass');
    });

    // resource: role
    Route::resource('role', 'RoleController');
    Route::group(['prefix' => 'role'], function () {
        Route::post('advanced', 'RoleController@index')->name('role.index.advanced');
        Route::post('mass_destroy', 'RoleController@mass_destroy')->name('role.destroy.mass');
        Route::get('{id}/members', 'RoleController@members')->name('role.members');
    });

    // resource: access
    Route::resource('access', 'AccessController');
});

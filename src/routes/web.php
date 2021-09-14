<?php

use \Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'api/v1', 'namespace' => 'Sitic\Auth\Http\Controllers\V1'], function () {
    /* Auth */
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::post('/logout', 'AuthController@logout');

    /* User Password Reset */
    Route::post('/password/code', 'UserPasswordResetController@code');
    Route::post('/password/change', 'UserPasswordResetController@change');
});

Route::group(['prefix' => 'api/v1', 'namespace' => 'Sitic\Auth\Http\Controllers\V1', 'middleware' => 'auth'], function () {
    /* Users */
    Route::post('/users', 'UserController@store');
    Route::get('/users', 'UserController@index');
    Route::get('/users/{id}', 'UserController@show');
    Route::put('/users/{id}', 'UserController@update');
    Route::delete('/users/{id}', 'UserController@destroy');
    Route::post('/users/{id}/restore', 'UserController@restore');
    Route::post('/users/{id}/forceDelete', 'UserController@forceDelete');
});


Route::get('/test', function () {
    return new \Sitic\Auth\Mail\UserPasswordReset\ResetCodeMail();
});

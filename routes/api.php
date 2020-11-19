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

Route::group(['prefix' => 'auth'], function (){
    Route::post('login', 'Auth\AuthController@login');
    Route::post('logout', 'Auth\AuthController@logout');
    Route::get('me', 'Auth\AuthController@me');
});

Route::group(['middleware' => 'auth:api'], function (){
    Route::group(['prefix' => 'user'], function (){
        Route::post('/', 'UserController@store');
        Route::get('/', 'UserController@index');
        Route::patch('/', 'UserController@update');
        Route::delete('/', 'UserController@destroy');
        Route::get('/{id}', 'UserController@show')->where('id', '[0-9]+');
    });

    Route::group(['prefix' => 'post'], function (){
        Route::post('/', 'PostController@store');
        Route::get('/', 'PostController@index');
        Route::patch('/', 'PostController@update');
        Route::delete('/', 'PostController@destroy');
        Route::get('/{id}', 'PostController@show')->where('id', '[0-9]+');
    });
});
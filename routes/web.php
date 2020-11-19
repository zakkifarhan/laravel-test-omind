<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {    
    return view('login');
});

Route::get('/login', function () {
    return view('login');
});

Route::group(['prefix' => 'users'], function (){
    Route::view('/', 'users.index');
    Route::view('/add', 'users.form')->name('add_user');
    Route::view('/{id}/edit', 'users.form');
    Route::view('/{id}', 'users.detail');
});

Route::group(['prefix' => 'posts'], function (){
    Route::view('/', 'posts.index');
    Route::view('/add', 'posts.form')->name('add_post');
    Route::view('/{id}/edit', 'posts.form');
});

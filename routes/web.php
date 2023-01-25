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


Route::view('/', 'welcome');

Route::controller('Room')
->prefix('rooms')
->name('rooms')
->middleware('auth')
->group(function(){

    Route::get('/create', 'create')->name('.create');

});

Route::controller('Login')->prefix('login')->name('login')->group(function(){
    Route::get('/', 'index');
    Route::post('/', 'store')->name('.store');
});

Route::controller('Signup')->prefix('signup')->name('signup')->group(function(){
    Route::get('/','index');
    Route::post('/', 'store')->name('.store');
});



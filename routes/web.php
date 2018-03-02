<?php

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
    // return view('dashboard.index');
    return redirect()->route('tokens.index');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::resource('tokens', 'TokenController');
Route::post('tokens/create/stage/{token}', 'TokenController@createStage')->name('tokens.createStage');

Route::get('users/buy/{token}', 'UserController@buyToken')->name('users.buy');
Route::post('users/send/ether', 'UserController@sendEther')->name('users.sendEther');
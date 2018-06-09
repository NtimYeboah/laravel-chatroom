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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'room', 'as' => 'room.', 'middleware' => ['auth']], function () {
    Route::get('index', ['as' => 'index', 'uses' => 'RoomController@index']);
    Route::get('create', ['as' => 'create', 'uses' => 'RoomController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'RoomController@store']);
});
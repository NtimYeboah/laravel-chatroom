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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'rooms', 'as' => 'rooms.', 'middleware' => ['auth']], function () {
    Route::get('', ['as' => 'index', 'uses' => 'RoomsController@index']);
    Route::get('create', ['as' => 'create', 'uses' => 'RoomsController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'RoomsController@store']);
    Route::get('{room}', ['as' => 'show', 'uses' => 'RoomsController@show']);
    Route::post('{room}/join', ['as' => 'join', 'uses' => 'RoomsController@join']);
});

Route::post('messages/store/{room}', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
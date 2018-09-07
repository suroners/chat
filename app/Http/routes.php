<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/dashboard', 'DashboardController@index');
Route::get('/createChat', 'ChatController@createChat');
Route::get('/chat/{slug}', 'ChatController@chat');
Route::get('/socketChat/{slug}', 'ChatController@socketChat');

Route::post('/addChat', 'ChatController@addChat');
Route::post('/addSms', 'SmsController@addSms');
Route::any('/getNewest', 'SmsController@getNewest');

// it for socket
Route::any('/runServer', 'ServerController@runServer');

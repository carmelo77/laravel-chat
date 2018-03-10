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

Route::middleware(['web'])->group(function (){
	Route::get('/', 'HomeController@index');

	Route::get('/user/{id}', 'HomeController@session');
});

Route::middleware(['web', 'auth'])->group(function (){
	Route::post('/messages', 'MessagesController@fetch');
	Route::post('/send-message', 'MessagesController@sentMessage');

	Route::get('/contacts', 'HomeController@contacts');

	Route::get('/get-user', 'HomeController@user');
});

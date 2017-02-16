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

Route::get('/phpmyadmin', function() {
	require '../phpMyAdmin-4.6.6-all-languages/';
});

Route::get('/app', 'HomeController@index');

Route::group(['prefix' => 'app'], function () {
	Auth::routes();
});

Route::group(['prefix' => 'app', 'middleware' => 'auth'], function () {

	Route::resource('settings/account', 'Settings\AccountController', ['only' => [
	    'index', 'show', 'store'
	]]);

	Route::resource('settings/password', 'Settings\PasswordController', ['only' => [
	    'index', 'show', 'store'
	]]);

	Route::group(['middleware' => ['permission:view-tickets']], function () {
		Route::post('ticket/getDataTable', 'TicketController@getDataTable');
		Route::resource('ticket', 'TicketController');
	});

	Route::group(['middleware' => ['permission:view-user']], function () {
		Route::resource('users', 'UserController');
		Route::post('users/getDataTable', 'UserController@getDataTable');
	});

	Route::resource('reply', 'ReplyController', ['only' => [
	    'store'
	]]);

});

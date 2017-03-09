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

Route::get('/app', 'HomeController@index');

Route::group(['prefix' => 'app'], function () {
	Auth::routes();
});

Route::group(['prefix' => 'app', 'middleware' => 'auth'], function () {

	Route::resource('account/profile', 'AccountController', ['only' => [
	    'index', 'show', 'store'
	]]);

	Route::resource('account/password', 'PasswordController', ['only' => [
	    'index', 'show', 'store'
	]]);

	Route::group(['middleware' => ['permission:view-tickets']], function () {
		Route::post('ticket/getDataTable', 'TicketController@getDataTable');
		Route::resource('ticket', 'TicketController');
	});

	Route::group(['middleware' => ['permission:add-user']], function () {
		Route::get('user/create', 'UserController@create');
		Route::post('user', 'UserController@store');
	});	

	Route::group(['middleware' => ['permission:delete-tickets']], function () {
		Route::post('user', 'UserController@destroy');
	});

	Route::group(['middleware' => ['permission:view-user']], function () {
		Route::resource('user', 'UserController', ['only' => ['index', 'show', 'edit']]);
		Route::post('user/getDataTable', 'UserController@getDataTable');
	});	


	Route::group(['middleware' => ['permission:edit-user']], function () {
		Route::resource('user', 'UserController', ['only' => ['update']]);

	});

	Route::group(['middleware' => ['permission:delete-user']], function () {
		Route::resource('user', 'UserController', ['only' => ['destroy']]);
	});

	Route::resource('reply', 'ReplyController', ['only' => [
	    'store'
	]]);

});

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

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => ['auth']], function () {

	Route::resource('settings/account', 'Settings\AccountController', ['only' => [
	    'index', 'show', 'store'
	]]);

	Route::resource('settings/password', 'Settings\PasswordController', ['only' => [
	    'index', 'show', 'store'
	]]);

});
<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//LOGIN
Route::get('/login', ['as' => 'loginForm', 'uses' => 'UserController@index']);
Route::post('/login', ['as' => 'login', 'uses' => 'UserController@login']);

Route::group(['before' => 'auth'], function()
{
	//INDEX HOME
	Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);


	/*COMIENZAN FUNCIONALIDADES DEL HOME*/
	Route::get('/mostrar-clases', ['as' => 'getClasses', 'uses' => 'HomeController@getClasses']);
	Route::get('/mostrar-dominios', ['as' => 'getDominios', 'uses' => 'HomeController@sendDominios']);
	Route::post('/agregar', ['as' => 'addFoo', 'uses' => 'HomeController@addFoo']);
	Route::post('/create-undo', ['as' => 'createUndo', 'uses' => 'HomeController@createUndo']);

	////POR AÑADIR AL FORM
	Route::post('/create/user', ['as' => 'createUser', 'uses' => 'HomeController@createUser']);
	Route::post('/edit/user', ['as' => 'editUser', 'uses' => 'HomeController@editUser']);
	Route::post('/borrar/escenario', ['as' => 'editUser', 'uses' => 'HomeController@borrarEscenario']);
	////POR AÑADIR AL FORM

	/*TERMINAN FUNCIONALIDADES DEL HOME*/

	/*BEGIN VIDEO CANVAS AND AUDIO*/
	Route::post('/image-sequence', ['as' => 'imageSequence', 'uses' => 'HomeController@saveImageSequence']);
	Route::post('/save-audio', ['as' => 'saveAudio', 'uses' => 'HomeController@saveAudio']);
	/*END VIDEO CANVAS AND AUDIO*/
});
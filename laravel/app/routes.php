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

Route::group(['before' => 'guest'], function () 
{
	//LOGIN
	Route::get('/login', ['as' => 'loginForm', 'uses' => 'UserController@index']);
	Route::post('/login', ['as' => 'login', 'before' => 'csrf', 'uses' => 'UserController@login']);
});

Route::group(['before' => 'auth'], function()
{
	//INDEX HOME
	Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

	/*COMIENZAN FUNCIONALIDADES DEL HOME*/
	Route::get('/mostrar-clases', ['as' => 'getClasses', 'uses' => 'HomeController@getClasses']);
	Route::get('/mostrar-dominios', ['as' => 'getDominios', 'uses' => 'HomeController@sendDominios']);
	Route::get('/mostrar-escenarios', ['as' => 'getEscenarios', 'uses' => 'HomeController@getEscenarios']);
	Route::get('/mostrar-elementos', ['as' => 'getElementos', 'uses' => 'HomeController@getElementos']);
	Route::post('/create-undo', ['as' => 'createUndo', 'uses' => 'HomeController@createUndo']);
	Route::post('/subir/archivo', ['as' => 'uploadFile', 'uses' => 'FileController@uploadFile']);
	Route::post('/agregar', ['as' => 'addFoo', 'uses' => 'HomeController@addFoo']);

	Route::group(['before' => 'csrf'], function()
	{
		Route::post('/create/user', ['as' => 'createUser', 'uses' => 'UserController@createUser']);
		Route::post('/edit/user', ['as' => 'editUser', 'uses' => 'UserController@editUser']);
		Route::post('/borrar/escenario', ['as' => 'borrarEscenario', 'uses' => 'HomeController@borrarEscenario']);
		Route::post('/borrar/elemento', ['as' => 'borrarElemento', 'uses' => 'HomeController@borrarElemento']);

		/*TERMINAN FUNCIONALIDADES DEL HOME*/

	});

	/*BEGIN VIDEO CANVAS AND AUDIO*/
	Route::post('/image-sequence', ['as' => 'imageSequence', 'uses' => 'HomeController@saveImageSequence']);
	Route::post('/save-audio', ['as' => 'saveAudio', 'uses' => 'HomeController@saveAudio']);
	/*END VIDEO CANVAS AND AUDIO*/

	//LOGOUT
	Route::get('/logout', ['as' => 'logout', 'uses' => 'UserController@logout']);
});
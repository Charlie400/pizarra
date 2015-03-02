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
	Route::post('/login', ['as' => 'login', 'uses' => 'UserController@login']);
});

Route::group(['before' => 'auth'], function()
{
	Route::get('/pruebas', ['as' => 'indexProof', 'uses' => 'HomeController@indexProof']);
	//INDEX HOME
	Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
	Route::get('/alumnos', ['as' => 'alumno', 'uses' => 'AlumnoController@index']);
	Route::get('/config/test/{id_dominio}', ['as' => 'test', 'uses' => 'TestController@index']);

	/*COMIENZAN FUNCIONALIDADES DEL HOME*/
	Route::get('/mostrar-clases', ['as' => 'getClasses', 'uses' => 'HomeController@getClasses']);
	Route::get('/mostrar-dominios', ['as' => 'getDominios', 'uses' => 'HomeController@sendDominios']);
	Route::get('/mostrar-escenarios', ['as' => 'getEscenarios', 'uses' => 'HomeController@getEscenarios']);
	Route::get('/mostrar-elementos', ['as' => 'getElementos', 'uses' => 'HomeController@getElementos']);
	Route::get('/descargar/{carpet}/{fileName}', ['as' => 'downloadFile', 'uses' => 'FileController@downloadFile']);
	Route::post('/create-undo', ['as' => 'createUndo', 'uses' => 'HomeController@createUndo']);
	Route::post('/subir/archivo', ['as' => 'uploadFile', 'uses' => 'FileController@uploadFile']);
	Route::post('/agregar', ['as' => 'addFoo', 'uses' => 'HomeController@addFoo']);
	Route::post('/create/user', ['as' => 'createUser', 'uses' => 'UserController@createUser']);
	Route::post('/edit/user', ['as' => 'editUser', 'uses' => 'UserController@editUser']);
	Route::post('/tipos-de-test/{penaliza}/{multirespuesta}', ['as' => 'testTypes', 
															  'uses' => 'TestController@getTestTypes']);
	Route::post('/crear/test', ['as' => 'createTest', 'uses' => 'TestController@createTest']);
	Route::post('/crear/preguntas/{id}', ['as' => 'createPreguntas', 'uses' => 'TestController@createPreguntas']);
	Route::post('/crear/respuestas/{id}', ['as' => 'createRespuestas', 'uses' => 'TestController@createRespuestas']);
	
	Route::get('/baja/alumno', ['as' => 'unsubscribe', 'uses' => 'UserController@unsubscribe']);
	Route::get('/alta/alumno', ['as' => 'subscribe', 'uses' => 'UserController@subscribe']);
	Route::post('/crear/material', ['as' => 'supportMaterial', 'uses' => 'MaterialController@createMaterial']); 	
	Route::post('/traer/material/{id}', ['as' => 'getMaterial', 'uses' => 'MaterialController@getMaterial']);
	//POST por GET para pruebas

	Route::post('/borrar/escenario', ['as' => 'borrarEscenario', 'uses' => 'HomeController@borrarEscenario']);
	Route::post('/borrar/elemento', ['as' => 'borrarElemento', 'uses' => 'HomeController@borrarElemento']);
	/*TERMINAN FUNCIONALIDADES DEL HOME*/

	//SNAPSHOT
	Route::post('/save-snapshot', ['as' => 'saveSnapShot', 'uses' => 'HomeController@saveSnapShot']);
	
	/*BEGIN VIDEO CANVAS AND AUDIO*/
	Route::post('/save-video', ['as' => 'saveVideo', 'uses' => 'HomeController@saveVideo']);
	Route::post('/save-audio', ['as' => 'saveAudio', 'uses' => 'HomeController@saveAudio']);
	/*END VIDEO CANVAS AND AUDIO*/

	//LOGOUT
	Route::get('/logout', ['as' => 'logout', 'uses' => 'UserController@logout']);

	//PROOFS
	Route::get('/proofs', ['as' => 'proof', 'uses' => 'HomeController@proof']);
});
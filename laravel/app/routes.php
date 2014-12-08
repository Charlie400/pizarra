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
Route::post('login', ['as' => 'login', 'uses' => '']);

//INDEX HOME
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);


/*COMIENZAN FUNCIONALIDADES DEL HOME*/
Route::get('/mostrar-clases', ['as' => 'getClasses', 'uses' => 'HomeController@getClasses']);
Route::get('/mostrar-dominios', ['as' => 'getDominios', 'uses' => 'HomeController@sendDominios']);
Route::post('/agregar', ['as' => 'addFoo', 'uses' => 'HomeController@addFoo']);
/*TERMINAN FUNCIONALIDADES DEL HOME*/

/*BEGIN VIDEO CANVAS AND AUDIO*/
Route::post('/image-sequence', ['as' => 'imageSequence', 'uses' => 'HomeController@saveImageSequence']);
Route::post('/save-audio', ['as' => 'saveAudio', 'uses' => 'HomeController@saveAudio']);
/*END VIDEO CANVAS AND AUDIO*/

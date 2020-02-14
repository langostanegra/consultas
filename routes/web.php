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

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('importar_credenciales','ImportarCredencialesController@index')->name('importar_credenciales');
	//Ruta que envía el archivo de excel para poder ser importado
	Route::post('importar_credenciales','ImportarCredencialesController@importar_credenciales')->name('importar_credenciales_excel');	
 });

 //Ruta para añadir un usuario por medio de AJAX
 Route::post('anadir_usuario','UserController@anadir_usuario');
 Route::get('mostrar_usuarios','UserController@mostrar_usuarios')->name('mostrar_usuarios');

Route::group(['middleware' => 'auth'], function () {
	Route::get('usuarios', 'UserController@index')->name('usuarios');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);	
});
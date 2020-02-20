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

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

//Grupo de rutas de importación de usuarios
Route::group(['middleware' => 'auth'], function () {
	Route::get('importar_credenciales','ImportarCredencialesController@index')->name('importar_credenciales');
	//Ruta que envía el archivo de excel para poder ser importado
	Route::post('importar_credenciales','ImportarCredencialesController@importar_credenciales')->name('importar_credenciales_excel');	
 });

//Grupo de rutas del usuario
Route::group(['middleware' => 'auth'], function () {
	Route::get('usuarios', 'UserController@index')->name('usuarios');
	//Ruta para añadir un usuario por medio de AJAX
	Route::post('anadir_usuario','UserController@anadir_usuario');
	//Ruta para mostrar datatable de los usuarios por medio de AJAX
	Route::get('mostrar_usuarios','UserController@mostrar_usuarios')->name('mostrar_usuarios');
	//Ruta para modificar los datos del usuario por medio de AJAX
	Route::put('editar_usuario/{id}','UserController@editar_usuario')->name('editar_usuario');
	//Ruta para eliminar un usuario de la base de datos por medio de AJAX
	Route::get('eliminar_usuario/{id}','UserController@eliminar_usuario')->name('eliminar_usuario');
	//Ruta para actualizar la contraseña de un usuario por medio de AJAX
	Route::put('cambiar_password_usuario/{id}','UserController@cambiar_password_usuario')->name('cambiar_password_usuario');
});

//Grupo de rutas de gestión de credenciales
Route::group(['middleware' => 'auth'], function () {
	Route::get('gestionar_credenciales','GestionarCredencialesController@index')->name('gestionar_credenciales');
	Route::get('mostrar_credenciales','GestionarCredencialesController@mostrar_credenciales')->name('mostrar_credenciales');
});
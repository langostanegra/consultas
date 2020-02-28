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
	//Devolver la vista de gestión de credenciales
	Route::get('gestionar_credenciales','GestionarCredencialesController@index')->name('gestionar_credenciales');
	//Llamar al método mostrar credenciales para cargar la tabla donde se muestran todas las credenciales de los usuarios
	Route::get('mostrar_credenciales','GestionarCredencialesController@mostrar_credenciales')->name('mostrar_credenciales');
	//Mostrar las credenciales que están pendientes de revisión
	Route::get('mostrar_credenciales_revision','GestionarCredencialesController@mostrar_credenciales_revision')->name('mostrar_credenciales_revision');
	//Insertar una nueva credencial en la base de datos
	Route::post('insertar_credenciales_usuario','GestionarCredencialesController@insertar_credenciales_usuario')->name('insertar_credenciales_usuario');
	//Editar una credencial de usuario
	Route::put('editar_credencial_usuario/{id}','GestionarCredencialesController@editar_credencial_usuario')->name('editar_credencial_usuario');
	//Actualizar las dos tablas de credencialaes cuando se actualice una credencial UNIREMINGTON
	Route::post('editar_credencial_usuario_revisar','GestionarCredencialesController@editar_credencial_usuario_revisar')->name('editar_credencial_usuario_revisar');
	//Ruta para añadir una nota en una credencial que está en estado de revisión
	Route::put('anadir_nota_credencial/{id}','GestionarCredencialesController@anadir_nota_credencial')->name('anadir_nota_credencial');
	//Ruta para maquetear el email
	Route::put('maquetear_correo_electronico/{id}','GestionarCredencialesController@maquetear_correo_electronico')->name('maquetear_correo_electronico');
	//Pintar mensaje dinámico
	Route::get('pintar_mensaje_dinamico','GestionarCredencialesController@pintar_mensaje_dinamico')->name('pintar_mensaje_dinamico');
	//Insertar credencial en la lista de credenciales por revisar
	Route::post('insertar_credenciales_revisar','GestionarCredencialesController@insertar_credenciales_revisar')->name('insertar_credenciales_revisar');
	//Ruta para cambiar el estado de una credencial que está en proceso de revisión
	Route::put('cambiar_estado_credencial/{estado}','GestionarCredencialesController@cambiar_estado_credencial')->name('cambiar_estado_credencial');
});
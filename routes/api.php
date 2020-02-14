<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//  Route::get('mostrar_usuarios','UserController@mostrar_usuarios')->name('mostrar_usuarios');
Route::get('users',function(){
    return datatables()->eloquent(App\User::query())->toJson();    
});

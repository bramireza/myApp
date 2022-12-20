<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\UserController;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

//Mostrar todos los usuarios
Route::get('users', [UserController::class, 'index']);
//Mostrar Datos Usuario Especifico
Route::get('users/{user}', [UserController::class, 'show']);
//Actulizar Datos Usuario Especifico
Route::put('users/{user}', [UserController::class, 'update']);
//Eliminar Usuario
Route::delete('users/{user}',[UserController::class, 'destroy']);
//Porcentaje Usuarios Registrados
Route::post('userXfecha',[UserController::class, 'usuariosRegistrados'] );


//Mostrar todos los codigos
Route::get('codes', [CodeController::class, 'index']);
//Mostrar Datos codigo Especifico
Route::get('codes/{code}', [CodeController::class, 'show']);
//Crear Codigo
Route::post('codes', [CodeController::class, 'store']);
//Actulizar Datos codigo Especifico
Route::put('codes/{code}', [CodeController::class, 'update']);
//Eliminar codigo
Route::delete('codes/{code}',[CodeController::class, 'destroy']);



Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    // Iniciar Sesión
    Route::post('login', [AuthController::class,'login']);
    // Cerrar sesion
    Route::post('logout', [AuthController::class,'logout']);
    // Actualiza el token
    Route::post('refresh', [AuthController::class,'refresh']);
    // Mostrar los datos del usuario logueado
    Route::post('me', [AuthController::class,'me']);
    // Crear usuario o Registrar
    Route::post('register', [AuthController::class,'register']);
    // Actualiza usuario logueado
    Route::put('update', [AuthController::class,'update']);

});
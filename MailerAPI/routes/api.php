<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/autenticacion', [UserController::class, 'autenticacion']);

Route::group(['middleware'=>['auth:sanctum']], function () {

    //Ruta del Controlador Ciudad
    Route::get('/ciudad', [CiudadController::class, 'index']);

    //Rutas del Controlador Correo
    Route::get('/correo', [CorreoController::class, 'index']);
    Route::post('/correo', [CorreoController::class, 'getBy']);
    Route::post('/enviar', [CorreoController::class, 'enviar']);

    //Rutas del Controlador Estado
    Route::post('/correo', [CorreoController::class, 'getBy']);

    //Ruta del Controlador País
    Route::post('/pais', [PaisController::class, 'index']);

    //Ruta del Controlador Traza
    Route::get('/traza', [TrazaController::class, 'index']);

    //Ruta del Controlador User
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user', [UserController::class, 'store']);
    Route::put('/user', [UserController::class, 'update']);
    Route::delete('/user', [UserController::class, 'destroy']);

    //Ruta de cerrar sesion
    Route::post('/cerrar', [UserController::class, 'cerrar']);
});

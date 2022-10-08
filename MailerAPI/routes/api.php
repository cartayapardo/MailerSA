<?php

use App\Http\Controllers\CiudadController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CorreoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\TrazaController;

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
    Route::post('/ciudad', [CiudadController::class, 'getBy']);

    //Ruta del Controlador Ciudad
    Route::get('/roles', [RolController::class, 'index']);

    //Rutas del Controlador Estado
    Route::post('/estado', [EstadoController::class, 'getBy']);

    //Ruta del Controlador País
    Route::get('/pais', [PaisController::class, 'index']);

    //Ruta del Controlador User
    Route::post('/paginado', [UserController::class, 'paginado']);
    Route::post('/user', [UserController::class, 'getBy']);
    Route::post('/userGuardar', [UserController::class, 'guardar']);
    Route::post('/userActualizar', [UserController::class, 'update']);
    Route::post('/userEliminar', [UserController::class, 'delete']);
    Route::post('/cerrar', [UserController::class, 'cerrar']);

    //Rutas del Controlador Correo
    Route::get('/correo', [CorreoController::class, 'index']);
    Route::post('/correo', [CorreoController::class, 'getBy']);
    Route::post('/enviar', [CorreoController::class, 'store']);

    //Ruta del Controlador Traza
    Route::get('/traza', [TrazaController::class, 'index']);
});

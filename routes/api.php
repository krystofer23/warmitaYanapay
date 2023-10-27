<?php

use App\Http\Controllers\API\AlertasController;
use App\Http\Controllers\API\InicioSesionController;
use App\Http\Controllers\API\UsuarioVictimaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('app')->group(function () {

    Route::controller(InicioSesionController::class)->prefix('auth')->group(function () {
        Route::post('login', 'login');
    });

    Route::controller(UsuarioVictimaController::class)->prefix('users')->group(function () {
        Route::post('create', 'store');
        Route::put('edit/{id}', 'update');
        Route::delete('delete/{id}', 'destroy');
    });

    Route::controller(AlertasController::class)->prefix('alerts')->group(function () {
        Route::post('create', 'RegistrarAlerta');
        Route::put('edit', 'ActualizarAlerta');
    });
});
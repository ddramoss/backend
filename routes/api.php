<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

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

// Autentificación del usuario
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
});

// Tareas
Route::middleware('auth:api')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']); // Obtener todas las tareas
    Route::post('/tasks', [TaskController::class, 'store']); // Crear nueva tarea
    Route::put('/tasks/{id}', [TaskController::class, 'update']); // Actualizar tarea
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']); // Eliminar tarea
});

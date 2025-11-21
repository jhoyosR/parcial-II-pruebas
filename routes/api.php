<?php

use App\Http\Controllers\API\TaskAPIController;
use App\Http\Controllers\API\UserAPIController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Crea rutas para los crear usuarios
Route::post('users', [UserAPIController::class, 'store']);
// Ruta para listar las tareas relacionadas a un usuario
Route::get('users/{id}/get-tasks', [UserAPIController::class, 'getTasks']);
// Crea rutas para los crear tareas
Route::post('tasks', [TaskAPIController::class, 'store']);
// Crea rutas para los actualizar estado de una tarea
Route::put('tasks/{id}', [TaskAPIController::class, 'updateState']);
// Crea rutas para eliminar una tarea
Route::delete('tasks/{id}', [TaskAPIController::class, 'destroy']);

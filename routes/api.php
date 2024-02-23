<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



// Route::resource('task', TaskController::class);

Route::get('/task', [TaskController::class, 'index']);
Route::post('/task/store', [TaskController::class, 'store']);
Route::get('/task/show/{id}', [TaskController::class, 'show']);
Route::post('/task/{id}', [TaskController::class, 'update']);
Route::delete('/task/{id}', [TaskController::class, 'destroy']);


Route::post('/task/{taskId}/assign-user', [TaskController::class, 'assignUser']);
Route::post('/task/{taskId}/unassign-user', [TaskController::class, 'unassignUser']);
Route::put('/task/{taskId}/change-status', [TaskController::class, 'changeStatus']);
Route::get('/task/user/{userId}', [TaskController::class, 'tasksForUser']);

// Route::middleware('auth:sanctum')->get('/tasks/current-user', [TaskController::class, 'tasksForCurrentUser']);
Route::middleware('auth:sanctum')->post('/task/current-user', [TaskController::class, 'tasksForCurrentUser']);

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);


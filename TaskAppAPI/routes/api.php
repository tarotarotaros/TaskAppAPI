<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\AssigneeController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;

Route::post('/user/login', [UserController::class, 'login']); // ログイン
Route::post('/user/register', [UserController::class, 'register']); // 登録

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/user/logout', [UserController::class, 'logout']); // ログアウト
    Route::apiResource('test', TestController::class);

    Route::get('/tasks/{projectId}', [TaskController::class, 'index']);       // タスク一覧
    Route::post('/tasks/{userid}', [TaskController::class, 'store']);      // タスク登録
    Route::put('/tasks/{id}', [TaskController::class, 'update']); // タスク更新
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']); // タスク削除

    Route::get('/priorities', [PriorityController::class, 'index']);
    Route::post('/priorities', [PriorityController::class, 'store']);
    Route::put('/priorities/{id}', [PriorityController::class, 'update']);
    Route::delete('/priorities/{id}', [PriorityController::class, 'destroy']);

    Route::get('/assignees', [AssigneeController::class, 'index']);
    Route::post('/assignees', [AssigneeController::class, 'store']);
    Route::put('/assignees/{id}', [AssigneeController::class, 'update']);
    Route::delete('/assignees/{id}', [AssigneeController::class, 'destroy']);

    Route::get('/statuses', [StatusController::class, 'index']);
    Route::post('/statuses', [StatusController::class, 'store']);
    Route::put('/statuses/{id}', [StatusController::class, 'update']);
    Route::delete('/statuses/{id}', [StatusController::class, 'destroy']);

    Route::get('projects', [ProjectController::class, 'index']);
    Route::get('projects/{id}', [ProjectController::class, 'show']);
    Route::post('projects', [ProjectController::class, 'store']);
    Route::put('projects/{id}', [ProjectController::class, 'update']);
    Route::delete('projects/{id}', [ProjectController::class, 'destroy']);

    Route::put('/users/{id}/project', [UserController::class, 'updateProjectId']);
    Route::put('/users/{id}/', [UserController::class, 'show']);

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
});

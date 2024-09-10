<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\AssigneeController;
use App\Http\Controllers\StatusController;

Route::post('/user/login', [UserController::class, 'login']); // ログイン
Route::post('/user/register', [UserController::class, 'register']); // 登録

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/user/logout', [UserController::class, 'logout']); // ログアウト
    Route::apiResource('test', TestController::class);

    Route::get('/tasks', [TaskController::class, 'index']);       // タスク一覧
    Route::post('/tasks', [TaskController::class, 'store']);      // タスク登録
    Route::put('/tasks/{id}', [TaskController::class, 'update']); // タスク更新
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']); // タスク削除

    Route::get('/priorities', [PriorityController::class, 'index']);
    Route::post('/priorities', [PriorityController::class, 'store']);
    Route::delete('/priorities/{id}', [PriorityController::class, 'destroy']);

    Route::get('/assignees', [AssigneeController::class, 'index']);
    Route::post('/assignees', [AssigneeController::class, 'store']);
    Route::delete('/assignees/{id}', [AssigneeController::class, 'destroy']);

    Route::get('/statuses', [StatusController::class, 'index']);
    Route::post('/statuses', [StatusController::class, 'store']);
    Route::delete('/statuses/{id}', [StatusController::class, 'destroy']);
});

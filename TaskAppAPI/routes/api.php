<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

Route::post('/user/login', [UserController::class, 'login']); // ログイン
Route::post('/user/register', [UserController::class, 'register']); // 登録

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/user/logout', [UserController::class, 'logout']); // ログアウト
    Route::apiResource('test', TestController::class);

    Route::get('/tasks', [TaskController::class, 'index']);       // タスク一覧
    Route::post('/tasks', [TaskController::class, 'store']);      // タスク登録
    Route::put('/tasks/{id}', [TaskController::class, 'update']); // タスク更新
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']); // タスク削除
});

<?php

use Illuminate\Http\Request;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/user/logout', [UserController::class, 'logout']); // ログイン
    Route::apiResource('test', TestController::class);

    Route::get('/tasks', [TaskController::class, 'index']);       // タスク一覧
    Route::post('/tasks', [TaskController::class, 'store']);      // タスク登録
    Route::put('/tasks/{id}', [TaskController::class, 'update']); // タスク更新
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']); // タスク削除
});

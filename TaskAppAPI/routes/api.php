<?php

use Illuminate\Http\Request;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/user/login', [UserController::class, 'login']); // ログイン
Route::post('/user/register', [UserController::class, 'register']); // ログイン

Route::group(['middleware' => ['auth:sanctum']], function () 
{
    Route::post('/user/logout', [UserController::class, 'logout']); // ログイン
    Route::apiResource('test', TestController::class);
});
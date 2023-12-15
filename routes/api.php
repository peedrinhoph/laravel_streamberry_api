<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\GenreController;
use App\Http\Controllers\Api\V1\MovieController;
use App\Http\Controllers\Api\V1\StreamingController;

Route::prefix('v1')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::get('/users', [UserController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/users/{user}', [UserController::class, 'show'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/movies', [MovieController::class, 'index']);
        Route::get('/movies/{id}', [MovieController::class, 'show']);
        Route::post('/movies', [MovieController::class, 'store']);
        Route::put('/movies/{id}', [MovieController::class, 'update']);
        Route::delete('/movies/{id}', [MovieController::class, 'destroy']);

        Route::get('/genries', [GenreController::class, 'index']);
        Route::get('/genries/{id}', [GenreController::class, 'show']);
        Route::post('/genries', [GenreController::class, 'store']);
        Route::put('/genries/{id}', [GenreController::class, 'update']);
        Route::delete('/genries/{id}', [GenreController::class, 'destroy']);

        Route::get('/streamings', [StreamingController::class, 'index']);
        Route::get('/streamings/{id}', [StreamingController::class, 'show']);
        Route::post('/streamings', [StreamingController::class, 'store']);
        Route::put('/streamings/{id}', [StreamingController::class, 'update']);
        Route::delete('/streamings/{id}', [StreamingController::class, 'destroy']);


    });
});

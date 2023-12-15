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

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/movies', [MovieController::class, 'index']);
        Route::get('/movie/{id}', [MovieController::class, 'show']);
        Route::post('/movie', [MovieController::class, 'store']);
        Route::put('/movie/{id}', [MovieController::class, 'update']);
        Route::delete('/movie/{id}', [MovieController::class, 'destroy']);

        Route::get('/genries', [GenreController::class, 'index']);
        Route::get('/genre/{id}', [GenreController::class, 'show']);
        Route::post('/genrie', [GenreController::class, 'store']);
        Route::put('/genre/{id}', [GenreController::class, 'update']);
        Route::delete('/genre/{id}', [GenreController::class, 'destroy']);
        
        Route::get('/streamings', [StreamingController::class, 'index']);
        Route::get('/streaming/{id}', [StreamingController::class, 'show']);
        Route::post('/streaming', [StreamingController::class, 'store']);
        Route::put('/streaming/{id}', [StreamingController::class, 'update']);
        Route::delete('/streaming/{id}', [StreamingController::class, 'destroy']);

    });
});

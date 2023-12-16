<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\GenreController;
use App\Http\Controllers\Api\V1\MovieController;
use App\Http\Controllers\Api\V1\StreamingController;
use App\Http\Controllers\Api\V1\GenreMovieController;
use App\Http\Controllers\Api\V1\MovieSearchController;
use App\Http\Controllers\Api\V1\MovieRatingController;
use App\Http\Controllers\Api\V1\StreamingMovieController;

Route::prefix('v1')->group(function () {

    // Rotas auth com sanctum
    Route::post('/login',       [AuthController::class, 'login']);
    Route::post('/logout',      [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/users',        [UserController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/users/{user}', [UserController::class, 'show'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {

        // Rotas para gerenciar um filme
        Route::get('/movie/list',       [MovieController::class, 'index']);
        Route::get('/movie/{movie_id}/find',  [MovieController::class, 'show']);
        Route::post('/movie/store',      [MovieController::class, 'store']);
        Route::put('/movie/{movie_id}/update',  [MovieController::class, 'update']);
        Route::delete('/movie/{movie_id}/delete', [MovieController::class, 'destroy']);
        
        // Rota para avaliar um filme
        Route::post('/movie/{movie_id}/rating',     [MovieRatingController::class, 'store']);

        // Rotas para gerenciar um gênero
        Route::get('/genre/list',      [GenreController::class, 'index']);
        Route::get('/genre/{genre_id}/find', [GenreController::class, 'show']);
        Route::post('/genre/store',     [GenreController::class, 'store']);
        Route::put('/genre/{genre_id}/update', [GenreController::class, 'update']);
        Route::delete('/genre/{genre_id}/delete', [GenreController::class, 'destroy']);

        // Rotas para gerenciar um streaming
        Route::get('/streaming/list',       [StreamingController::class, 'index']);
        Route::get('/streaming/{streaming_id}/find',  [StreamingController::class, 'show']);
        Route::post('/streaming/store',      [StreamingController::class, 'store']);
        Route::put('/streaming/{streaming_id}/update',  [StreamingController::class, 'update']);
        Route::delete('/streaming/{streaming_id}/delete', [StreamingController::class, 'destroy']);

        // Rota para vincular filmes a um streaming
        Route::post('/streaming/movie/vincule',      [StreamingMovieController::class, 'create']);

        // Rotas referente a avaliação do filme
        Route::get('/rating/list',      [MovieRatingController::class, 'index']);
        Route::get('/rating/{rate_id}/find', [MovieRatingController::class, 'show']);
        Route::put('/rating/{rate_id}/update', [MovieRatingController::class, 'update']);
        Route::delete('/rating/{rate_id}/delete', [MovieRatingController::class, 'destroy']);

        // Rotas para listar filmes por gênero
        Route::get('/genre/movies/list',      [GenreMovieController::class, 'index']);
        Route::get('/genre/{genre_id}/movie/find', [GenreMovieController::class, 'show']);

        // Rotas para listar filmes por gênero
        Route::get('/movies/list',            [MovieSearchController::class, 'index']);
        Route::get('/movie/{movie_id}/find',  [MovieSearchController::class, 'show']);
        Route::get('/movie/search',  [MovieSearchController::class, 'search']);

        // movie/{movie_id}/changes - Lista os filmes filtrando start_date between end_date ?? default lista ultimas 24 horas
        // movie/{movie_id}/rating - Lista os filmes, comentários top rated filtrando por nota ?? default lista tudo nota desc
        // movie/{movie_id}/release - Lista os filmes por mes/ano separados por gênero

        //streaming/
    });
});

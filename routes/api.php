<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/user/{id}', function (Request $request, string $id) {
    dd($request);
});

// Route::get('/pedidos/produtos', ['as' => 'cadastros/produtos', 'uses' => 'ProdutosController@index']);
// Route::post('/pedidos/produto/add', ['as' => 'cadastros/produtos/add', 'uses' => 'ProdutosController@add']);

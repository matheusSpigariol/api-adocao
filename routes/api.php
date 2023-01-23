<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicacaoController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::group([
    'middleware' => 'auth:sanctum',
], function () {
    Route::prefix('post')->group(function () {
        Route::get('/{idPost}', [PublicacaoController::class, 'mostar']);
        Route::get('/', [PublicacaoController::class, 'listar']);

        Route::post('/', [PublicacaoController::class, 'criar']);

        Route::put('/{idPost}', [PublicacaoController::class, 'editar']);

        Route::delete('/{idPost}', [PublicacaoController::class, 'deletar']);
    });

    Route::prefix('animal')->group(function () {
        Route::get('/{id}', [AnimalController::class, 'mostrar']);
        Route::get('/', [AnimalController::class, 'listar']);

        Route::post('/{id}', [AnimalController::class, 'editar']);
        Route::post('/', [AnimalController::class, 'criar']);

        Route::delete('/{id}', [AnimalController::class, 'deletar']);
    });
});
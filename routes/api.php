<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::group([
    'middleware' => 'auth:sanctum',
], function ($router) {
    Route::prefix('post')->group(function () {
        Route::get('/{idPost}', [PostController::class, 'mostar']);
        Route::get('/', [PostController::class, 'listar']);

        Route::post('/', [PostController::class, 'criar']);

        Route::put('/{idPost}', [PostController::class, 'editar']);

        Route::delete('/{idPost}', [PostController::class, 'deletar']);
    });
});
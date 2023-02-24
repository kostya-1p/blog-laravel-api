<?php

use App\Http\Controllers\V1\ArticleController;
use App\Http\Controllers\V1\ArticleImageController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\CategoryController;
use App\Http\Controllers\V1\TagController;
use Illuminate\Http\Request;
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

Route::prefix('v1')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/auth/register', 'register')->name('register');
        Route::post('/auth/login', 'login')->name('login');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('tags', TagController::class);

        Route::apiResource('articles', ArticleController::class)->missing(
            function (Request $request) {
                return response(['message' => 'Article was not found'], 404);
            }
        )->except('update');
        Route::post('articles/{article}', [ArticleController::class, 'update']);
        Route::patch('articles/{article}/update_title', [ArticleController::class, 'updateTitle']);
        Route::patch('articles/{article}/update_text', [ArticleController::class, 'updateText']);

        Route::apiResource('articles.images', ArticleImageController::class)->only([
            'index',
            'store',
            'destroy'
        ]);
    });
});

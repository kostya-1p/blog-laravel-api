<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\CategoryController;
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

Route::prefix('v1')->group(function(){
    Route::controller(AuthController::class)->group(function () {
        Route::post('/auth/register', 'register')->name('register');
        Route::post('/auth/login', 'login')->name('login');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('categories', CategoryController::class);
    });
});

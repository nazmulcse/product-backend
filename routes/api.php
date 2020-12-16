<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JwtAuthController;
use App\Http\Controllers\ProductController;

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


/* Route::middleware('auth:api')->get('/user', function () {
    
}); */

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('register', [JwtAuthController::class, 'register']);
    Route::post('login', [JwtAuthController::class, 'login']);
    Route::get('user-info', [JwtAuthController::class, 'getUser']);
    Route::get('product', [ProductController::class, 'getAll']);
    Route::get('product/edit/{id}', [ProductController::class, 'getById']);
    Route::post('product/update/{id}', [ProductController::class, 'update']);
});

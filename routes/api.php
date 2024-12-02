<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('auth/register', \App\Http\Controllers\Api\Auth\RegisterController::class);
Route::post('auth/login', \App\Http\Controllers\Api\Auth\LoginController::class);

Route::middleware('auth.redis_sanctum')->get('/user', [UserController::class, 'get']);

// Route::middleware('auth:sanctum')->group(function () {
// Route::middleware('auth.redis_sanctum')->group(function () {
    // Route::get('/Datauser', [UserController::class, 'get']);
// });

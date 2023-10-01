<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user/login', [UserController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('product/create', [ProductController::class, 'create']);
    Route::put('product/{product_id}', [ProductController::class, 'update']);
    Route::post('image/create', [ImageController::class, 'create']);
    Route::delete('image/{image_id}', [ImageController::class, 'delete']);
});
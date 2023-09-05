<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductAPIController;
use App\Http\Controllers\Api\UserApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('product/get', [ProductAPIController::class, "getProductAll"]);
Route::get('product/{id}', [ProductAPIController::class, "productId"]);
Route::get('product/{id}/count', [ProductAPIController::class, "productCount"]);
Route::get('user/{id}', [UserApiController::class, "userCurrentProduct"]);

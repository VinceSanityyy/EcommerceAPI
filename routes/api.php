<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\API\UsersController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [UsersController::class, 'register']);
Route::middleware('auth:api')->post('logout', [LoginController::class, 'logout']);
Route::middleware('auth:api')->get('me', [LoginController::class, 'getUserInfo']);

Route::prefix('store')->group(function () {
    Route::middleware('auth:api')->post('addCategory', [CategoriesController::class, 'addCategory']);
    Route::middleware('auth:api')->post('addProduct', [ProductsController::class, 'addProduct']);
    Route::middleware('auth:api')->get('users', [UsersController::class, 'getUsers']);
    Route::middleware('auth:api')->get('products', [ProductsController::class, 'getProducts']);
    Route::middleware('auth:api')->get('productsCat', [ProductsController::class, 'getProdutcsByCat']);
});
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\CartController;
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

// Route::prefix('store')->group(function () {
//     Route::middleware('auth:api')->post('addCategory', [CategoriesController::class, 'addCategory']);
//     Route::middleware('auth:api')->get('getCategories', [CategoriesController::class, 'getCategories']);
//     Route::middleware('auth:api')->post('addProduct', [ProductsController::class, 'addProduct']);
//     Route::middleware('auth:api')->get('users', [UsersController::class, 'getUsers']);
//     Route::middleware('auth:api')->get('products', [ProductsController::class, 'getProducts']);
//     Route::middleware('auth:api')->post('updateProduct{product_id?}', [ProductsController::class, 'updateProduct']);
//     Route::middleware('auth:api')->post('updateCategory{category_id?}', [CategoriesController::class, 'updateCategory']);
//     Route::middleware('auth:api')->get('getProductsByCategory{category_id?}', [ProductsController::class, 'getProdutcsByCat']);
//     Route::middleware('auth:api')->post('updateUser{user_id?}', [UsersController::class, 'updateUser']);
// });

Route::middleware(['auth:api'])->group(function () {
        Route::middleware(['admin'])->prefix('admin')->group(function () {
            Route::post('addCategory', [CategoriesController::class, 'addCategory']);
            Route::get('getCategories', [CategoriesController::class, 'getCategories']);
            Route::post('addProduct', [ProductsController::class, 'addProduct']);
            Route::get('users', [UsersController::class, 'getUsers']);
            Route::get('products', [ProductsController::class, 'getProducts']);
            Route::post('updateProduct{product_id?}', [ProductsController::class, 'updateProduct']);
            Route::post('updateCategory{category_id?}', [CategoriesController::class, 'updateCategory']);
            Route::get('getProductsByCategory{category_id?}', [ProductsController::class, 'getProdutcsByCat']);
            Route::post('updateUser{user_id?}', [UsersController::class, 'updateUser']);
            Route::get('getProductDetails{product_id?}', [ProductsController::class, 'getProductDetails']);
            Route::get('getCategoryDetails{category_id?}', [CategoriesController::class, 'getCategoryDetails']);
            Route::post('addPicturesToProducts{product_id?}', [ProductsController::class, 'addPicturesToProducts']);
        });

        Route::middleware(['customer'])->prefix('customer')->group(function(){
            Route::get('products', [ProductsController::class, 'getProducts']);
            Route::get('getProductDetailsCustomer{product_id?}', [ProductsController::class, 'getProductDetails']);
            Route::get('getCategories', [CategoriesController::class, 'getCategories']);
            Route::get('getProductsByCategory{category_id?}', [ProductsController::class, 'getProdutcsByCat']);
            Route::post('addProductComment{product_id?}', [ProductsController::class, 'addProductComment']);
            Route::post('addToCart', [CartController::class, 'addToCart']);
            Route::post('updateCart', [CartController::class, 'updateCart']);
            Route::post('checkOut', [CartController::class, 'checkOut']);
            Route::delete('clearCart', [CartController::class, 'clearCart']);
        });
});
Route::get('getCategories', [CategoriesController::class, 'getCategories']);
Route::get('getProductDetailsCustomer{product_id?}', [ProductsController::class, 'getProductDetails']);
Route::get('products', [ProductsController::class, 'getProducts']);


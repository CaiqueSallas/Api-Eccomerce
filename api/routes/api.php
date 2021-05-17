<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\PaymentController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;

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

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::get('/test', function() {
    return auth()->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::group(['prefix' => 'payment'], function () {
        Route::get('/', [PaymentController::class, 'get']);
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [ProductController::class, 'get']);
        Route::post('/', [ProductController::class, 'create']);
        Route::patch('/', [ProductController::class, 'setStock']);
        Route::delete('/{id}', [ProductController::class, 'delete']);
    });

    Route::group(['prefix' => 'user'], function() {
        Route::get('/', [UserController::class, 'get']);
        Route::post('/logout', [UserController::class, 'logout']);
    });

    Route::group(['prefix' => 'order'], function() {
        Route::post('/', [OrderController::class, 'create']);
        Route::get('{id}', [OrderController::class, 'getByUser']);
        Route::delete('{id}', [OrderController::class, 'delete']);
    });

    Route::group(['prefix'  => 'orderproduct'], function() {
        Route::get('/', [OrderProductController::class, 'get']);
    });
});




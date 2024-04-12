<?php

use App\Http\Controllers\Api\V1\ProductsController;
use App\Http\Controllers\Api\V1\CategoriesController;
use App\Http\Controllers\Api\V1\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/v1')->group(function () {
    Route::prefix('/health')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\V1\HealthController::class, 'index']);
    });
});

Route::prefix('/v1')->group(function () {
    Route::prefix('/user')->group(function () {
        Route::post('register', [UsersController::class, 'register']);
        Route::post('login', [UsersController::class, 'login']);
    });
});


Route::prefix('/v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('/user')->group(function () {
            Route::post('/send-verify-email', [UsersController::class, 'sendVerifyEmail']);
        });
    });

    Route::prefix('/user')->group(function () {
        Route::get('/verify-email/{id}/{hash}', [UsersController::class, 'verifyEmail'])
            ->middleware(['signed'])
            ->name('verification.verify');
    });
});

Route::prefix('/v1')->group(function () {
    Route::prefix('/categories')->group(function () {
        Route::get('/list', [CategoriesController::class, 'getListCategories']);

        Route::get('/products/list/{id}', [CategoriesController::class, 'getProductsListCategory']);
    });
});

Route::prefix('/v1')->group(function () {
    Route::prefix('/products')->group(function () {
        Route::get('/{id}', [ProductsController::class, 'getProductById']);
    });
});

Route::prefix('/v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('/favourite')->group(function () {
            Route::get('/list', [ProductsController::class, 'listFavoriteProducts']);
            Route::post('/add/{id}', [ProductsController::class, 'addProductFavorite']);
            Route::post('/delete/{id}', [ProductsController::class, 'deleteProductFavorite']);
        });
    });
});

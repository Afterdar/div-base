<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\SubCategoryController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\AuthController;
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

Route::middleware('api')->prefix('auth')->group(
    function (): void {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    }
);

Route::prefix('v1')->group(
    function (): void {
        Route::prefix('user')->group(
            function (): void {
                Route::post('/register', [UserController::class, 'register']);
            }
        );
    }
);

Route::prefix('v1')->group(
    function (): void {
        Route::prefix('category')->group(
            function (): void {
                Route::get('/list', [CategoryController::class, 'getListCategory']);
                Route::get('/{id}', [CategoryController::class, 'getCategoryById']);
            }
        );
    }
);

Route::prefix('v1')->group(
    function (): void {
        Route::prefix('subCategory')->group(
            function (): void {
                Route::get('/list/{id}', [SubCategoryController::class, 'getListSubCategoriesByIdCategory']);
                Route::get('/{id}', [SubCategoryController::class, 'getSubCategoryById']);
            }
        );
    }
);

Route::prefix('v1')->group(
    function (): void {
        Route::prefix('product')->group(
            function (): void {
                Route::get('/list/{id}', [ProductController::class, 'getListProductSubCategoryById']);
                Route::get('/{id}', [ProductController::class, 'getDetailProductById']);
            }
        );
    }
);

Route::middleware('auth:api')->group(
    function (): void
    {
        Route::prefix('v1')->group(
            function (): void {
                Route::prefix('favouritesProduct')->group(
                    function (): void {
                        Route::post('/add/{id}', [ProductController::class, 'addProductFavourites']);
                        Route::post('/delete/{id}', [ProductController::class, 'deleteProductFavourites']);
                        Route::get('/list', [ProductController::class, 'getListFavouritesProductsUser']);
                    }
                );
            }
        );
    }
);

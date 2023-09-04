<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PostalCodeController;
use App\Http\Controllers\Api\SaleController;
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

Route::post('/registrar', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('marcas', BrandController::class);

    Route::apiResource('carros', CarController::class);

    Route::apiResource('clientes', CustomerController::class);

    Route::apiResource('vendas', SaleController::class);

    Route::get('/postal-code', [PostalCodeController::class, 'findAddress']);
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Rota não encontrada.'
    ], 404);
});

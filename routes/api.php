<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarteVisiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get("/test", [AuthController::class, "test"]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource('cartes-visites', CarteVisiteController::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/index', [CarteVisiteController::class, 'index']);
    Route::post('/cartes-visites', [CarteVisiteController::class, 'store']);
    Route::put('/cartes-visites/{id}', [CarteVisiteController::class, 'update']);
    Route::delete('/cartes-visites/{id}', [CarteVisiteController::class, 'destroy']);
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

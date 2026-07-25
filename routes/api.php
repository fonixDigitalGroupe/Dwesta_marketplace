<?php

use App\Http\Controllers\Api\AnnonceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API (application mobile React Native) — auth par token Sanctum
|--------------------------------------------------------------------------
*/

// Authentification
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// Catalogue public
Route::get('/annonces', [AnnonceController::class, 'index'])->name('api.annonces.index');
Route::get('/annonces/{annonce}', [AnnonceController::class, 'show'])->name('api.annonces.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('api.categories.index');

// Routes protégées (token requis)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me'])->name('api.me');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
});

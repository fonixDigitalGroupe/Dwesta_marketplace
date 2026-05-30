<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColisController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/packages/receive', [PackageController::class, 'receive'])->name('packages.receive');
    Route::post('/packages/release', [PackageController::class, 'release'])->name('packages.release');

    // Opérations
    Route::get('/litiges', [OperationController::class, 'litiges'])->name('operations.litiges');
    Route::get('/journal', [OperationController::class, 'journal'])->name('operations.journal');
    Route::get('/statistiques', [OperationController::class, 'statistiques'])->name('operations.stats');

    // Finances
    Route::get('/commissions', [FinanceController::class, 'commissions'])->name('finances.commissions');
    Route::get('/paiements', [FinanceController::class, 'paiements'])->name('finances.paiements');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/agence', [ProfileController::class, 'updateAgence'])->name('profile.agence.update');
    Route::post('/profile/users', [ProfileController::class, 'storeUser'])->name('profile.users.store');
    Route::patch('/profile/users/{user}', [ProfileController::class, 'updateUser'])->name('profile.users.update');
    Route::delete('/profile/users/{user}', [ProfileController::class, 'destroyUser'])->name('profile.users.destroy');

    // Gestion du Stock (Colis)
    Route::get('/stock', [ColisController::class, 'index'])->name('operations.stock');
    Route::post('/stock/scan', [ColisController::class, 'scan'])->name('colis.scan');
    Route::post('/stock/{order}/receive', [ColisController::class, 'receive'])->name('colis.receive');
    Route::post('/stock/{order}/deliver', [ColisController::class, 'deliver'])->name('colis.deliver');
});

require __DIR__.'/auth.php';

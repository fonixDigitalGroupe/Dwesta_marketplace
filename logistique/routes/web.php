<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/missions/available', [MissionController::class, 'available'])->name('missions.available');
    Route::get('/missions/earnings', [MissionController::class, 'earnings'])->name('missions.earnings');
    Route::get('/missions/{order}', [MissionController::class, 'show'])->name('missions.show');
    Route::post('/missions/{order}/accept', [MissionController::class, 'accept'])->name('missions.accept');
    Route::post('/missions/{order}/deliver', [MissionController::class, 'deliver'])->name('missions.deliver');
    Route::post('/location/update', [MissionController::class, 'updateLocation'])->name('location.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

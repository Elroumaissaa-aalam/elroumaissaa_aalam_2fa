<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/2fa/enable', [ProfileController::class, 'enable2fa'])->name('profile.2fa.enable');
    Route::get('/profile/2fa/verify', [ProfileController::class, 'show2faVerify'])->name('profile.2fa.verify');
    Route::post('/profile/2fa/check', [ProfileController::class, 'check2faCode'])->name('profile.2fa.check');
    Route::post('/profile/2fa/disable', [ProfileController::class, 'disable2fa'])->name('profile.2fa.disable');
    Route::get('/profile/2fa/disable/verify', [ProfileController::class, 'show2faDisableVerify'])->name('profile.2fa.disable.verify');
    Route::post('/profile/2fa/disable/check', [ProfileController::class, 'check2faDisableCode'])->name('profile.2fa.disable.check');
});

Route::get('/login/2fa', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'show2faVerify'])->name('auth.2fa.verify');
Route::post('/login/2fa', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'check2faCode'])->name('auth.2fa.check');

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IncomingLetterController;
use App\Http\Controllers\OutgoingLetterController;
use App\Http\Controllers\DispositionController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\LetterStatusController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/', [PageController::class, 'index'])->name('home');
    Route::get('profile', [PageController::class, 'profile'])->name('profile.show');
    Route::put('profile', [PageController::class, 'profileUpdate'])->name('profile.update');
    Route::delete('attachment', [PageController::class, 'removeAttachment'])->name('attachment.destroy');

    // Admin Only
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('user', UserController::class)->except(['show', 'edit', 'create']);
        Route::get('settings', [PageController::class, 'settings'])->name('settings.show');
        Route::put('settings', [PageController::class, 'settingsUpdate'])->name('settings.update');
    });

    // Staff Only
    Route::middleware(['role:staff'])->group(function () {
        Route::put('profile/deactivate', [PageController::class, 'deactivate'])->name('profile.deactivate');
    });

    // TRANSACTION: Izinkan admin, staff, dan siswa
    Route::middleware(['role:admin,staff,siswa'])->group(function () {
        Route::prefix('transaction')->as('transaction.')->group(function () {
            Route::resource('incoming', IncomingLetterController::class);
            Route::resource('outgoing', OutgoingLetterController::class);
            Route::resource('{letter}/disposition', DispositionController::class)->except(['show']);
        });
    });

    // AGENDA
    Route::prefix('agenda')->as('agenda.')->group(function () {
        Route::get('incoming', [IncomingLetterController::class, 'agenda'])->name('incoming');
        Route::get('incoming/print', [IncomingLetterController::class, 'print'])->name('incoming.print');
        Route::get('outgoing', [OutgoingLetterController::class, 'agenda'])->name('outgoing');
        Route::get('outgoing/print', [OutgoingLetterController::class, 'print'])->name('outgoing.print');
    });

    // REFERENCE (Admin Only)
    Route::prefix('reference')
        ->as('reference.')
        ->middleware(['role:admin'])
        ->group(function () {
        Route::resource('classification', ClassificationController::class)->except(['show', 'create', 'edit']);
        Route::resource('status', LetterStatusController::class)->except(['show', 'create', 'edit']);
    });

});

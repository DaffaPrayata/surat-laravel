<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IncomingLetterController;
use App\Http\Controllers\OutgoingLetterController;
use App\Http\Controllers\DispositionController;
use App\Http\Controllers\LetterGalleryController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\LetterStatusController;

/*
|--------------------------------------------------------------------------
| AUTH (TANPA middleware auth)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| APP (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/', [PageController::class, 'index'])
        ->name('home');

    Route::resource('user', UserController::class)
        ->except(['show', 'edit', 'create'])
        ->middleware(['role:admin']);

    Route::get('profile', [PageController::class, 'profile'])
        ->name('profile.show');

    Route::put('profile', [PageController::class, 'profileUpdate'])
        ->name('profile.update');

    Route::put('profile/deactivate', [PageController::class, 'deactivate'])
        ->name('profile.deactivate')
        ->middleware(['role:staff']);

    Route::get('settings', [PageController::class, 'settings'])
        ->name('settings.show')
        ->middleware(['role:admin']);

    Route::put('settings', [PageController::class, 'settingsUpdate'])
        ->name('settings.update')
        ->middleware(['role:admin']);

    Route::delete('attachment', [PageController::class, 'removeAttachment'])
        ->name('attachment.destroy');

    Route::prefix('transaction')->as('transaction.')->group(function () {
        Route::resource('incoming', IncomingLetterController::class);
        Route::resource('outgoing', OutgoingLetterController::class);
        Route::resource('{letter}/disposition', DispositionController::class)
            ->except(['show']);
    });

    Route::prefix('agenda')->as('agenda.')->group(function () {
        Route::get('incoming', [IncomingLetterController::class, 'agenda'])
            ->name('incoming');
        Route::get('incoming/print', [IncomingLetterController::class, 'print'])
            ->name('incoming.print');

        Route::get('outgoing', [OutgoingLetterController::class, 'agenda'])
            ->name('outgoing');
        Route::get('outgoing/print', [OutgoingLetterController::class, 'print'])
            ->name('outgoing.print');
    });

    Route::prefix('gallery')->as('gallery.')->group(function () {
        Route::get('incoming', [LetterGalleryController::class, 'incoming'])
            ->name('incoming');
        Route::get('outgoing', [LetterGalleryController::class, 'outgoing'])
            ->name('outgoing');
    });

    Route::prefix('reference')
        ->as('reference.')
        ->middleware(['role:admin'])
        ->group(function () {

        Route::resource('classification', ClassificationController::class)
            ->except(['show', 'create', 'edit']);

        Route::resource('status', LetterStatusController::class)
            ->except(['show', 'create', 'edit']);
    });
});

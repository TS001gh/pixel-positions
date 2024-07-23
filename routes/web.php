<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', [JobController::class, 'index']);

Route::get('/search', SearchController::class);

Route::middleware('guest')->group(function () {

    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {

    Route::middleware('verified')->group(function () {
        Route::get('/jobs/create', [JobController::class, 'create']);
        Route::post('/jobs', [JobController::class, 'store']);
        Route::get('/jobs/{id}', [JobController::class, 'show']);
        Route::get('/jobs/edit/{job}', [JobController::class, 'edit']);
        Route::patch('/jobs/{job}', [JobController::class, 'update']);
        Route::delete('/jobs/{job}', [JobController::class, 'destroy']);

        // the identifier here is the name of the tag not the by default
        // laravel will say : select * from tags where name = "frontend"
        Route::get('/tags/{tag:name}', TagController::class);

        Route::delete('/logout', [SessionController::class, 'destroy']);
    });


    // Email verification notice route
    Route::get('/email/verify', [RegisteredUserController::class, 'verifyNotice'])->name('verification.notice');

    // Email verification handler
    Route::get('/email/verify/{id}/{hash}', [RegisteredUserController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');

    // Resending email verification notice route
    // throttle: is used here to avoid submitting the form many times
    Route::post('/email/verification-notification', [RegisteredUserController::class, 'verifyHandler'])->middleware(['throttle:6,1'])->name('verification.send');
});

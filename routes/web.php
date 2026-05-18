<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YouTubeController;
use App\Support\SessionUser;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RedditController;

Route::get('/', [YouTubeController::class, 'index']);

Route::get('/watch_youtube/{id}', [YouTubeController::class, 'watch']);

Route::get('/login-admin', [App\Http\Controllers\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::middleware('session.auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\LoginController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
// Reddit routes
Route::get('/reddit', [RedditController::class, 'index']);
Route::get('/watch_reddit/{id}', [RedditController::class, 'show']);

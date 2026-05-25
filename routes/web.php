<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YouTubeController;
use App\Support\SessionUser;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RedditController;
use App\Http\Controllers\BloggerController;

// Route::get('/', [YouTubeController::class, 'index']);


Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::get('/', [App\Http\Controllers\LoginController::class, 'dashboard'])->name('dashboard');
Route::get('/login-admin', [App\Http\Controllers\LoginController::class, 'showLoginForm'])->name('login');
Route::middleware('session.auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\LoginController::class, 'dashboard'])->name('dashboard');
    // Route::get('/', [YouTubeController::class, 'index']);
    Route::get('/watch_youtube/{id}', [YouTubeController::class, 'watch']);
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Reddit routes
    Route::get('/reddit', [RedditController::class, 'index']);
    Route::get('/watch_reddit/{id}', [RedditController::class, 'show']);

    // Blogger routes
    Route::get('/blogger', [BloggerController::class, 'index'])->name('blog.index');
    Route::get('/blogger/{blogId}/post/{postId}', [BloggerController::class, 'show'])->name('blog.show');
});

<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BloggerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswordRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RedditController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\YouTubeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/login', [App\Http\Controllers\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.post');
Route::get('/forgot-password', [PasswordRequestController::class, 'create'])->name('password.request.form');
Route::post('/forgot-password', [PasswordRequestController::class, 'store'])->name('password.request.store');
Route::get('/video/{id}', [YouTubeController::class, 'watch'])->name('video.watch');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\LoginController::class, 'dashboard'])->name('dashboard');
    Route::get('/watch_youtube/{id}', [YouTubeController::class, 'watch']);
    Route::get('/reddit', [RedditController::class, 'index']);
    Route::get('/watch_reddit/{id}', [RedditController::class, 'show']);
    Route::get('/blogger', [BloggerController::class, 'index'])->name('blog.index');
    Route::get('/blogger/{blogId}/post/{postId}', [BloggerController::class, 'show'])->name('blog.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/reviews/{post}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
    Route::get('/password-requests', [PasswordRequestController::class, 'index'])->name('password-requests.index');
    Route::patch('/password-requests/{request}/approve', [PasswordRequestController::class, 'approve'])->name('password-requests.approve');
    Route::patch('/password-requests/{request}/deny', [PasswordRequestController::class, 'deny'])->name('password-requests.deny');
});


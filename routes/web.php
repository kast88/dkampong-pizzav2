<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BloggerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswordRequestController;
use App\Http\Controllers\ProductController;
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

Route::get('/menus', [ProductController::class, 'index'])->name('products.index');
Route::get('/menu/{product}', [ProductController::class, 'show'])->name('products.show');

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
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::post('/reviews/{post}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/reviews/{review}/react', [ReviewController::class, 'react'])->name('reviews.react');
    Route::post('/reviews/{review}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');

    Route::get('/menu', [ProductController::class, 'index'])->name('products.index');
    Route::get('/menu/{product}', [ProductController::class, 'show'])->name('products.show');
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

    Route::get('/products', [ProductController::class, 'adminIndex'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'adminShow'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

    Route::get('/menu', [ProductController::class, 'index'])->name('products.index');
    Route::get('/menu/{product}', [ProductController::class, 'show'])->name('products.show');
});

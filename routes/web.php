<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YouTubeController;
use App\Http\Controllers\RedditController;

Route::get('/', [YouTubeController::class, 'index']);

Route::get('/watch_youtube/{id}', [YouTubeController::class, 'watch']);

// Reddit routes
Route::get('/reddit', [RedditController::class, 'index']);
Route::get('/watch_reddit/{id}', [RedditController::class, 'show']);

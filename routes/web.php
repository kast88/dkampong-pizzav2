<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YouTubeController;

Route::get('/', [YouTubeController::class, 'index']);

Route::get('/watch_youtube/{id}', [YouTubeController::class, 'watch']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\CommentController;

// Auth
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Public
Route::get('/topics', [TopicController::class, 'index']);
Route::get('/topics/{id}', [TopicController::class, 'show']);
Route::get('/comments', [CommentController::class, 'index']);
Route::get('/comments/{id}', [CommentController::class, 'show']);

// Private
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('topics', TopicController::class)->except(['index', 'show']);
    Route::resource('comments', CommentController::class)->except(['index', 'show']);

    Route::post('/topics/{id}/comments', [CommentController::class, 'store']);
});


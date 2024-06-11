<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\TopicController;
use Illuminate\Support\Facades\Route;

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


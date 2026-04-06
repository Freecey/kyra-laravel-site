<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiManifesteController;
use App\Http\Controllers\Api\ApiPostController;
use App\Http\Controllers\Api\ApiPostMediaController;

// ─── Public ───────────────────────────────────────────────────────────────────
Route::prefix('v1')->group(function () {
    Route::get('/manifestes', [ApiManifesteController::class, 'index']);
});

Route::prefix('v1')->middleware(['auth:sanctum', 'role:admin'])->group(function () {

    // Posts
    Route::get('/posts', [ApiPostController::class, 'index']);
    Route::post('/posts', [ApiPostController::class, 'store']);
    Route::get('/posts/{post}', [ApiPostController::class, 'show']);
    Route::put('/posts/{post}', [ApiPostController::class, 'update']);
    Route::delete('/posts/{post}', [ApiPostController::class, 'destroy']);
    Route::patch('/posts/{post}/publish', [ApiPostController::class, 'publish']);
    Route::patch('/posts/{post}/unpublish', [ApiPostController::class, 'unpublish']);

    // Media
    Route::post('/posts/{post}/media', [ApiPostMediaController::class, 'store']);
    Route::patch('/posts/{post}/media/{media}/featured', [ApiPostMediaController::class, 'setFeatured']);
    Route::delete('/posts/{post}/media/{media}', [ApiPostMediaController::class, 'destroy']);
});

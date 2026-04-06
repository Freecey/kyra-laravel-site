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

    // Manifestes
    Route::get('/manifestes/all', [ApiManifesteController::class, 'all']);
    Route::post('/manifestes', [ApiManifesteController::class, 'store']);
    Route::get('/manifestes/{manifeste}', [ApiManifesteController::class, 'show']);
    Route::put('/manifestes/{manifeste}', [ApiManifesteController::class, 'update']);
    Route::delete('/manifestes/{manifeste}', [ApiManifesteController::class, 'destroy']);
    Route::patch('/manifestes/{manifeste}/pin', [ApiManifesteController::class, 'pin']);
    Route::patch('/manifestes/{manifeste}/unpin', [ApiManifesteController::class, 'unpin']);

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

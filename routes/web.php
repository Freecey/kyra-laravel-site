<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Member\AuthController as MemberAuthController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    $formEnabled = \App\Models\Setting::get('form_enabled', true);
    return view('pages.contact', compact('formEnabled'));
})->name('contact');

Route::get('/signal', function () {
    return view('pages.signal');
})->name('signal');

Route::get('/protocole', function () {
    return view('pages.protocole');
})->name('protocole');

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// ─── Admin ───────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth (unauthenticated)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected — admin role required
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('messages')->name('messages.')->group(function () {
            Route::get('/', [MessageController::class, 'index'])->name('index');
            Route::get('/{message}', [MessageController::class, 'show'])->name('show');
            Route::patch('/{message}/read', [MessageController::class, 'markRead'])->name('read');
            Route::patch('/{message}/unread', [MessageController::class, 'markUnread'])->name('unread');
            Route::delete('/{message}', [MessageController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::put('/', [SettingController::class, 'update'])->name('update');
        });

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [AdminProfileController::class, 'edit'])->name('edit');
            Route::put('/', [AdminProfileController::class, 'update'])->name('update');
        });
    });
});

// ─── Member ──────────────────────────────────────────────────────────────────
Route::prefix('member')->name('member.')->group(function () {
    // Auth (unauthenticated)
    Route::get('/login', [MemberAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [MemberAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [MemberAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [MemberAuthController::class, 'register'])->name('register.post');
    Route::post('/logout', [MemberAuthController::class, 'logout'])->name('logout');

    // Protected — member role required
    Route::middleware(['auth', 'role:member'])->group(function () {
        Route::get('/profile', [MemberProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [MemberProfileController::class, 'update'])->name('profile.update');
    });
});

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/robots.txt', function () {
    $content = "User-agent: *\nDisallow: /storage/\nDisallow: /vendor/\n\nSitemap: " . route('sitemap') . "\n";
    return response($content, 200)->header('Content-Type', 'text/plain');
});


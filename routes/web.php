<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ReplyController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\ToolboxController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\DocController;
use App\Http\Controllers\Member\AuthController as MemberAuthController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminBlogMediaController;

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

// ─── Blog (public) ───────────────────────────────────────────────────────────
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
});

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
            // Replies
            Route::post('/{message}/replies', [ReplyController::class, 'store'])->name('replies.store');
            Route::get('/replies/{reply}/attachments/{attachment}', [ReplyController::class, 'downloadAttachment'])->name('replies.attachment');
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
            Route::post('/tokens', [AdminProfileController::class, 'tokenCreate'])->name('tokens.create');
            Route::delete('/tokens/{tokenId}', [AdminProfileController::class, 'tokenRevoke'])->name('tokens.revoke');
        });

        Route::get('/stats', [StatsController::class, 'index'])->name('stats');

        // ─── Blog admin ───────────────────────────────────────────────────────
        Route::prefix('blog')->name('blog.')->group(function () {
            Route::get('/', [AdminBlogController::class, 'index'])->name('index');
            Route::get('/create', [AdminBlogController::class, 'create'])->name('create');
            Route::post('/', [AdminBlogController::class, 'store'])->name('store');
            Route::get('/{post}/edit', [AdminBlogController::class, 'edit'])->name('edit');
            Route::put('/{post}', [AdminBlogController::class, 'update'])->name('update');
            Route::delete('/{post}', [AdminBlogController::class, 'destroy'])->name('destroy');
            Route::patch('/{post}/publish', [AdminBlogController::class, 'publish'])->name('publish');
            Route::patch('/{post}/unpublish', [AdminBlogController::class, 'unpublish'])->name('unpublish');
            // Media
            Route::post('/{post}/media', [AdminBlogMediaController::class, 'store'])->name('media.store');
            Route::patch('/{post}/media/{media}/featured', [AdminBlogMediaController::class, 'setFeatured'])->name('media.featured');
            Route::delete('/{post}/media/{media}', [AdminBlogMediaController::class, 'destroy'])->name('media.destroy');
        });

        Route::prefix('toolbox')->name('toolbox')->group(function () {
            Route::get('/', [ToolboxController::class, 'index']);
            Route::post('/send-email', [ToolboxController::class, 'sendEmail'])->name('.send-email');
            Route::post('/artisan', [ToolboxController::class, 'runArtisan'])->name('.artisan');
            Route::get('/error/{code}', [ToolboxController::class, 'triggerError'])->name('.error')->whereNumber('code');
        });

        Route::prefix('logs')->name('logs')->group(function () {
            Route::get('/', [LogController::class, 'index']);
            Route::post('/clear', [LogController::class, 'clear'])->name('.clear');
            Route::get('/download', [LogController::class, 'download'])->name('.download');
        });

        Route::prefix('doc')->name('doc.')->group(function () {
            Route::get('/api', [DocController::class, 'api'])->name('api');
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


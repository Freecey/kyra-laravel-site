<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SitemapController;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/signal', function () {
    return view('pages.signal');
})->name('signal');

Route::get('/protocole', function () {
    return view('pages.protocole');
})->name('protocole');

Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|min:10'
    ]);
    
    // Log the message (could be sent via email, stored in DB, etc.)
    \Log::info('Contact message received', $validated);
    
    return response()->json(['success' => true]);
});

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/robots.txt', function () {
    $content = "User-agent: *\nDisallow: /storage/\nDisallow: /vendor/\n\nSitemap: " . route('sitemap') . "\n";
    return response($content, 200)->header('Content-Type', 'text/plain');
});


<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\PageView;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMessages  = ContactMessage::count();
        $unreadMessages = ContactMessage::where('is_read', false)->count();
        $recentMessages = ContactMessage::latest()->take(5)->get();

        $recentUsers    = User::latest()->take(5)->get();
        $totalUsers     = User::count();

        $viewsToday = PageView::whereDate('viewed_on', today())->count();
        $viewsWeek  = PageView::where('viewed_on', '>=', now()->subDays(6)->startOfDay())->count();
        $viewsMonth = PageView::where('viewed_on', '>=', now()->subDays(29)->startOfDay())->count();

        return view('admin.dashboard', compact(
            'totalMessages', 'unreadMessages', 'recentMessages',
            'recentUsers', 'totalUsers',
            'viewsToday', 'viewsWeek', 'viewsMonth'
        ));
    }
}

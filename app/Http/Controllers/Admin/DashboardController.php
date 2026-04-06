<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\PageView;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

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

        $systemStatus = $this->buildSystemStatus();

        return view('admin.dashboard', compact(
            'totalMessages', 'unreadMessages', 'recentMessages',
            'recentUsers', 'totalUsers',
            'viewsToday', 'viewsWeek', 'viewsMonth',
            'systemStatus'
        ));
    }

    private function buildSystemStatus(): array
    {
        try {
            DB::connection()->getPdo();
            $dbOk = true;
        } catch (\Throwable) {
            $dbOk = false;
        }

        $dbDriver = Config::get('database.default');
        $dbSize   = null;
        if ($dbDriver === 'sqlite') {
            $dbPath = Config::get('database.connections.sqlite.database');
            $dbSize = file_exists($dbPath) ? filesize($dbPath) : null;
        }

        $storagePath = storage_path();
        $diskFree    = disk_free_space($storagePath);
        $diskTotal   = disk_total_space($storagePath);
        $diskUsedPct = $diskTotal > 0 ? round((1 - $diskFree / $diskTotal) * 100) : 0;

        $storageWritable = is_writable(storage_path('logs'))
            && is_writable(storage_path('framework/cache'));

        $logPath = storage_path('logs/laravel.log');
        $logSize = file_exists($logPath) ? filesize($logPath) : 0;

        $requiredExts = ['pdo', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath', 'fileinfo'];
        $extensions   = collect($requiredExts)->map(fn ($e) => [
            'name'   => $e,
            'loaded' => extension_loaded($e),
        ]);

        return [
            'php_version'      => PHP_VERSION,
            'laravel_version'  => app()->version(),
            'app_env'          => Config::get('app.env'),
            'app_debug'        => Config::get('app.debug'),
            'db_driver'        => $dbDriver,
            'db_ok'            => $dbOk,
            'db_size'          => $dbSize,
            'cache_driver'     => Config::get('cache.default'),
            'queue_driver'     => Config::get('queue.default'),
            'disk_free'        => $diskFree,
            'disk_total'       => $diskTotal,
            'disk_used_pct'    => $diskUsedPct,
            'storage_writable' => $storageWritable,
            'log_size'         => $logSize,
            'extensions'       => $extensions,
        ];
    }
}

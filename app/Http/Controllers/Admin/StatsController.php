<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\PageView;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StatsController extends Controller
{
    public function index()
    {
        $today     = Carbon::today();
        $week      = Carbon::today()->subDays(6);
        $month     = Carbon::today()->subDays(29);

        // ── Totaux ────────────────────────────────────────────────────
        $totalToday = PageView::whereDate('viewed_on', $today)->count();
        $totalWeek  = PageView::where('viewed_on', '>=', $week)->count();
        $totalMonth = PageView::where('viewed_on', '>=', $month)->count();

        // ── Visiteurs uniques (par ip_hash) sur 30 jours
        $uniqueMonth = PageView::where('viewed_on', '>=', $month)
            ->distinct('ip_hash')
            ->count('ip_hash');

        // Visiteurs uniques par session sur 30 jours (plus précis)
        $uniqueSessionsMonth = PageView::where('viewed_on', '>=', $month)
            ->whereNotNull('session_hash')
            ->distinct('session_hash')
            ->count('session_hash');

        // ── Bar chart : 14 derniers jours ─────────────────────────────
        $days = collect();
        for ($i = 13; $i >= 0; $i--) {
            $days->push(Carbon::today()->subDays($i)->toDateString());
        }

        $rawDaily = PageView::select(DB::raw('viewed_on, count(*) as total'))
            ->where('viewed_on', '>=', Carbon::today()->subDays(13))
            ->groupBy('viewed_on')
            ->pluck('total', 'viewed_on');

        $daily = $days->map(fn($d) => [
            'date'  => $d,
            'label' => Carbon::parse($d)->format('d/m'),
            'count' => (int) ($rawDaily[$d] ?? 0),
        ]);

        $dailyMax = max($daily->max('count'), 1);

        // ── Top 15 pages (30 jours) ───────────────────────────────────
        $topPages = PageView::select('path', DB::raw('count(*) as total'))
            ->where('viewed_on', '>=', $month)
            ->groupBy('path')
            ->orderByDesc('total')
            ->limit(15)
            ->get();

        $topMax = max($topPages->max('total') ?? 1, 1);

        // ── Répartition rôles (30 jours) ──────────────────────────────
        $byRole = PageView::select('user_role', DB::raw('count(*) as total'))
            ->where('viewed_on', '>=', $month)
            ->groupBy('user_role')
            ->pluck('total', 'user_role');

        $roleTotal = max($byRole->sum(), 1);

        // ── Trafic par jour de la semaine (30 jours) ──────────────────
        $rawDow = PageView::select(DB::raw("CAST(strftime('%w', viewed_on) AS INTEGER) as dow, count(*) as total"))
            ->where('viewed_on', '>=', $month)
            ->groupBy('dow')
            ->pluck('total', 'dow');

        $dowLabels = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
        $dow = collect(range(0, 6))->map(fn($d) => [
            'label' => $dowLabels[$d],
            'count' => (int) ($rawDow[$d] ?? 0),
        ]);
        $dowMax = max($dow->max('count'), 1);

        // ── Répartition appareils (30 jours) ─────────────────────────
        $byDevice = PageView::select('device_type', DB::raw('count(*) as total'))
            ->where('viewed_on', '>=', $month)
            ->groupBy('device_type')
            ->pluck('total', 'device_type');

        $deviceTotal = max($byDevice->sum(), 1);

        // ── Top référents (30 jours) ──────────────────────────────────
        $topReferers = PageView::select('referer_host', DB::raw('count(*) as total'))
            ->where('viewed_on', '>=', $month)
            ->whereNotNull('referer_host')
            ->groupBy('referer_host')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $directCount   = PageView::where('viewed_on', '>=', $month)->whereNull('referer_host')->count();
        $refererMax    = max($topReferers->max('total') ?? 1, $directCount, 1);

        // ── Messages ──────────────────────────────────────────────────
        $totalMessages  = ContactMessage::count();
        $unreadMessages = ContactMessage::where('is_read', false)->count();
        $messagesMonth  = ContactMessage::where('created_at', '>=', $month)->count();

        return view('admin.stats.index', compact(
            'totalToday', 'totalWeek', 'totalMonth', 'uniqueMonth', 'uniqueSessionsMonth',
            'daily', 'dailyMax',
            'topPages', 'topMax',
            'byRole', 'roleTotal',
            'dow', 'dowMax',
            'byDevice', 'deviceTotal',
            'topReferers', 'directCount', 'refererMax',
            'totalMessages', 'unreadMessages', 'messagesMonth'
        ));
    }
}

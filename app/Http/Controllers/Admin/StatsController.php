<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        // Visiteurs uniques (par ip_hash) sur 30 jours
        $uniqueMonth = PageView::where('viewed_on', '>=', $month)
            ->distinct('ip_hash')
            ->count('ip_hash');

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

        return view('admin.stats.index', compact(
            'totalToday', 'totalWeek', 'totalMonth', 'uniqueMonth',
            'daily', 'dailyMax',
            'topPages', 'topMax',
            'byRole', 'roleTotal'
        ));
    }
}

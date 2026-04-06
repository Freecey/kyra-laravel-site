<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LogController extends Controller
{
    private const MAX_BYTES   = 300 * 1024; // 300 KB lus depuis la fin
    private const MAX_ENTRIES = 200;

    public function index(Request $request)
    {
        $logPath = storage_path('logs/laravel.log');
        $entries  = [];
        $fileSize = 0;

        if (file_exists($logPath)) {
            $fileSize = filesize($logPath);
            $content  = $this->readTail($logPath, self::MAX_BYTES);
            $entries  = $this->parseLogs($content);
        }

        $levelFilter = $request->input('level');
        if ($levelFilter) {
            $entries = array_values(
                array_filter($entries, fn ($e) => $e['level'] === strtoupper($levelFilter))
            );
        }

        // Plus récents en premier, limité à MAX_ENTRIES
        $entries = array_slice(array_reverse($entries), 0, self::MAX_ENTRIES);

        return view('admin.logs.index', [
            'entries'     => $entries,
            'fileSize'    => $fileSize,
            'levelFilter' => $levelFilter,
            'levels'      => ['DEBUG', 'INFO', 'NOTICE', 'WARNING', 'ERROR', 'CRITICAL', 'ALERT', 'EMERGENCY'],
        ]);
    }

    public function clear()
    {
        file_put_contents(storage_path('logs/laravel.log'), '');

        return redirect()->route('admin.logs')->with('success', 'Journal effacé.');
    }

    public function download()
    {
        $path = storage_path('logs/laravel.log');
        abort_unless(file_exists($path) && filesize($path) > 0, 404);

        return response()->download($path, 'laravel-' . now()->format('Ymd-His') . '.log');
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    private function readTail(string $path, int $bytes): string
    {
        $size = filesize($path);
        $fp   = fopen($path, 'rb');

        if ($size > $bytes) {
            fseek($fp, -$bytes, SEEK_END);
            fgets($fp); // ignore partial first line
        }

        $content = stream_get_contents($fp);
        fclose($fp);

        return $content;
    }

    private function parseLogs(string $content): array
    {
        // Chaque entrée commence par [YYYY-MM-DD HH:MM:SS]
        $pattern = '/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.*?)(?=^\[\d{4}-\d{2}-\d{2}|\z)/ms';
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

        return array_map(function ($m) {
            $full    = rtrim($m[4]);
            $firstNl = strpos($full, "\n");
            $summary = $firstNl !== false ? substr($full, 0, $firstNl) : $full;

            return [
                'timestamp' => $m[1],
                'env'       => $m[2],
                'level'     => strtoupper($m[3]),
                'summary'   => Str::limit($summary, 200),
                'detail'    => $full,
                'has_detail' => $firstNl !== false,
            ];
        }, $matches);
    }
}

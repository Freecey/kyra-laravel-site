<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ToolboxController extends Controller
{
    // Whitelist stricte — aucune commande arbitraire n'est acceptée
    public const ARTISAN_COMMANDS = [
        'cache:clear'    => 'Vider le cache applicatif',
        'config:clear'   => 'Vider le cache de configuration',
        'config:cache'   => 'Reconstruire le cache de configuration',
        'view:clear'     => 'Vider les vues compilées',
        'route:clear'    => 'Vider le cache de routes',
        'optimize:clear' => 'Tout vider (cache, config, vues, routes)',
        'migrate:status' => 'État des migrations',
        'storage:link'   => 'Créer le lien symbolique storage',
    ];

    public function index()
    {
        $mailConfig = [
            'driver'   => Config::get('mail.default'),
            'host'     => Config::get('mail.mailers.smtp.host'),
            'port'     => Config::get('mail.mailers.smtp.port'),
            'from'     => Config::get('mail.from.address'),
        ];

        $systemStatus = $this->buildSystemStatus();

        return view('admin.toolbox.index', [
            'mailConfig'   => $mailConfig,
            'commands'     => self::ARTISAN_COMMANDS,
            'systemStatus' => $systemStatus,
        ]);
    }

    private function buildSystemStatus(): array
    {
        // ── Base de données ───────────────────────────────────────────
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

        // ── Disque ────────────────────────────────────────────────────
        $storagePath  = storage_path();
        $diskFree     = disk_free_space($storagePath);
        $diskTotal    = disk_total_space($storagePath);
        $diskUsedPct  = $diskTotal > 0 ? round((1 - $diskFree / $diskTotal) * 100) : 0;

        // ── Storage writable ──────────────────────────────────────────
        $storageWritable = is_writable(storage_path('logs'))
            && is_writable(storage_path('framework/cache'));

        // ── Log courant ───────────────────────────────────────────────
        $logPath = storage_path('logs/laravel.log');
        $logSize = file_exists($logPath) ? filesize($logPath) : 0;

        // ── Extensions PHP requises ───────────────────────────────────
        $requiredExts = ['pdo', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath', 'fileinfo'];
        $extensions   = collect($requiredExts)->map(fn($e) => [
            'name'    => $e,
            'loaded'  => extension_loaded($e),
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

    public function sendEmail(Request $request)
    {
        $request->validate([
            'to' => ['required', 'email', 'max:254'],
        ]);

        try {
            app(MailService::class)->sendRaw(
                $request->input('to'),
                '[KYRA] Test d\'envoi d\'email — ' . now()->format('d/m/Y H:i'),
                'Ceci est un email de test envoyé depuis la boîte à outils KYRA Admin.'
            );

            return redirect()->route('admin.toolbox')->with('success', 'Email de test envoyé à ' . $request->input('to') . '.');
        } catch (\Throwable $e) {
            return redirect()->route('admin.toolbox')->with('error', 'Échec de l\'envoi : ' . $e->getMessage());
        }
    }

    public function runArtisan(Request $request)
    {
        $command = $request->input('command');

        if (! array_key_exists($command, self::ARTISAN_COMMANDS)) {
            return redirect()->route('admin.toolbox')->with('artisan_result', [
                'command' => $command,
                'output'  => 'Commande non autorisée.',
                'status'  => 1,
            ]);
        }

        try {
            $status = Artisan::call($command);
            $output = Artisan::output() ?: '(aucune sortie)';
        } catch (\Throwable $e) {
            $status = 1;
            $output = $e->getMessage();
        }

        return redirect()->route('admin.toolbox')->with('artisan_result', [
            'command' => $command,
            'output'  => trim($output),
            'status'  => $status,
        ]);
    }

    public function triggerError(int $code)
    {
        $allowed = [404, 500, 503];

        if (! in_array($code, $allowed, true)) {
            abort(404);
        }

        abort($code);
    }
}


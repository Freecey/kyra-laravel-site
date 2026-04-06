<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    /** Routes/paths à ignorer */
    private const EXCLUDED_PATHS = [
        'admin',
        'up',
        'sitemap.xml',
        'robots.txt',
        'altcha-challenge',
        'favicon.ico',
    ];

    /** Fragments de user-agent bots courants */
    private const BOT_AGENTS = [
        'bot', 'crawl', 'spider', 'slurp', 'mediapartners',
        'baiduspider', 'yandex', 'sogou', 'exabot', 'facebot',
        'ia_archiver', 'curl', 'wget', 'python', 'go-http',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->shouldTrack($request, $response)) {
            $this->record($request);
        }

        return $response;
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        // GET uniquement
        if (!$request->isMethod('GET')) {
            return false;
        }

        // Réponses non-2xx ignorées (404, 500…)
        if ($response->getStatusCode() >= 400) {
            return false;
        }

        // Exclure certains paths
        $path = ltrim($request->path(), '/');
        foreach (self::EXCLUDED_PATHS as $excluded) {
            if ($path === $excluded || str_starts_with($path, $excluded . '/')) {
                return false;
            }
        }

        // Exclure bots
        $ua = strtolower($request->userAgent() ?? '');
        foreach (self::BOT_AGENTS as $bot) {
            if (str_contains($ua, $bot)) {
                return false;
            }
        }

        return true;
    }

    private function record(Request $request): void
    {
        $user = $request->user();

        if ($user?->isAdmin()) {
            $role = 'admin';
        } elseif ($user?->isMember()) {
            $role = 'member';
        } else {
            $role = 'guest';
        }

        try {
            PageView::create([
                'path'       => '/' . ltrim($request->path(), '/'),
                'route_name' => $request->route()?->getName(),
                'user_role'  => $role,
                'ip_hash'    => hash('sha256', $request->ip()),
                'viewed_on'  => now()->toDateString(),
            ]);
        } catch (\Throwable) {
            // Ne jamais bloquer la réponse pour un log d'analytics
        }
    }
}

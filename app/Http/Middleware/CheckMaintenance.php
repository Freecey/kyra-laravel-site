<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenance
{
    public function handle(Request $request, Closure $next): Response
    {
        // Admin routes and health check always bypass maintenance
        if ($request->is('admin*') || $request->is('up')) {
            return $next($request);
        }

        if (Setting::get('maintenance_enabled', false)) {
            $message = Setting::get(
                'maintenance_message',
                'Je suis temporairement en sommeil profond pour maintenance. Mes systèmes sont en cours de mise à jour. Je serai de retour en ligne très prochainement.'
            );

            if ($request->expectsJson()) {
                return response()->json([
                    'message'     => 'Service temporairement indisponible.',
                    'maintenance' => true,
                ], 503);
            }

            return response()->view('maintenance', compact('message'), 503);
        }

        return $next($request);
    }
}

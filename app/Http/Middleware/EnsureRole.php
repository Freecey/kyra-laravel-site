<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || $request->user()->role !== $role) {
            if ($role === 'admin') {
                return redirect()->route('admin.login');
            }
            return redirect()->route('member.login');
        }

        return $next($request);
    }
}

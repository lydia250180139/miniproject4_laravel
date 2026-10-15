<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if (! in_array($request->user()->role, $roles, true)) {
            abort(403, 'Akses Terlarang: Anda tidak memiliki izin untuk mengakses halaman ini. Halaman ini memerlukan hak akses khusus (' . implode(', ', array_map('strtoupper', $roles)) . ').');
        }

        return $next($request);
    }
}

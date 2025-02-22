<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Nasabah
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!in_array(auth()->user()->role, ['admin', 'dokter', 'apoteker'])) {
            abort(403, 'Hanya untuk admin, dokter, atau operator');
        }

        return $next($request);
    }
}

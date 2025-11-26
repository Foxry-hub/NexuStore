<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PelangganMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized action.');
        }
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isPelanggan()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}

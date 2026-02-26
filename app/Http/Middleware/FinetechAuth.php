<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FinetechAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $type): Response
    {
        $type = strtolower($type);

        if ($type === 'auth' && !Auth::check()) {
            return redirect()->route('finetech.login');
        }

        if ($type === 'guest' && Auth::check()) {
            return redirect()->route('finetech.dashboard');
        }

        return $next($request);
    }
}

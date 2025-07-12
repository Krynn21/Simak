<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (Auth::check() && Auth::user()->role?->name === 'admin') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Akses hanya untuk admin.');
    }
}

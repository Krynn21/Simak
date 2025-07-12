<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
{
    if (!Auth::check() || Auth::user()->id_role != $this->mapRole($role)) {
        abort(403, 'Unauthorized');
    }

    return $next($request);
}

protected function mapRole($role)
{
    return match ($role) {
        'admin' => 1,
        'guru' => 2,
        default => throw new \InvalidArgumentException("Role '{$role}' tidak dikenali.")
    };
}

}

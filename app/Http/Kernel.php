<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

protected $routeMiddleware = [
    // middleware bawaan...
    'auth' => \App\Http\Middleware\Authenticate::class,
    // 'admin' => \App\Http\Middleware\RoleAdmin::class,
    'role' => \App\Http\Middleware\RoleMiddleware::class,
];
}

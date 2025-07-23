<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
class Kernel extends HttpKernel
{
    // Global middleware
    protected $middleware = [
        // Global middleware here...
    ];

    // 👇 Yeh part me aap `web` aur `api` middleware groups define karte ho
    protected $middlewareGroups = [
       'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        // \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],

      'api' => [
        EnsureFrontendRequestsAreStateful::class, 
        'throttle:api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
    ];

    // Middleware aliases (optional)
    protected $middlewareAliases = [
        // e.g. 'auth' => \App\Http\Middleware\Authenticate::class,
    ];
}

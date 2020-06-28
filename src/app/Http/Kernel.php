<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \App\Http\Middleware\SecurityHeaders::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        /*
         * Doctor middlewares
         */
        'doctor.auth'               => \App\Http\Middleware\Doctor\Authenticate::class,
        'doctor.guest'              => \App\Http\Middleware\Doctor\RedirectIfAuthenticated::class,
        'doctor.values'             => \App\Http\Middleware\Doctor\SetDefaultValues::class,

        'entrust.role'              => \Zizaco\Entrust\Middleware\EntrustRole::class,
        'entrust.permission'        => \Zizaco\Entrust\Middleware\EntrustPermission::class,
        'entrust.ability'           => \Zizaco\Entrust\Middleware\EntrustAbility::class,
    ];
}

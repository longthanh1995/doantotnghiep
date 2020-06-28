<?php

namespace App\Providers;

use App\Models\ManaUser;
use App\Models\Patient;
use App\Services\DoctorServiceInterface;
use App\Services\Production\DoctorService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class ServiceBindServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            '1' => ManaUser::class,
            '2' => Patient::class
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*
         * Admin bindings
         */
        $this->app->singleton(\App\Services\AdminUserServiceInterface::class, \App\Services\Production\AdminUserService::class);

        $this->app->singleton(\App\Services\AuthenticatableServiceInterface::class,
            \App\Services\Production\AuthenticatableService::class);

        $this->app->singleton(\App\Services\BaseServiceInterface::class, \App\Services\Production\BaseService::class);

        $this->app->singleton(\App\Services\FileUploadServiceInterface::class,
            \App\Services\Production\FileUploadService::class);

        $this->app->singleton(\App\Services\ImageServiceInterface::class, \App\Services\Production\ImageService::class);

        $this->app->singleton(\App\Services\LanguageDetectionServiceInterface::class,
            \App\Services\Production\LanguageDetectionService::class);

        $this->app->singleton(\App\Services\MailServiceInterface::class, \App\Services\Production\MailService::class);

        $this->app->singleton(\App\Services\ServiceAuthenticationServiceInterface::class,
            \App\Services\Production\ServiceAuthenticationService::class);

        $this->app->singleton(\App\Services\UserServiceAuthenticationServiceInterface::class,
            \App\Services\Production\UserServiceAuthenticationService::class);

        $this->app->singleton(\App\Services\UserServiceInterface::class, \App\Services\Production\UserService::class);

        $this->app->singleton(
            \App\Services\NotificationServiceInterface::class,
            \App\Services\Production\NotificationService::class
        );

        $this->app->singleton(
            \App\Services\TeleconsultServiceInterface::class,
            \App\Services\Production\TeleconsultService::class
        );

        $this->app->singleton(
            \App\Services\SearchServiceInterface::class,
            \App\Services\Production\SearchService::class
        );

        $this->app->singleton(
            \App\Services\BroadcastServiceInterface::class,
            \App\Services\Production\BroadcastService::class
        );

        $this->app->singleton(
            \App\Services\CMEServiceInterface::class,
            \App\Services\Production\CMEService::class
        );

        /* NEW BINDING */
        $this->app->singleton(DoctorServiceInterface::class, DoctorService::class);

        $this->app->singleton(
            \App\Services\AppointmentServiceInterface::class,
            \App\Services\Production\AppointmentService::class
        );
    }
}

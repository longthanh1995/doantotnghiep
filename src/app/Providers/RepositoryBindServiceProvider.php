<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryBindServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
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
        $this->app->singleton(\App\Repositories\AdminUserRepositoryInterface::class, \App\Repositories\Eloquent\AdminUserRepository::class);
        $this->app->singleton(\App\Repositories\AdminUserRoleRepositoryInterface::class, \App\Repositories\Eloquent\AdminUserRoleRepository::class);
        $this->app->singleton(\App\Repositories\AdminPasswordResetRepositoryInterface::class, \App\Repositories\Eloquent\AdminPasswordResetRepository::class);

        $this->app->singleton(\App\Repositories\UserRepositoryInterface::class, \App\Repositories\Eloquent\UserRepository::class);
        $this->app->singleton(\App\Repositories\FileRepositoryInterface::class, \App\Repositories\Eloquent\FileRepository::class);
        $this->app->singleton(\App\Repositories\ImageRepositoryInterface::class, \App\Repositories\Eloquent\ImageRepository::class);
        $this->app->singleton(\App\Repositories\UserServiceAuthenticationRepositoryInterface::class, \App\Repositories\Eloquent\UserServiceAuthenticationRepository::class);
        $this->app->singleton(\App\Repositories\PasswordResettableRepositoryInterface::class, \App\Repositories\Eloquent\PasswordResettableRepository::class);
        $this->app->singleton(\App\Repositories\UserPasswordResetRepositoryInterface::class, \App\Repositories\Eloquent\UserPasswordResetRepository::class);

        $this->app->singleton(
            'App\Repositories\DoctorRepositoryInterface',
            'App\Repositories\Eloquent\DoctorRepository'
        );

        $this->app->singleton(
            'App\Repositories\AppointmentRepositoryInterface',
            'App\Repositories\Eloquent\AppointmentRepository'
        );

        $this->app->singleton(
            'App\Repositories\ClinicRepositoryInterface',
            'App\Repositories\Eloquent\ClinicRepository'
        );

        $this->app->singleton(
            'App\Repositories\PatientRepositoryInterface',
            'App\Repositories\Eloquent\PatientRepository'
        );

        $this->app->singleton(
            'App\Repositories\DoctorTimetableRepositoryInterface',
            'App\Repositories\Eloquent\DoctorTimetableRepository'
        );

        $this->app->singleton(
            'App\Repositories\AppointmentStatusRepositoryInterface',
            'App\Repositories\Eloquent\AppointmentStatusRepository'
        );

        $this->app->singleton(
            'App\Repositories\PatientConditionRepositoryInterface',
            'App\Repositories\Eloquent\PatientConditionRepository'
        );

        $this->app->singleton(
            'App\Repositories\DoctorTitleRepositoryInterface',
            'App\Repositories\Eloquent\DoctorTitleRepository'
        );

        $this->app->singleton(
            'App\Repositories\LanguageRepositoryInterface',
            'App\Repositories\Eloquent\LanguageRepository'
        );

        $this->app->singleton(
            'App\Repositories\RelationshipRepositoryInterface',
            'App\Repositories\Eloquent\RelationshipRepository'
        );

        $this->app->singleton(
            'App\Repositories\CountryRepositoryInterface',
            'App\Repositories\Eloquent\CountryRepository'
        );

        $this->app->singleton(
            'App\Repositories\DoctorProfessionRepositoryInterface',
            'App\Repositories\Eloquent\DoctorProfessionRepository'
        );

        $this->app->singleton(
            'App\Repositories\MedicalSchoolRepositoryInterface',
            'App\Repositories\Eloquent\MedicalSchoolRepository'
        );

        $this->app->singleton(
            'App\Repositories\DoctorQualificationRepositoryInterface',
            'App\Repositories\Eloquent\DoctorQualificationRepository'
        );

        $this->app->singleton(
            'App\Repositories\ManaImageRepositoryInterface',
            'App\Repositories\Eloquent\ManaImageRepository'
        );

        $this->app->singleton(
            'App\Repositories\DoctorBookingFeeRepositoryInterface',
            'App\Repositories\Eloquent\DoctorBookingFeeRepository'
        );

        $this->app->singleton(
            'App\Repositories\AppointmentFeeRepositoryInterface',
            'App\Repositories\Eloquent\AppointmentFeeRepository'
        );

        $this->app->singleton(
            'App\Repositories\AppointmentTypeRepositoryInterface',
            'App\Repositories\Eloquent\AppointmentTypeRepository'
        );

        $this->app->singleton(
            'App\Repositories\AdminWhitelistEmailRepositoryInterface',
            'App\Repositories\Eloquent\AdminWhitelistEmailRepository'
        );

        $this->app->singleton(
            'App\Repositories\AdminInvitationRepositoryInterface',
            'App\Repositories\Eloquent\AdminInvitationRepository'
        );

        $this->app->singleton(
            'App\Repositories\ClinicTypeRepositoryInterface',
            'App\Repositories\Eloquent\ClinicTypeRepository'
        );

        $this->app->singleton(
            'App\Repositories\ManaUserRepositoryInterface',
            'App\Repositories\Eloquent\ManaUserRepository'
        );

        $this->app->singleton(
            'App\Repositories\DoctorSettingRepositoryInterface',
            'App\Repositories\Eloquent\DoctorSettingRepository'
        );

        $this->app->singleton(
            'App\Repositories\HouseCallAppointmentInformationRepositoryInterface',
            'App\Repositories\Eloquent\HouseCallAppointmentInformationRepository'
        );

        $this->app->singleton(
            'App\Repositories\WorkCompanyRepositoryInterface',
            'App\Repositories\Eloquent\WorkCompanyRepository'
        );

        $this->app->singleton(
            'App\Repositories\InsuranceCompanyRepositoryInterface',
            'App\Repositories\Eloquent\InsuranceCompanyRepository'
        );

        $this->app->singleton(
            'App\Repositories\ActivityRepositoryInterface',
            'App\Repositories\Eloquent\ActivityRepository'
        );

        $this->app->singleton(
            'App\Repositories\ConsultReasonRepositoryInterface',
            'App\Repositories\Eloquent\ConsultReasonRepository'
        );

        $this->app->singleton(
            'App\Repositories\HouseCallReasonRepositoryInterface',
            'App\Repositories\Eloquent\HouseCallReasonRepository'
        );

        $this->app->singleton(
            'App\Repositories\TaxProfileRepositoryInterface',
            'App\Repositories\Eloquent\TaxProfileRepository'
        );

        $this->app->singleton(
            'App\Repositories\SurchargeSettingRepositoryInterface',
            'App\Repositories\Eloquent\SurchargeSettingRepository'
        );

        $this->app->singleton(
            'App\Repositories\CMEOrganizerRepositoryInterface',
            'App\Repositories\Eloquent\CMEOrganizerRepository'
        );

        $this->app->singleton(
            'App\Repositories\SuperClinicDataRepositoryInterface',
            'App\Repositories\Eloquent\SuperClinicDataRepository'
        );

        /* NEW BINDING */
    }
}

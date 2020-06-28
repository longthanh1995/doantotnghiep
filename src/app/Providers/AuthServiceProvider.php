<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\DoctorQualification;
use App\Models\DoctorTimetable;
use App\Models\Patient;
use App\Policies\AppointmentPolicy;
use App\Policies\DoctorQualificationPolicy;
use App\Policies\DoctorTimetablePolicy;
use App\Policies\PatientPolicy;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        DoctorQualification::class => DoctorQualificationPolicy::class,
        DoctorTimetable::class => DoctorTimetablePolicy::class,
        Appointment::class => AppointmentPolicy::class,
        Patient::class => PatientPolicy::class
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}

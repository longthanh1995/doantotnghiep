<?php

namespace App\Providers;

use App\Events\AppointmentCancelledEvent;
use App\Events\AppointmentCreatedEvent;
use App\Events\AppointmentMessageCreatedEvent;
use App\Events\AppointmentRescheduledEvent;
use App\Events\AppointmentVisitedEvent;
use App\Events\UserProfileUpdatedByDoctorEvent;
use App\Listeners\CreateAppointmentFeeWhenAppointmentCreated;
use App\Listeners\NotifyToUserWhenAppointmentCancelled;
use App\Listeners\NotifyToUserWhenAppointmentCreated;
use App\Listeners\NotifyToUserWhenAppointmentMessageCreated;
use App\Listeners\NotifyToUserWhenAppointmentRescheduled;
use App\Listeners\NotifyToUserWhenProfileUpdatedByDoctor;
use App\Listeners\RefundWhenAppointmentCancelled;
use App\Listeners\TellBackendWhenAppointmentVisited;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AppointmentCancelledEvent::class => [
            NotifyToUserWhenAppointmentCancelled::class,
            RefundWhenAppointmentCancelled::class,
        ],

        AppointmentCreatedEvent::class => [
            CreateAppointmentFeeWhenAppointmentCreated::class,
            NotifyToUserWhenAppointmentCreated::class,
        ],

        AppointmentVisitedEvent::class => [
            TellBackendWhenAppointmentVisited::class,
        ],

        AppointmentRescheduledEvent::class => [
            NotifyToUserWhenAppointmentRescheduled::class,
        ],

        AppointmentMessageCreatedEvent::class => [
            NotifyToUserWhenAppointmentMessageCreated::class,
        ],

        UserProfileUpdatedByDoctorEvent::class => [
            NotifyToUserWhenProfileUpdatedByDoctor::class
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}

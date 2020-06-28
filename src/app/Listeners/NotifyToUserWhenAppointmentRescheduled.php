<?php

namespace App\Listeners;

use App\Events\AppointmentRescheduledEvent;
use App\Services\NotificationServiceInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Barryvdh\Debugbar\Facade as Debugbar;

class NotifyToUserWhenAppointmentRescheduled
{
    /**
     * @var NotificationServiceInterface
     */
    protected $notificationService;

    /**
     * NotifyToUserWhenAppointmentRescheduled constructor.
     *
     * @param NotificationServiceInterface $notificationService
     */
    public function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     *
     * @param  AppointmentRescheduledEvent  $event
     * @return void
     */
    public function handle(AppointmentRescheduledEvent $event)
    {
        /*
         * Only run this job when env is production.
         */
        if (config('app.env') != 'production') {
            return;
        }

        $appointment = $event->getAppointment();

        /*
         * If appointment doesn't have user_id, API won't be called.
         */
        if (!$appointment->user_id) {
            return;
        }

        $appointment->load('doctor', 'doctorTimetable');

        $doctor = $appointment->doctor;
        $doctorTimetable = $appointment->doctorTimetable;
        $doctorTimetable->load('clinic');

//        $message = view('legacy.pages.doctor.partials.notifications.appointmentRescheduled', [
//            'appointment' => $appointment,
//            'doctorTimetable' => $doctorTimetable,
//            'doctor' => $doctor,
//        ])->render();
//
//        $this->notificationService->sendMessageByAppointmentAsync($appointment, $message);

        $this->notificationService->sendAppointmentNotificationToUserAsync($appointment, 'rescheduled');
    }
}

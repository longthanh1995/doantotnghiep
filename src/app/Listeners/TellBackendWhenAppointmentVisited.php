<?php

namespace App\Listeners;

use App\Events\AppointmentVisitedEvent;
use App\Services\NotificationServiceInterface;

class TellBackendWhenAppointmentVisited
{
    /**
     * @var NotificationServiceInterface
     */
    protected $notificationService;

    /**
     * NotifyToUserWhenAppointmentCancelled constructor.
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
     * @param  AppointmentVisitedEvent  $event
     * @return void
     */
    public function handle(AppointmentVisitedEvent $event)
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

//        $appointment->load('doctor', 'doctorTimetable');
//
//        $message = 'ACTION_RATE_DOCTOR';

//        $this->notificationService->sendMessageByAppointmentAsync($appointment, $message);

        $this->notificationService->sendAppointmentNotificationToUserAsync($appointment, 'marked_visited');
    }
}

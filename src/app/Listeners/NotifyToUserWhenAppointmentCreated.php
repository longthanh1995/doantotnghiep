<?php

namespace App\Listeners;

use App\Events\AppointmentCreatedEvent;
use App\Services\NotificationServiceInterface;

class NotifyToUserWhenAppointmentCreated
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
     * @param  AppointmentCreatedEvent  $event
     * @return void
     */
    public function handle(AppointmentCreatedEvent $event)
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
        $this->notificationService->sendAppointmentNotificationToUserAsync($appointment, 'confirmed');
    }
}

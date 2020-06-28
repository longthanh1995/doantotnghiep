<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\AppointmentCancelledEvent;
use App\Services\NotificationServiceInterface;

class NotifyToUserWhenAppointmentCancelled
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
     * @param  AppointmentCancelledEvent  $event
     * @return void
     */
    public function handle(AppointmentCancelledEvent $event)
    {

        $appointment = $event->getAppointment();

        /*
         * Only run this job when env is production.
         */
        if (config('app.env') != 'production') {
            return;
        }

        /*
         * If appointment doesn't have user_id, API won't be called.
         */
        if (!$appointment->user_id) {
            return;
        }

        $this->notificationService->sendAppointmentNotificationToUserAsync($appointment, 'cancelled');
    }
}

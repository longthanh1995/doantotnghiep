<?php

namespace App\Listeners;

use App\Events\UserProfileUpdatedByDoctorEvent;
use App\Services\NotificationServiceInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyToUserWhenProfileUpdatedByDoctor
{
    /**
     * @var NotificationServiceInterface
     */
    protected $notificationService;

    /**
     * NotifyToUserWhenProfileUpdatedByDoctor constructor.
     *
     * @param NotificationServiceInterface $notificationService
     */
    public function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * @param UserProfileUpdatedByDoctorEvent $event
     */
    public function handle(UserProfileUpdatedByDoctorEvent $event)
    {
        /*
         * Only run this job when env is production.
         */
        if (config('app.env') != 'production') {
            return;
        }

        $doctor = $event->getDoctor();
        $user = $event->getUser();
        $patient = $event->getPatient();

        if (!$user->id || !$doctor->id) {
            return;
        }

        $title = 'Profile Updated';
        $message = 'Doctor ' . $doctor->name . ' have just updated your profile information.';
        $data = array(
            'patient_id' => $patient->id,
            'click_action' => 'ACTION_VIEW_PATIENT_PROFILE',
            'extra_action' => 'ACTION_VIEW_PATIENT_PROFILE'
        );

        $this->notificationService->sendNotificationToUserAsync($user, $title, $message, $data);
    }
}

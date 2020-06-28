<?php

namespace App\Services\Production;

use App\Jobs\SendAlertsNotificationToUserJob;
use App\Jobs\SendAppointmentNotificationToUser;
use App\Jobs\SendNotificationToUser;
use App\Models\Appointment;
use App\Services\NotificationServiceInterface;

class NotificationService extends BaseService implements NotificationServiceInterface
{
    /**
     * @param Appointment $appointment
     * @param string $action_type
     * @param null $message
     */
    public function sendAppointmentNotificationToUserAsync(Appointment $appointment, $action_type = '', $message = null)
    {
        dispatch(new SendAppointmentNotificationToUser(
            $appointment,
            $action_type,
            $message
        ));
    }

    /**
     * @param $user
     * @param $title
     * @param $message
     * @param $data
     */
    public function sendNotificationToUserAsync($user, $title, $message, $data){
        dispatch(new SendNotificationToUser(
            $user,
            $title,
            $message,
            $data
        ));
    }

    /**
     * @param null $appointmentMessageId
     * @param $iconUrl
     * @param bool $iconRounded
     * @param string $senderName
     * @param $senderId
     * @param $href
     * @param string $message
     * @param string $extendedMessage
     * @param $category
     * @param $recipientId
     * @param string $appType
     * @param array $actions
     */
    public function sendAlertsNotificationToUserAsync(
        $appointmentMessageId = null,
        $iconUrl,
        $iconRounded = true,
        $senderName = 'MaNaDr',
        $senderId,
        $href,
        $message = '',
        $extendedMessage = '',
        $category,
        $recipientId,
        $appType = 'patient',
        array $actions = []
    )
    {
        dispatch(new SendAlertsNotificationToUserJob(
            $appointmentMessageId,
            $iconUrl,
            $iconRounded,
            $senderName,
            $senderId,
            $href,
            $message,
            $extendedMessage,
            $category,
            $recipientId,
            $appType,
            $actions
        ));
    }
}

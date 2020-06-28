<?php

namespace App\Services;

use App\Models\Appointment;

/**
 * Interface NotificationServiceInterface
 * @package App\Services
 */
interface NotificationServiceInterface extends BaseServiceInterface
{
    /**
     * @param Appointment $appointment
     * @param string $action_type
     * @param null $message
     * @return mixed
     */
    public function sendAppointmentNotificationToUserAsync(Appointment $appointment, $action_type = '', $message = null);

    /**
     * @param $user
     * @param $title
     * @param $message
     * @param $data
     * @return mixed
     */
    public function sendNotificationToUserAsync($user, $title, $message, $data);

    /**
     * @param $appointmentMessageId
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
     * @return mixed
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
    );
}

<?php

namespace App\Listeners;

use App\Events\AppointmentCancelledEvent;
use App\Models\AppointmentStatus;

class RefundWhenAppointmentCancelled
{
    /**
     * @param AppointmentCancelledEvent $event
     * @return bool
     * @throws \Exception
     */
    public function handle(AppointmentCancelledEvent $event)
    {
        /*
         * Only run this job when env is production.
         */
        if (config('app.env') != 'production') {
            return true;
        }

        $appointment = $event->getAppointment();

        /*
         * If appointment doesn't have user_id, API won't be called.
         */
        if (!$appointment->user_id) {
            return true;
        }

        $baseUrl = config('manadr.base_url_api');
        $key = config('manadr.notification_key');
        $url = $baseUrl.'/api/v1.3/dashboard/appointments/'.$appointment->id.'/refund';

        try {
            $client = new \GuzzleHttp\Client();
            $client->post($url, [
                'headers' => [
                    'Authorization' => $key,
                ],
            ]);
        } catch (\Exception $e) {
            // Don't care about result messages. && errors
        }

        return true;
    }
}

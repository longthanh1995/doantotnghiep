<?php

namespace App\Jobs;

use App\Models\Appointment;
use GuzzleHttp\Client;

class SendAppointmentNotificationToUser extends Job
{
    protected $appointment;

    protected $action;

    protected $message;

    public function __construct(Appointment $appointment, $action_type = '', $message = null)
    {
        $this->appointment = $appointment;

        $actions_array = array(
            'cancelled' => "APPOINTMENT_ACTION_DOCTOR_CANCEL",
            'confirmed' => "APPOINTMENT_ACTION_DOCTOR_CONFIRM",
            'rescheduled' => "APPOINTMENT_ACTION_DOCTOR_RESCHEDULE",
            'marked_visited' => "APPOINTMENT_ACTION_DOCTOR_VISITED",
            'message' => 'APPOINTMENT_ACTION_DOCTOR_MESSAGE'
        );

        abort_unless($this->action = $actions_array[$action_type], 400, 'Action parameter is invalid');

        $this->message = $message;
    }

    public function handle()
    {
        $key = config('manadr.notification_key');
        $base_url = config('manadr.notification_url');

        $url = $base_url . '/appointments';

        $params = [
            'appointment_id' => $this->appointment->id,
            'action' => $this->action,
            'message' => $this->message
        ];

        $client = new Client();

        try{
            $response = $client->post($url, [
                'form_params' => $params,
                'headers' => [
                    'Authorization' => $key
                ]
            ]);

            $status_code = $response->getStatusCode();

            if($status_code != 200) {
                throw new \Exception('Send notification to user failed. Params encode: '.base64_encode($params));
            }

            $body_content = $response->getBody()->getContents();
            $json_code = json_encode($body_content);

            if (!isset($json_code->status) && !$json_code->status) {
                throw new \Exception('Send notifications to user failed. Result encode: '.base64_encode($body_content));
            } else {
                return true;
            }
        } catch(\Exception $e){
            return true;
        }
    }
}
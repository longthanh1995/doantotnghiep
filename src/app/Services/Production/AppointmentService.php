<?php

namespace App\Services\Production;

use App\Services\AppointmentServiceInterface;
use GuzzleHttp\Client;

abstract class AppointmentEvent
{
    const Confirmed = 'confirmed';
    const Cancelled = 'cancelled';
    const Rescheduled = 'rescheduled';

    protected static $eventList = array(AppointmentEvent::Confirmed, AppointmentEvent::Cancelled, AppointmentEvent::Rescheduled);
    public static function IsValidEvents($event) {
        return in_array($event, AppointmentEvent::$eventList);
    }
}


/**
 * Class BroadcastService
 * @package App\Services\Production
 */
class AppointmentService extends BaseService implements AppointmentServiceInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * BroadcastService constructor.
     */
    public function __construct()
    {
        $apiRoot = config('manadr.appointment_api.base_url');
        $authKey = config('manadr.appointment_api.api_key');

        $this->client = new Client([
            'base_uri' => $apiRoot,
            'headers' => [
                'X-Internal-Key' => $authKey,
                'Content-Type' => 'application/json',
                'Accept'     => 'application/json',
            ],
        ]);
    }

    public function sendAppointmentEvent(int $appointmentID, string $event)
    {
        if (!AppointmentEvent::IsValidEvents($event)) {
            throw new \Exception("Invalid appointment event");
        }

        try {
            $response = $this->client->post('dashboard/appointments/'.$appointmentID.'/events',[
                'json'=> array('event' => $event),
            ]);
            $status_code = $response->getStatusCode();
            $responseData = json_decode($response->getBody()->getContents());
            return $responseData->data;
        } catch(RequestException $e){
            if ($e->hasResponse()) {
                $responseData = json_decode($e->getResponse()->getBody()->getContents());
                throw new \Exception($responseData->data->message);
            } else {
                throw $e->getResponse();
            }
        }
    }
}
<?php

namespace App\Jobs;

use App\Models\AppointmentMessage;
use GuzzleHttp\Client;

/**
 * Class SendAlertsNotificationToUserJob
 * @package App\Jobs
 */
class SendAlertsNotificationToUserJob extends Job
{
    /**
     * @var null
     */
    private $appointmentMessageId;

    /**
     * @var
     */
    private $iconUrl;

    /**
     * @var
     */
    private $iconRounded;

    /**
     * @var
     */
    private $senderName;

    /**
     * @var
     */
    private $senderId;

    /**
     * @var
     */
    private $href;

    /**
     * @var
     */
    private $message;

    /**
     * @var
     */
    private $extendedMessage;

    /**
     * @var
     */
    private $category;

    /**
     * @var
     */
    private $recipientId;

    /**
     * @var
     */
    private $appType;

    /**
     * @var array
     */
    private $actions;

    /**
     * SendAlertsNotificationToUserJob constructor.
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
    public function __construct(
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
        $this->appointmentMessageId = $appointmentMessageId;
        $this->iconUrl = $iconUrl;
        $this->iconRounded = $iconRounded;
        $this->senderName = $senderName;
        $this->senderId = $senderId;
        $this->href = $href;
        $this->message = $message;
        $this->extendedMessage = $extendedMessage;
        $this->category = $category;
        $this->recipientId = $recipientId;
        $this->appType = $appType;
        $this->actions = $actions;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $authKey = config('manadr.alerts_api.auth_key');
        $baseUrl = config('manadr.alerts_api.base_url');
        $timeout = config('manadr.alerts_api.timeout');

        $client = new Client([
            'base_uri' => $baseUrl,
            'timeout' => $timeout,
        ]);

        try {
            $response = $client->post('alerts', [
                'headers' => [
                    'Authorization' => "Basic {$authKey}",
                ],
                'json' => [
                    'icon' => [
                        'url' => $this->iconUrl,
                        'rounded' => $this->iconRounded,
                    ],
                    'sender_name' => $this->senderName,
                    'sender_id' => $this->senderId,
                    'href' => $this->href,
                    'message' => $this->message,
                    'ext_message' => $this->extendedMessage,
                    'category' => $this->category,
                    'recipient_id' => $this->recipientId,
                    'app_type' => $this->appType,
                    'actions' => $this->actions
                ]
            ]);

            $statusCode = $response->getStatusCode();

            if($statusCode != 200){
                throw new \Exception('Cannot send notitification to user.');
            }

            $responseData = json_decode($response->getBody()->getContents());

            //update appointment message id if exists
            if($this->appointmentMessageId){
                $actions = $responseData->actions;
                $acknowledgeAction = array_first($actions, function($index, $action){
                    return $action->category_button === 'ack';
                });

                $appointmentMessage = AppointmentMessage::find($this->appointmentMessageId);

                if($appointmentMessage){
                    $appointmentMessage->update(['ack_action_id'=> $acknowledgeAction->id]);
                    $appointmentMessage->save();
                }
            }

            return $responseData;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
<?php

namespace App\Jobs;

use App\Models\ManaUser;
use GuzzleHttp\Client;

//use Barryvdh\Debugbar\Facade as Debugbar;

class SendNotificationToUser extends Job
{
    protected $user;
    protected $title;
    protected $message;
    protected $data;

    public function __construct(ManaUser $user, $title='', $message='', $data = array())
    {
        $this->user = $user;
        $this->title = $title;
        $this->message = $message;
        $this->data = $data;
    }

    public function handle()
    {
        $key = config('manadr.notification_key');
        $base_url = config('manadr.notification_url');

        $url = $base_url . '';

        $params = [
            'user_id' => $this->user->id,
            'title' => $this->title,
            'message' => $this->message,
            'data' => $this->data
        ];

        $client = new Client();

        try{
            $response = $client->post($url, [
                'json' => $params,
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
//            return true;
//            Debugbar::error($e);
        }
    }
}

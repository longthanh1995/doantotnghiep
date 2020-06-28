<?php

namespace App\Services\Production;

use Illuminate\Support\Str;
use App\Services\BroadcastServiceInterface;
use GuzzleHttp\Client;
use Merujan99\LaravelVideoEmbed\Facades\LaravelVideoEmbed;

/**
 * Class BroadcastService
 * @package App\Services\Production
 */
class BroadcastService extends BaseService implements BroadcastServiceInterface
{
    /**
     * @var Client
     */
    private $client;
    private $searchClient;

    /**
     * BroadcastService constructor.
     */
    public function __construct()
    {
        $authKey = config('manadr.alerts_api.auth_key');
        $baseUrl = config('manadr.alerts_api.base_url');
        $timeout = config('manadr.alerts_api.timeout');

        $searchApiURL = config('manadr.search_api.base_url');
        $searchApiKey = config('manadr.search_api.key');

        $this->client = new Client([
            'base_uri' => $baseUrl,
            'timeout' => $timeout,
            'headers' => [
                'Authorization' => "Basic {$authKey}",
            ],
        ]);

        $this->searchClient = new Client([
            'base_uri' => $searchApiURL,
            'timeout' => $timeout,
            'headers' => [
                'API_KEY' => "{$searchApiKey}",
            ],
        ]);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function index()
    {
        try{
            $response = $this->client->get('system/articles');

            $statusCode = $response->getStatusCode();

            if($statusCode != 200){
                throw new \Exception('Get article list failed.');
            }

            $responseData = json_decode($response->getBody()->getContents());

            return $responseData;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        switch($mediaType = array_get($data, 'media.type')){
            case 'youtube':
                $youtubeVideoUrl = array_get($data, 'media.video_url');
                array_set($data, 'media.thumb_url', LaravelVideoEmbed::getYoutubeThumbnail($youtubeVideoUrl));
                break;
            case 'image':
            default:
                break;
        }

        try{
            $response = $this->client->post('system/articles', [
                'json' => $data,
            ]);

            $statusCode = $response->getStatusCode();

            if($statusCode != 200){
                throw new \Exception('Create new article failed.');
            }

            $responseData = json_decode($response->getBody()->getContents());

            return $responseData;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function show($id)
    {
        try{
            $response = $this->client->get("system/articles/{$id}");

            $statusCode = $response->getStatusCode();

            if($statusCode != 200){
                throw new \Exception('Get article failed.');
            }

            $responseData = json_decode($response->getBody()->getContents());

            return $responseData;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function update($id, array $data)
    {
        switch($mediaType = array_get($data, 'media.type')){
            case 'youtube':
                $youtubeVideoUrl = array_get($data, 'media.video_url');
                array_set($data, 'media.thumb_url', LaravelVideoEmbed::getYoutubeThumbnail($youtubeVideoUrl));
                break;
            case 'image':
            default:
                break;
        }

        try{
            $response = $this->client->put("system/articles/{$id}", [
                'json' => $data,
            ]);

            $statusCode = $response->getStatusCode();

            if($statusCode != 200){
                throw new \Exception('Update article failed.');
            }

            $responseData = json_decode($response->getBody()->getContents());

            return $responseData;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function delete($id)
    {
        try{
            $response = $this->client->delete("system/articles/{$id}");

            $statusCode = $response->getStatusCode();

            if($statusCode != 200){
                throw new \Exception('Delete article failed.');
            }

            $responseData = json_decode($response->getBody()->getContents());

            return $responseData;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }


    public function addUsers($id, array $userIds = [])
    {
        try{
            $response = $this->client->post("system/articles/{$id}/add-users", [
                'json' => [
                    'user_ids' => $userIds,
                ]
            ]);
        } catch(\Exception $exception) {
            throw $exception;
        }
    }

    public function getTopics()
    {
        try{
            $response = $this->searchClient->get('tags?limit=100&offset=0');

            $statusCode = $response->getStatusCode();

            if($statusCode != 200){
                throw new \Exception('Get article list failed.');
            }

            $responseData = json_decode($response->getBody()->getContents());
            $topics = $responseData->data;

            foreach ($topics as $topic) {
                $topic->displayName = Str::title($topic->name);
            }

            return $topics;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
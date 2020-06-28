<?php

namespace App\Jobs\Search;

use App\Jobs\Job;
use GuzzleHttp\Client;

/**
 * Class SearchPatientsByClinicAndDoctor
 * @package App\Jobs\Search
 */
class SearchPatientsByClinicAndDoctor extends Job
{
    /**
     * @var
     */
    private $clinicId;

    /**
     * @var
     */
    private $doctorId;

    /**
     * @var
     */
    private $filter;

    /**
     * @var
     */
    private $top;

    /**
     * @var
     */
    private $skip;

    /**
     * SearchPatientsByClinicAndDoctor constructor.
     * @param $clinicId
     * @param $doctorId
     * @param $filter
     * @param $top
     * @param $skip
     */
    public function __construct($clinicId, $doctorId, $filter, $top, $skip)
    {
        $this->clinicId = $clinicId;
        $this->doctorId = $doctorId;
        $this->filter = $filter;
        $this->top = $top;
        $this->skip = $skip;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $apiRoot = config('manadr.search_api.base_url');
        $timeout = config('manadr.search_api.timeout');
        $searchApiKey = config('manadr.search_api.key');

        $client = new Client([
            'base_uri' => $apiRoot,
            'timeout' => $timeout,
            'headers' => [
                'API_KEY' => "{$searchApiKey}",
            ],
        ]);

        try {
            $response = $client->get('clinics/'.$this->clinicId.'/doctors/'.$this->doctorId.'/patients', [
                'query' => urldecode(http_build_query([
                    'filter' => $this->filter,
                    'top' => $this->top,
                    'skip' => $this->skip,
                ])),
            ]);

            $statusCode = $response->getStatusCode();

            if($statusCode != 200){
                throw new \Exception('Cannot get data from search service');
            }

            $results = json_decode($response->getBody()->getContents());

            return $results;
        } catch(\Exception $exception){
            throw $exception;
        }
    }
}
<?php

namespace App\Jobs\Search;

use App\Jobs\Job;
use GuzzleHttp\Client;

/**
 * Class SearchPatientsByClinicJob
 * @package App\Jobs\Search
 */
class SearchPatientsByClinicJob extends Job
{
    private $clinicId;

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
     * SearchPatientsByClinicJob constructor.
     * @param $clinicId
     * @param $filter
     * @param $top
     * @param $skip
     */
    public function __construct($clinicId, $filter, $top, $skip)
    {
        $this->clinicId = $clinicId;
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

        $client = new Client([
            'base_uri' => $apiRoot,
            'timeout' => $timeout,
        ]);

        try {
            $response = $client->get('clinics/'.$this->clinicId.'/patients', [
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
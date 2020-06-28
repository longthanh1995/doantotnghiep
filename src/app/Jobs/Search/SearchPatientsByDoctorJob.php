<?php

namespace App\Jobs\Search;

use App\Jobs\Job;
use GuzzleHttp\Client;

/**
 * Class SearchPatientsByDoctorJob
 * @package App\Jobs\Search
 */
class SearchPatientsByDoctorJob extends Job
{
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
     * @var
     */
    private $doctorId;

    /**
     * SearchPatientsJob constructor.
     * @param $doctorId
     * @param $filter
     * @param $top
     * @param $skip
     */
    public function __construct($doctorId, $filter, $top, $skip)
    {
        $this->filter = $filter;
        $this->top = $top;
        $this->skip = $skip;
        $this->doctorId = $doctorId;
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
            $response = $client->get('doctors-clinics/'.$this->doctorId.'/patients', [
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
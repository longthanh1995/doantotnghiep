<?php

namespace App\Services\Production;

use App\Jobs\Search\SearchPatientsByClinicAndDoctor;
use App\Jobs\Search\SearchPatientsByClinicJob;
use App\Jobs\Search\SearchPatientsByDoctorJob;
use App\Jobs\Search\SearchPatientsJob;
use App\Services\SearchServiceInterface;

/**
 * Class SearchService
 * @package App\Services\Production
 */
class SearchService extends BaseService implements SearchServiceInterface
{
    /**
     * @param $filter
     * @param int $top
     * @param int $skip
     * @return mixed
     */
    public function search($filter, $top = 20, $skip = 0)
    {
        return dispatch(new SearchPatientsJob($filter, $top, $skip));
    }

    /**
     * @param $clinicId
     * @param $filter
     * @param int $top
     * @param int $skip
     * @return mixed
     */
    public function searchByClinic($clinicId, $filter, $top = 20, $skip = 0)
    {
        return dispatch(new SearchPatientsByClinicJob($clinicId, $filter, $top, $skip));
    }

    /**
     * @param $clinicId
     * @param $doctorId
     * @param $filter
     * @param int $top
     * @param int $skip
     * @return mixed
     */
    public function searchByClinicAndDoctor($clinicId, $doctorId, $filter, $top = 20, $skip = 0)
    {
        return dispatch(new SearchPatientsByClinicAndDoctor($clinicId, $doctorId, $filter, $top, $skip));
    }

    /**
     * @param $doctorId
     * @param $filter
     * @param int $top
     * @param int $skip
     * @return mixed
     */
    public function searchByDoctor($doctorId, $filter, $top = 20, $skip = 0)
    {
        return dispatch(new SearchPatientsByDoctorJob($doctorId, $filter, $top, $skip));
    }
}
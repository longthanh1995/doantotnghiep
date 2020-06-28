<?php

namespace App\Services;

/**
 * Interface SearchServiceInterface
 * @package App\Services
 */
interface SearchServiceInterface extends BaseServiceInterface
{

    /**
     * @param $filter
     * @param int $top
     * @param int $skip
     * @return mixed
     */
    public function search($filter, $top = 20, $skip = 0);

    /**
     * @param $clinicId
     * @param $filter
     * @param int $top
     * @param int $skip
     * @return mixed
     */
    public function searchByClinic($clinicId, $filter, $top = 20, $skip = 0);

    /**
     * @param $clinicId
     * @param $doctorId
     * @param $filter
     * @param int $top
     * @param int $skip
     * @return mixed
     */
    public function searchByClinicAndDoctor($clinicId, $doctorId, $filter, $top = 20, $skip = 0);

    /**
     * @param $doctorId
     * @param $filter
     * @param int $top
     * @param int $skip
     * @return mixed
     */
    public function searchByDoctor($doctorId, $filter, $top = 20, $skip = 0);
}
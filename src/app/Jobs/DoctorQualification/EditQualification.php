<?php

namespace App\Jobs\DoctorQualification;

use App\Jobs\Job;
use App\Models\Doctor;
use App\Models\DoctorQualification;
use App\Repositories\DoctorQualificationRepositoryInterface;
use Carbon\Carbon;

class EditQualification extends Job
{
    /**
     * @var DoctorQualification
     */
    protected $doctorQualification;

    /**
     * @var array
     */
    protected $data;

    /**
     * EditQualification constructor.
     *
     * @param DoctorQualification $doctorQualification
     * @param array $data
     */
    public function __construct(DoctorQualification $doctorQualification, array $data)
    {
        $this->doctorQualification = $doctorQualification;
        $this->data = $this->buildData($data);
    }

    protected function buildData($data)
    {
        $date = new Carbon();
        $data['issued_time'] = $date->setDateTime($data['issued_time'], 1, 1, 0, 0, 0);

        return array_only($data, [
            'name',
            'issuer',
            'issued_time',
        ]);
    }

    /**
     * @param DoctorQualificationRepositoryInterface $doctorQualificationRepository
     */
    public function handle(DoctorQualificationRepositoryInterface $doctorQualificationRepository)
    {
        return $doctorQualificationRepository->update($this->doctorQualification, $this->data);
    }
}

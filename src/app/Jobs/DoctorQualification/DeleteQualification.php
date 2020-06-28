<?php

namespace App\Jobs\DoctorQualification;

use App\Jobs\Job;
use App\Models\DoctorQualification;
use App\Repositories\DoctorQualificationRepositoryInterface;

class DeleteQualification extends Job
{
    /**
     * @var DoctorQualification
     */
    protected $doctorQualification;

    /**
     * DeleteQualification constructor.
     *
     * @param DoctorQualification $doctorQualification
     */
    public function __construct(DoctorQualification $doctorQualification)
    {
        $this->doctorQualification = $doctorQualification;
    }

    /**
     * @param DoctorQualificationRepositoryInterface $doctorQualificationRepository
     */
    public function handle(DoctorQualificationRepositoryInterface $doctorQualificationRepository)
    {
        $doctorQualificationRepository->delete($this->doctorQualification);
    }
}

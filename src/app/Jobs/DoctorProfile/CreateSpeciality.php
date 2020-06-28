<?php

namespace App\Jobs\DoctorProfile;

use App\Jobs\Job;
use App\Models\Doctor;
use App\Repositories\PatientConditionRepositoryInterface;
use App\Repositories\Eloquent\PatientConditionRepository;
use Carbon\Carbon;

class CreateSpeciality extends Job
{
    /**
     * @var Doctor
     */
    protected $doctor;

    /**
     * @var void
     */
    protected $data;

    /**
     * CreateSpeciality constructor.
     *
     * @param Doctor $doctor
     * @param array $data
     */
    public function __construct(Doctor $doctor, array $data)
    {
        $this->doctor = $doctor;
        $this->data = $this->buildData($data);
    }

    protected function buildData($data)
    {
        return array_only($data, [
            'name',
        ]);
    }

    /**
     * @param PatientConditionRepositoryInterface $doctorSpecialityRepository
     */
    public function handle(PatientConditionRepositoryInterface $doctorSpecialityRepository)
    {
        return $doctorSpeciality = $doctorSpecialityRepository->create($this->data);
    }
}

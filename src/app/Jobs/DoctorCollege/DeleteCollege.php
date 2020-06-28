<?php

namespace App\Jobs\DoctorCollege;

use App\Jobs\Job;
use App\Models\Doctor;
use App\Repositories\DoctorRepositoryInterface;

class DeleteCollege extends Job
{
    /**
     * @var Doctor
     */
    protected $doctor;

    /**
     * @var int
     */
    protected $actionId;

    /**
     * DeleteCollege constructor.
     *
     * @param Doctor $doctor
     * @param $id
     */
    public function __construct(Doctor $doctor, $id)
    {
        $this->doctor = $doctor;
        $this->actionId = $id;
    }

    /**
     * @param DoctorRepositoryInterface $doctorRepository
     */
    public function handle(DoctorRepositoryInterface $doctorRepository)
    {
        $this->doctor->medicalSchools()->detach($this->actionId);

        $doctorRepository->save($this->doctor);
    }
}

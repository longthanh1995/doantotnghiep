<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Doctor;
use App\Models\DoctorTimetable;
use App\Repositories\DoctorTimetableRepositoryInterface;

class DeleteDoctorTimetableJob extends Job
{
    /**
     * @var Doctor
     */
    protected $doctor;

    /**
     * @var DoctorTimetable
     */
    protected $doctorTimetable;

    /**
     * DeleteDoctorTimetableJob constructor.
     *
     * @param Doctor $doctor
     * @param DoctorTimetable $doctorTimetable
     */
    public function __construct(Doctor $doctor, DoctorTimetable $doctorTimetable)
    {
        $this->doctor = $doctor;
        $this->doctorTimetable = $doctorTimetable;
    }

    /**
     * @param DoctorTimetableRepositoryInterface $doctorTimetableRepository
     */
    public function handle(DoctorTimetableRepositoryInterface $doctorTimetableRepository)
    {
        $doctorTimetableRepository->delete($this->doctorTimetable);
    }
}

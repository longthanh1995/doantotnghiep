<?php

namespace App\Jobs\DoctorCollege;

use App\Jobs\Job;
use App\Models\Doctor;
use App\Models\MedicalSchool;
use App\Repositories\DoctorRepositoryInterface;
use App\Repositories\MedicalSchoolRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;

class EditCollege extends Job
{
    use DispatchesJobs;

    /**
     * @var Doctor
     */
    protected $doctor;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var int
     */
    protected $medicalSchoolId;

    /**
     * EditCollege constructor.
     * @param Doctor $doctor
     * @param $medicalSchoolId
     * @param array $data
     */
    public function __construct(Doctor $doctor, $medicalSchoolId, array $data)
    {
        $this->doctor = $doctor;
        $this->medicalSchoolId = $medicalSchoolId;
        $this->data = $data;
    }

    /**
     * @param DoctorRepositoryInterface $doctorRepository
     */
    public function handle(DoctorRepositoryInterface $doctorRepository)
    {
        /*
         * First delete old record
         */
        $this->doctor->medicalSchools()->detach($this->medicalSchoolId);

        $doctorRepository->save($this->doctor);

        /*
         * Last create new record
         */
        return $this->dispatchNow(new CreateCollege(
            $this->doctor,
            $this->data
        ));
    }
}

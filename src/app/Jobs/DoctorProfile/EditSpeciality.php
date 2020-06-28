<?php

namespace App\Jobs\DoctorProfile;

use App\Jobs\Job;
use App\Models\Doctor;
use App\Repositories\DoctorRepositoryInterface;

use App\Repositories\PatientConditionRepositoryInterface;
use Barryvdh\Debugbar\Facade as Debugbar;

use Illuminate\Support\Facades\Log;

class EditSpeciality extends Job
{
    /**
     * @var Doctor
     */
    protected $doctor;

    /**
     * @var array
     */
    protected $listConditions;

    /**
     * EditSpeciality constructor.
     *
     * @param Doctor $doctor
     * @param array $listConditions
     */
    public function __construct(Doctor $doctor, array $listConditions = [])
    {
        $this->doctor = $doctor;

        $this->listConditions = collect($listConditions)->map(function($value, $key){
            if(strpos($value, '0:') == 0 && strlen($value) > 2){
                $newSpecialityName = explode(':', $value)[1];
                $newSpeciality = dispatch(new CreateSpeciality(
                    $this->doctor,
                    ['name' => $newSpecialityName]
                ));
                return $newSpeciality->id;
            } else {
                return $value;
            }
        })->toArray();
    }

    /**
     * @param DoctorRepositoryInterface $doctorRepository
     */
    public function handle(DoctorRepositoryInterface $doctorRepository)
    {
        $this->doctor->patientConditions()->sync($this->listConditions);

        $doctorRepository->save($this->doctor);
    }
}

<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\DoctorQualification;
use Illuminate\Auth\Access\HandlesAuthorization;

class DoctorQualificationPolicy
{
    use HandlesAuthorization;

    /**
     * @param Doctor $doctor
     * @param DoctorQualification $doctorQualification
     *
     * @return bool
     */
    public function own(Doctor $doctor, DoctorQualification $doctorQualification)
    {
        return $doctor->id == $doctorQualification->doctor_id;
    }

    /**
     * @param Doctor $doctor
     * @param DoctorQualification $doctorQualification
     *
     * @return bool
     */
    public function edit(Doctor $doctor, DoctorQualification $doctorQualification)
    {
        return $this->own($doctor, $doctorQualification);
    }

    /**
     * @param Doctor $doctor
     * @param DoctorQualification $doctorQualification
     *
     * @return bool
     */
    public function delete(Doctor $doctor, DoctorQualification $doctorQualification)
    {
        return $this->own($doctor, $doctorQualification);
    }
}

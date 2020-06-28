<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientPolicy
{
    use HandlesAuthorization;

    /**
     * Does a doctor can access a patient's records?
     * @param Doctor $doctor
     * @param Patient $patient
     * @return bool
     */
    public function retrieve(Doctor $doctor, Patient $patient)
    {
        return false;
    }

    /**
     * Does a doctor can update a patient's records?
     * @param Doctor $doctor
     * @param Patient $patient
     * @return bool
     */
    public function update(Doctor $doctor, Patient $patient)
    {
        /**
         * ->whereHas('clinics', function($query) use ($currentClinicIds){
                    return $query->whereIn('clinic_id', $currentClinicIds);
                })
                ->orWhereHas('appointments', function($query) use ($currentDoctor){
                    return $query->where('doctor_id', $currentDoctor->id);
                })
         * */
        foreach($patient->clinics as $clinic){
            if($clinic->doctors && $clinic->doctors->contains($doctor)){
                return true;
            }
        }
        foreach($patient->appointments as $appointment){
            if($appointment->doctor_id == $doctor->id){
                return true;
            }
        }
        return false;
    }

    /**
     * Does a doctor can activate a patient's records?
     * @param Doctor $doctor
     * @param Patient $patient
     * @return bool
     */
    public function activate(Doctor $doctor, Patient $patient)
    {
        return false;
    }

    /**
     * Does a doctor can deactivate a patient's records?
     * @param Doctor $doctor
     * @param Patient $patient
     * @return bool
     */
    public function deactivate(Doctor $doctor, Patient $patient)
    {
        return false;
    }

}
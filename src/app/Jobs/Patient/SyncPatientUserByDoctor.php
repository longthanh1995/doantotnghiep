<?php

namespace App\Jobs\Patient;

use App\Events\UserProfileUpdatedByDoctorEvent;
use App\Jobs\Job;
use App\Models\Doctor;
use App\Models\Patient;

/**
 * Update Me Record if this patient record is verified & connected
 * Requirements: https://mobilehealth.atlassian.net/wiki/x/VLk5
 */
class SyncPatientUserByDoctor extends Job
{
    protected $patient;

    public function __construct(Doctor $doctor, Patient $patient)
    {
        $this->doctor = $doctor;
        $this->patient = $patient;
    }

    public function handle()
    {
        $patient = $this->patient;

        if(!isset($patient)){
            return;
        }

        $account = $patient->account;
        if(isset($account) && $patient->verified){
            $patient->relationships()->updateExistingPivot($patient->id, [
                'first_name' => $patient->first_name,
                'last_name' => $patient->last_name,
                'gender' => $patient->gender,
                'date_of_birth' => $patient->date_of_birth,
                'email' => $patient->email,
                'id_number' => $patient->id_number,
                'issue_country_id' => $patient->issue_country_id,
                'resident_country_id' => $patient->resident_country_id
            ]);

            event(new UserProfileUpdatedByDoctorEvent(
                $this->doctor,
                $account,
                $patient
            ));
        }
    }
}
<?php

namespace App\Jobs\Patient;

use App\Jobs\Job;
use App\Models\Patient;

class MergeJob extends Job{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        Patient $fromPatient,
        Patient $toPatient
    )
    {
        $this->fromPatient = $fromPatient;
        $this->toPatient = $toPatient;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fromPatient = $this->fromPatient;
        $toPatient = $this->toPatient;

        \DB::transaction(function() use ($fromPatient, $toPatient){
            //transfer appointments
            \DB::table(env('DB_DATABASE_BACKEND').'.appointments')->where('patient_id', $fromPatient->id)->update(['patient_id' => $toPatient->id]);

            //transfer clinic relationships
            \DB::table(env('DB_DATABASE_BACKEND').'.patient_clinic')->where('patient_id', $fromPatient->id)->update(['patient_id' => $toPatient->id]);

            #transfer relationships
            \DB::table(env('DB_DATABASE_BACKEND').'.user_relatives')->where('patient_id', $fromPatient->id)->update(['patient_id' => $toPatient->id]);
            \DB::table(env('DB_DATABASE_BACKEND').'.user_relatives')->where('user_patient_id', $fromPatient->id)->update(['user_patient_id' => $toPatient->id]);

            #transfer user_id
            $userId = $toPatient->user_id;
            if($userId){
                \DB::table(env('DB_DATABASE_BACKEND').'.users')->where('id', $userId)->update(['account_id'=> $toPatient->id]);
                \DB::table(env('DB_DATABASE_BACKEND').'.patients')->where('id', $fromPatient->id)->update(['user_id'=>null]);
                \DB::table(env('DB_DATABASE_BACKEND').'.patients')->where('id', $toPatient->id)->update(['user_id'=>$userId]);
            }

            #remove patient record
            \DB::table(env('DB_DATABASE_BACKEND').'.patients')->where('id', $fromPatient->id)->update(['id_number' => $fromPatient->id_number . '_OLD_'.str_random(3)]);
            \DB::table(env('DB_DATABASE_BACKEND').'.patients')->where('id', $fromPatient->id)->delete();
        });
    }
}

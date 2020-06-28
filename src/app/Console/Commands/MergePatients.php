<?php

namespace App\Console\Commands;

use App\Jobs\Patient\MergeJob;
use App\Repositories\PatientRepositoryInterface;
use Illuminate\Console\Command;

class MergePatients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manadr:patient:merge {from?} {to?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merge 2 patients record';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(PatientRepositoryInterface $patientRepository)
    {
        $fromPatientId = $this->argument('from');
        if(!$fromPatientId){
            $fromPatientId = $this->ask('What is the id of patient record that you want to remove?');
        }

        $toPatientId = $this->argument('to');
        if(!$toPatientId){
            $toPatientId = $this->ask('What is the id of patient record that you want to keep?');
        }

        $fromPatient = $patientRepository->find($fromPatientId);
        if(!$fromPatient){
            return $this->error('The patient record that you want to remove doesn\'t exist');
        }

        $toPatient = $patientRepository->find($toPatientId);
        if(!$toPatient){
            return $this->error('The patient record that you want to keep doesn\'t exist');
        }

        return dispatch(new MergeJob($fromPatient, $toPatient));
    }
}

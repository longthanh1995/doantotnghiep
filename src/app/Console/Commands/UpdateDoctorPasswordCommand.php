<?php

namespace App\Console\Commands;

use App\Models\Doctor;
use App\Repositories\DoctorRepositoryInterface;
use Illuminate\Console\Command;

class UpdateDoctorPasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:update-doctor-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Password of all doctors to 123456';

    /**
     * @var DoctorRepositoryInterface
     */
    protected $doctorRepository;

    /**
     * UpdateDoctorPasswordCommand constructor.
     */
    public function __construct(DoctorRepositoryInterface $doctorRepository)
    {
        parent::__construct();

        $this->doctorRepository = $doctorRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $doctors = $this->doctorRepository->all();

        /** @var Doctor $doctor */
        foreach ($doctors as $doctor) {
            $doctor->password = '123456';

            $this->doctorRepository->save($doctor);
        }

        $this->info('Update all doctors password successfully.');
    }
}

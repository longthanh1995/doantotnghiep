<?php

namespace App\Jobs\DoctorProfile;

use App\Jobs\Job;
use App\Models\Doctor;
use App\Models\ManaUser;
use App\Repositories\DoctorRepositoryInterface;
use App\Repositories\ManaUserRepositoryInterface;

use Barryvdh\Debugbar\Facade as Debugbar;

class EditPersonalContact extends Job
{
    /**
     * @var Doctor
     */
    protected $doctor;

    /**
     * @var array
     */
    protected $doctorData;

    /**
     * EditBasicInformation constructor.
     *
     * @param Doctor $doctor
     * @param $data
     */
    public function __construct(Doctor $doctor, array $data)
    {
        $this->doctor = $doctor;
        $this->user = $doctor->account;

        $this->buildDoctorData($data);
    }

    protected function buildDoctorData($data)
    {
        $fillables = [
            'phone_country_code',
            'phone_number',
            'email',
            'website',
            'address',
            'office_hours',
            'country_id'
        ];

        $fillableData = array_only($data, $fillables);

        foreach ($fillables as $key) {
            $this->doctorData[$key] = array_get($fillableData, $key);
        }
    }

    /**
     * @param DoctorRepositoryInterface $doctorRepository
     * @param ManaUserRepositoryInterface $userRepository
     */
    public function handle(DoctorRepositoryInterface $doctorRepository, ManaUserRepositoryInterface $userRepository)
    {
        $doctorRepository->update($this->doctor, $this->doctorData);
        if($this->user){
            $userRepository->update($this->user, [
                'email' => $this->doctorData['email']
            ]);
        }
    }
}

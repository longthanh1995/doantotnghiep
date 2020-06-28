<?php

namespace App\Jobs\DoctorQualification;

use Illuminate\Database\QueryException;
use App\Jobs\Job;
use App\Models\Doctor;
use App\Repositories\DoctorQualificationRepositoryInterface;
use App\Repositories\Eloquent\DoctorQualificationRepository;
use Carbon\Carbon;

class CreateQualification extends Job
{
    /**
     * @var Doctor
     */
    protected $doctor;

    /**
     * @var void
     */
    protected $data;

    /**
     * CreateQualification constructor.
     *
     * @param Doctor $doctor
     * @param array $data
     */
    public function __construct(Doctor $doctor, array $data)
    {
        $this->doctor = $doctor;
        $this->data = $this->buildData($data);
    }

    protected function buildData($data)
    {
        $date = new Carbon();
        $data['issued_time'] = $date->setDateTime($data['issued_time'], 1, 1, 0, 0, 0);

        return array_only($data, [
            'name',
            'issuer',
            'issued_time',
        ]);
    }

    /**
     * @param DoctorQualificationRepositoryInterface $doctorQualificationRepository
     */
    public function handle(DoctorQualificationRepositoryInterface $doctorQualificationRepository)
    {
        return $doctorQualificationRepository->create(array_merge($this->data, [
            'doctor_id' => $this->doctor->id,
        ]));
    }
}

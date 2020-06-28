<?php

namespace App\Jobs\DoctorCollege;

use App\Jobs\Job;
use App\Models\Doctor;
use App\Models\MedicalSchool;
use App\Repositories\DoctorRepositoryInterface;
use App\Repositories\MedicalSchoolRepositoryInterface;
use Carbon\Carbon;

class CreateCollege extends Job
{
    /**
     * @var Doctor
     */
    protected $doctor;

    /**
     * @var array
     */
    protected $data;

    /**
     * CreateCollege constructor.
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
        $data['name'] = trim($data['name']);

        return array_only($data, [
            'name',
            'date_of_graduation',
        ]);
    }

    /**
     * @param DoctorRepositoryInterface $doctorRepository
     * @param MedicalSchoolRepositoryInterface $medicalSchoolRepository
     */
    public function handle(
        DoctorRepositoryInterface $doctorRepository,
        MedicalSchoolRepositoryInterface $medicalSchoolRepository
    ) {
        /** @var MedicalSchool $medicalSchool */
        $medicalSchool = $medicalSchoolRepository->getBlankModel()->newQuery()->firstOrCreate([
            'name' => $this->data['name'],
        ]);

        $medicalSchoolRepository->save($medicalSchool);

        list($day, $month, $year) = explode('/', $this->data['date_of_graduation']);

        $date = new Carbon();
        $date->setDateTime($year, $month, $day, 0, 0, 0);

        $this->doctor->medicalSchools()->attach($medicalSchool->id, [
            'date_of_graduation' => $date,
        ]);

        $doctorRepository->save($this->doctor);

        //re-query from doctor to make sure we get all pivot values
        return $this->doctor->medicalSchools()->find($medicalSchool->id);
    }
}

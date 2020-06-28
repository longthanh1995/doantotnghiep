<?php

namespace App\Jobs\DoctorProfile;

use App\Jobs\Job;
use App\Models\Doctor;
use App\Models\DoctorProfession;
use App\Repositories\DoctorProfessionRepositoryInterface;
use App\Repositories\DoctorRepositoryInterface;
use App\Repositories\LanguageRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Barryvdh\Debugbar\Facade as Debugbar;

class EditBasicInformation extends Job
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

        $this->buildDoctorData($data);
    }

    protected function buildDoctorData($data)
    {
        $fillables = [
            'title',
            'name',
            'date_of_birth',
            'gender',
            'languages',
            'professions',
        ];

        $fillableData = array_only($data, $fillables);

        foreach ($fillables as $key) {
            $this->doctorData[$key] = array_get($fillableData, $key);
        }
    }

    /**
     * @param DoctorRepositoryInterface $doctorRepository
     * @param DoctorProfessionRepositoryInterface $doctorProfessionRepository
     */
    public function handle(DoctorRepositoryInterface $doctorRepository, DoctorProfessionRepositoryInterface $doctorProfessionRepository)
    {
        list($day, $month, $year) = explode('/', $this->doctorData['date_of_birth']);

        $birth = new Carbon;
        $birth->setDateTime($year, $month, $day, 0, 0, 0);

        $doctorRepository->update($this->doctor, [
            'name' => $this->doctorData['name'],
            'date_of_birth' => $birth,
            'gender' => $this->doctorData['gender'],
            'doctor_title_id' => $this->doctorData['title'],
        ]);

        /*
         * Set languages
         */
        $this->doctor->languages()->sync($this->doctorData['languages']);

        /*
         * Set profession
         */
        $storedProfessionCollection = new Collection();

        if (count($this->doctorData['professions']) > 0) {
            foreach ($this->doctorData['professions'] as $professionData) {
                $license = $professionData['license'];
                $name = $professionData['name'];

                if (strlen($name) < 2 || strlen($license) < 2) {
                    continue;
                }

                /** @var DoctorProfession $profession */
                $profession = $this->doctor->professions()->firstOrCreate([
                    'doctor_id' => $this->doctor->id,
                    'license_no' => $license,
                    'name' => $name,
                ]);

                $storedProfessionCollection->push($profession);
            }
        }

        // Delete the others.
        $doctorProfessionRepository->getBlankModel()
            ->newQuery()
            ->getQuery()
            ->where('doctor_id', $this->doctor->id)
            ->whereNotIn('id', $storedProfessionCollection->pluck('id')->toArray())
            ->delete();

        $doctorRepository->save($this->doctor);

        return response()->json([
            'success' => true
        ]);
    }
}

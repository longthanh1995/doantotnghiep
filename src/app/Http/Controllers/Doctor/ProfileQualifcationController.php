<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorQualification\DoctorQualificationRequest;
use App\Jobs\DoctorQualification\CreateQualification;
use App\Jobs\DoctorQualification\DeleteQualification;
use App\Jobs\DoctorQualification\EditQualification;
use App\Models\Doctor;
use App\Models\DoctorQualification;
use App\Services\DoctorServiceInterface;
use Barryvdh\Debugbar\Facade as Debugbar;

class ProfileQualifcationController extends Controller
{
    /**
     * @var DoctorServiceInterface
     */
    protected $doctorService;

    /**
     * ProfileQualifcationController constructor.
     *
     * @param DoctorServiceInterface $doctorService
     */
    public function __construct(DoctorServiceInterface $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    public function store(DoctorQualificationRequest $request)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        // dd($request->all());
        try {
            $this->dispatchNow(new CreateQualification(
                $doctor,
                $request->all()
            ));


        } catch( \Exception $e) {

            if (str_contains($e->getMessage(), 'uix_qualifications')){
                flash()->warning('The qualification has already been added');
            } else {
                flash()->warning('Something went wrong');
            }

            return back();
        }

        return back();
    }

    public function update(DoctorQualificationRequest $request, DoctorQualification $doctorQualification)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $this->authorizeForUser($doctor, 'edit', $doctorQualification);

        $this->dispatchNow(new EditQualification(
            $doctorQualification,
            $request->all()
        ));

        return back();
    }

    public function destroy(DoctorQualification $doctorQualification)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $this->authorizeForUser($doctor, 'delete', $doctorQualification);

        $this->dispatchNow(new DeleteQualification(
            $doctorQualification
        ));

        return back();
    }
}

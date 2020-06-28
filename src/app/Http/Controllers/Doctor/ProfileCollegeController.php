<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorCollege\DoctorCollegeRequest;
use App\Jobs\DoctorCollege\CreateCollege;
use App\Jobs\DoctorCollege\DeleteCollege;
use App\Jobs\DoctorCollege\EditCollege;
use App\Models\Doctor;
use App\Services\DoctorServiceInterface;

class ProfileCollegeController extends Controller
{
    /**
     * @var DoctorServiceInterface
     */
    protected $doctorService;

    /**
     * ProfileCollegeController constructor.
     *
     * @param DoctorServiceInterface $doctorService
     */
    public function __construct(DoctorServiceInterface $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    public function store(DoctorCollegeRequest $request)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $this->dispatchNow(new CreateCollege(
            $doctor, $request->all()
        ));

        return back();
    }

    public function update(DoctorCollegeRequest $request, $id)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $this->dispatchNow(new EditCollege(
            $doctor, $id, $request->all()
        ));

        return back();
    }

    public function destroy($id)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $this->dispatchNow(new DeleteCollege(
            $doctor, $id
        ));

        return back();
    }
}

<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Repositories\ClinicRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Class ClinicController
 * @package App\Http\Controllers\Doctor
 */
class ClinicController extends Controller
{
    /**
     * @var ClinicRepositoryInterface
     */
    private $clinicRepository;

    /**
     * ClinicController constructor.
     * @param ClinicRepositoryInterface $clinicRepository
     */
    public function __construct(
        ClinicRepositoryInterface $clinicRepository
    )
    {
        $this->clinicRepository = $clinicRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = [];
        if($clinicTypeId = $request->input('clinic_type_id')){
            $query['clinic_type_id'] = $clinicTypeId;
        }
        $clinics = $this->clinicRepository->getBlankModel()->where($query)->get();
        $clinics->load([
            'doctors',
            'doctors.timetableConfigs',
        ]);

        return response()->json($clinics);
    }
}
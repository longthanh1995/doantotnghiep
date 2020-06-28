<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Services\DoctorServiceInterface;

class IndexController extends Controller
{
    /**
     * @var DoctorServiceInterface
     */
    protected $doctorService;

    /**
     * IndexController constructor.
     *
     * @param DoctorServiceInterface $doctorService
     */
    public function __construct(DoctorServiceInterface $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    public function index()
    {
        if ($this->doctorService->getUser()) {
            return redirect()->route('doctor.dashboard');
        }

        return redirect()->route('doctor.signIn');
    }
}

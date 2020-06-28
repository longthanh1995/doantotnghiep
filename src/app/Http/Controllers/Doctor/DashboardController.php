<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Repositories\AppointmentRepositoryInterface;
use App\Repositories\Eloquent\PatientRepository;
use App\Repositories\PatientRepositoryInterface;
use App\Services\DoctorServiceInterface;
use Illuminate\Support\Collection;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function __construct(
        DoctorServiceInterface $doctorService,
        AppointmentRepositoryInterface $appointmentRepository,
        PatientRepositoryInterface $patientRepository
    ){
        $this->doctorService = $doctorService;
        $this->appointmentRepository = $appointmentRepository;
        $this->patientRepository = $patientRepository;
    }

    public function index()
    {
        $currentDoctor = $this->doctorService->getUser()->account;

        $statistics = Cache::remember('statistics_doctor_'.$currentDoctor->id, 60, function() use ($currentDoctor){
            $result = [
                'clinics' => []
            ];

            foreach($currentDoctor->clinics as $clinic){
                $newAppointments = $this->appointmentRepository->getBlankModel()
                    ->where('doctor_id', $this->doctorService->getUser()->account->id)
                    ->whereHas('doctorTimetable', function($query) use ($clinic){
                        $query->where('clinic_id', $clinic->id);
                    })
                    ->where('created_at', '>=', (new \Carbon\Carbon())->startOfWeek()->toDateTimeString())
                    ->get()
                ;

                $newAppointmentsMadeFromApp = $newAppointments->filter(function($newAppointment){
                    return $newAppointment->book_source == 'M';
                });

                $newPatients = $this->patientRepository->getBlankModel()
                    ->whereHas('clinics', function($query) use ($clinic){
                        $query->where('patient_clinic.created_at', '>=', (new \Carbon\Carbon())->startOfWeek()->toDateTimeString());
                        $query->where('patient_clinic.clinic_id', $clinic->id);
                    })
                    ->get()
                ;

                $newPatientUsingFromApp = $newPatients->filter(function($newPatient){
                    return $newPatient->user_id;
                });

                $doctorCinicStatistics = [
                    'info' => $clinic->toArray(),
                    'statistics' => [
                        'numberOfNewPatients' => $newPatients->count(),
                        'numberOfNewPatientsUsingApp' => $newPatientUsingFromApp->count(),
                        'numberOfNewAppointments' => $newAppointments->count(),
                        'numberOfNewAppointmentsMadeFromApp' => $newAppointmentsMadeFromApp->count()
                    ]
                ];

                array_push($result['clinics'], $doctorCinicStatistics);
            }

            return $result;
        });

        return view('doctor.pages.dashboard.index', [
            'statistics' => $statistics
        ]);
    }
}

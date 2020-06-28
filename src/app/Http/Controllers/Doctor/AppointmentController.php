<?php

namespace App\Http\Controllers\Doctor;

use App\Jobs\Activity\CreateActivity;
use App\Jobs\Appointment\CreateAppointmentMessage;
use App\Jobs\Appointment\CreateHouseCallAppointmentInformation;
use App\Jobs\Appointment\MarkAppointmentAsLate;
use App\Jobs\Appointment\MarkAppointmentAsNoShow;
use App\Models\AppointmentMessage;
use App\Models\AppointmentType;
use App\Repositories\DoctorRepositoryInterface;
use App\Repositories\DoctorSettingRepositoryInterface;
use App\Repositories\Eloquent\AppointmentRepository;
use App\Repositories\ManaImageRepositoryInterface;
use Barryvdh\Debugbar\Facade as Debugbar;
use Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\CancelAppointmentRequest;
use App\Http\Requests\Appointment\ConfirmAppointmentRequest;
use App\Http\Requests\Appointment\CreateAppointmentRequest;
use App\Http\Requests\Appointment\FilterSearchRequest;
use App\Jobs\Appointment\CancelAppointment;
use App\Jobs\Appointment\ConfirmAppointment;
use App\Jobs\Appointment\CreateAppointment;
use App\Jobs\Appointment\RescheduleAppointment;
use App\Jobs\Appointment\VisitAppointment;
use App\Models\Appointment;
use App\Models\AppointmentHealthSummary;
use App\Models\AppointmentStatus;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\DoctorTimetable;
use App\Models\DoctorTimetableTime;
use App\Models\Patient;
use App\Models\PatientCondition;
use App\Repositories\AppointmentRepositoryInterface;
use App\Repositories\DoctorBookingFeeRepositoryInterface;
use App\Repositories\DoctorTimetableRepositoryInterface;
use App\Repositories\PatientConditionRepositoryInterface;
use App\Repositories\PatientRepositoryInterface;
use App\Services\DoctorServiceInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

/**
 * Class AppointmentController.
 */
class AppointmentController extends Controller
{
    /**
     * @var DoctorServiceInterface
     */
    protected $doctorService;

    /**
     * @var AppointmentRepositoryInterface
     */
    protected $appointmentRepository;

    /**
     * @var PatientRepositoryInterface
     */
    protected $patientRepository;

    /**
     * @var DoctorTimetableRepositoryInterface
     */
    protected $doctorTimetableRepository;

    /**
     * @var DoctorBookingFeeRepositoryInterface
     */
    protected $doctorBookingFeeRepository;

    private $doctorRepository;

    public function __construct(
        DoctorServiceInterface $doctorService,
        AppointmentRepositoryInterface $appointmentRepository,
        PatientRepositoryInterface $patientRepository,
        DoctorTimetableRepositoryInterface $doctorTimetableRepository,
        DoctorBookingFeeRepositoryInterface $doctorBookingFeeRepository,
        DoctorSettingRepositoryInterface $doctorSettingRepository,
        ManaImageRepositoryInterface $manaImageRepository,
        DoctorRepositoryInterface $doctorRepository
    )
    {
        $this->doctorService = $doctorService;
        $this->appointmentRepository = $appointmentRepository;
        $this->patientRepository = $patientRepository;
        $this->doctorTimetableRepository = $doctorTimetableRepository;
        $this->doctorBookingFeeRepository = $doctorBookingFeeRepository;
        $this->doctorSettingRepository = $doctorSettingRepository;
        $this->manaImageRepository = $manaImageRepository;
        $this->doctorRepository = $doctorRepository;
    }

    public function index()
    {
        return redirect()->route('appointment.confirmedBooking');
    }

    public function store(CreateAppointmentRequest $request)
    {
        /*
         * Find Patient
         */
        /* @var Patient $patient */
        abort_unless($patient = $this->patientRepository->find($request->get('patient_id')), 400);

        /*
         * Find Doctor Timetable
         */
        /* @var DoctorTimetable $doctorTimetable */
        abort_unless($doctorTimetable = $this->doctorTimetableRepository->find($request->get('appointment-time-slot')), 400);

        /*
         * Time Slot is not available
         */
        if (!$doctorTimetable->isReadyToBook()) {
            return response()->json([
                'message' => 'Time slot is already booked. Please choose another time slot.',
            ], 400);
        }

        /** @var Doctor $doctor */
        $user = $this->doctorService->getUser();
        $doctorId = $request->get('doctor_id');
        $currentDoctor = $user->account;
        $doctor = $doctorId ? $this->doctorRepository->find($doctorId) : $currentDoctor;

        /*
         * Authorize Doctor Timetable
         */

        abort_unless(Gate::forUser($currentDoctor)->check('createNewAppointment', $doctorTimetable), 403, 'You cannot create appointment for this timeslot');

        $selectedAppointmentType = AppointmentType::find($doctorTimetable->appointment_type_id);
        if ($selectedAppointmentType && in_array($selectedAppointmentType->name, config('data.house_call_appointment_types'))) {
            $patient_address = $request->get('patient_address');
            $patient_location_lat = $request->get('patient_location_lat');
            $patient_location_lng = $request->get('patient_location_lng');

            if (empty($patient_address) || empty($patient_location_lat) || empty($patient_location_lng)) {
                abort(400, 'Please fill in the patient\'s address & location');
            }
        }

        $note = $request->get('note');

        //book for other doctor
        if($doctorId != $currentDoctor->id){
            $doctorTitle = $currentDoctor->title?$currentDoctor->title->title:'';
            $note = "This appointment has been booked by {$doctorTitle} {$currentDoctor->getFullname()}. {$note}";
        }

        /** @var Appointment $appointment */
        $appointment = $this->dispatchNow(new CreateAppointment(
            $doctor,
            $patient,
            $doctorTimetable,
            $request->get('booking_reason'),
            $note
        ));
        dd($appointment);

        //attach uploaded files to newly created appointment
        $files = $request->get('files');
        if (count($files)) {
            $appointment->files()->attach($files);

            //save the description to file record in `images` table instead of `appointment_files` table
            foreach($files as $fileId => $fileData){
                $this->manaImageRepository->getBlankModel()->find($fileId)->update($fileData);
            }
        }

        if ($selectedAppointmentType && in_array($selectedAppointmentType->name, config('data.house_call_appointment_types'))) {
            $house_call_appointment_information = $this->dispatchNow(new CreateHouseCallAppointmentInformation(
                $appointment,
                $request->get('patient_address'),
                $request->get('patient_location_lat'),
                $request->get('patient_location_lng')
            ));
        }

        $appointment->load([
            'doctor',
            'doctor.title',
            'appointmentType',
            'clinic',
            'patient'
        ]);

        return response()->json($appointment);
    }

    public function reschedule(Request $request)
    {
        abort_unless($doctor = $this->doctorService->getUser()->account, 400);
        abort_unless($appointment = $this->appointmentRepository->find($request->get('appointmentId')), 400);
        abort_unless($doctorTimetable = $this->doctorTimetableRepository->find($request->get('doctorTimetableId')), 400);

        $this->authorizeForUser($doctor, 'reschedule', [$appointment, $doctorTimetable]);

        $appointment = $this->dispatchNow(new RescheduleAppointment(
            $appointment,
            $doctorTimetable
        ));

        return response()->json([
            'success' => true
        ]);
    }

    public function show(Appointment $appointment)
    {
        $appointment->load([
            'patient',
            'patient.profileImage',
            'user',
            'patientCondition',
            'doctorTimetable.clinic',
            'booker',
            'healthSummary',
            'files',
            'messages',
            'clinic',
        ]);

        $patientClinicMRID = null;
        $patient = $appointment->patient;
        $clinic = $appointment->clinic;
        if($patient && $clinic){
            $patientClinicRecord = $patient->clinics->filter(function($patientClinic) use ($appointment, $clinic){
                return $patientClinic->id === $clinic->id;
            })->first();

            if($patientClinicRecord){
                $patientClinicMRID = $patientClinicRecord->pivot->medical_record_number;
            }
        }

        return view('doctor.pages.appointments.details', [
            'appointment' => $appointment,
            'patientClinicMRID' => $patientClinicMRID,
        ]);
    }

    public function fetch(Appointment $appointment)
    {
        $appointment->load(
            'patient.profileImage',
            'user',
            'patientCondition',
            'doctorTimetable.clinic',
            'booker',
            'healthSummary',
            'files'
        );

        return response()->json($appointment);
    }

    public function visitSubmit(Appointment $appointment)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $this->authorizeForUser($doctor, 'visit', [$appointment]);

        $this->dispatchNow(new VisitAppointment(
            $appointment
        ));

        return back();
    }

    public function cancelSubmit(Appointment $appointment, CancelAppointmentRequest $request)
    {
        /** @var Doctor $doctor */
        $user = $this->doctorService->getUser();
        $doctor = $user->account;

        $this->authorizeForUser($doctor, 'cancel', [$appointment]);

        $this->dispatchNow(new CancelAppointment(
            $user,
            $doctor,
            $appointment,
            $request->all()
        ));

        return back();
    }

    /**
     * @param Appointment $appointment
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function markAsNoShowSubmit(Appointment $appointment, Request $request)
    {
        /** @var Doctor $doctor */
        $user = $this->doctorService->getUser();
        $doctor = $user->account;

        $this->authorizeForUser($doctor, 'markAsNoShow', [$appointment]);

        $this->dispatchNow(new MarkAppointmentAsNoShow(
            $user,
            $doctor,
            $appointment
        ));

        return back();
    }

    /**
     * @param Appointment $appointment
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function markAsLateSubmit(Appointment $appointment, Request $request)
    {
        /** @var Doctor $doctor */
        $user = $this->doctorService->getUser();
        $doctor = $user->account;

        $this->authorizeForUser($doctor, 'markAsLate', [$appointment]);

        $this->dispatchNow(new MarkAppointmentAsLate(
            $user,
            $doctor,
            $appointment
        ));

        return back();
    }

    public function confirmedBooking(FilterSearchRequest $request)
    {
        // Set current sidebar
        \View::share('sidebarCurrentView', 'appointment.confirmedBooking');

        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $doctor->load('clinics');

        $appointments = $this->appointmentRepository->getConfirmedBookingAppointments($doctor, $request->all());

        $doctorClinicsOption = $doctor->clinics->pluck('name', 'id')->toArray();

        return view('doctor.pages.appointments.index-confirmed', [
            'appointments' => $appointments,
            'doctorClinicsOption' => $doctorClinicsOption,
            'queries' => [
                'patientName' => $request->get('patientName'),
                'patientNationalIdNumber' => $request->get('patientNationalIdNumber'),
                'clinic' => $request->get('clinic'),
                'appointmentBooking' => $request->get('appointmentBooking'),
                'appointmentStatus' => AppointmentStatus::STATUS_CONFIRMED,
                'isPaginated' => $request->get('isPaginated'),
            ]
        ]);
    }

    public function visitedBooking(FilterSearchRequest $request)
    {
        // Set current sidebar
        \View::share('sidebarCurrentView', 'appointment.visitedBooking');

        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;
        $doctor->load('clinics');

        $appointments = $this->appointmentRepository->getVisitedBookingAppointments($doctor, $request->all());

        $doctorClinicsOption = $doctor->clinics->pluck('name', 'id')->toArray();

        return view('doctor.pages.appointments.index-visited', [
            'appointments' => $appointments,
            'doctorClinicsOption' => $doctorClinicsOption,
            'queries' => [
                'patientName' => $request->get('patientName'),
                'patientNationalIdNumber' => $request->get('patientNationalIdNumber'),
                'clinic' => $request->get('clinic'),
                'appointmentBooking' => $request->get('appointmentBooking'),
                'appointmentStatus' => AppointmentStatus::STATUS_VISITED,
                'isPaginated' => $request->get('isPaginated'),
            ],
        ]);
    }

    public function cancelledBooking(FilterSearchRequest $request)
    {
        // Set current sidebar
        \View::share('sidebarCurrentView', 'appointment.cancelledBooking');

        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;
        $doctor->load('clinics');

        $appointments = $this->appointmentRepository->getCancelledBookingAppointments($doctor, $request->all());

        $doctorClinicsOption = $doctor->clinics->pluck('name', 'id')->toArray();

        return view('doctor.pages.appointments.index-cancelled', [
            'appointments' => $appointments,
            'doctorClinicsOption' => $doctorClinicsOption,
            'queries' => [
                'patientName' => $request->get('patientName'),
                'patientNationalIdNumber' => $request->get('patientNationalIdNumber'),
                'clinic' => $request->get('clinic'),
                'appointmentBooking' => $request->get('appointmentBooking'),
                'appointmentStatus' => AppointmentStatus::STATUS_CANCELLED,
                'isPaginated' => $request->get('isPaginated'),
            ],
        ]);
    }

    public function notShowingUpBooking(FilterSearchRequest $request)
    {
        // Set current sidebar
        \View::share('sidebarCurrentView', 'appointment.notShowingBooking');

        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;
        $doctor->load('clinics');

        $appointments = $this->appointmentRepository->getNotShowingUpBookingAppointments($doctor, $request->all());

        $doctorClinicsOption = $doctor->clinics->pluck('name', 'id')->toArray();

        return view('doctor.pages.appointments.index-notShowingUp', [
            'appointments' => $appointments,
            'doctorClinicsOption' => $doctorClinicsOption,
            'queries' => [
                'patientName' => $request->get('patientName'),
                'patientNationalIdNumber' => $request->get('patientNationalIdNumber'),
                'clinic' => $request->get('clinic'),
                'appointmentBooking' => $request->get('appointmentBooking'),
                'appointmentStatus' => AppointmentStatus::STATUS_NOT_SHOWING_UP,
                'isPaginated' => $request->get('isPaginated'),
            ],
        ]);
    }

    public function lateBooking(FilterSearchRequest $request)
    {
        // Set current sidebar
        \View::share('sidebarCurrentView', 'appointment.lateBooking');

        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;
        $doctor->load('clinics');

        $appointments = $this->appointmentRepository->getLateBookingAppointments($doctor, $request->all());

        $doctorClinicsOption = $doctor->clinics->pluck('name', 'id')->toArray();

        return view('doctor.pages.appointments.index-late', [
            'appointments' => $appointments,
            'doctorClinicsOption' => $doctorClinicsOption,
            'queries' => [
                'patientName' => $request->get('patientName'),
                'patientNationalIdNumber' => $request->get('patientNationalIdNumber'),
                'clinic' => $request->get('clinic'),
                'appointmentBooking' => $request->get('appointmentBooking'),
                'appointmentStatus' => AppointmentStatus::STATUS_LATE,
                'isPaginated' => $request->get('isPaginated'),
            ],
        ]);
    }

    public function createHealthSummary(Appointment $appointment, Request $request)
    {
        abort_unless($healthSummary = new AppointmentHealthSummary($request->all()), 400, 'Cannot create health summary. Please check input data again.');
        abort_unless($healthSummary->save(), 500, 'Cannot save this health summary. Please try later.');

        return response()->json([
            'success' => true
        ]);
    }

    public function updateHealthSummary(Appointment $appointment, Request $request)
    {
        abort_unless($healthSummary = $appointment->healthSummary, 404, 'There\'s no health summary attached to this appointment yet. Please check again.');
        abort_unless($healthSummary->update($request->all()), 400, 'Cannot update health summary. Please check input data again.');
        abort_unless($healthSummary->save(), 500, 'Cannot update this health summary. Please try later.');
        return response()->json([
            'success' => true
        ]);
    }

    public function updateBookingReason(Appointment $appointment, Request $request)
    {
        abort_unless($doctor = $this->doctorService->getUser()->account, 400);
        $this->authorizeForUser($doctor, 'updateBookingReason', [$appointment]);
        abort_unless($appointment->update(['booking_reason' => $request->get('booking_reason')]), 400, 'Cannot update booking reason. Please check input data again.');
        return response()->json([
            'success' => true
        ]);
    }

    public function sendMessage(Appointment $appointment, Request $request)
    {
        abort_unless($user = $this->doctorService->getUser(), 400);
        abort_unless($doctor = $user->account, 400);
        $this->authorizeForUser($doctor, 'sendAppointmentMessage', [$appointment]);

        $message = $request->get('message');

        $appointmentMessage = $this->dispatchNow(new CreateAppointmentMessage(
            $appointment,
            $message,
            $user
        ));
        return response()->json([
            'success' => true
        ]);
    }

    public function exportXls(Request $request)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $doctorTimezoneSetting = $this->doctorSettingRepository->getBlankModel()
            ->whereDoctorId($doctor->id)
            ->whereName('timezone')
            ->first();

        $doctorTimezone = $doctorTimezoneSetting ? $doctorTimezoneSetting->value : 'UTC';

        //get the data
        $appointments = $this->appointmentRepository->getAppointments($doctor, $request->all());

        //generate filename
        $exportingFileName = 'exported-appointments-' . \DateTimeHelper::setTimeZoneByStr(\Carbon\Carbon::now(), $doctorTimezone)->format('Y-m-d-H-i-s');

        //build the exporting data
        $exportingData = new Collection();
        foreach ($appointments as $appointment) {
            $patient = $appointment->patient;
            $timeslot = $appointment->doctorTimetable;
            $doctor = $appointment ? $appointment->doctor : null;
            $clinic = $timeslot ? $timeslot->clinic : null;
            $clinicTimezone = $clinic ? $clinic->time_zone : 'GMT';
            $appointmentType = $appointment->appointmentType;
            $booker = $appointment->booker;
            $appointmentStatus = $appointment->appointmentStatus;

            $exportingData->push([
                'ID' => $appointment->id,
                'Created at' => \DateTimeHelper::setTimeZoneByStr($appointment->created_at, $clinicTimezone)->format('Y-m-d H:i'),
                'Updated at' => \DateTimeHelper::setTimeZoneByStr($appointment->updated_at, $clinicTimezone)->format('Y-m-d H:i'),
                'Start at' => \DateTimeHelper::setTimeZoneByStr($appointment->start_at, $clinicTimezone)->format('Y-m-d H:i'),
                'End at' => \DateTimeHelper::setTimeZoneByStr($appointment->end_at, $clinicTimezone)->format('Y-m-d H:i'),
                'Timezone' => 'GMT+' . \Carbon\Carbon::now($clinicTimezone)->offsetHours,
                'Clinic' => $clinic ? $clinic->name : null,
                'Doctor' => $doctor ? $doctor->name : null,
                'Patient ID' => $patient ? $patient->id : null,
                'Patient Name' => $patient ? $patient->getFullname() : null,
                'Patient ID Number' => $patient ? $patient->id_number : null,
                'Patient Phone Number' => $patient ? $patient->phone_country_code . ' ' . $patient->phone_number : null,
                'Imported Phone Number' => $patient ? $patient->imported_phone : null,
                'Booker Patient ID' => $booker ? $booker->id : null,
                'Booker' => $booker ? $booker->getFullname() : null,
                'Status' => $appointmentStatus ? $appointmentStatus->name : null,
                'Appointment Type' => $appointmentType ? $appointmentType->name : null,
                'Booking Reason' => $appointment->booking_reason,
                'Cancel Reason' => $appointment->cancel_reason,
                'Medical Condition' => $patient ? $patient->medical_condition : null,
                'Drug Allergy' => $patient ? $patient->drug_allergy : null
            ]);
        }

        return Excel::create($exportingFileName, function ($excel) use ($exportingData) {
            $excel->sheet('Appointments', function ($sheet) use ($exportingData) {
                $sheet->fromModel($exportingData);
            });
        })->export('xls');
    }

    public function exportPdf(Request $request)
    {

        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $doctor->load('clinics');

        $appointments = $this->appointmentRepository->getAppointments($doctor, $request->all());

        $doctorClinicsOption = $doctor->clinics->pluck('name', 'id')->toArray();
//        $doctorClinicsOption = array_add($doctorClinicsOption, 'default', 'All clinics');

        $doctorTimezoneSetting = $this->doctorSettingRepository->getBlankModel()
            ->whereDoctorId($doctor->id)
            ->whereName('timezone')
            ->first();

        $doctorTimezone = $doctorTimezoneSetting ? $doctorTimezoneSetting->value : 'UTC';
        //generate filename
        $exportingFileName = 'exported-appointments-' . \DateTimeHelper::setTimeZoneByStr(\Carbon\Carbon::now(), $doctorTimezone)->format('Y-m-d-H-i-s');

        $appointmentStatus = AppointmentStatus::STATUS_CONFIRMED;


        $pdf = PDF::loadView('pdf.pages.appointments', [
            'appointments' => $appointments,
            'doctorClinicsOption' => $doctorClinicsOption,
            'queries' => [
                'patientName' => $request->get('patientName'),
                'patientNationalIdNumber' => $request->get('patientNationalIdNumber'),
                'clinic' => $request->get('clinic'),
                'appointmentBooking' => $request->get('appointmentBooking'),
                'appointmentStatus' => $appointmentStatus,
                'isPaginated' => $request->get('isPaginated'),
            ]
        ])->setOptions([
            'dpi' => 300,
            'margin-top' => '100mm',
            'footer-html' => view('pdf.pages.footer'),
        ]);
        return $pdf->download($exportingFileName . '.pdf');
    }

    public function markAsVisited(Appointment $appointment)
    {
        $user = $this->doctorService->getUser();
        $doctor = $user->account;

        $this->authorizeForUser($doctor, 'visit', [$appointment]);

        $this->dispatchNow(new VisitAppointment(
            $appointment
        ));

        $this->dispatchNow(new CreateActivity(
            'user',
            $user->id,
            'mark_visited.appointment',
            'appointment',
            $appointment->id,
            ''
        ));

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @param Appointment $appointment
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function markAsNoShow(Appointment $appointment)
    {
        $user = $this->doctorService->getUser();
        $doctor = $user->account;

        $this->authorizeForUser($doctor, 'markAsNoShow', [$appointment]);

        $this->dispatchNow(new MarkAppointmentAsNoShow(
            $user,
            $doctor,
            $appointment
        ));

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @param Appointment $appointment
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function markAsLate(Appointment $appointment)
    {
        $user = $this->doctorService->getUser();
        $doctor = $user->account;

        $this->authorizeForUser($doctor, 'markAsLate', [$appointment]);

        $this->dispatchNow( new MarkAppointmentAsLate(
            $user,
            $doctor,
            $appointment
        ));

        return response()->json([
            'success' => true
        ]);
    }
}

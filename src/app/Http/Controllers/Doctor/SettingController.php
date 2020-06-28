<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\PriceSubmitRequest;
use App\Models\AppointmentType;
use App\Models\Doctor;
use App\Models\DoctorTimetable;
use App\Repositories\AppointmentTypeRepositoryInterface;
use App\Repositories\DoctorSettingRepositoryInterface;
use App\Services\DoctorServiceInterface;
use App\Services\TeleconsultServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class SettingController
 * @package App\Http\Controllers\Doctor
 */
class SettingController extends Controller
{
    /**
     * @var DoctorServiceInterface
     */
    protected $doctorService;

    /**
     * @var TeleconsultServiceInterface
     */
    private $teleconsultService;

    /**
     * @var AppointmentTypeRepositoryInterface
     */
    protected $appointmentTypeRepository;

    /**
     * SettingController constructor.
     * @param DoctorServiceInterface $doctorService
     * @param AppointmentTypeRepositoryInterface $appointmentTypeRepository
     * @param DoctorSettingRepositoryInterface $doctorSettingRepository
     * @param TeleconsultServiceInterface $teleconsultService
     */
    public function __construct(
        DoctorServiceInterface $doctorService,
        AppointmentTypeRepositoryInterface $appointmentTypeRepository,
        DoctorSettingRepositoryInterface $doctorSettingRepository,
        TeleconsultServiceInterface $teleconsultService
    )
    {
        $this->doctorService = $doctorService;
        $this->appointmentTypeRepository = $appointmentTypeRepository;
        $this->doctorSettingRepository = $doctorSettingRepository;
        $this->teleconsultService = $teleconsultService;

        // Set current sidebar
        \View::share('sidebarCurrentView', 'setting.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;
        $doctorAppointmentTypes = $doctor->timetableConfigs()->withPivot('duration')->get();
        $doctorClinics = $doctor->clinics;

        $globalAppointmentTypes = AppointmentType::where('is_active', 1)->where('clinic_id', null)->get();
        $clinicAppointmentTypes = AppointmentType::whereIn('clinic_id', $doctorClinics->pluck('id')->all())->get();

        /** @var Collection $appointmentTypesCollection */
        $appointmentTypesCollection = collect($clinicAppointmentTypes)->merge($globalAppointmentTypes);
        $appointmentTypesArr = new Collection($appointmentTypesCollection->pluck('name', 'id')->toArray());
        $appointmentTypesArr->put(0, 'Choose a appointment type');
        $appointmentTypesArr = $appointmentTypesArr->toArray();
        ksort($appointmentTypesArr);

        $listDurations = new Collection(range(0, 180));
        $listDurations->put(0, '0 (Disable)');
        $listDurations = $listDurations->toArray();
        ksort($listDurations);

        return view('doctor.pages.settings.index', [
            'appointmentTypesArr' => $appointmentTypesArr,
            'doctorAppointmentTypes' => $doctorAppointmentTypes,
            'listDurations' => $listDurations
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function appointmentTypeSubmit(Request $request)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $appointmentTypeIdCollection = new Collection($request->get('appointment_type_id'));
        $appointmentTypeDurationCollection = new Collection($request->get('appointment_type_duration'));

        abort_unless($appointmentTypeDurationCollection->count() == $appointmentTypeIdCollection->count(), 400);

        $availableDurations = range(1,180);

        $mergeCollection = $appointmentTypeIdCollection->map(function ($id, $index) use ($appointmentTypeDurationCollection, $availableDurations) {
            $duration = $appointmentTypeDurationCollection->get($index);

            if (!in_array($duration, $availableDurations)) {
                return false;
            }

            return [
                'id' => $id,
                'duration' => $duration
            ];
        })->keyBy('id')->map(function ($data) {
            unset($data['id']);

            return $data;
        });

        /*
         * Sync
         */
        $doctor->timetableConfigs()->sync($mergeCollection->toArray());

        return redirect()->back()->with('appointmentTypeSuccess', 'Update appointment type successfully.');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function price()
    {
        return view('legacy.pages.doctor.setting.price');
    }

    /**
     * @param PriceSubmitRequest $request
     */
    public function priceSubmit(PriceSubmitRequest $request)
    {
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function notification()
    {
        return view('legacy.pages.doctor.setting.notification');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function time()
    {
        $doctor = $this->doctorService->getUser()->account;
        $timezoneSetting = $this->doctorSettingRepository->getBlankModel()
            ->whereDoctorId($doctor->id)
            ->whereName('timezone')
            ->first();

        return view('doctor.pages.settings.time', [
            'timezoneSetting' => $timezoneSetting
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function timeSubmit(Request $request)
    {
        abort_unless($timezoneValue = $request->get('timezone'), 400, 'Please provide timezone.');

        $doctor = $this->doctorService->getUser()->account;

        $this->doctorSettingRepository->getBlankModel()
            ->firstOrCreate([
                'doctor_id' => $doctor->id,
                'name' => 'timezone'
            ])
            ->update([
                'value' => $timezoneValue
            ]);

        flash('Update time settings successfully.', 'info');
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function teleconsults(Request $request)
    {
        return view('doctor.pages.settings.tele-consults');
    }

    /**
     * @return mixed
     */
    public function fetchDoctorInfo()
    {
        $doctor = $this->doctorService->getUser()->account;

        $doctorInfo = $this->teleconsultService->getDoctor($doctor);
        return response()->json([
            "data" => $doctorInfo
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateChatAvailability(Request $request)
    {
        $doctor = $this->doctorService->getUser()->account;
        $availability = $request->get('availability') == 'true'? true:false;

        $doctorInfo = $this->teleconsultService->updateChatAvailability($doctor, $availability);
        return response()->json([
            "data" => $doctorInfo
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateVideoAvailability(Request $request)
    {
        $doctor = $this->doctorService->getUser()->account;
        $availability = $request->get('availability') == 'true'? true:false;
        
        $doctorInfo = $this->teleconsultService->updateVideoAvailability($doctor, $availability);
        return response()->json([
            "data" => $doctorInfo
        ]);
    }

    /**
     * @return mixed
     */
    public function getChatFeeSettings()
    {
        $doctor = $this->doctorService->getUser()->account;

        $chatFeeSettings = $this->teleconsultService->getDoctor($doctor)->chat_fee;
        return response()->json([
            "data" => $chatFeeSettings
        ]);
    }

    /**
     * @return mixed
     */
    public function getVideoFeeSettings()
    {
        $doctor = $this->doctorService->getUser()->account;

        $videoFeeSettings = $this->teleconsultService->getDoctor($doctor)->video_fee;

        return response()->json([
            "data" => $videoFeeSettings
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateChatFeeSettings(Request $request){
        $doctor = $this->doctorService->getUser()->account;
        $firstFiveMessages = $request->get('initial_message_fee');
        $subMessage = $request->get('subsequent_message_fee');
        $consultSummary = $request->get('summary_fee');
        $currencyCode = $request->get('currency');

        $chatFeeSettings = $this->teleconsultService->updateDoctorChatFeeSettings($doctor, $firstFiveMessages, $subMessage, $consultSummary, $currencyCode);
        return response()->json([
            "data" => $chatFeeSettings
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateVideoFeeSettings(Request $request){
        $doctor = $this->doctorService->getUser()->account;
        $firstThreeMinutes = $request->get('video_initial_block');
        $subMinute = $request->get('video_sub_minute');
        $consultSummary = $request->get('video_consult_summary');
        $currencyCode = $request->get('currency');

        $videoFeeSettings = $this->teleconsultService->updateDoctorVideoFeeSettings($doctor, $firstThreeMinutes, $subMinute, $consultSummary, $currencyCode);
        return response()->json([
            "data" => $videoFeeSettings
        ]);
    }

}

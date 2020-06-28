<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Calendar\CreateRequest;
use App\Jobs\Activity\CreateActivity;
use App\Jobs\BlockDoctorTimetableJob;
use App\Jobs\UnblockDoctorTimetableJob;
use App\Jobs\CreateDoctorTimeslotCycleJob;
use App\Jobs\DeleteDoctorTimetableJob;
use App\Jobs\MultiCreateDoctorTimetableJob;
use App\Models\AppointmentType;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\DoctorTimeslotCycle;
use App\Models\DoctorTimetable;
use App\Models\DoctorTimetableTime;
use App\Repositories\AppointmentRepositoryInterface;
use App\Repositories\AppointmentTypeRepositoryInterface;
use App\Repositories\ClinicRepositoryInterface;
use App\Repositories\DoctorRepositoryInterface;
use App\Repositories\DoctorSettingRepositoryInterface;
use App\Repositories\DoctorTimetableRepositoryInterface;
use App\Repositories\CountryRepositoryInterface;
use App\Services\DoctorServiceInterface;
use Barryvdh\Debugbar\Facade as Debugbar;
use Carbon\Carbon;
use Doctrine\Common\Util\Debug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CalendarController extends Controller
{
    /**
     * @var DoctorTimetableRepositoryInterface
     */
    protected $doctorTimetableRepository;

    /**
     * @var DoctorServiceInterface
     */
    protected $doctorService;

    /**
     * @var ClinicRepositoryInterface
     */
    protected $clinicRepository;

    /**
     * @var CountryRepositoryInterface
     */
    protected $countryRepository;

    /**
     * @var AppointmentTypeRepositoryInterface
     */
    protected $appointmentTypeRepository;

    /**
     * @var DoctorRepositoryInterface
     */
    protected $doctorRepository;

    /**
     * CalendarController constructor.
     * @param DoctorTimetableRepositoryInterface $doctorTimetableRepository
     * @param DoctorServiceInterface $doctorService
     * @param ClinicRepositoryInterface $clinicRepository
     * @param AppointmentTypeRepositoryInterface $appointmentTypeRepository
     * @param CountryRepositoryInterface $countryRepository
     * @param AppointmentRepositoryInterface $appointmentRepository
     * @param DoctorSettingRepositoryInterface $doctorSettingRepository
     * @param DoctorRepositoryInterface $doctorRepository
     */
    public function __construct(
        DoctorTimetableRepositoryInterface $doctorTimetableRepository,
        DoctorServiceInterface $doctorService,
        ClinicRepositoryInterface $clinicRepository,
        AppointmentTypeRepositoryInterface $appointmentTypeRepository,
        CountryRepositoryInterface $countryRepository,
        AppointmentRepositoryInterface $appointmentRepository,
        DoctorSettingRepositoryInterface $doctorSettingRepository,
        DoctorRepositoryInterface $doctorRepository
    ) {
        $this->doctorTimetableRepository = $doctorTimetableRepository;
        $this->doctorService = $doctorService;
        $this->clinicRepository = $clinicRepository;
        $this->appointmentTypeRepository = $appointmentTypeRepository;
        $this->countryRepository = $countryRepository;
        $this->appointmentRepository = $appointmentRepository;
        $this->doctorSettingRepository = $doctorSettingRepository;
        $this->doctorRepository = $doctorRepository;

        // Set current sidebar
        \View::share('sidebarCurrentView', 'calendar.index');
    }

    public function index(Request $request)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;
        $doctor->load([
            'clinics',
            'timetableConfigs'
        ]);

        $viewMode = $request->get('view', 'month');
        if(!in_array($viewMode, ['day','month','week','year',])){
            $viewMode = 'month';
        };

        /*
         * Get data for filters
         */
        $filters = with(new Collection(json_decode($request->get('filters'), true)));

        $baseFilters = clone $filters;


        if ($filters->has('clinic')) {

            $clinicsCollection = with(new Collection($filters['clinic']));
            $clinics = $this->clinicRepository->allByIds($clinicsCollection->toArray())->keyBy('id');

            $filters['clinic'] = $clinicsCollection->filter(function ($id) use ($clinics) {
                return $clinics->has($id);
            })
                ->flip()
                ->map(function ($key, $id) use ($clinics) {
                    return $clinics->get($id)->name;
                });
        }

        if ($filters->has('condition')) {
            $conditionsCollection = with(new Collection($filters['condition']));
            $conditions = $doctor->timetableConfigs->keyBy('id');

            $filters['condition'] = $conditionsCollection->filter(function ($id) use ($conditions) {
                return $conditions->has($id);
            })
                ->flip()
                ->map(function ($key, $id) use ($conditions) {
                    return $conditions->get($id)->name;
                });
        }

        if ($filters->has('label')) {
            $labelsCollection = with(new Collection($filters['label']));

            $filters['label'] = new Collection();

            if ($labelsCollection->count() > 0) {
                $filters['label']->put('blocked', 'Blocked Only');
            }
        }

        $totalFilters = 0;

        $filters->each(function ($lists) use (&$totalFilters) {
            $totalFilters += count($lists);
        });

        $filterTypes = [
            'clinic' => 'label-info',
            'condition' => 'label-primary',
            'label' => 'label-success',
        ];

        $doctorClinics = $doctor->clinics;
        $conditions = $doctor->timetableConfigs()->withPivot('duration')->get();

        $doctorTimezone = $this->doctorSettingRepository->getBlankModel()
            ->whereDoctorId($doctor->id)
            ->whereName('timezone')
            ->first();

        $countriesCollection = $this->countryRepository->all();

        return view('doctor.pages.working-calendar.index', [
            'viewMode' => $viewMode,
            'doctorClinics' => $doctorClinics,
            'conditions' => $conditions,
            'filtersCollection' => $filters,
            'baseFilters' => $baseFilters,
            'filterTypes' => $filterTypes,
            'totalFilters' => $totalFilters,
            'day' => $request->has('day') ? $request->get('day') : with(new Carbon())->format('Y-m-d'),
//            'doctorTimetablesData' => $doctorTimetablesCollection->toJson(),

            'phoneCountriesOption' => $countriesCollection->sortBy('phone_country_code')->keyBy('phone_country_code')->map(function ($item) {
                return $item->nice_name . ' (' . $item->phone_country_code . ')';
            }),
            'countriesOption' => $countriesCollection->keyBy('id')->map(function($item){
                return $item->nice_name;
            }),
            'doctorTimezone' => $doctorTimezone,
            'pageData' => collect([
                'doctor' => $doctor,
                'currentView' => $viewMode,
                'currentDay' => $request->has('day') ? $request->get('day') : with(new Carbon())->format('Y-m-d'),
                'filters' => [
                    'condition' => $baseFilters->has('condition') ? $baseFilters->get('condition') : [],
                    'label' => $baseFilters->has('label') ? $baseFilters->get('label') : [],
                    'clinic' => $baseFilters->has('clinic') ? $baseFilters->get('clinic') : []
                ],
                'filterTypeClasses' => $filterTypes,
                'doctorClinics' => $doctorClinics,
                'timeOptions' => \DateTimeHelper::getTimeOptionsForDoctor(),
                'conditions' => $conditions,
                'phoneCountryCodes' => $countriesCollection->sortBy('phone_country_code')->keyBy('phone_country_code')->map(function ($item) {
                    return $item->nice_name . ' (' . $item->phone_country_code . ')';
                }),
                'countries' => $countriesCollection->keyBy('id')->map(function($item){
                    return $item->nice_name;
                }),
                'routes' => [
                    'base' => 'working-calendar.index',
                    'feedTimeslots' => 'working-calendar.feed',
                    'createTimeslots' => 'working-calendar.createTimeslots',
                    'blockTimeslot' => 'working-calendar.block',
                    'unblockTimeslot' => 'working-calendar.unblock',
                    'destroyTimeslot' => 'working-calendar.destroy',
                    'createAppointment' => 'appointment.store',
                    'checkUpdates' => 'working-calendar.checkUpdates',
                    'createPatient' => 'api.patients.store',
                    'searchPatients' => config('manadr.search_api.enabled')?'api.patients.search':'api.patients.searchByIcOrName',
                    'uploadFile' => 'doctor.file.store'
                ],
                'doctorTimezone' => $doctorTimezone,
            ])->toJson(JSON_HEX_APOS)
        ]);
    }

    public function feed(Request $request)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $from = $request->get('from') / 1000; // seconds
        $to = $request->get('to') / 1000; // seconds
        $offsetFrom = $request->get('utc_offset_from');
        $offsetTo = $request->get('utc_offset_to');
        $filters = with(new Collection(json_decode($request->get('filters'), true)));

        $startAt = with(new Carbon)->setTimestamp($from);
        $endAt = with(new Carbon)->setTimestamp($to);

        $result = $this->doctorTimetableRepository->feed($doctor, $startAt, $endAt, $filters);

        $response = [];
        $response['success'] = true;
        $response['result'] = $result;

        return response()->json($response);
    }

    public function fetchAvailableTimeslots(Request $request)
    {
        abort_unless($doctorId = $request->get('doctor_id'), 403, 'Please select a doctor.');
        abort_unless($doctor = $this->doctorRepository->find($doctorId), 403, 'Doctor not found.');
        abort_unless($clinicId = $request->get('clinic_id'), 403, 'Please select a clinic.');
        abort_unless($clinic = $this->clinicRepository->find($clinicId), 403, 'Clinic not found');
        abort_unless($date = $request->get('date'), 403, 'Please select a date.');
        abort_unless($appointmentTypeId = $request->get('appointment-type'), 403, 'Please select an appointment type.');

        $startAt = Carbon::createFromFormat('d/m/Y', $date, $clinic->time_zone)->startOfDay()->setTimezone('UTC');
        $endAt = Carbon::createFromFormat('d/m/Y', $date, $clinic->time_zone)->endOfDay()->setTimezone('UTC');

        $filters = collect([
            'clinic' => [$clinicId],
            'condition' => [$appointmentTypeId],
        ]);

        $result = $this->doctorTimetableRepository->feed($doctor, $startAt, $endAt, $filters);

        $response = [];
        $response['success'] = true;
        $response['result'] = $result;

        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Check if there's any changes (appointments, timeslots) since last_updated_time
     */
    public function checkUpdates(Request $request)
    {
        $doctorId = $request->get('doctor');
        $lastUpdatedTime = $request->get('last_updated_time') / 1000;
        $since = with(new Carbon)->setTimestamp($lastUpdatedTime);

        $updatedTimeslots = $this->doctorTimetableRepository->getBlankModel()
            ->whereDoctorId($doctorId)
            ->where(function(Builder $query) use ($since){
                $query->where('updated_at', '>', $since);
            })
            ->withTrashed()
            ->get()
        ;

        $updatedAppointments = $this->appointmentRepository->getBlankModel()
            ->whereDoctorId($doctorId)
            ->where(function(Builder $query) use ($since){
                $query->where('updated_at', '>', $since);
            })
            ->withTrashed()
            ->get()
        ;

        return response()->json([
            'success' => true,
            'shouldUpdate' => ($updatedTimeslots->count() || $updatedAppointments->count())?true:false
        ]);
    }

    /**
     * @param CreateRequest $request
     *
     * @return mixed
     */
    public function storeTimeslots(CreateRequest $request)
    {
        $clinicId = $request->get('clinic');

        /** @var Clinic $clinic */
        $clinic = $this->clinicRepository->find($clinicId);
        if (!$clinic) {
            abort(403);
        }

        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        /*
         * Duration
         */
        $duration = (int) $request->get('duration');

        abort_unless(is_int($duration), 500, 'Duration is not valid.');

        /*
         * Create date collection
         */
        $datesRequest = $request->get('date');

        $dates = explode(',', $datesRequest);

        abort_if(!$datesRequest || count($dates) == 0, 500, 'Please pick a valid date.');

        /*
         * Create time collection
         */
        $fromTime = $request->get('fromTime');
        $endTime = $request->get('endTime');

        // Valid time, time must be divided by 5 minutes.
        abort_if($endTime % 60 % 5 != 0, 500, 'Time is not valid. Time must be divided by 5 minutes.');
        abort_if($fromTime % 60 % 5 != 0, 500, 'Time is not valid. Time must be divided by 5 minutes.');

        // End time must less or equal than from time.
        abort_if($endTime <= $fromTime, 500, 'Time is not valid. End time is less than start time.');

        $doctorTimetableTime = new DoctorTimetableTime($fromTime, $endTime);

        //add cycle here
        /**
         * Get cycle value
         */
        $cycle_value = intval($request->get('weekly-cycle'));

        /**
         * Get appointment type
         */
        $appointment_type_id = $request->get('appointmentType');
        $appointment_type = $this->appointmentTypeRepository->find($appointment_type_id);

        abort_if(!$appointment_type, 500, 'Please choose a valid appointment type.');

        $responseResult = [
            'success' => true,
            'timetables' => new Collection(),
            'timetablesError' => new Collection(),
            'timezone' => $clinic->time_zone
        ];

        //split the jobs
        foreach($dates as $date){
            $cycling_dates = [];

            $doctor_timeslot_cycle = null;

            if($cycle_value > 0){
                for ($i = 0; ++$i <= $cycle_value; ) {
                    array_push($cycling_dates, Carbon::createFromFormat('d/m/Y', $date)->addWeek($i)->format('d/m/Y'));
                }

                $doctor_timeslot_cycle = $this->dispatch(new CreateDoctorTimeslotCycleJob(
                    $doctor,
                    $clinic,
                    DoctorTimeslotCycle::LIST_DAYS_OF_WEEK[Carbon::createFromFormat('d/m/Y', $date)->dayOfWeek],
                    Carbon::createFromFormat('d/m/Y', $date),
                    DoctorTimetableTime::toDate($date, $doctorTimetableTime->getStart(), null),
                    DoctorTimetableTime::toDate($date, $doctorTimetableTime->getEnd(), null),
                    $duration,
                    $appointment_type,
                    $cycle_value
                ));
            }

            $dateCollection = new Collection(array_merge([$date], $cycling_dates));

            // Valid dates, dates must be large than today.
//            $dateCollection->each(function ($date) {
//                // Don't need to valid this rule.
//            });

            $result = $this->dispatchNow(new MultiCreateDoctorTimetableJob(
                $doctor,
                $clinic,
                $dateCollection,
                $doctorTimetableTime,
                $duration,
                $appointment_type,
                $doctor_timeslot_cycle
            ));

            //merge the $result into $responseResult

            if(!empty($result['timetables'])){
                $responseResult['timetables'] = $responseResult['timetables']->merge($result['timetables']);
            }

            if(!empty($result['timetablesError'])){
                $responseResult['timetablesError'] = $responseResult['timetablesError']->merge($result['timetablesError']);
            }


            unset($doctor_timeslot_cycle);
            unset($result);
        }

        //merge the jobs' result

        return response()->json($responseResult);
    }

    public function destroy(Request $request, DoctorTimetable $doctorTimetable)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $this->authorizeForUser($doctor, 'delete', $doctorTimetable);

        $this->dispatchNow(new DeleteDoctorTimetableJob($doctor, $doctorTimetable));

        return response()->json([
            'success' => true,
        ]);
    }

    public function block(Request $request, DoctorTimetable $doctorTimetable)
    {
        /** @var Doctor $doctor */
        $user = $this->doctorService->getUser();
        $doctor = $user->account;

        $this->authorizeForUser($doctor, 'block', $doctorTimetable);

        $this->dispatchNow(new BlockDoctorTimetableJob($user, $doctor, $doctorTimetable));

        $this->dispatchNow(new CreateActivity(
            'user',
            $user->id,
            'block',
            'timeslot',
            $doctorTimetable->id,
            $request->get('block_reason')
        ));

        return response()->json([
            'success' => true,
        ]);
    }

    public function unblock(Request $request, DoctorTimetable $doctorTimetable)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $this->authorizeForUser($doctor, 'unblock', $doctorTimetable);

        $this->dispatchNow(new UnblockDoctorTimetableJob($doctorTimetable));

        return response()->json([
            'success' => true,
        ]);
    }
}
<?php namespace App\Http\Controllers\Doctor;

use App\Jobs\Patient\SyncPatientUserByDoctor;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\RelationshipRepositoryInterface;
use App\Services\DoctorServiceInterface;
use App\Services\SearchServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Transformers\PatientTransformer;
use App\Repositories\PatientRepositoryInterface;
use DB;

/**
 * Class PatientController
 * @package App\Http\Controllers\Doctor
 */
class PatientController extends Controller
{
    /**
     * @var PatientRepositoryInterface
     */
    protected $patientRepository;

    /**
     * @var RelationshipRepositoryInterface
     */
    private $relationshipRepository;

    /**
     * @var CountryRepositoryInterface
     */
    private $countryRepository;

    /**
     * @var DoctorServiceInterface
     */
    private $doctorService;

    /**
     * @var SearchServiceInterface
     */
    private $searchService;

    /**
     * PatientController constructor.
     * @param PatientRepositoryInterface $patientRepository
     * @param RelationshipRepositoryInterface $relationshipRepository
     * @param CountryRepositoryInterface $countryRepository
     * @param DoctorServiceInterface $doctorService
     * @param SearchServiceInterface $searchService
     */
    public function __construct(
        PatientRepositoryInterface $patientRepository,
        RelationshipRepositoryInterface $relationshipRepository,
        CountryRepositoryInterface $countryRepository,
        DoctorServiceInterface $doctorService,
        SearchServiceInterface $searchService
    ) {
        $this->patientRepository = $patientRepository;
        $this->relationshipRepository = $relationshipRepository;
        $this->countryRepository = $countryRepository;
        $this->doctorService = $doctorService;
        $this->searchService = $searchService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $currentDoctor = $this->doctorService->getUser()->account;
        $currentClinics = $currentDoctor->clinics;

        $patient = [];

        if($currentClinics){
            $currentClinicIds = $currentClinics->pluck('id')->toArray();


            $patients = $this->patientRepository->getBlankModel()
                ->whereHas('clinics', function($query) use ($currentClinicIds){
                    return $query->whereIn('clinic_id', $currentClinicIds);
                })
                ->orWhereHas('appointments', function($query) use ($currentDoctor){
                    return $query->where('doctor_id', $currentDoctor->id);
                })
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->load([
                    'users',
                    'profileImage',
                    'account',
                    'user'
                ])
            ;
        }

        return view('doctor.pages.patients.index', [
            'patients' => $patients
        ]);
    }

    /**
     * @param Patient $patient
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function details(Patient $patient)
    {
        $currentUser = $this->doctorService->getUser();
        $canView = false;
        $patientClinicIds = $patient->clinics ? $patient->clinics->pluck('id')->all() : [];
        $userClinicIds = $currentUser->account->clinics ? $currentUser->account->clinics->pluck('id')->all() : [];
        $relatedAppointments = $patient->appointments()->whereIn('clinic_id', $userClinicIds)->get();

        if(sizeof(array_intersect($patientClinicIds, $userClinicIds)) > 0 || $relatedAppointments->count() > 0){
            $canView = true;
        }
        abort_unless($canView, '403', 'You don\'t have permission to do this operation!');

        $patient->load([
            'users' => function($query){
                $query->withPivot([
                    'relationship_id',
                ]);
            },
            'users.profileImage',
            'appointments' => function($query) use ($userClinicIds){
                $query->whereIn('clinic_id', $userClinicIds);
            },
            'appointments.doctorTimetable',
            'appointments.doctorTimetable.clinic',
            'appointments.appointmentStatus',
            'appointments.appointmentType',
            'appointments.doctor',
            'appointments.user',
            'appointments.patient',
            'appointments.booker',

            //new relationships
            'relationships' => function($query){
                $query->withPivot([
                    'relationship_id',
                    'description'
                ]);
            },
            'relationships.profileImage',
            'account'
        ]);

        $relationships = $this->relationshipRepository->all()->keyBy('id');
        $countries = $this->countryRepository->all();
        $linkedPatients = $patient->relationships;

        $guardian = $patient->guardian;
        $guardianDescription = null;

        if($guardian){
            $guardianInLinkedPatients = $linkedPatients->filter(function($linkedPatient) use ($guardian){
                return $guardian-> id === $linkedPatient->id;
            })->first();
            if($guardianInLinkedPatients){
                $guardianDescription = $guardianInLinkedPatients->pivot->description;
            }
        }

        $currentDoctor = $this->doctorService->getUser()->account;

        $canEdit = $this->authorizeForUser($currentDoctor, 'update', $patient);

        return view('doctor.pages.patients.details', [
            'patient' => $patient,
            'relationships' => $relationships,
            'countries' => $countries,
            // 'history' => $formattedHistory,
            'guardian' => $guardian,
            'guardianDescription' => $guardianDescription,
            'linkedPatients' => $linkedPatients,
            'canEdit' => $canEdit
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request){
        if(config('manadr.search_api.enabled') && config('manadr.search_api.search_by_doctor_enabled')) {
            $text = urldecode($request->get('query'));
            $text = str_replace('-', '', $text);
            $text = str_replace(' ', '_', trim($text));
            abort_unless($text !=='' && strlen($text) > 2, '400', 'Please use another keyword.');
            $filter = 'all_fields eq "' . $text . '"';
            $doctorId = $this->doctorService->getUser()->account_id;
            $top = $request->get('top', config('manadr.search_api.default.top'));
            $skip = $request->get('skip', config('manadr.search_api.default.skip'));

            $results = $this->searchService->searchByDoctor($doctorId, $filter, $top, $skip);

            $ids = collect($results->records)->pluck('patient_id');

            $patients = $this->patientRepository->getBlankModel()->whereIn('id', $ids)->get();

            $fractalArray = fractal()->collection($patients, new PatientTransformer())->toArray();

            return response()->json($fractalArray);
        } else {
            $patients = $this->patientRepository->searchByIcOrName($request->get('query'), false, 'doctor');

            /*
             * Generate fractal and return response.
             */
            $fractalArray = fractal()->collection($patients, new PatientTransformer())->toArray();

            return response()->json($fractalArray);
        }
    }

    /**
     * @param Patient $patient
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Patient $patient, Request $request){
        if(!$patient){
            abort(403, 'This patient doesn\'t exist in the database!');
        }

        $currentDoctor = $this->doctorService->getUser()->account;

        if(!$this->authorizeForUser($currentDoctor, 'update', $patient)){
            abort(401, 'You don\'t have permission to do this operation!');
        }

        $rules = array(
            'first_name'        => 'bail|required',
            'last_name'         => 'bail|required',
            'date_of_birth'     => 'bail|required',
            'email'             => 'bail|email',
            'address_zip'       => 'bail|numeric',
            'id_number'         => 'bail|required|min:4|max:32|unique:mysql-backend.patients,id_number,'.$patient->id.',id,issue_country_id,'.$patient->issue_country_id,
        );

        $this->validate($request, $rules);

        /*
         * Parse date_of_birth field
         */
        list($day, $month, $year) = explode('/', $request->get('date_of_birth'));

        $dateOfBirth = new \Carbon\Carbon();
        $dateOfBirth->setDateTime($year, $month, $day, 0, 0, 0);

        /*
         * Parse country_id
         */
        /** @var Country $country */
        $country = $this->countryRepository->find($request->get('issue_country_id'));
        $residentCountry = $this->countryRepository->find($request->get('resident_country_id'));

        DB::beginTransaction();
        try{
            $patient->update([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'gender' => $request->get('gender'),
                'date_of_birth' => $dateOfBirth,
                'email' => $request->get('email') ? $request->get('email') : null,
                'address_street' => $request->get('address_street') ? $request->get('address_street') : null,
                'address_city' => $request->get('address_city') ? $request->get('address_city') : null,
                'issue_country_id' => $country ? $country->id : null,
                'resident_country_id' => $residentCountry ? $residentCountry->id: null,
                'address_zip' => $request->get('address_zip') ? $request->get('address_zip') : null,
                'id_number' => $request->get('id_number') ? $request->get('id_number') : null,
                'race' => $request->get('race') ? $request->get('race') : null,
                'medical_record_number' => $request->get('medical_record_number') ? $request->get('medical_record_number') : null,
                'deceased' => $request->get('deceased')? $request->get('deceased'): 0,
                'verified' => $request->get('verified')? $request->get('verified'): 0,
                'alias' => $request->get('alias')?$request->get('alias'):'',
                'medical_condition' => $request->get('medical_condition')?$request->get('medical_condition'):'',
                'drug_allergy' => $request->get('drug_allergy')?$request->get('drug_allergy'):'',
                'address_block' => $request->input('address_block'),
                'apartment_number' => $request->input('apartment_number'),
            ]);

    
            $account = $patient->account;
            if($account){
                $account->update([
                    'email' => $request->get('email') ? $request->get('email') : null
                ]);
            }

            DB::commit();
        }
        catch (\Exception $e)
        {
                DB::rollBack();
                $msg = $e->getMessage();

                if (strpos($msg, 'udx_user_phone_number')) {
                    abort(400, 'The phone number has been used by an other patient');
                } else if (strpos($msg, 'udx_user_email')) {
                    abort(400, 'The email has been used by an other patient');
                } else {
                    abort(400, $msg);
                }
        }

        $this->dispatchNow(new SyncPatientUserByDoctor(
            $currentDoctor,
            $patient
        ));

        return response()->json($patient);
    }

    /**
     * @param Patient $patient
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(Patient $patient)
    {
        $patient->load(['country']);

        return response()->json($patient);
    }

    /**
     * @param Patient $patient
     * @param Patient $guardian
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setGuardianship(Patient $patient, Patient $guardian, Request $request){
//        abort_unless($patient->relationships->contains($guardian->id), 400);

        $patient->update([
            'guardian_patient_id' => $guardian->id
        ]);

        $patient->relationships()->updateExistingPivot($guardian->id, [
            'description' => $request->get('description')
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @param Patient $patient
     * @param Patient $guardian
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function revokeGuardianship(Patient $patient, Patient $guardian, Request $request){
//        abort_unless($patient->relationships->contains($guardian->id), 400);

        $patient->update([
            'guardian_patient_id' => null
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Reference: https://gist.github.com/hieutnbk/3d22ee2a4e4bfc2654d4d20c12aaa4b0
     *
     * @param $nric
     * @return bool
     */
    public function validateSingaporeNRIC($nric)
    {
        $nricGravity = [2, 7, 6, 5, 4, 3, 2];
        $nricSt = str_split("JZIHGFEDCBA");
        $nricFg = str_split("XWUTRQPNMLK");

        if(strlen($nric) !== 9){
            return false;
        }

        $nric = strtoupper($nric);

        $isFormatValid = preg_match('/\A[STFG]([1-9]{7})([A-Z])\z/m', $nric, $matches);
        if(!$isFormatValid){
            return false;
        }

        $checkingDigits = str_split(substr($nric, 1,7));
        $checkSumResults = collect($checkingDigits)->zip($nricGravity)->sum(function($item){
            return (int) $item[0] * $item[1];
        });

        $firstNRICLetter = $nric[0];

        if($firstNRICLetter === 'T' || $firstNRICLetter === 'G'){
            $checkSumResults += 4;
        }

        $resultMod = $checkSumResults % 11;

        if($firstNRICLetter === 'S' || $firstNRICLetter === 'T') {
            $checksum = $nricSt[$resultMod];
        } else if($firstNRICLetter === 'F' || $firstNRICLetter === 'G') {
            $checksum = $nricFg[$resultMod];
        }

        return $checksum == $nric[8];
    }

    /**
     * DASH1-332 Check existence of ID Number when creating new patient record
     * DASH1-348 Implement Singapore NRIC checking when create/update patient profile
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByIDNumber(Request $request)
    {
        //validate nric if the country is singapore
//        $issueCountryId = $request->input('issue_country_id');
//        $idNumber = $request->input('id_number');
//
//        if($issueCountryId == 192){ //Singapore
//            $isIdNumberValid = $this->validateSingaporeNRIC($idNumber);
//            abort_unless($isIdNumberValid, 422, 'Invalid Singapore NRIC');
//        }

        $patient = $this->patientRepository->getBlankModel()->where($request->only([
            'issue_country_id',
            'id_number',
        ]))->firstOrFail();

        $fractalArray = fractal()->item($patient, new PatientTransformer())->toArray();

        return response()->json($fractalArray);
    }
}
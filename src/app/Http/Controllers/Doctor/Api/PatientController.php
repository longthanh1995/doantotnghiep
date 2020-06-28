<?php

namespace App\Http\Controllers\Doctor\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\CreatePatientApiRequest;
use App\Jobs\Patient\SyncPatientUserByDoctor;
use App\Models\Country;
use App\Models\Patient;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\PatientRepositoryInterface;
use App\Services\SearchServiceInterface;
use App\Transformers\PatientTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class PatientController
 * @package App\Http\Controllers\Doctor\Api
 */
class PatientController extends Controller
{
    /**
     * @var PatientRepositoryInterface
     */
    protected $patientRepository;

    /**
     * @var CountryRepositoryInterface
     */
    protected $countryRepository;

    /**
     * @var SearchServiceInterface
     */
    private $searchService;

    /**
     * PatientController constructor.
     * @param PatientRepositoryInterface $patientRepository
     * @param CountryRepositoryInterface $countryRepository
     */
    public function __construct(
        PatientRepositoryInterface $patientRepository,
        CountryRepositoryInterface $countryRepository,
        SearchServiceInterface $searchService
    )
    {
        $this->patientRepository = $patientRepository;
        $this->countryRepository = $countryRepository;
        $this->searchService = $searchService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByIcOrName(Request $request)
    {
        /*
         * Request & validation
         */
        $text = $request->get('text');

        if (strlen($text) < 1) {
            abort(412, 'The length of text need to have at least 1 character.');
        }

        /*
         * Searching
         */
        $patients = $this->patientRepository->searchByIcOrName($text, true, 'createAppointment');

        /*
         * Generate fractal and return response.
         */
        $fractalArray = fractal()->collection($patients, new PatientTransformer())->toArray();

        return response()->json($fractalArray);
    }

    /**
     * @param CreatePatientApiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreatePatientApiRequest $request)
    {
        //Check the existent of input ID number first
        abort_if($this->patientRepository->getBlankModel()->where($request->only([
            'issue_country_id',
            'id_number',
        ]))->get()->count() > 0, 400, 'The given National ID Number is already in our system. Could you try searching for this patient 5 minutes later?');

        /*
         * Parse date_of_birth field
         */
        list($day, $month, $year) = explode('/', $request->get('date_of_birth'));

        $dateOfBirth = new Carbon();
        $dateOfBirth->setDateTime($year, $month, $day, 0, 0, 0);

        /*
         * Parse phone_country_code
         */
        $phoneCountry = null;

        if ($request->get('phone_country_code')) {
            $phoneCountry = $this->countryRepository->getOneByPhoneCountryCode($request->get('phone_country_code'));
        }

        /*
         * Parse country_id
         */
        /** @var Country $country */
        $country = $this->countryRepository->find($request->get('issue_country_id'));
        $residentCountry = $this->countryRepository->find($request->get('resident_country_id'));

        /** @var Patient $patient */
        $patient = $this->patientRepository->create([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'gender' => $request->get('gender'),
            'date_of_birth' => $dateOfBirth,
            'email' => $request->get('email') ? $request->get('email') : null,
            'phone_number' => $request->get('phone_number') ? $request->get('phone_number') : null,
            'phone_country_code' => $phoneCountry ? $phoneCountry->phone_country_code : null,
            'address_street' => $request->get('address_street') ? $request->get('address_street') : null,
            'address_city' => $request->get('address_city') ? $request->get('address_city') : null,
            'issue_country_id' => $country ? $country->id : null,
            'resident_country_id' => $residentCountry ? $residentCountry->id: null,
            'address_zip' => $request->get('address_zip') ? $request->get('address_zip') : null,
            'id_number' => $request->get('id_number') ? $request->get('id_number') : null,
            'race' => $request->get('race') ? $request->get('race') : null,
            'medical_record_number' => $request->get('medical_record_number') ? $request->get('medical_record_number') : null,
            'medical_condition' => $request->get('medical_condition')?$request->get('medical_condition'):'',
            'drug_allergy' => $request->get('drug_allergy')?$request->get('drug_allergy'):'',
            'address_block' => $request->input('address_block'),
            'apartment_number' => $request->input('apartment_number'),
        ]);

        $patient->clinics()->attach($request->get('clinic_id'));

        /*
         * Generate fractal and return response.
         */
        $fractalArray = fractal()->item($patient, new PatientTransformer())->toArray();

        return response()->json($fractalArray);
    }

    /**
     * @param CreatePatientApiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function externalStore(Request $request)
    {
        $bypassKey = env('BY_PASS_CSRF_TOKEN', null);
        $requestBypassKey = $request->header('Authorization');
        abort_unless($requestBypassKey === $bypassKey, 403, 'You don\'t have permission to use this API');

        $rules = array(
            'first_name' => 'required|min:1|max:255',
            'last_name' => 'required|min:1|max:255',
            'gender' => 'required|in:'.implode(',', array_keys(Patient::LIST_GENDERS)),
            'date_of_birth' => 'required|date_format:d/m/Y',
            'email' => 'sometimes|email',
            'phone_number' => 'sometimes',
            'phone_country_code' => 'sometimes',
            'address_street' => 'sometimes',
            'address_city' => 'sometimes',
            'address' => 'sometimes',
            'issue_country_id' => 'integer',
            'address_zip' => 'sometimes|integer',
            'race' => 'sometimes',
            'id_number' => 'required|min:4|max:32',
            'deceased' => 'sometimes|in:0,1',
            'verified' => 'sometimes|in:0,1',
            'medical_condition' => 'sometimes',
            'drug_allergy' => 'sometimes',
            'work_companies' => 'sometimes|json',
            'insurance_companies' => 'sometimes|json',
        );

        $this->validate($request, $rules);

        $requestData = array_filter($request->all());

        //Check the existent of input ID number first
        abort_if($this->patientRepository->getBlankModel()->where($request->only([
            'issue_country_id',
            'id_number',
        ]))->get()->count() > 0, 400, 'The given National ID Number is already in our system. Could you try searching for this patient 5 minutes later?');

        /*
         * Parse date_of_birth field
         */
        if(array_key_exists('date_of_birth', $requestData)){
            list($day, $month, $year) = explode('/', $requestData['date_of_birth']);

            $dateOfBirth = new \Carbon\Carbon();
            $requestData['date_of_birth'] = $dateOfBirth->setDateTime($year, $month, $day, 0, 0, 0);
        }

        /** @var Patient $patient */
        $patient = $this->patientRepository->create($requestData);

        $patient->clinics()->attach($request->get('clinic_id'));

        /*
         * Generate fractal and return response.
         */
        return response()->json($patient);
    }

    /**
     * @param Patient $patient
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function externalDetails(Patient $patient, Request $request)
    {
        $bypassKey = env('BY_PASS_CSRF_TOKEN', null);
        $requestBypassKey = $request->header('Authorization');
        abort_unless($requestBypassKey === $bypassKey, 403, 'You don\'t have permission to use this API');

        return response()->json($patient);
    }

    /**
     * @param Patient $patient
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function externalUpdate(Patient $patient, Request $request)
    {
        $bypassKey = env('BY_PASS_CSRF_TOKEN', null);
        $requestBypassKey = $request->header('Authorization');
        abort_unless($requestBypassKey === $bypassKey, 403, 'You don\'t have permission to use this API');

        $rules = array(
            'first_name' => 'sometimes|min:1|max:255',
            'last_name' => 'sometimes|min:1|max:255',
            'gender' => 'sometimes|in:'.implode(',', array_keys(Patient::LIST_GENDERS)),
            'date_of_birth' => 'sometimes|date_format:d/m/Y',
            'email' => 'sometimes|email',
            'phone_number' => 'sometimes',
            'phone_country_code' => 'sometimes',
            'address_street' => 'sometimes',
            'address_city' => 'sometimes',
            'address' => 'sometimes',
            'issue_country_id' => 'integer',
            'address_zip' => 'sometimes|integer',
            'race' => 'sometimes',
            'id_number' => 'sometimes|min:4|max:32',
            'deceased' => 'sometimes|in:0,1',
            'verified' => 'sometimes|in:0,1',
            'medical_condition' => 'sometimes',
            'drug_allergy' => 'sometimes',
            'work_companies' => 'sometimes|json',
            'insurance_companies' => 'sometimes|json',
        );

        $this->validate($request, $rules);

        $requestData = array_filter($request->all());

        /*
         * Parse date_of_birth field
         */
        if(array_key_exists('date_of_birth', $requestData)){
            list($day, $month, $year) = explode('/', $requestData['date_of_birth']);

            $dateOfBirth = new \Carbon\Carbon();
            $requestData['date_of_birth'] = $dateOfBirth->setDateTime($year, $month, $day, 0, 0, 0);
        }

        $patient->update($requestData);

        abort_unless($patient->save(), 500, 'The patient hasn\'t been updated. Please check input information again.');

        $account = $patient->account;
        if($account) {
            $account->update([
                'email' => $request->get('email') ? $request->get('email') : null
            ]);


            // @TODO: Bypass the logging for now
//            $this->dispatchNow(new SyncPatientUserByDoctor(
//                $currentDoctor,
//                $patient
//            ));
            abort_unless($account->save(), 500, 'The patient email hasn\'t been updated. Please check input information again.');
        }

        return response()->json($patient);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $text = urldecode($request->get('text'));
        $text = str_replace('-', '', $text);
        $text = str_replace(' ', '_', trim($text));
        abort_unless($text !=='' && strlen($text) > 2, '400', 'Please use another keyword.');
        $filter = 'all_fields eq "' . $text . '"';
        $clinicId = $request->get('clinic_id');
        $doctorId = $request->get('doctor_id');
        $top = config('manadr.search_api.default.top');

        $page = $request->get('page', 1);
        $skip = $top * ($page - 1);

        if(!$clinicId){
            $results = $this->searchService->search($filter, $top, $skip);
        } elseif (!$doctorId){
            $results = $this->searchService->searchByClinic($clinicId, $filter, $top, $skip);
        } else {
            $results = $this->searchService->searchByClinicAndDoctor($clinicId, $doctorId, $filter, $top, $skip);
        }

        $ids = collect($results->records)->pluck('patient_id');

//        return response()->json($results);

        $patients = $this->patientRepository->getBlankModel()->whereIn('id', $ids)->get();

        $fractalArray = fractal()->collection($patients, new PatientTransformer())->toArray();

        $count = $results->count;

        return response()->json(array_merge(
            $fractalArray,
            ['count' => $count]
        ));
    }
}

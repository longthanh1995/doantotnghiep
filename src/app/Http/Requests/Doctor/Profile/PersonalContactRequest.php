<?php

namespace App\Http\Requests\Doctor\Profile;

use App\Http\Requests\BaseRequest;
use App\Models\Doctor;
use App\Repositories\CountryRepositoryInterface;
use App\Services\DoctorServiceInterface;

class PersonalContactRequest extends BaseRequest
{
    /**
     * @var CountryRepositoryInterface
     */
    protected $countryRepository;

    /**
     * @var DoctorServiceInterface
     */
    protected $doctorService;

    /**
     * @var string
     */
    protected $errorBag = 'personalContactForm';

    /**
     * PersonalContactRequest constructor.
     *
     * @param CountryRepositoryInterface $countryRepository
     * @param DoctorServiceInterface $doctorService
     */
    public function __construct(
        CountryRepositoryInterface $countryRepository,
        DoctorServiceInterface $doctorService
    ) {
        $this->countryRepository = $countryRepository;
        $this->doctorService = $doctorService;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function all()
    {
        $input = parent::all();
        $input = array_map('trim', $input);
        if (isset($input['phone_number'])) {
            $input['phone_number'] = ltrim($input['phone_number'], '0');
        }
        
        return $input;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $countriesCollection = $this->countryRepository->all();
        $listPhoneCountries = $countriesCollection->lists('phone_country_code');

        /** @var Doctor $doctor */
        $currentDoctorUser = $this->doctorService->getUser();
        if($currentDoctorUser){
            $doctor = $this->doctorService->getUser()->account;
            if ($doctor && $doctor->email != $this->get('email')) {
                $emailRules = 'bail|required|email|unique:mysql-backend.doctors,email';
            } else {
                $emailRules = 'required|email';
            }
        } else {
            $emailRules = 'required|email';
        }




        return [
            'phone_country_code' => 'required|in:'.implode(',', $listPhoneCountries->toArray()),
            'phone_number' => 'required|phone_number',
            'email' => $emailRules,
            'website' => 'url',
            'address' => 'required|min:1|max:255',
        ];
    }

    public function messages()
    {
        return [];
    }
}

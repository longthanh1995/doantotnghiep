<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Profile\BasicInformationRequest;
use App\Http\Requests\Doctor\Profile\EditAvatarRequest;
use App\Http\Requests\Doctor\Profile\PersonalContactRequest;
use App\Http\Requests\Doctor\Profile\SpecialityRequest;
use App\Jobs\DoctorProfile\EditAvatar;
use App\Jobs\DoctorProfile\EditBasicInformation;
use App\Jobs\DoctorProfile\EditPersonalContact;
use App\Jobs\DoctorProfile\EditSpeciality;
use App\Models\Doctor;
use App\Repositories\AppointmentRepositoryInterface;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\DoctorRepositoryInterface;
use App\Repositories\DoctorTitleRepositoryInterface;
use App\Repositories\LanguageRepositoryInterface;
use App\Repositories\PatientConditionRepositoryInterface;
use App\Services\DoctorServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

use Barryvdh\Debugbar\Facade as Debugbar;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Doctor
 */
class ProfileController extends Controller
{
    /**
     * @var DoctorServiceInterface
     */
    protected $doctorService;

    /**
     * @var DoctorRepositoryInterface
     */
    protected $doctorRepository;

    /**
     * @var DoctorTitleRepositoryInterface
     */
    protected $doctorTitleRepository;

    /**
     * @var LanguageRepositoryInterface
     */
    protected $languageRepository;

    /**
     * @var CountryRepositoryInterface
     */
    protected $countryRepository;

    /**
     * @var PatientConditionRepositoryInterface
     */
    protected $patientConditionRepository;

    /**
     * @var AppointmentRepositoryInterface
     */
    protected $appointmentRepository;

    /**
     * ProfileController constructor.
     *
     * @param DoctorServiceInterface $doctorService
     * @param DoctorRepositoryInterface $doctorRepository
     * @param DoctorTitleRepositoryInterface $doctorTitleRepository
     * @param LanguageRepositoryInterface $languageRepository
     * @param CountryRepositoryInterface $countryRepository
     * @param PatientConditionRepositoryInterface $patientConditionRepository
     * @param AppointmentRepositoryInterface $appointmentRepository
     */
    public function __construct(
        DoctorServiceInterface $doctorService,
        DoctorRepositoryInterface $doctorRepository,
        DoctorTitleRepositoryInterface $doctorTitleRepository,
        LanguageRepositoryInterface $languageRepository,
        CountryRepositoryInterface $countryRepository,
        PatientConditionRepositoryInterface $patientConditionRepository,
        AppointmentRepositoryInterface $appointmentRepository
    ) {
        $this->doctorService = $doctorService;
        $this->doctorRepository = $doctorRepository;
        $this->doctorTitleRepository = $doctorTitleRepository;
        $this->languageRepository = $languageRepository;
        $this->countryRepository = $countryRepository;
        $this->patientConditionRepository = $patientConditionRepository;
        $this->appointmentRepository = $appointmentRepository;

        // Set current sidebar
        \View::share('sidebarCurrentView', 'profile.index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return redirect()->route('profile.basicInformation');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function avatar()
    {
//        return view('legacy.pages.doctor.profile.avatar');
        return view('doctor.pages.profile.avatar');
    }

    /**
     * @param EditAvatarRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function avatarSubmit(EditAvatarRequest $request)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $avatar = $request->file('avatar');

        $this->dispatchNow(new EditAvatar(
            $doctor,
            $avatar
        ));

        return back();
    }

    /**
     * @param EditAvatarRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function avatarUpload(EditAvatarRequest $request)
    {
        $doctor = $this->doctorService->getUser()->account;

        $avatar = $request->file('avatar');

        $newAvatarUrl = $this->dispatchNow(new EditAvatar(
            $doctor,
            $avatar
        ));

        return response()->json([
            'success' => true,
            'newAvatarUrl' => $newAvatarUrl
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function basicInformation()
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $doctor->load('languages');
        $doctor->load('professions');

        /** @var Collection $titlesCollection */
        $titlesCollection = $this->doctorTitleRepository->all();
        $titlesOption = $titlesCollection->pluck('title', 'id');

        $gendersOption = Doctor::LIST_GENDERS;

        /** @var Collection $languagesCollection */
        $languagesCollection = $this->languageRepository->all();
        $languagesOption = $languagesCollection->pluck('name', 'id');

        /** @var Collection $countriesCollection */
        $countriesCollection = $this->countryRepository->all();
        $phoneCountriesOption = $countriesCollection->keyBy('phone_country_code')->map(function ($item) {
            return $item->phone_country_code;
        });
        return view('doctor.pages.profile.basicInformation', [
            'doctor' => $doctor,
            'doctorLanguages' => $doctor->languages->keyBy('id'),
            'doctorProfessions' => $doctor->professions->keyBy('id'),
            'titlesOption' => $titlesOption,
            'gendersOption' => $gendersOption,
            'languagesOption' => $languagesOption,
            'phoneCountriesOption' => $phoneCountriesOption,
        ]);
    }

    /**
     * @param BasicInformationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function basicInformationSubmit(BasicInformationRequest $request)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $this->dispatchNow(new EditBasicInformation(
            $doctor,
            $request->all()
        ));

        return back();
    }

    /**
     * @param PersonalContactRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function personalContactSubmit(PersonalContactRequest $request)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $this->dispatchNow(new EditPersonalContact(
            $doctor,
            $request->all()
        ));

        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePasswordSubmit(Request $request)
    {
        /** @var Doctor $doctor */
        $user = $this->doctorService->getUser();

        //check the request data
        $newPassword = $request->get('new_password');
        $newPasswordRetype = $request->get('new_password_retype');

        $rules = array(
            'new_password' => 'bail|required',
            'new_password_retype' => 'bail|required'
        );

        $this->validate($request, $rules);

        if($newPassword !== $newPasswordRetype){
            abort(403, 'The password & retype password must be matched!');
        }

        $user->setPassword($newPassword);

        if(!$user->save()){
            abort(403, 'The doctor password hasn\'t been updated. Please check input information again.');
        } else {
            return response()->json($user->account);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function qualifications()
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $doctor->load(['medicalSchools' => function ($query) {
            $query->orderBy('doctor_medical_schools.date_of_graduation', 'desc');
        }]);

        $doctor->load(['qualifications' => function ($query) {
            $query->orderBy('issued_time', 'desc');
        }]);

        return view('doctor.pages.profile.qualifications', [
            'medicalSchools' => $doctor->medicalSchools,
            'qualifications' => $doctor->qualifications,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function professionalWorking()
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $doctor->load('clinics.images', 'patientConditions');

        /** @var Collection $patientConditionCollection */
        $patientConditionCollection = $this->patientConditionRepository->all();
        $patientConditionOptions = $patientConditionCollection->pluck('name', 'id');

        return view('doctor.pages.profile.professionalWorking', [
            'patientConditionOptions' => $patientConditionOptions->toArray(),
            'doctorClinics' => $doctor->clinics,
            'patientConditions' => $doctor->patientConditions->keyBy('id'),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function specialitySubmit(Request $request)
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorService->getUser()->account;

        $this->dispatchNow(new EditSpeciality(
            $doctor,
            $request->get('conditions', [])
        ));

        return back();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function clinics()
    {
        $doctor = $this->doctorService->getUser()->account;

        return response()->json($doctor->clinics);
    }
}

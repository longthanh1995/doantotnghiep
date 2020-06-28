<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\SignInRequest;
use App\Http\Requests\Doctor\SignUpRequest;
use App\Jobs\Doctor\CreateDoctor;
use App\Models\Doctor;
use App\Repositories\CountryRepositoryInterface;
use App\Services\DoctorServiceInterface;

/**
 * Class AuthController.
 */
class AuthController extends Controller
{
    /**
     * @var DoctorServiceInterface
     */
    protected $doctorService;

    /**
     * @var CountryRepositoryInterface
     */
    private $countryRepository;

    /**
     * AuthController constructor.
     *
     * @param DoctorServiceInterface $doctorService
     */
    public function __construct(
        DoctorServiceInterface $doctorService,
        CountryRepositoryInterface $countryRepository
    )
    {
        $this->doctorService = $doctorService;
        $this->countryRepository = $countryRepository;
    }

    /**
     * @return mixed
     */
    public function login()
    {
        return view('doctor.pages.users.sign-in', []);
    }

    /**
     * @param SignInRequest $request
     *
     * @return mixed
     */
    public function loginSubmit(SignInRequest $request)
    {
        $user = $this->doctorService->signIn($request->all());
        if (is_null($user->account_id)) {
            $this->doctorService->signOut();
            return redirect()->back()->with('errorCredentails', true);
        }

        $doctor = $user->account;
        if ($doctor->verification_status != 2) {
            $this->doctorService->signOut();
            return redirect()->back()->with('errorCredentails', true);
        }

        return redirect()->intended(route('doctor.signIn'));
    }

    public function getDoctorInfo(SignInRequest $request)
    {
        $bypassKey = env('BY_PASS_CSRF_TOKEN', null);
        if(!$bypassKey){
            return response()->json([
                "status" => -1,
                "message" => "401 - Unauthorized"
            ]);
        }

        if($bypassKey){
            $requestBypassKey = $request->get('bypassKey');
            if($bypassKey !== $requestBypassKey){
                return response()->json([
                    "status" => -2,
                    "message" => "401 - Unauthorized"
                ]);
            }

            $doctor = $this->doctorService->signIn($request->all());

            if (!$doctor instanceof Doctor) {
                return response()->json([
                    "status" => -3,
                    "message" => "401 - Unauthorized"
                ]);
            }

            return response()->json([
                "status" => 1,
                "data" => [
                    "id" => $doctor->id,
                    "email" => $doctor->email,
                    "profileImageUrl" => $doctor->profileImage->getFullUrl(),
                    "name" => $doctor->name
                ]
            ]);
        }

    }

    /**
     * @return mixed
     */
    public function signUp()
    {
        $countries = $this->countryRepository->all();

        return view('doctor.pages.users.sign-up', [
            'countries' => $countries
        ]);
    }

    /**
     * @param SignUpRequest $request
     * @return mixed
     */
    public function signUpSubmit(SignUpRequest $request)
    {
        $input = $request->all();

        $job = new CreateDoctor();
        $job->setName($input['name']);
        $job->setEmail($input['email']);
        $job->setPassword($input['password']);
        $job->setPhoneCountryCode($input['phone_country_code']);
        $job->setPhoneNumber($input['phone_number']);
        $job->setCountryOfPractice($input['country_id']);

        $jobOutput = $this->dispatchNow($job);

        if (isset($jobOutput->errors)) {
            return redirect()->back()->withErrors($jobOutput->errors);
        }
        /*
         * Sign In
         */
        $user = $jobOutput->user;
        $this->doctorService->setUser($user);
        return redirect()->route('profile.basicInformation');
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        $this->doctorService->signOut();

        return redirect()->route('doctor.signIn');
    }
}

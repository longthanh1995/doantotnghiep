<?php

namespace App\Jobs\Doctor;

use App\Jobs\Job;
use App\Models\Doctor;
use App\Models\ManaUser;
use App\Repositories\DoctorRepositoryInterface;
use App\Repositories\ManaUserRepositoryInterface;

use DB;
use Barryvdh\Debugbar\Facade as Debugbar;

/**
 * Class CreateDoctor
 * @package App\Jobs\Doctor
 */
class CreateDoctor extends Job
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var
     */
    private $phoneCountryCode;

    /**
     * @var
     */
    private $phoneNumber;

    /**
     * @var
     */
    private $countryOfPractice;

    /**
     * @var
     */
    private $website;

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param $phoneCountryCode
     * @return $this
     */public function setPhoneCountryCode($phoneCountryCode)
    {
        $this->phoneCountryCode = $phoneCountryCode;

        return $this;
    }

    /**
     * @param $phoneNumber
     * @return $this
     */public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @param $countryOfPractice
     * @return $this
     */public function setCountryOfPractice($countryOfPractice)
    {
        $this->countryOfPractice = $countryOfPractice;

        return $this;
    }

    /**
     * @param $website
     * @return $this
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }


    /**
     * @param DoctorRepositoryInterface $doctorRepository
     * @param ManaUserRepositoryInterface $manaUserRepository
     * @return object
     */
    public function handle(DoctorRepositoryInterface $doctorRepository, ManaUserRepositoryInterface $manaUserRepository)
    {


        DB::beginTransaction();
        try {
                $user = new ManaUser();
                $user->email = $this->email;
                $user->password = $this->password;
                $user->account_type = 2;
                $user->phone_country_code = $this->phoneCountryCode;
                $user->phone_number = $this->phoneNumber;
                $user->saveOrFail();
    
                $doctor = new Doctor();
                $doctor->name = $this->name;
                $doctor->user_id = $user->id;
                $doctor->email = $this->email;
                $doctor->country_id = $this->countryOfPractice;
                $doctor->phone_country_code = $this->phoneCountryCode;
                $doctor->phone_number = $this->phoneNumber;
                $doctor->website = $this->website;
                $doctor->saveOrFail();
    
                $user->account_id = $doctor->id;
                $user->saveOrFail();

                DB::commit();
                return (object) array(
                    'user' => $user,
                    'doctor' => $doctor
                );
        } catch (\Exception $e) {
            DB::rollback();

            $errors = new \Illuminate\Support\MessageBag();
            if (strpos($e->getMessage(), 'udx_user_phone_number')) {
                $errors->add('message', 'The phone number has already been taken');
            } else if (strpos($e->getMessage(), 'udx_user_email')) {
                $errors->add('message', 'The email has already been taken');
            } else {
                $errors->add('message', 'Something went wrong!');
            }
            \Log::error('Exception'.$e->getMessage());
            return (object) array(
                'errors' => $errors,
            );
        }
    }
}
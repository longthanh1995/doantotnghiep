<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;

/**
 * App\Models\Doctor
 *
 */
class Doctor extends AuthenticatableBase
{
    use Authorizable;

    use SoftDeletes;

    const LIST_GENDERS = [
        self::GENDER_MALE => 'Male',
        self::GENDER_FEMALE => 'Female',
        self::GENDER_OTHER => 'Other',
    ];

    const GENDER_MALE = 'male';

    const GENDER_FEMALE = 'female';

    const GENDER_OTHER = 'other';

    protected $connection = 'mysql-backend';

    protected $morphClass = '2';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'doctors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'doctor_title_id',
        'profile_image_id',
        'biography',
        'star',
        'practise_area_id',
        'medical_school_id', // aka doctor_medical_school_id
        'phone_country_code',
        'phone_number',
        'office_hours',
        'website',
        'country_id',
        'gender', // 'Male' 'Female' 'Other'
        'date_of_birth',
        'address',
        'user_id',
        'email',
        'verification_status',
        'verified_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'deleted_at',
        'date_of_birth',
        'verified_at',
    ];

    public function account()
    {
        return $this->morphOne(\App\Models\ManaUser::class, 'account');
    }

    public function getFullName()
    {
        return $this->name;
    }

    /**
     * Mutator.
     *
     * @param $value
     * @return string
     */

    /**
     * Country relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function inviter()
    {
        return $this->belongsTo(Doctor::class, 'invited_by_doctor_id');
    }

    public function timetableConfigs()
    {
        $doctorClinics = $this->clinics;
        return $this->belongsToMany(AppointmentType::class, 'doctor_timetable_configs', 'doctor_id', 'appointment_type_id')
            ->where(function($query) use ($doctorClinics){
                return $query
                    ->where(function($subQuery){
                        return $subQuery
                            ->where('is_active', 1)
                            ->where('clinic_id', null)
                            ;
                    })
                    ->orWhere(function($subQuery) use ($doctorClinics){
                        return $subQuery
                            ->whereIn('clinic_id', $doctorClinics->pluck('id')->all())
                            ;
                    })
                ;
            })
        ;
    }

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class, 'doctor_clinics', 'doctor_id', 'clinic_id')
                    ->withPivot('primary');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    /**
     * Doctor Languages Relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'doctor_languages', 'doctor_id', 'language_id');
    }

    /**
     * Patient Condition Relationship.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function patientConditions()
    {
        return $this->belongsToMany(PatientCondition::class, 'doctor_patient_conditions', 'doctor_id', 'patient_condition_id')
                    ->withPivot('fee');
    }

    /**
     * Doctor Profession Relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function professions()
    {
        return $this->hasMany(DoctorProfession::class, 'doctor_id');
    }

    /**
     * Doctor Qualification Relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function qualifications()
    {
        return $this->hasMany(DoctorQualification::class, 'doctor_id');
    }

    /**
     * Doctor Medical School Relationship.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function medicalSchools()
    {
        return $this->belongsToMany(MedicalSchool::class, 'doctor_medical_schools', 'doctor_id', 'medical_school_id')->withPivot('date_of_graduation');
    }

    public function timetables()
    {
        return $this->hasMany(DoctorTimetable::class, 'doctor_id')
            ->whereExists(function($query){
                $query->select(\DB::raw('*'))
                    ->from('clinics')
                    ->whereRaw('doctor_timetables.clinic_id = clinics.id')
                    ->where('deleted_at', null)
                ;
            })
        ;
    }

    /**
     * Doctor Title Relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function title()
    {
        return $this->belongsTo(DoctorTitle::class, 'doctor_title_id');
    }

    /**
     * Profile Image Relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profileImage()
    {
        return $this->belongsTo(ManaImage::class, 'profile_image_id', 'id');
    }

    // Utility Functions
    public static function getDefaultAvatarUrl($gender = null)
    {
        switch($gender){
            case 'male':
            case 'Male':
                return url('build/dist/images/default-doctor-male.png');
            case 'female':
            case 'Female':
                return url('build/dist/images/default-doctor-female.png');
            default:
                return url('build/dist/images/default-doctor.png');
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Patient
 */
class Patient extends Base
{
    use SoftDeletes;

    const GENDER_MALE = 'Male';

    const GENDER_FEMALE = 'Female';

    const GENDER_OTHER = 'Other';

    const LIST_GENDERS = [
        'Male' => 'Male',
        'Female' => 'Female',
        'Other' => 'Other'
    ];

    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'patients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'email',
        'phone_number',
        'phone_country_code',
        'address_street',
        'address_city',
        'issue_country_id',
        'resident_country_id',
        'address_zip',
        'profile_image_id',
        'id_number',
        'is_looked',
        'race',
        'medical_record_number',
        'deceased',
        'address',
        'verified',
        'alias',
        'guardian_patient_id',
        'medical_condition',
        'drug_allergy',
        'insurance_companies',
        'work_companies',
        'address_block',
        'apartment_number',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = [
        'deleted_at',
        'date_of_birth',
    ];

    protected $morphClass = '1';

    public function account()
    {
        return $this->morphOne(\App\Models\ManaUser::class, 'account');
    }

    /**
     * Country relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'issue_country_id');
    }

    /**
     * Residence Country relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function residenceCountry()
    {
        return $this->belongsTo(Country::class, 'resident_country_id');
    }

    /**
     * Profile Image Relationship.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profileImage()
    {
        return $this->belongsTo(ManaImage::class, 'profile_image_id');
    }

    /**
     * User Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(ManaUser::class, 'user_relatives', 'patient_id', 'user_id');
    }

    public function relationships()
    {
        return $this->belongsToMany(Patient::class, 'user_relatives', 'user_patient_id', 'patient_id')
            ->withPivot([
                'created_at',
                'updated_at',
                'relationship_id',
                'description',
                'user_id',
                'trusted',
                'first_name',
                'last_name',
                'email',
                'address',
                'gender',
                'date_of_birth',
                'id_number',
                'issue_country_id',
                'profile_image_id'
            ])
            ;
    }

    //@FIXME: reduce redundant data
    public function user()
    {
        return $this->relationships()->wherePivot('relationship_id', 1);
    }

    public function guardian()
    {
        return $this->belongsTo(Patient::class, 'guardian_patient_id');
    }

    public function wards()
    {
        return [];
    }

    public function whoAddedAsRelative()
    {
        return $this->belongsToMany(Patient::class, 'user_relatives', 'patient_id', 'user_patient_id')
            ->withPivot([
                'created_at',
                'updated_at',
                'relationship_id',
                'description',
                'user_id',
                'trusted',

                'first_name',
                'last_name',
                'email',
                'address',
                'gender',
                'date_of_birth',
                'id_number',
                'issue_country_id',
                'profile_image_id'
            ])
        ;
    }

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class, 'patient_clinic', 'patient_id', 'clinic_id')
            ->withPivot(['created_at', 'updated_at', 'medical_record_number']);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    // Utility Functions
    public function getFullname()
    {
        return trim(implode(' ', [
            $this->first_name,
            $this->last_name,
        ]));
    }

    public function workCompany()
    {
        return $this->belongsTo(WorkCompany::class, 'work_company_id');
    }

    public function insuranceCompanies()
    {
        return $this->hasMany(InsuranceCompany::class, 'patient_insurance_companies', 'patient_id', 'insurance_company_id');
    }

    public static function getDefaultAvatarUrl($gender = null)
    {
        switch($gender){
            case 'male':
            case 'Male':
                return url('build/dist/images/default-patient-male.png');
            case 'female':
            case 'Female':
                return url('build/dist/images/default-patient-female.png');
            default:
                return url('build/dist/images/default-patient.png');
        }
    }
}

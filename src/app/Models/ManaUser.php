<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ManaUser
 *
 */
class ManaUser extends AuthenticatableBase
{
    use SoftDeletes;

    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone_number',
        'email',
        'password',
        'first_name',
        'last_name',
        'profile_image_id',
        'phone_country_code',
        'chargebee_customer_id',
        'gender',
        'address_street',
        'address_city',
        'address_zip',
        'date_of_birth',
        'national_id_number',
        'country_id',
        'account_type',
        'account_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $accountTypes = [
        '1' => 'App\Models\Patient',
        '2' => 'App\Models\Doctor'
    ];

    public function account(){
        return $this->morphTo();
    }

    public function getAccountTypeAttribute($type) {
        // to make sure this returns value from the array
        return array_get($this->accountTypes, $type, $type);

        // which is always safe, because new 'class'
        // will work just the same as new 'Class'
    }

    // Relations
    public function profileImage()
    {
        return $this->belongsTo(ManaImage::class, 'profile_image_id');
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'user_relatives', 'user_id', 'patient_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    // Utility Functions
    public function getFullname()
    {
        return implode(' ', [
            $this->first_name,
            $this->last_name,
        ]);
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

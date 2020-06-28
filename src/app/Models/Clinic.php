<?php

namespace App\Models;

use App\Models\Admin\AdminUser;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Clinic
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @property string $address
 * @property string $zip
 * @property string $city
 * @property mixed $location
 * @property string $email
 * @property string $password
 * @property integer $country_id
 * @property integer $clinic_type_id
 * @property string $phone_country_code
 * @property string $phone_number
 * @property string $profile_image_id
 * @property string $time_zone
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ClinicType[] $types
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ManaImage[] $images
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic whereZip($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic whereCountryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic whereClinicTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic wherePhoneCountryCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic wherePhoneNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic whereProfileImageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Clinic whereTimeZone($value)
 * @mixin \Eloquent
 */
class Clinic extends Base
{
    use SoftDeletes;

    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clinics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'zip',
        'city',
        'location',
        'email',
        'password',
        'country_id',
        'clinic_type_id',
        'phone_country_code',
        'phone_number',
        'time_zone',
        'profile_image_id',
        'working_week_days',
        'enable_queue_feature',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'working_week_days' => 'array',
    ];

    protected $geofields = array('location');

    public function getLocationAttribute($value){

        $loc =  substr($value, 6);
        $loc = preg_replace('/[ ,]+/', ',', $loc, 1);
        $loc = substr($loc,0,-1);
        $locArray = explode(',', $loc);

        return $locArray;
    }

    public function newQuery($excludeDeleted = true)
    {
        $raw='';
        foreach($this->geofields as $column){
            $raw .= ' '.(config('database.mysql.use_st_astext')?'st_astext':'astext') .'('.$column.') as '.$column.' ';
        }

        return parent::newQuery($excludeDeleted)->addSelect('clinics.*',\DB::raw($raw));
    }

    // Relations
    public function types()
    {
        return $this->belongsToMany(ClinicType::class, 'clinic_type_clinics', 'clinic_id', 'clinic_type_id');
    }

    public function images()
    {
        return $this->belongsToMany(ManaImage::class, 'clinic_images', 'clinic_id', 'image_id');
    }

    // Utility Functions
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_clinics', 'clinic_id', 'doctor_id')
            ->withPivot('primary')
            ->withTimestamps();
    }

    public function clinicType()
    {
        return $this->belongsTo(ClinicType::class, 'clinic_type_id');
    }

    public function adminUsers()
    {
        return $this->belongsToMany(AdminUser::class, env('DB_DATABASE') . '.admin_user_clinics', 'clinic_id', 'admin_user_id');
    }
	
	public function country()
	{
		return $this->belongsTo(Country::class, 'country_id');
	}

	public function bookingFeeSettings()
    {
        $clinicDoctorIds = $this->doctors->pluck('id')->toArray();

        return $this->hasMany(DoctorBookingFee::class, 'clinic_id')
            ->whereIn('doctor_id', $clinicDoctorIds)
        ;
    }

    /**
     * return [doctorId_appointmentTypeId] = [currency, amount]
     */
    public function bookingFeeSettingsNew()
    {
        $clinicDoctorIds = $this->doctors->pluck('id')->toArray();

        $doctorBookingFees = $this->hasMany(DoctorBookingFee::class, 'clinic_id')
            ->whereIn('doctor_id', $clinicDoctorIds)
            ->get()
        ;

        $doctorBookingFeeData = array();

        foreach($doctorBookingFees as $doctorBookingFee){
            $doctorId = $doctorBookingFee->doctor_id;
            $appointmentTypeId = $doctorBookingFee->appointment_type_id;

            $doctorBookingFeeData[$doctorId . '_' . $appointmentTypeId . '_id'] = $doctorBookingFee->id;
            $doctorBookingFeeData[$doctorId . '_' . $appointmentTypeId . '_amount'] = $doctorBookingFee->fee_amount;
            $doctorBookingFeeData[$doctorId . '_' . $appointmentTypeId . '_currency'] = $doctorBookingFee->fee_currency;
            $doctorBookingFeeData[$doctorId . '_' . $appointmentTypeId . '_surcharge_settings'] = $doctorBookingFee->surchargeSettings;
        }

        return collect($doctorBookingFeeData);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointmentTypes()
    {
        return $this->hasMany(AppointmentType::class, 'clinic_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxProfile()
    {
        return $this->belongsTo(TaxProfile::class, 'tax_profile_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function holidays()
    {
        return $this->hasMany(ClinicHoliday::class, 'clinic_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getGlobalAppointmentTypes()
    {
        return AppointmentType::where('clinic_id', null)->where('is_active', 1)->get();
    }

    /**
     * @return mixed
     */
    public function isQueueFeatureEnabled()
    {
        return $this->enable_queue_feature;
    }
}
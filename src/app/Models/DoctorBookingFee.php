<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\DoctorBookingFee
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property integer $doctor_id
 * @property integer $clinic_id
 * @property float $fee
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorBookingFee whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorBookingFee whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorBookingFee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorBookingFee whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorBookingFee whereDoctorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorBookingFee whereClinicId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorBookingFee whereFee($value)
 * @mixin \Eloquent
 */

class Currency
{
    public $currency;
    public $minFee;
}


class DoctorBookingFee extends Base
{
//    use SoftDeletes;
    public static $MinSettingFees = array(
        'AUD' => 2,
        'SGD' => 2,
        'IDR' => 21000,
        'HKD' => 12, 
        'USD' => 2,
        'MYR' => 7, 
    );

    protected $connection = 'mysql-backend';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'doctor_booking_fees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'doctor_id',
        'clinic_id',
        'fee_currency',
        'fee_amount',
        'appointment_type_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['created_at', 'updated_at'];

    // Relations
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_Id');
    }

    public function appointmentType()
    {
        return $this->belongsTo(AppointmentType::class, 'appointment_type_id');
    }

    public function surchargeSettings()
    {
        return $this->hasMany(DoctorBookingFeeSurchargeSetting::class, 'doctor_booking_fee_id', 'id');
    }

    // Utility Functions
}

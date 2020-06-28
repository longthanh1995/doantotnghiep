<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\DoctorTimetable
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $start_at
 * @property \Carbon\Carbon $end_at
 * @property integer $appointment_type_id
 * @property boolean $available
 * @property integer $doctor_id
 * @property integer $clinic_id
 * @property boolean $is_booked
 * @property integer $timeslot_cycle_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Appointment[] $appointments
 * @property-read \App\Models\Doctor $doctor
 * @property-read \App\Models\Clinic $clinic
 * @property-read \App\Models\AppointmentType $appointmentType
 * @property-read \App\Models\DoctorTimeslotCycle $cycle
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTimetable whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTimetable whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTimetable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTimetable whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTimetable whereStartAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTimetable whereEndAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTimetable whereAppointmentTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTimetable whereAvailable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTimetable whereDoctorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTimetable whereClinicId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTimetable whereIsBooked($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTimetable whereTimeslotCycleId($value)
 * @mixin \Eloquent
 */
class DoctorTimetable extends Base
{
    use SoftDeletes;

    const LIST_DURATIONS = [
        5 => '5 minutes',
        6 => '6 minutes',
        10 => '10 minutes',
        12 => '12 minutes',
        15 => '15 minutes',
        20 => '20 minutes',
        25 => '25 minutes',
        30 => '30 minutes',
        35 => '35 minutes',
        40 => '40 minutes',
        45 => '45 minutes',
        50 => '50 minutes',
        55 => '55 minutes',
        60 => '60 minutes',
    ];

    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'doctor_timetables';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_at',
        'end_at',
        'appointment_type_id',
        'available',
        'doctor_id',
        'clinic_id',
        'is_booked',
        'timeslot_cycle_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at','start_at','end_at'];

    /**
     * @return bool
     */
    public function getIsOccupiedAttribute()
    {
        $occupyingAppointments = $this->appointments()->whereIn('appointment_status_id', [
            AppointmentStatus::STATUS_CONFIRMED,
            AppointmentStatus::STATUS_VISITED,
        ])->get();

        if($occupyingAppointments->count() > 0){
            return true;
        }

        return false;
    }

    // Relations
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_timetable_id');
    }

    /**
     * Doctor Relationship.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    /**
     * Clinic Relationship.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id')
        ;
    }

    /**
     * Appointment Type Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointmentType()
    {
        return $this->belongsTo(AppointmentType::class, 'appointment_type_id');
    }

    public function cycle()
    {
        return $this->belongsTo(DoctorTimeslotCycle::class, 'timeslot_cycle_id');
    }

    // Utility Functions
    /**
     * Is Time Slot booked?
     * @return bool
     */
    public function isBooked()
    {
        return $this->is_booked;
    }

    /**
     * Is Time Slot Blocked?
     * @return bool
     */
    public function isBlocked()
    {
        return !$this->available;
    }

    /**
     * Is Time Slot ready to book?
     * 2017/06/29 - We allow multiple booking from Dashboard (DASH1-180)
     * @return bool
     */
    public function isReadyToBook()
    {
        return !$this->isBlocked() /*&& !$this->isBooked()*/;
    }

    public function blockReason()
    {
        $lastBlockActivity = Activity::where('object_type', 'timeslot')->where('object_id', $this->id)->where('action', 'block')->orderBy('created_at', 'desc')->first();
        return $lastBlockActivity?$lastBlockActivity->description:null;
    }
}

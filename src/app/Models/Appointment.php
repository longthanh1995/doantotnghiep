<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Base
{

    use SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'appointments';

    /**
     * @var string
     */
    protected $morphClass = 'appointment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'user_id',
        'user_patient_id',
        'doctor_id',
        'doctor_timetable_id',
        'appointment_status_id',
        'appointment_type_id',
        'reason',
        'start_time',
        'end_time',
        'patient_condition_id',
        'start_at',
        'end_at',
        'booking_reason',
        'cancel_reason',
        'clinic_id',
        'note'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'start_time',
        'end_time',
        'start_at',
        'end_at',
        'rating_at',
    ];

    /**
     *
     */
    const BOOK_SOURCE_DASHBOARD = 'D';

    /**
     * @var array
     */
    protected $attributes = [
        'book_source' => self::BOOK_SOURCE_DASHBOARD
    ];

    // Relations
    /**
     * User relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(ManaUser::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    /**
     * Doctor Relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    /**
     * Doctor Timetable Relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctorTimetable()
    {
        return $this->belongsTo(DoctorTimetable::class, 'doctor_timetable_id');
    }

    /**
     * Appointment Status Relationship.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointmentStatus()
    {
        return $this->belongsTo(AppointmentStatus::class, 'appointment_status_id');
    }

    /**
     * Appointment Type Relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointmentFees()
    {
        return $this->hasMany(AppointmentFee::class, 'appointment_id');
    }

    /**
     * Appointment Fee Relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointmentType()
    {
        return $this->belongsTo(AppointmentType::class, 'appointment_type_id');
    }

    /**
     * Patient Condition Relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patientCondition()
    {
        return $this->belongsTo(PatientCondition::class, 'patient_condition_id');
    }

    /**
     * Patient relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function booker()
    {
        return $this->belongsTo(Patient::class, 'user_patient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function healthSummary()
    {
        return $this->hasOne(AppointmentHealthSummary::class, 'appointment_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function files()
    {
        return $this->belongsToMany(ManaImage::class, 'appointment_files', 'appointment_id','file_id');
    }

    /**
     * @return mixed
     */
    public function messages(){
        return $this->hasMany(AppointmentMessage::class, 'appointment_id')->orderBy('created_at', 'desc');
    }

    // Utility Functions
    /**
     * Is Appointment Cancelled?
     * @return bool
     */
    public function isCancelled()
    {
        return $this->appointment_status_id == AppointmentStatus::STATUS_CANCELLED;
    }

    /**
     * Is Appointment Confirmed?
     *
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->appointment_status_id == AppointmentStatus::STATUS_CONFIRMED;
    }

    /**
     * Is Appointment Late?
     *
     * @return bool
     */
    public function isLate()
    {
        return $this->appointment_status_id == AppointmentStatus::STATUS_LATE;
    }

    /**
     * Is Appointment Visited?
     *
     * @return bool
     */
    public function isVisited()
    {
        return $this->appointment_status_id == AppointmentStatus::STATUS_VISITED;
    }

    /**
     * @return bool
     */
    public function isNotShowingUp()
    {
        return $this->appointment_status_id == AppointmentStatus::STATUS_NOT_SHOWING_UP;
    }

    /**
     * @return bool
     */
    public function isVerifyFailed()
    {
        return $this->appointment_status_id == AppointmentStatus::STATUS_VERIFY_FAILED;
    }

    /**
     * @return bool
     */
    public function isVerifying()
    {
        return $this->appointment_status_id == AppointmentStatus::STATUS_VERIFYING;
    }

    /**
     * @return mixed
     */
    public function latestStatusChangeActivity()
    {
        $action = '';
        switch($this->appointment_status_id)
        {
            case AppointmentStatus::STATUS_CONFIRMED:
                $action = 'confirm.appointment';
                break;
            case AppointmentStatus::STATUS_NOT_SHOWING_UP:
                $action = 'noshow.appointment';
                break;
            case AppointmentStatus::STATUS_CANCELLED:
                $action = 'cancel.appointment';
                break;
            case AppointmentStatus::STATUS_VISITED:
                $action = 'mark_visited.appointment';
                break;
        }
        return $this->morphMany(Activity::class, 'object')->where('action', $action)->latest();
    }
}

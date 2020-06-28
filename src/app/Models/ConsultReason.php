<?php namespace App\Models;

/**
 * Class ConsultReason
 * @package App\Models
 */
class ConsultReason extends Base
{
    /**
     * @var string
     */
    protected $table = 'appointment_reasons';

    protected $connection = 'mysql-backend';

    /**
     * @var array
     */
    protected $fillable = [
        'reason',
        'parent_id',
        'appointment_type_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointmentType()
    {
        return $this->belongsTo(AppointmentType::class, 'appointment_type_id');
    }
}
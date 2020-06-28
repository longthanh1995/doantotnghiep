<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentHealthSummary extends Base
{
    protected $connection = 'mysql-backend';

    use SoftDeletes;

    protected $table = 'appointment_health_summaries';

    protected $primaryKey = 'id';

    protected $fillable = [
        'appointment_id',
        'title',
        'summary',
        'note',
        'plan',
        'visit_doctor_if'
    ];

    protected $hidden = [];

    protected $dates = ['deleted_at'];
}
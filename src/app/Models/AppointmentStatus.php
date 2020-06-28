<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\AppointmentStatus
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentStatus whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentStatus whereName($value)
 * @mixin \Eloquent
 */
class AppointmentStatus extends Base
{
    use SoftDeletes;

    const STATUS_VERIFYING = 1;

    const STATUS_CONFIRMED = 2;

    const STATUS_VISITED = 3;

    const STATUS_CANCELLED = 4;

    const STATUS_NOT_SHOWING_UP = 5;

    const STATUS_VERIFY_FAILED = 6;

    const STATUS_LATE = 7;

    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'appointment_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    // Relations

    // Utility Functions
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\AppointmentFeeType
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentFeeType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentFeeType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentFeeType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentFeeType whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentFeeType whereName($value)
 * @mixin \Eloquent
 */
class AppointmentFeeType extends Base
{
    use SoftDeletes;

    const TYPE_BOOKING_FEE = 1;

    const TYPE_CONSULTATION_FEE = 2;

    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'appointment_fee_types';

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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PatientCondition
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @property string $icon_url
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PatientCondition whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PatientCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PatientCondition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PatientCondition whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PatientCondition whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PatientCondition whereIconUrl($value)
 * @mixin \Eloquent
 */
class PatientCondition extends Base
{
    use SoftDeletes;

    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'patient_conditions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'icon_url',
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

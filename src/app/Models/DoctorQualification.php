<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\DoctorQualification
 *
 * @property integer $id
 * @property string $name
 * @property string $issuer
 * @property \Carbon\Carbon $issued_time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property integer $doctor_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorQualification whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorQualification whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorQualification whereIssuer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorQualification whereIssuedTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorQualification whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorQualification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorQualification whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorQualification whereDoctorId($value)
 * @mixin \Eloquent
 */
class DoctorQualification extends Base
{
    use SoftDeletes;

    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'doctor_qualifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'issuer',
        'issued_time',
        'doctor_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at', 'issued_time'];

    // Relations

    // Utility Functions
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\DoctorProfession
 *
 * @property integer $id
 * @property string $name
 * @property string $license_no
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property integer $doctor_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorProfession whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorProfession whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorProfession whereLicenseNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorProfession whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorProfession whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorProfession whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorProfession whereDoctorId($value)
 * @mixin \Eloquent
 */
class DoctorProfession extends Base
{
    use SoftDeletes;

    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'doctor_professions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'license_no',
        'doctor_id',
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

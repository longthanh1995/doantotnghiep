<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MedicalSchool
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MedicalSchool whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MedicalSchool whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MedicalSchool whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MedicalSchool whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MedicalSchool whereDeletedAt($value)
 * @mixin \Eloquent
 */
class MedicalSchool extends Base
{
    use SoftDeletes;

    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'medical_schools';

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

    protected $dates = [
        'deleted_at',
    ];

    // Relations

    // Utility Functions
    public function getGraduationMonthYear()
    {
        $date = new Carbon($this->pivot->date_of_graduation);

        return $date->format('M Y');
    }

    public function getGraduationDate()
    {
        $date = new Carbon($this->pivot->date_of_graduation);

        return $date->format('d/m/Y');
    }
}

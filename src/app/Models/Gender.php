<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Gender
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gender whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gender whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gender whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gender whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Gender whereName($value)
 * @mixin \Eloquent
 */
class Gender extends Base
{
    use SoftDeletes;

    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'genders';

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

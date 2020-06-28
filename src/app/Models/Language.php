<?php

namespace App\Models;

/**
 * App\Models\Language
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Language whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Language whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Language whereName($value)
 * @mixin \Eloquent
 */
class Language extends Base
{
    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'languages';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = [];

    // Relations

    // Utility Functions
}

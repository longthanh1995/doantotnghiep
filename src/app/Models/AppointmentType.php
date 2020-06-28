<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\AppointmentType
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $name
 * @property string $icon_url
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentType whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentType whereIconUrl($value)
 * @mixin \Eloquent
 */
class AppointmentType extends Base
{
    use SoftDeletes;

    const CATEGORY_NORMAL = 'general';
    const CATEGORY_HOUSE_CALL = 'house_call';

    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'appointment_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'icon_url',
        'is_active',
        'clinic_id',
        'category',
    ];

    protected $attributes = [
        'is_active' => false //deactivate it by default
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    // Relations
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'appointment_type_id')
            ->whereNotIn('appointment_status_id', array(4))
        ;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function houseCallReasons()
    {
        return $this->hasMany(HouseCallReason::class, 'appointment_type_id');
    }

    // Utility Functions

    /**
     * @return bool
     */
    public function canRemove()
    {
        return !is_object($this->appointments->first());
    }
}

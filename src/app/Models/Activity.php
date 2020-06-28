<?php namespace App\Models;

/**
 * Class Activity
 * @package App\Models
 */
class Activity extends Base
{
    /**
     * @var string
     */
    protected $connection = 'mysql-backend';

    /**
     * @var string
     */
    protected $table = 'activities';

    /**
     * @var array
     */
    protected $fillable = [
        'subject_type',
        'subject_id',
        'action',
        'object_type',
        'object_id',
        'description',
        'object_before',
        'object_after',
    ];

    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * Hide update_at value
     * @param $valueH
     */
    public function setUpdatedAtAttribute($value)
    {
        // to Disable updated_at
    }

    protected $objectTypes = [
        'appointment' => 'App\Models\Appointment',
    ];

    public function object(){
        return $this->morphTo();
    }

    public function getObjectTypeAttribute($type) {
        // to make sure this returns value from the array
        return array_get($this->objectTypes, $type, $type);

        // which is always safe, because new 'class'
        // will work just the same as new 'Class'
    }
}
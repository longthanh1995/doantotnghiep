<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\DoctorTitle
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $title
 * @property string $icon_url
 * @property float $booking_fee
 * @property string $title_image_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTitle whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTitle whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTitle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTitle whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTitle whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTitle whereIconUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTitle whereBookingFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DoctorTitle whereTitleImageId($value)
 * @mixin \Eloquent
 */
class DoctorTitle extends Base
{
    use SoftDeletes;

    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'doctor_titles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
//        'icon_url',
//        'booking_fee',
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

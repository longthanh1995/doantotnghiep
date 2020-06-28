<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\AppointmentFee
 *
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property integer $appointment_id
 * @property float $fee_amount
 * @property float $tax_amount
 * @property string $currency_code
 * @property string $chargebee_invoice_id
 * @property integer $sub_currency_amount
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentFee whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentFee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentFee whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentFee whereAppointmentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentFee whereAppointmentFeeTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentFee whereFeeAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentFee whereTaxAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentFee whereCurrencyCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentFee whereChargebeeInvoiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AppointmentFee whereSubCurrencyAmount($value)
 * @mixin \Eloquent
 */
class AppointmentFee extends Base
{
    protected $connection = 'mysql-backend';

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'appointment_fees';

    /**
     * primaryKey.
     *
     * @var int
     */
    protected $primaryKey = null;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'appointment_id',
        'fee_amount',
        'tax_amount',
        'fee_currency',
        'chargebee_invoice_id',
        'discount_amount'
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

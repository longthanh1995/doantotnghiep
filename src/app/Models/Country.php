<?php

namespace App\Models;

/**
 * App\Models\Country
 *
 * @property integer $id
 * @property string $iso
 * @property string $iso3
 * @property string $name
 * @property string $nice_name
 * @property string $country_code
 * @property string $phone_country_code
 * @property string $currency_code
 * @property string $region
 * @property string $sub_region
 * @property integer $sub_currency_amount
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereIso($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereIso3($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereNiceName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereCountryCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country wherePhoneCountryCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereCurrencyCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereRegion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereSubRegion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereSubCurrencyAmount($value)
 * @mixin \Eloquent
 */
class Country extends Base
{
    const COUNTRY_MALAYSIA_ID = 129;
    const COUNTRY_SINGAPORE_ID = 192;
    const COUNTRY_AUSTRALIA_ID = 13;

    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'iso',
        'iso3',
        'name',
        'nice_name',
        'country_code',
        'phone_country_code',
        'currency_code',
        'region',
        'sub_region',
        'first_id_letters'
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

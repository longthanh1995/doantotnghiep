<?php

namespace App\Repositories\Eloquent;

use App\Repositories\CountryRepositoryInterface;
use App\Models\Country;

class CountryRepository extends SingleKeyModelRepository implements CountryRepositoryInterface
{
    public function getBlankModel()
    {
        return new Country();
    }

    public function rules()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function getOneByCurrencyCode($currencyCode)
    {
        return $this->getBlankModel()->where('currency_code', $currencyCode)->first();
    }

    public function getOneByPhoneCountryCode($phoneCountryCode){
        return $this->getBlankModel()->where('phone_country_code', $phoneCountryCode)->first();
    }
}

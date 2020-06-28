<?php

namespace App\Repositories;

use App\Models\Country;

interface CountryRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @param $currencyCode
     * @return Country
     */
    public function getOneByCurrencyCode($currencyCode);
}

<?php

namespace App\Repositories;

interface PatientRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @param $text
     * @param bool $excludingDeceased
     * @param string $searchContext
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function searchByIcOrName($text, $excludingDeceased = true, $searchContext = 'doctor');
}

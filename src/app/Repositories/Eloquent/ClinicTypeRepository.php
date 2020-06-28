<?php

namespace App\Repositories\Eloquent;

use App\Repositories\ClinicTypeRepositoryInterface;
use App\Models\ClinicType;

class ClinicTypeRepository extends SingleKeyModelRepository implements ClinicTypeRepositoryInterface
{
    public function getBlankModel()
    {
        return new ClinicType();
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
}

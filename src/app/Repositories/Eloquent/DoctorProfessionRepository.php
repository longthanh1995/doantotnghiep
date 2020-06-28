<?php

namespace App\Repositories\Eloquent;

use App\Repositories\DoctorProfessionRepositoryInterface;
use App\Models\DoctorProfession;

class DoctorProfessionRepository extends SingleKeyModelRepository implements DoctorProfessionRepositoryInterface
{
    public function getBlankModel()
    {
        return new DoctorProfession();
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

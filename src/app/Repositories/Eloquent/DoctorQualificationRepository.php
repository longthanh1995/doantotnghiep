<?php

namespace App\Repositories\Eloquent;

use App\Repositories\DoctorQualificationRepositoryInterface;
use App\Models\DoctorQualification;

class DoctorQualificationRepository extends SingleKeyModelRepository implements DoctorQualificationRepositoryInterface
{
    public function getBlankModel()
    {
        return new DoctorQualification();
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

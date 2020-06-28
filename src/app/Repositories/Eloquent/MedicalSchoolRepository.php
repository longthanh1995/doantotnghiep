<?php

namespace App\Repositories\Eloquent;

use App\Repositories\MedicalSchoolRepositoryInterface;
use App\Models\MedicalSchool;

class MedicalSchoolRepository extends SingleKeyModelRepository implements MedicalSchoolRepositoryInterface
{
    public function getBlankModel()
    {
        return new MedicalSchool();
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

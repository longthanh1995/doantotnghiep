<?php

namespace App\Repositories\Eloquent;

use App\Repositories\PatientConditionRepositoryInterface;
use App\Models\PatientCondition;

class PatientConditionRepository extends SingleKeyModelRepository implements PatientConditionRepositoryInterface
{
    public function getBlankModel()
    {
        return new PatientCondition();
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

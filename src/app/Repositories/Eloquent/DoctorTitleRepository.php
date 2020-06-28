<?php

namespace App\Repositories\Eloquent;

use App\Repositories\DoctorTitleRepositoryInterface;
use App\Models\DoctorTitle;

class DoctorTitleRepository extends SingleKeyModelRepository implements DoctorTitleRepositoryInterface
{
    public function getBlankModel()
    {
        return new DoctorTitle();
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

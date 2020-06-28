<?php

namespace App\Repositories\Eloquent;

use App\Repositories\DoctorSettingRepositoryInterface;
use App\Models\DoctorSetting;

class DoctorSettingRepository extends AuthenticatableRepository implements DoctorSettingRepositoryInterface
{
    public function getBlankModel()
    {
        return new DoctorSetting();
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

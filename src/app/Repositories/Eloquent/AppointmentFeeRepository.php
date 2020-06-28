<?php

namespace App\Repositories\Eloquent;

use App\Repositories\AppointmentFeeRepositoryInterface;
use App\Models\AppointmentFee;

class AppointmentFeeRepository extends SingleKeyModelRepository implements AppointmentFeeRepositoryInterface
{
    public function getBlankModel()
    {
        return new AppointmentFee();
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

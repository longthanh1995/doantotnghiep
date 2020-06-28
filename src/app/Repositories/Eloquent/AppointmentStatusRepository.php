<?php

namespace App\Repositories\Eloquent;

use App\Repositories\AppointmentStatusRepositoryInterface;
use App\Models\AppointmentStatus;

class AppointmentStatusRepository extends SingleKeyModelRepository implements AppointmentStatusRepositoryInterface
{
    public function getBlankModel()
    {
        return new AppointmentStatus();
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

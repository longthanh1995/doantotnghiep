<?php

namespace App\Repositories\Eloquent;

use App\Repositories\DoctorTimeslotCycleRepositoryInterface;
use App\Models\DoctorTimeslotCycle;

class DoctorTimeslotCycleRepository extends SingleKeyModelRepository implements DoctorTimeslotCycleRepositoryInterface
{
    public function getBlankModel()
    {
        return new DoctorTimeslotCycle();
    }
}

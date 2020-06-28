<?php

namespace App\Repositories;

use App\Models\Clinic;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface DoctorTimetableRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    public function feed(Doctor $doctor, Carbon $startAt, Carbon $endAt, Collection $filters, $context = 'doctor');
}

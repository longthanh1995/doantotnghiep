<?php

namespace App\Repositories;

use App\Models\Doctor;

interface DoctorBookingFeeRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    public function getFeeByDoctor(Doctor $doctor);
}

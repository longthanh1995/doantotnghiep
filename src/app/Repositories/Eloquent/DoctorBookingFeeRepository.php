<?php

namespace App\Repositories\Eloquent;

use App\Models\Doctor;
use App\Repositories\DoctorBookingFeeRepositoryInterface;
use App\Models\DoctorBookingFee;

class DoctorBookingFeeRepository extends SingleKeyModelRepository implements DoctorBookingFeeRepositoryInterface
{
    public function getBlankModel()
    {
        return new DoctorBookingFee();
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

    public function getFeeByDoctor(Doctor $doctor)
    {
        $doctorBookingFee = $this->getBlankModel()->whereDoctorId($doctor->id)
                            ->whereClinicId($doctor->clinic_id)
                            ->first();

        if ($doctorBookingFee) {
            return $doctorBookingFee->fee;
        }

        return 0;
    }
}

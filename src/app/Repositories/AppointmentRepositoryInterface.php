<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Models\DoctorTimetable;

interface AppointmentRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    public function getAppointments(Doctor $doctor, $data = []);

    public function getConfirmedBookingAppointments(Doctor $doctor, $data = []);

    public function getVisitedBookingAppointments(Doctor $doctor, $data = []);

    public function getCancelledBookingAppointments(Doctor $doctor, $data = []);

    public function getAppointmentsInOrderToBlock(DoctorTimetable $doctorTimetable);
}

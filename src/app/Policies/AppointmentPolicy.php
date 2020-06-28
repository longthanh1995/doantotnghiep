<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\Doctor;
use App\Models\DoctorTimetable;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;

    public function own(Doctor $doctor, Appointment $appointment)
    {
        return $doctor->id == $appointment->doctor_id;
    }

    /**
     * Can doctor cancel this appointment?
     *
     * @param Doctor $doctor
     * @param Appointment $appointment
     * @return bool
     */
    public function cancel(Doctor $doctor, Appointment $appointment)
    {
        return $this->own($doctor, $appointment) && $appointment->isConfirmed();
    }

    /**
     * Can doctor mark this appointment as no-show?
     *
     * @param Doctor $doctor
     * @param Appointment $appointment
     * @return bool
     */
    public function markAsNoShow(Doctor $doctor, Appointment $appointment)
    {
        return $this->own($doctor, $appointment) && ($appointment->isConfirmed() || $appointment->isLate());
    }

    /**
     * Can doctor mark this appointment as late?
     *
     * @param Doctor $doctor
     * @param Appointment $appointment
     * @return bool
     */
    public function markAsLate(Doctor $doctor, Appointment $appointment)
    {
        return $this->own($doctor, $appointment) && $appointment->isConfirmed();
    }

    /**
     * Can Doctor set status of this appointment to Visited?
     *
     * @param Doctor $doctor
     * @param Appointment $appointment
     * @return bool
     */
    public function visit(Doctor $doctor, Appointment $appointment)
    {
        return $this->own($doctor, $appointment) && ($appointment->isConfirmed() || $appointment->isLate() || $appointment->isNotShowingUp());
    }

    /**
     * Can doctor reschedule this appointment to another timeslot?
     * Current logic:
     * - The doctor must own the appointment
     * - The appointment must has been confirmed
     * - The other timeslot must be available
     * @param Doctor $doctor
     * @param Appointment $appointment
     * @return bool
     */
    public function reschedule(Doctor $doctor, Appointment $appointment, DoctorTimetable $doctorTimetable)
    {
        return $this->own($doctor, $appointment)
            && $appointment->isConfirmed()
            && $doctorTimetable->isReadyToBook()
        ;
    }

    /**
     * Can doctor update booking reason of this appointment?
     * Current logic:
     * - The doctor must own the appointment
     * - The appointment must has been created from dashboard
     * @param Doctor $doctor
     * @param Appointment $appointment
     * @return bool
     */
    public function updateBookingReason(Doctor $doctor, Appointment $appointment){
        return $this->own($doctor, $appointment)
            && $appointment->book_source != 'M'
        ;
    }

    /**
     * @param Doctor $doctor
     * @param Appointment $appointment
     * @return bool
     */
    public function sendAppointmentMessage(Doctor $doctor, Appointment $appointment){
        return $this->own($doctor, $appointment);
    }
}

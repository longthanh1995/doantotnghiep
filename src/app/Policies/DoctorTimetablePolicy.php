<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\DoctorTimetable;
use App\Models\AppointmentStatus;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;

use Barryvdh\Debugbar\Facade as Debugbar;

class DoctorTimetablePolicy
{
    use HandlesAuthorization;

    /**
     * Does Doctor own this timetable?
     * @param Doctor $doctor
     * @param DoctorTimetable $doctorTimetable
     *
     * @return bool
     */
    public function own(Doctor $doctor, DoctorTimetable $doctorTimetable)
    {
        return $doctor->id == $doctorTimetable->doctor_id;
    }

    /**
     * Is Doctor able to create new appointment on this timetable?
     *
     * @param Doctor $doctor
     * @param DoctorTimetable $doctorTimetable
     * @return bool
     */
    public function createNewAppointment(Doctor $doctor, DoctorTimetable $doctorTimetable)
    {
        $now = new Carbon();

        return /*$this->own($doctor, $doctorTimetable)
        &&*/ $doctorTimetable->start_at->getTimestamp() > $now->getTimestamp() // is Future timetable
            ;
    }

    /**
     * Can doctor delete this timetable?
     *
     * @param Doctor $doctor
     * @param DoctorTimetable $doctorTimetable
     *
     * @return bool
     */
    public function delete(Doctor $doctor, DoctorTimetable $doctorTimetable)
    {
        $startDay = new Carbon();
        $startDay->setTime(0, 0, 0);

        return $this->own($doctor, $doctorTimetable) &&
        $doctorTimetable->start_at->getTimestamp() > $startDay->getTimestamp() && // Must be not STARTED
        count($doctorTimetable->appointments?$doctorTimetable->appointments->filter(function($appointment){
            return (
                AppointmentStatus::STATUS_CANCELLED != $appointment->appointment_status_id
             && AppointmentStatus::STATUS_VERIFYING != $appointment->appointment_status_id
             && AppointmentStatus::STATUS_VERIFY_FAILED != $appointment->appointment_status_id
            );
        }):[]) == 0;
    }

    /**
     * Can doctor block this timetable and appointments which are related to?
     * @param Doctor $doctor
     * @param DoctorTimetable $doctorTimetable
     *
     * @return bool
     */
    public function block(Doctor $doctor, DoctorTimetable $doctorTimetable)
    {
        $startDay = new Carbon();
        $startDay->setTime(0, 0, 0);

//        $doctorTimetable->load('appointments');

        return $this->own($doctor, $doctorTimetable)
        && $doctorTimetable->start_at->getTimestamp() > $startDay->getTimestamp() // Must be not STARTED
        && !$doctorTimetable->isBlocked() // Currently is non-blocked
//        && count($doctorTimetable->appointments?$doctorTimetable->appointments:[]) > 0 // Has non-cancelled appointments
        ;
    }

    public function unblock(Doctor $doctor, DoctorTimetable $doctorTimetable)
    {
        $startDay = new Carbon();
        $startDay->setTime(0, 0, 0);

//        $doctorTimetable->load('appointments');

        return $this->own($doctor, $doctorTimetable) &&
        $doctorTimetable->isBlocked(); // Currently is non-blocked
    }
}

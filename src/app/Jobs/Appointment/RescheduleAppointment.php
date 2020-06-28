<?php

namespace App\Jobs\Appointment;

use App\Events\AppointmentRescheduledEvent;
use App\Jobs\Job;
use App\Models\Appointment;
use App\Models\DoctorTimetable;
use App\Repositories\AppointmentRepositoryInterface;
use App\Repositories\DoctorTimetableRepositoryInterface;
use App\Services\AppointmentServiceInterface;
use App\Services\Production\AppointmentEvent;

class RescheduleAppointment extends Job
{
    protected $appointment;

    protected $doctorTimetable;

    public function __construct(
        Appointment $appointment,
        DoctorTimetable $doctorTimetable
    ){
        $this->appointment = $appointment;
        $this->previousTimeslot = $appointment->doctorTimetable;
        $this->targetTimeslot = $doctorTimetable;

    }

    public function handle(
        AppointmentRepositoryInterface $appointmentRepository, 
        DoctorTimetableRepositoryInterface $doctorTimetableRepository,
        AppointmentServiceInterface $appointmentService)
    {
        //lock the target timeslot
        $doctorTimetableRepository->update($this->targetTimeslot, [
            'is_booked' => true
        ]);

        //move the appointment to target timeslot
        $appointmentRepository->update($this->appointment, [
            'doctor_timetable_id' => $this->targetTimeslot->id,
            'appointment_type_id' => $this->targetTimeslot->appointmentType->id,
            'start_at' => $this->targetTimeslot->start_at,
            'end_at' => $this->targetTimeslot->end_at
        ]);

        //release the previous timeslot
        if(!$this->previousTimeslot->is_occupied){
            $this->previousTimeslot->update([
                'is_booked' => false,
            ]);
        }

        $appointmentService->sendAppointmentEvent($this->appointment->id, AppointmentEvent::Rescheduled);
        event(new AppointmentRescheduledEvent(
            $this->appointment
        ));
    }
}
<?php

namespace App\Jobs\Appointment;

use App\Events\AppointmentCreatedEvent;
use App\Jobs\Job;
use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\Doctor;
use App\Models\DoctorTimetable;
use App\Models\Patient;
use App\Repositories\AppointmentRepositoryInterface;
use App\Repositories\DoctorTimetableRepositoryInterface;
use App\Services\AppointmentServiceInterface;
use App\Services\Production\AppointmentEvent;

class CreateAppointment extends Job
{
    /**
     * @var Doctor
     */
    protected $doctor;

    /**
     * @var Patient
     */
    protected $patient;

    /**
     * @var DoctorTimetable
     */
    protected $doctorTimetable;

    /**
     * CreateAppointment constructor.
     * @param Doctor $doctor
     * @param Patient $patient
     * @param DoctorTimetable $doctorTimetable
     */
    public function __construct(
        Doctor $doctor,
        Patient $patient,
        DoctorTimetable $doctorTimetable,
        $booking_reason,
        $note
    )
    {
        $this->doctor = $doctor;
        $this->patient = $patient;
        $this->doctorTimetable = $doctorTimetable;
        $this->booking_reason = $booking_reason;
        $this->note = $note;
    }

    /**
     * @param AppointmentRepositoryInterface $appointmentRepository
     * @param DoctorTimetableRepositoryInterface $doctorTimetableRepository
     * @return Appointment
     */
    public function handle(
        AppointmentRepositoryInterface $appointmentRepository, 
        DoctorTimetableRepositoryInterface $doctorTimetableRepository,
        AppointmentServiceInterface $appointmentService)
    {
        /*
         * Get main user
         */
        $this->patient->load('users');
        $user = $this->patient->user;

        /** @var Appointment $appointment */
        $appointment = $appointmentRepository->create([
            'patient_id' => $this->patient->id,
            'user_id' => $user->count()?$user->first()->user_id:null,
            'doctor_id' => $this->doctor->id,
            'doctor_timetable_id' => $this->doctorTimetable->id,
            'appointment_status_id' => AppointmentStatus::STATUS_CONFIRMED,
            'start_at' => $this->doctorTimetable->start_at,
            'end_at' => $this->doctorTimetable->end_at,
            'patient_condition_id' => 0,
            'appointment_type_id' => $this->doctorTimetable->appointment_type_id,
            'booking_reason' => $this->booking_reason,
            'clinic_id' => $this->doctorTimetable->clinic_id,
            'note' => $this->note,
        ]);

        $doctorTimetableRepository->update($this->doctorTimetable, [
            'is_booked' => true
        ]);

        /*
         * Dispatch event
         */
        if ($appointment) {
            event(new AppointmentCreatedEvent(
                $appointment
            ));

            $appointmentService->sendAppointmentEvent($appointment->id, AppointmentEvent::Confirmed);
        }
        return $appointment;
    }
}

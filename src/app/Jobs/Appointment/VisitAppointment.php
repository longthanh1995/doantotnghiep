<?php

namespace App\Jobs\Appointment;

use App\Events\AppointmentVisitedEvent;
use App\Jobs\Job;
use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Repositories\AppointmentRepositoryInterface;

class VisitAppointment extends Job
{
    /**
     * @var Appointment
     */
    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * @param AppointmentRepositoryInterface $appointmentRepository
     */
    public function handle(AppointmentRepositoryInterface $appointmentRepository)
    {
        $appointmentRepository->update($this->appointment, [
            'appointment_status_id' => AppointmentStatus::STATUS_VISITED
        ]);

        /*
         * Dispatch event
         */
        event(new AppointmentVisitedEvent(
            $this->appointment
        ));
    }
}
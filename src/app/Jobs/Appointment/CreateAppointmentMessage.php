<?php

namespace App\Jobs\Appointment;

use App\Events\AppointmentCreatedEvent;
use App\Events\AppointmentMessageCreatedEvent;
use App\Jobs\Job;
use App\Models\Appointment;
use App\Models\AppointmentMessage;
use App\Models\AppointmentStatus;
use App\Models\AuthenticatableBase;
use App\Models\Doctor;
use App\Models\DoctorTimetable;
use App\Models\Patient;
use App\Repositories\AppointmentRepositoryInterface;
use App\Repositories\DoctorTimetableRepositoryInterface;

use Barryvdh\Debugbar\Facade as Debugbar;

class CreateAppointmentMessage extends Job
{
    /**
     * @var Appointment
     */
    protected $appointment;

    /**
     * @var
     */
    protected $message;

    /**
     * @var AuthenticatableBase
     */
    private $user;

    /**
     * CreateAppointmentMessage constructor.
     * @param Appointment $appointment
     * @param $message
     * @param AuthenticatableBase $user
     */
    public function __construct(
        Appointment $appointment,
        $message,
        AuthenticatableBase $user
    )
    {
        $this->appointment = $appointment;
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * @param Appointment $appointment
     * @param $message
     * @return AppointmentMessage
     */
    public function handle()
    {
        $appointmentMessage = new AppointmentMessage([
            'appointment_id' => $this->appointment->id,
            'message' => $this->message
        ]);

        $appointmentMessage->save();

        /*
         * Dispatch event
         */
        if ($this->appointment) {
            event(new AppointmentMessageCreatedEvent(
                $appointmentMessage,
                $this->user
            ));
        }

        return $appointmentMessage;
    }
}

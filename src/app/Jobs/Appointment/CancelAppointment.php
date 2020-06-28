<?php

namespace App\Jobs\Appointment;

use App\Events\AppointmentCancelledEvent;
use App\Jobs\Activity\CreateActivity;
use App\Jobs\Job;
use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\AuthenticatableBase;
use App\Models\Doctor;
use App\Repositories\AppointmentRepositoryInterface;
use App\Repositories\DoctorTimetableRepositoryInterface;
use App\Services\AppointmentServiceInterface;
use App\Services\Production\AppointmentEvent;

use Barryvdh\Debugbar\Facade as Debugbar;

class CancelAppointment extends Job
{
    /**
     * @var Appointment
     */
    protected $appointment;

    /**
     * @var array
     */
    protected $data;

    /**
     * CancelAppointment constructor.
     * @param AuthenticatableBase $user
     * @param Doctor $doctor
     * @param Appointment $appointment
     * @param array $data
     */
    public function __construct(AuthenticatableBase $user, Doctor $doctor, Appointment $appointment, array $data = [])
    {
        $this->user = $user;
        $this->doctor = $doctor;
        $this->appointment = $appointment;
        $this->data = $this->buildData($data);
    }

    protected function buildData($data)
    {
        $data['cancel_reason'] = isset($data['cancel_reason']) ? $data['cancel_reason'] : '';

        return array_only($data, [
            'cancel_reason',
        ]);
    }

    /**
     * @param AppointmentRepositoryInterface $appointmentRepository
     */
    public function handle(
        AppointmentRepositoryInterface $appointmentRepository, 
        DoctorTimetableRepositoryInterface $doctorTimetableRepository,
        AppointmentServiceInterface $appointmentService)
    {
        $appointmentRepository->update($this->appointment, [
            'appointment_status_id' => AppointmentStatus::STATUS_CANCELLED,
            'cancel_reason' => $this->data['cancel_reason'],
        ]);

        $timeslot = $this->appointment->doctorTimetable;

        // DASH1-323 - Only unlock the timeslot when it is not occupied by other appointments
        if(!$timeslot->is_occupied){
            $timeslot->update([
                'is_booked' => false,
            ]);
        }

        // Inform to the Appointment service that the appointment has been cancelled its status
        $appointmentService->sendAppointmentEvent($this->appointment->id, AppointmentEvent::Cancelled);

        dispatch(new CreateActivity(
            get_class($this->user) === 'App\Models\Admin\AdminUser'?'adminuser':'user',
            $this->user?$this->user->id:null,
            'cancel.appointment',
            'appointment',
            $this->appointment->id,
            'Doctor '.$this->doctor->name.' cancelled appointment #'.$this->appointment->id. ' for reason: '.$this->data['cancel_reason']
        ));

        event(new AppointmentCancelledEvent(
            $this->appointment
        ));
    }
}

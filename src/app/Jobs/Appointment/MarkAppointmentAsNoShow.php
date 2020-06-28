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

use Barryvdh\Debugbar\Facade as Debugbar;

/**
 * Class MarkAppointmentAsNoShow
 * @package App\Jobs\Appointment
 */
class MarkAppointmentAsNoShow extends Job
{
    /**
     * @var AuthenticatableBase
     */
    private $user;

    /**
     * @var Doctor
     */
    private $doctor;

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
    }

    /**
     * @param AppointmentRepositoryInterface $appointmentRepository
     */
    public function handle(AppointmentRepositoryInterface $appointmentRepository)
    {
        $appointmentRepository->update($this->appointment, [
            'appointment_status_id' => AppointmentStatus::STATUS_NOT_SHOWING_UP,
        ]);

        dispatch(new CreateActivity(
            get_class($this->user) === 'App\Models\Admin\AdminUser'?'adminuser':'user',
            $this->user?$this->user->id:null,
            'markAsNoShow.appointment',
            'appointment',
            $this->appointment->id,
            'Doctor '.$this->doctor->name.' marked appointment #'.$this->appointment->id. ' as no show'
        ));
    }
}

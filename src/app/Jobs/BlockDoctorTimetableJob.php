<?php

namespace App\Jobs;

use App\Jobs\Appointment\CancelAppointment;
use App\Jobs\Job;
use App\Models\Appointment;
use App\Models\AuthenticatableBase;
use App\Models\Doctor;
use App\Models\DoctorTimetable;
use App\Repositories\AppointmentRepositoryInterface;
use App\Repositories\DoctorTimetableRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\DispatchesJobs;

class BlockDoctorTimetableJob extends Job
{
    use DispatchesJobs;

    /**
     * @var DoctorTimetable
     */
    protected $doctorTimetable;

    /**
     * BlockDoctorTimetableJob constructor.
     * @param AuthenticatableBase $user
     * @param Doctor $doctor
     * @param DoctorTimetable $doctorTimetable
     */
    public function __construct(AuthenticatableBase $user, Doctor $doctor, DoctorTimetable $doctorTimetable)
    {
        $this->user = $user;
        $this->doctor = $doctor;
        $this->doctorTimetable = $doctorTimetable;
    }

    /**
     * @param DoctorTimetableRepositoryInterface $doctorTimetableRepository
     * @param AppointmentRepositoryInterface $appointmentRepository
     */
    public function handle(
        DoctorTimetableRepositoryInterface $doctorTimetableRepository,
        AppointmentRepositoryInterface $appointmentRepository
    )
    {
        $user = $this->user;
        $doctor = $this->doctor;

        $doctorTimetableRepository->update($this->doctorTimetable, [
            'available' => 0,
        ]);

        /*
         * Find all appointment related to this timetable and block it as well.
         */
        /** @var Collection $appointments */
        $appointments = $appointmentRepository->getAppointmentsInOrderToBlock($this->doctorTimetable);

        $appointments->each(function (Appointment $appointment) use ($user, $doctor) {
            $this->dispatchNow(new CancelAppointment(
                $user,
                $doctor,
                $appointment,
                [
                    'cancel_reason' => 'Appointment was blocked by doctor.',
                ]
            ));
        });
    }
}

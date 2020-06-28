<?php

namespace App\Jobs;

use App\Jobs\Appointment\CancelAppointment;
use App\Jobs\Job;
use App\Models\Appointment;
use App\Models\DoctorTimetable;
use App\Repositories\AppointmentRepositoryInterface;
use App\Repositories\DoctorTimetableRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\DispatchesJobs;

class UnblockDoctorTimetableJob extends Job
{
    use DispatchesJobs;

    /**
     * @var DoctorTimetable
     */
    protected $doctorTimetable;

    /**
     * BlockDoctorTimetableJob constructor.
     * @param DoctorTimetable $doctorTimetable
     */
    public function __construct(DoctorTimetable $doctorTimetable)
    {
        $this->doctorTimetable = $doctorTimetable;
    }

    /**
     * @param DoctorTimetableRepositoryInterface $doctorTimetableRepository
     * @param AppointmentRepositoryInterface $appointmentRepository
     */
    public function handle(
        DoctorTimetableRepositoryInterface $doctorTimetableRepository,
        AppointmentRepositoryInterface $appointmentRepository
    ) {
        $doctorTimetableRepository->update($this->doctorTimetable, [
           'available' => 1,
        ]);
    }
}

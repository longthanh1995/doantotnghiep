<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\AppointmentType;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\DoctorTimeslotCycle;
use App\Models\DoctorTimetable;
use App\Repositories\DoctorTimetableRepositoryInterface;

class CreateDoctorTimetableJob extends Job
{
    /**
     * @var Doctor
     */
    protected $doctor;

    /**
     * @var Clinic
     */
    protected $clinic;

    /**
     * @var \DateTime
     */
    protected $startTime;

    /**
     * @var \DateTime
     */
    protected $endTime;

    /**
     * @var bool
     */
    protected $available = true;

    /**
     * @var bool
     */
    protected $isBooked = false;

    /**
     * @var AppointmentType
     */
    protected $appointmentType = null;

    /**
     * @var DoctorTimeslotCycle
     */
    protected $doctorTimeslotCycle = null;

    /**
     * CreateDoctorTimetableJob constructor.
     *
     * @param Doctor $doctor
     * @param Clinic $clinic
     * @param \DateTime $startTime
     * @param \DateTime $endTime
     * @param AppointmentType $appointmentType
     */
    public function __construct(Doctor $doctor, Clinic $clinic, \DateTime $startTime, \DateTime $endTime, AppointmentType $appointmentType, $doctorTimeslotCycle)
    {
        $this->doctor = $doctor;
        $this->clinic = $clinic;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->appointmentType = $appointmentType;
        $this->doctorTimeslotCycle = $doctorTimeslotCycle;
    }

    /**
     * @param DoctorTimetableRepositoryInterface $doctorTimetableRepository
     *
     * @return DoctorTimetable
     */
    public function handle(DoctorTimetableRepositoryInterface $doctorTimetableRepository)
    {
        $doctorTimetable = new DoctorTimetable;
        $doctorTimetable->start_at = $this->startTime;
        $doctorTimetable->end_at = $this->endTime;
        $doctorTimetable->available = $this->available;
        $doctorTimetable->is_booked = $this->isBooked;
        $doctorTimetable->doctor_id = $this->doctor->id;
        $doctorTimetable->clinic_id = $this->clinic->id;
        $doctorTimetable->appointment_type_id = $this->appointmentType->id;

        if($this->doctorTimeslotCycle){
            $doctorTimetable->timeslot_cycle_id = $this->doctorTimeslotCycle->id;
        }

        $doctorTimetableRepository->save($doctorTimetable);

        return $doctorTimetable;
    }
}

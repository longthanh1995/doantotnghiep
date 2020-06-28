<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\AppointmentType;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\DoctorTimeslotCycle;
use App\Models\DoctorTimetable;
use App\Repositories\DoctorTimeslotCycleRepositoryInterface;
use App\Repositories\Eloquent\DoctorTimeslotCycleRepository;

class CreateDoctorTimeslotCycleJob extends Job
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
     * @var integer
     */
    protected $dayOfWeek;

    /**
     * @var \DateTime
     */
    protected $startDate;

    /**
     * @var \DateTime
     */
    protected $startTime;

    /**
     * @var \DateTime
     */
    protected $endTime;

    /**
     * @var integer
     */
    protected $duration;

    /**
     * @var AppointmentType
     */
    protected $appointmentType = null;

    /**
     * CreateDoctorTimetableJob constructor.
     *
     * @param Doctor $doctor
     * @param Clinic $clinic
     * @param \DateTime $startTime
     * @param \DateTime $endTime
     * @param AppointmentType $appointmentType
     */
    public function __construct(Doctor $doctor, Clinic $clinic, $dayOfWeek, \DateTime $startDate,  \DateTime $startTime, \DateTime $endTime, $duration, AppointmentType $appointmentType, $numOfCycle)
    {
        $this->doctor = $doctor;
        $this->clinic = $clinic;
        $this->dayOfWeek = $dayOfWeek;
        $this->startDate = $startDate->format('Y-m-d');
        $this->startTime = $startTime->format('H:i:s');
        $this->endTime = $endTime->format('H:i:s');
        $this->duration = $duration;
        $this->appointmentType = $appointmentType;
        $this->numOfCycle = $numOfCycle;
    }

    /**
     * @param DoctorTimeslotCycleRepository $doctorTimeslotCycleRepository
     *
     * @return DoctorTimeslotCycle
     */
    public function handle(DoctorTimeslotCycleRepository $doctorTimeslotCycleRepository)
    {
        $doctorTimeslotCycle = new DoctorTimeslotCycle();
        $doctorTimeslotCycle->start_date = $this->startDate;
        $doctorTimeslotCycle->start_time = $this->startTime;
        $doctorTimeslotCycle->end_time = $this->endTime;
        $doctorTimeslotCycle->duration = $this->duration;
        $doctorTimeslotCycle->day_of_week = $this->dayOfWeek;
        $doctorTimeslotCycle->doctor_id = $this->doctor->id;
        $doctorTimeslotCycle->clinic_id = $this->clinic->id;
        $doctorTimeslotCycle->appointment_type_id = $this->appointmentType->id;
        $doctorTimeslotCycle->num_of_cycle = $this->numOfCycle;

        $doctorTimeslotCycleRepository->save($doctorTimeslotCycle);

        return $doctorTimeslotCycle;
    }
}

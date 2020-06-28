<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Appointment;
use App\Models\AppointmentType;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\DoctorTimeslotCycle;
use App\Models\DoctorTimetable;
use App\Models\DoctorTimetableTime;
use App\Repositories\DoctorTimetableRepositoryInterface;
use Barryvdh\Debugbar\Facade as Debugbar;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;

class MultiCreateDoctorTimetableJob extends Job
{
    use DispatchesJobs;

    /**
     * @var Doctor
     */
    protected $doctor;

    /**
     * @var Clinic
     */
    protected $clinic;

    /**
     * @var Collection
     */
    protected $dates;

    /**
     * @var DoctorTimetableTime
     */
    protected $doctorTimetableTime;

    /**
     * @var integer
     */
    protected $duration;

    /**
     * @var integer
     */
    protected $appointmentType;

    /**
     * @var integer
     */
    protected $doctorTimeslotCycle;

    /**
     * MultiCreateDoctorTimetableJob constructor.
     * @param Doctor $doctor
     * @param Clinic $clinic
     * @param Collection $dates
     * @param DoctorTimetableTime $doctorTimetableTime
     */
    public function __construct(Doctor $doctor, Clinic $clinic, Collection $dates, DoctorTimetableTime $doctorTimetableTime, $duration, AppointmentType $appointmentType, $doctorTimeslotCycle)
    {
        $this->doctor = $doctor;
        $this->clinic = $clinic;
        $this->dates = $dates;
        $this->doctorTimetableTime = $doctorTimetableTime;
        $this->duration = $duration;
        $this->appointmentType = $appointmentType;
        $this->doctorTimeslotCycle = $doctorTimeslotCycle;
    }

    /**
     * @param DoctorTimetableRepositoryInterface $doctorTimetableRepository
     *
     * @return array
     */
    public function handle(DoctorTimetableRepositoryInterface $doctorTimetableRepository)
    {
        $timetablesError = new Collection;
        $timetables = new Collection;

        $newDoctorTimetablesData = new Collection;

        $this->dates->each(function ($date) use ($doctorTimetableRepository, $timetables, $timetablesError, $newDoctorTimetablesData) {
            $doctorTimeTableTimeStart = $this->doctorTimetableTime->getStart();
            $doctorTimeTableTimeEnd = $this->doctorTimetableTime->getEnd();

            /**
             * Get timeslots for whole day, and check overlapping
             */
            $batchStartTime = DoctorTimetableTime::toDate($date, $doctorTimeTableTimeStart, $this->clinic->time_zone);
            $batchEndTime = DoctorTimetableTime::toDate($date, $doctorTimeTableTimeEnd, $this->clinic->time_zone);

            $wholeDayOverlappingTimetables = $doctorTimetableRepository->getBlankModel()
                ->where('doctor_id', $this->doctor->id)
                ->where(function (Builder $query) use ($batchStartTime, $batchEndTime) {
                    $query->where(function (Builder $query) use ($batchStartTime, $batchEndTime) {
                        $query->where('end_at', '>', $batchStartTime);
                        $query->where('start_at', '<', $batchEndTime);
                    });
                })->get();

            for ($i = $doctorTimeTableTimeStart; $i < $doctorTimeTableTimeEnd; $i += $this->duration) {
                $startDateTime = DoctorTimetableTime::toDate($date, $i, $this->clinic->time_zone);
                $endDateTime = DoctorTimetableTime::toDate($date, $i + $this->duration, $this->clinic->time_zone);

                $isNew = true;

                $count = $wholeDayOverlappingTimetables->filter(function(DoctorTimetable $doctorTimetable) use ($startDateTime, $endDateTime) {
                    if ($doctorTimetable->end_at > $startDateTime && $doctorTimetable->start_at < $endDateTime) {
                        return true;
                    }
                })->count();

                if ($count > 0) {
                    $isNew = false;

                    $timetablesError->push([
                        'startDateTime' => $startDateTime->getTimestamp() * 1000,
                        'endDateTime' => $endDateTime->getTimestamp() * 1000,
                    ]);
                }

                if ($isNew) {
                    $now = Carbon::now('utc')->toDateTimeString();
                    $doctorTimetable = new DoctorTimetable;
                    $doctorTimetable->start_at = $startDateTime;
                    $doctorTimetable->end_at = $endDateTime;
                    $doctorTimetable->available = true;
                    $doctorTimetable->is_booked = false;
                    $doctorTimetable->doctor_id = $this->doctor->id;
                    $doctorTimetable->clinic_id = $this->clinic->id;
                    $doctorTimetable->appointment_type_id = $this->appointmentType->id;
                    $doctorTimetable->created_at = $now;
                    $doctorTimetable->updated_at = $now;

                    if($this->doctorTimeslotCycle){
                        $doctorTimetable->timeslot_cycle_id = $this->doctorTimeslotCycle->id;
                    }

                    $newDoctorTimetablesData->push($doctorTimetable->toArray());

                    $timetables->push([
                        'startDateTime' => $startDateTime->getTimestamp() * 1000,
                        'endDateTime' => $endDateTime->getTimestamp() * 1000,
                    ]);

                    unset($doctorTimetable);
                    unset($count);
                }
            }

            unset($batchStartTime);
            unset($batchEndTime);
            unset($wholeDayOverlappingTimetables);
        });

        DoctorTimetable::insert($newDoctorTimetablesData->toArray());

        return [
            'timetables' => $timetables,
            'timetablesError' => $timetablesError,
        ];
    }
}
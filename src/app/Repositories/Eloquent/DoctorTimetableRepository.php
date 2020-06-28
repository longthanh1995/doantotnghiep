<?php

namespace App\Repositories\Eloquent;

use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\AppointmentType;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Repositories\DoctorTimetableRepositoryInterface;
use App\Models\DoctorTimetable;
use Carbon\Carbon;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class DoctorTimetableRepository extends SingleKeyModelRepository implements DoctorTimetableRepositoryInterface
{
    public function getBlankModel()
    {
        return new DoctorTimetable();
    }

    public function rules()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    public function feed(Doctor $doctor, Carbon $startAt, Carbon $endAt, Collection $filters, $context = 'doctor')
    {
        /*
         * Filter labels
         */
        $accessBlockedOnly = false;
        $accessAvailableOnly = false;

        if ($filters->has('label') && count($filters->get('label')) > 0) {
            $labels = array_values($filters->get('label'));

            if (in_array('blocked', $labels)) {
                $accessBlockedOnly = true;
            }
        }

        if ($filters->has('label') && count($filters->get('label')) > 0) {
            $labels = array_values($filters->get('label'));

            if (in_array('available', $labels)) {
                $accessAvailableOnly = true;
            }
        }

        /** @var Collection $timetables */
        $timetables = $this->getBlankModel()
            /*
             * Base filters
             */
            ->whereDoctorId($doctor->id)
            ->where(function (Builder $query) use ($startAt, $endAt) {
                $query->where('start_at', '>=', $startAt);
                $query->where('end_at', '<', $endAt);
            })
//            hide the timeslots with no appointment type
            ->where(function(Builder $query){
                $query->where('appointment_type_id', '>', 0);
            })
            ->whereExists(function($query){
                $query->select(\DB::raw('*'))
                    ->from('clinics')
                    ->whereRaw('doctor_timetables.clinic_id = clinics.id')
                    ->where('deleted_at', null)
                ;
            })
            /*
             * Extra Filters
             */
            ->where(function (Builder $query) use ($filters, $accessBlockedOnly, $accessAvailableOnly) {
                if($accessAvailableOnly){
                    $query->where('available', 1);
                    $query->where('is_booked', 0);
                } elseif ($accessBlockedOnly) {
                    $query->where('available', 0);
                }

                /*
                 * Filter clinics
                 */
                if ($filters->has('clinic') && count($filters->get('clinic')) > 0) {
                    $query->whereIn('clinic_id', $filters->get('clinic'));
                }

                $appointmentTypeCategories = $filters->get('appointmentTypeCategory');
                if($appointmentTypeCategories && count($appointmentTypeCategories) > 0) {
                    $query->whereHas('appointmentType', function ($query) use ($appointmentTypeCategories){
                        return $query->whereIn('category', $appointmentTypeCategories);
                    });
                }
            })
            ->with(['clinic', 'appointments' => function ($query) use ($filters, $accessBlockedOnly) {
                /*
                 * Filter labels
                 */
                if ($accessBlockedOnly) {
                    $query->where('appointment_status_id', '=', AppointmentStatus::STATUS_CANCELLED);
                }

                /*
                 * appointments that have Verifying status only display on mobile side.
                 * This status means when users haven't completed booking that appointment. The information of
                 * appointment will be saved as a verifying appointment
                 * https://github.com/Innovatube/manadr-dashboard/issues/6
                 */
//                $query->where('appointment_status_id', '!=', AppointmentStatus::STATUS_VERIFYING);

                $query->orderBy('start_at', 'asc');

                $query->with([
                    'patient',
                    'patient.clinics',
                    'patientCondition',
                    'appointmentStatus',
                    'user',
                    'doctor',
                    'booker',
                ]);
            }, 'appointmentType', 'doctor'])
            ->orderBy('start_at')
            ->get();

        $timetables = $timetables->filter(function (DoctorTimetable $doctorTimetable) use ($filters) {
            /*
             * Filter conditions
             */
            $filter = true;

            if ($filters->has('condition') && count($filters->get('condition')) > 0) {
                $filter = false;

                $conditions = $filters->get('condition');
                if(in_array($doctorTimetable->appointment_type_id, $conditions)){
                    $filter = true;
                }
            }

            return $filter;
        })
        ->flatten()
        ->map(function (DoctorTimetable $doctorTimetable) use ($doctor, $context) {
            $appointmentsCollection = new Collection();

            $doctorTimetable->appointments->each(function (Appointment $appointment) use ($appointmentsCollection, $doctorTimetable, $context) {
                $patientClinicMRID = null;

                if($appointment->patient && $doctorTimetable->clinic){
                    $patientClinicRecord = $appointment->patient->clinics->filter(function($clinic) use ($appointment, $doctorTimetable){
                        return $clinic->id === $doctorTimetable->clinic->id;
                    })->first();

                    if($patientClinicRecord){
                        $patientClinicMRID = $patientClinicRecord->pivot->medical_record_number;
                    }
                }

                $appointmentsCollection->push([
                    'id' => $appointment->id,
                    'booking_reason' => $appointment->booking_reason,
                    'cancel_reason' => $appointment->cancel_reason,
                    'book_source' => $appointment->book_source,
                    'note' => $appointment->note,
                    'created_at' => $appointment->created_at,
                        'format' => [
                        'url' => route($context==='admin'?'admin.appointment.details':'appointment.show', $appointment->id)
                    ],
                    'patient' => $appointment->patient ? [
                        'id' => $appointment->patient->id,
                        'name' => $appointment->patient->getFullname(),
                        'phone_number' => $appointment->patient->phone_number,
                        'phone_country_code' => $appointment->patient->phone_country_code,
                        'email' => $appointment->patient->email,
                        'id_number' => $appointment->patient->id_number,
                        'imported_name' => $appointment->patient->imported_name,
                        'imported_phone' => $appointment->patient->imported_phone,
                        'MRID' => $patientClinicMRID,
                    ] : '',

                    'user' => $appointment->user,

                    'booker' => $appointment->booker,

                    'patient_condition' => $appointment->patientCondition ? [
                        'name' => $appointment->patientCondition->name,
                        'icon_url' => $appointment->patientCondition->icon_url,
                    ] : '',

                    'appointment_status' => $appointment->appointmentStatus ? [
                        'id' => $appointment->appointmentStatus->id,
                        'name' => $appointment->appointmentStatus->name,
                    ] : '',

                    'is_confirmed' => $appointment->isConfirmed(),
                    'is_late' => $appointment->isLate(),
                    'is_no_show' => $appointment->isNotShowingUp(),
                    'has_patient_arrived' => $appointment->has_patient_arrived,
                ]);
            });

            $eventClassses = [
                'red',
                'yellow',
                'aqua',
                'blue',
                'light-blue',
                'green',
                'navy',
                'teal',
                'olive',
                'lime',
                'orange',
                'fuchsia',
                'purple',
                'maroon',
                'black',
            ];

            return [
                'id' => $doctorTimetable->id,
                'class' => $doctorTimetable->appointmentType && $doctorTimetable->appointmentType->id ? $eventClassses[$doctorTimetable->appointmentType->id % count($eventClassses)] : $eventClassses[0],
                'available' => $doctorTimetable->available,
                'isBlocked' => $doctorTimetable->isBlocked(),
                'canBlock' => $doctor->can('block', $doctorTimetable),
                'canDelete' => $doctor->can('delete', $doctorTimetable),
                'start' => $doctorTimetable->start_at->getTimestamp() * 1000,
                'end' => $doctorTimetable->end_at->getTimestamp() * 1000,
                'timezone' => $doctorTimetable->clinic ? $doctorTimetable->clinic->time_zone : '',
                'clinic' => [
                    'name' => $doctorTimetable->clinic ? $doctorTimetable->clinic->name : '',
                    'id' => $doctorTimetable->clinic ? $doctorTimetable->clinic->id : '',
                ],
                'doctor' => [
                    'id' => $doctorTimetable->doctor ? $doctorTimetable->doctor->id : '',
                    'name' => $doctorTimetable->doctor ? $doctorTimetable->doctor->name : ''
                ],
                'appointments' => $appointmentsCollection,
                'appointmentType'=> $doctorTimetable->appointmentType,
                'blockReason' => $doctorTimetable->isBlocked()?$doctorTimetable->blockReason():''
            ];
        });

        return $timetables;
    }
}

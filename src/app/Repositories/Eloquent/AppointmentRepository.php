<?php

namespace App\Repositories\Eloquent;

use App\Models\AppointmentStatus;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\DoctorTimetable;
use App\Repositories\AppointmentRepositoryInterface;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

use Barryvdh\Debugbar\Facade as Debugbar;

class AppointmentRepository extends SingleKeyModelRepository implements AppointmentRepositoryInterface
{
    public function getBlankModel()
    {
        return new Appointment();
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

    /**
     * @param Doctor $doctor
     * @param array $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    //@TODO Replace getQueryBooking with getAppointments
    public function getAppointments(Doctor $doctor, $data = [])
    {
        $fillableData = array_only($data, [
            'patientName',
            'patientNationalIdNumber',
            'clinic',
            'appointmentBooking',
            'appointmentStatus',
            'isPaginated',
            'sortOption',
            'per_page',
            'search',
        ]);

        $appointmentsQuery = $this->getBlankModel()
            //filter by doctor
            ->whereDoctorId($doctor->id)
            ->where(function (Builder $query) use ($fillableData) {
                //filter by appointment status ids
                if (isset($fillableData['appointmentStatus'])) {
                    $query->where('appointment_status_id', $fillableData['appointmentStatus']);
                }

                if (isset($fillableData['search'])) {
                    $id = $fillableData['search']->value;
                    if ($id > 0){
                        $query->where('id', $id);
                    }
                }

                //filter by clinic
                if (isset($fillableData['clinic']) && $clinicId = $fillableData['clinic']) {
                    if ($clinicId != 'default') {
                        $query->whereHas('doctorTimetable', function ($query) use ($clinicId) {
                            $query->where('clinic_id', $clinicId);
                        });
                    }

                    $clinic = Clinic::find($clinicId);
                }

                //filter by booking date
                if (isset($clinic) && isset($fillableData['appointmentBooking']) && $appointmentBooking = $fillableData['appointmentBooking']) {
                    list($day, $month, $year) = explode('/', $appointmentBooking);

                    $timezone = $clinic->time_zone ? $clinic->time_zone : 'UTC';

                    $date = Carbon::create($year, $month, $day, 0, 0, 0, $timezone);
                    $date->subHours($date->offsetHours);

                    $query->where('start_at', '>=', $date->toDateTimeString());
                    $query->where('start_at', '<=', $date->addDay()->toDateTimeString());
                }

                //filter by patient name
                if (isset($fillableData['patientName']) && $patientName = $fillableData['patientName']) {
                    $query->whereHas('patient', function (Builder $query) use ($patientName) {
                        $query->where(function ($query) use ($patientName) {
                            $query->where(\DB::raw('concat(first_name, " ", last_name)'), 'LIKE', '%' . $patientName . '%');
                            $query->orWhere(\DB::raw('concat(last_name, " ", first_name)'), 'LIKE', '%' . $patientName . '%');
                        });
                    });
                }

                //filter by patient ID Number
                if (isset($fillableData['patientNationalIdNumber']) && $patientNationalIdNumber = $fillableData['patientNationalIdNumber']) {
                    $query->whereHas('patient', function (Builder $query) use ($patientNationalIdNumber) {
                        $query->where('id_number', 'LIKE', '%' . $patientNationalIdNumber . '%');
                    });
                }
            })
            ->with([
                'appointmentType',
                'appointmentStatus',
                'patient.profileImage',
                'patientCondition',
                'doctorTimetable.clinic',
                'patient.country',
                'healthSummary',
                'clinic',
                'booker'
            ])
        ;

        $perPage = isset($fillableData['per_page'])?$fillableData['per_page']:10;
        return isset($fillableData['isPaginated'])? $appointmentsQuery->paginate($perPage):$appointmentsQuery->get();
    }

    public function getConfirmedBookingAppointments(Doctor $doctor, $data = [])
    {
        return $this->getQueryBooking($doctor, AppointmentStatus::STATUS_CONFIRMED, $data);
    }

    public function getVisitedBookingAppointments(Doctor $doctor, $data = [])
    {
        return $this->getQueryBooking($doctor, AppointmentStatus::STATUS_VISITED, $data);
    }

    public function getCancelledBookingAppointments(Doctor $doctor, $data = [])
    {
        return $this->getQueryBooking($doctor, AppointmentStatus::STATUS_CANCELLED, $data);
    }

    public function getNotShowingUpBookingAppointments(Doctor $doctor, $data = [])
    {
        return $this->getQueryBooking($doctor, AppointmentStatus::STATUS_NOT_SHOWING_UP, $data);
    }

    /**
     * @param Doctor $doctor
     * @param array $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getLateBookingAppointments(Doctor $doctor, $data = [])
    {
        return $this->getQueryBooking($doctor, AppointmentStatus::STATUS_LATE, $data);
    }

    protected function getQueryBooking(Doctor $doctor, $appointmentStatus, $data = [])
    {

        $fillableData = array_only($data, [
            'patientName',
            'patientNationalIdNumber',
            'clinic',
            'appointmentBooking',
            'print',
            'sortOption',
        ]);

        $appointmentsQuery = $this->getBlankModel()
            ->whereDoctorId($doctor->id)
            ->where(function ($query) use ($appointmentStatus) {
                if ($appointmentStatus) {
                    $query->where('appointment_status_id', $appointmentStatus);
                }
            })
            /*
             * Custom
             */
            ->where(function (Builder $query) use ($fillableData) {
                if (isset($fillableData['clinic']) && $clinicId = $fillableData['clinic']) {
                    if ($clinicId != 'default') {
                        $query->whereHas('doctorTimetable', function ($query) use ($clinicId) {
                            $query->where('clinic_id', $clinicId);
                        });
                    }

                    $clinic = Clinic::find($clinicId);
                }

                if (isset($clinic) && isset($fillableData['appointmentBooking']) && $appointmentBooking = $fillableData['appointmentBooking']) {
                    list($day, $month, $year) = explode('/', $appointmentBooking);

                    $timezone = $clinic->time_zone ? $clinic->time_zone : 'UTC';

                    $date = Carbon::create($year, $month, $day, 0, 0, 0, $timezone);
                    $date->subHours($date->offsetHours);

                    $query->where('start_at', '>=', $date->toDateTimeString());
                    $query->where('start_at', '<=', $date->addDay()->toDateTimeString());
                }
            })
            ->where(function (Builder $query) use ($fillableData) {
                if (isset($fillableData['patientName']) && $patientName = $fillableData['patientName']) {
                    $query->whereHas('patient', function (Builder $query) use ($patientName) {
                        $query->where(function ($query) use ($patientName) {
                            $query->where(\DB::raw('concat(first_name, " ", last_name)'), 'LIKE', '%' . $patientName . '%');
                            $query->orWhere(\DB::raw('concat(last_name, " ", first_name)'), 'LIKE', '%' . $patientName . '%');
                        });
                    });
                }

                if (isset($fillableData['patientNationalIdNumber']) && $patientNationalIdNumber = $fillableData['patientNationalIdNumber']) {
                    $query->whereHas('patient', function (Builder $query) use ($patientNationalIdNumber) {
                        $query->where('id_number', 'LIKE', '%' . $patientNationalIdNumber . '%');
                    });
                }
            })
            ->with('patient.profileImage', 'patientCondition', 'doctorTimetable.clinic', 'appointmentType', 'patient.country', 'healthSummary', 'appointmentType')
        ;

        if(isset($fillableData['sortOption'])){
            $sortOption = $fillableData['sortOption'];

            switch($sortOption){
                case '1':
                default:
                    $appointmentsQuery = $appointmentsQuery->orderBy('created_at', 'desc');
                    break;
                case '2':
                    $appointmentsQuery = $appointmentsQuery->orderBy('created_at', 'asc');
                    break;
                case '3':
                    $appointmentsQuery = $appointmentsQuery->orderBy('start_at', 'desc');
                    break;
                case '4':
                    $appointmentsQuery = $appointmentsQuery->orderBy('start_at', 'asc');
                    break;
            }
        } else {
            $appointmentsQuery = $appointmentsQuery->orderBy('start_at', 'desc');
        }

        $appointments = $appointmentsQuery->paginate(isset($fillableData['print']) ? 10000 : null);

        return $appointments;
    }

    public function getRatings(Doctor $doctor, $paginate = true)
    {
        $ratings = $this->getBlankModel()
            ->whereDoctorId($doctor->id)
            ->whereNotNull('rating')
            ->where('rating', '>', 0);

        if ($paginate) {
            $ratings = $ratings->paginate(25);
        } else {
            $ratings = $ratings->get();
        }

        return $ratings;
    }

    public function getAppointmentsInOrderToBlock(DoctorTimetable $doctorTimetable)
    {
        return $this->getBlankModel()
            ->whereDoctorTimetableId($doctorTimetable->id)
            ->where(function (Builder $query) {
                $query->where('appointment_status_id', AppointmentStatus::STATUS_CONFIRMED);
//                $query->orWhere('appointment_status_id', AppointmentStatus::STATUS_VERIFYING);
            })
            ->get();
    }
}

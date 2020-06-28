@extends('legacy.layouts.doctor.appLayout')

@section('pageHeader')
    <h1>
        @if ($appointment->isCancelled())
            Cancelled Appointment
        @elseif ($appointment->isConfirmed())
            Confirmed Appointment
        @else
            Appointment
        @endif
    </h1>
@stop

@section('content')
    <div id="appointmentShowRecord">
        <div class="row">
            <div class="col-md-3 appointment-show-user-section">
                <div class="appointment-show-user-avatar">
                    @if ($appointment->patient && $appointment->patient->profileImage)
                        <a href="{{ $appointment->patient->profileImage->getThumbnailUrl() }}" target="_blank">
                            <img src="{{ $appointment->patient->profileImage->getThumbnailUrl() }}" width="160" height="160"/>
                        </a>
                    @else
                        <img src="{{ \App\Models\Patient::getDefaultAvatarUrl() }}" width="160" height="160"/>
                    @endif
                </div>

                <div class="appointment-show-user-info">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="class-a" width="50%">
                                    {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('M, d Y') }}
                                </td>

                                <td class="class-a" width="50%">
                                    {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('H:i') }}
                                    -
                                    {{ with(DateTimeHelper::setTimeZoneByStr($appointment->end_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('H:i') }}
                                </td>
                            </tr>

                            <tr>
                                <td class="class-a" colspan="2">
                                    <i class="fa fa-fw fa-hospital-o"></i> {{ $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->name:''}}
                                </td>
                            </tr>

                            <tr>
                                <td class="class-a" colspan="2">
                                    <i class="fa fw-fa fa-stethoscope"></i> &nbsp; {{ $appointment->appointmentType ? $appointment->appointmentType->name : '' }}
                                </td>
                            </tr>

                            @if ($appointment->isCancelled())
                                <tr>
                                    <td colspan="2" class="appointment-record-status">
                                        Cancelled
                                    </td>
                                </tr>
                            @elseif ($appointment->isConfirmed())
                                <tr>
                                    <td colspan="2" class="appointment-record-status">
                                        Confirmed
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        {!! Form::open([
                                            'route' => ['appointment.cancelSubmit', $appointment->id],
                                            'id' => 'appointment-cancel-'.$appointment->id
                                        ]) !!}
                                            <input type="hidden" id="cancelReasonField" name="cancel_reason" />
                                        {!! Form::close() !!}

                                        <a href="#" class="btn btn-primary btn-cancel-appointment" data-appointment-id="{{ $appointment->id }}">
                                            Cancel
                                        </a>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="2" class="appointment-record-status">
                                        {{$appointment->appointmentStatus?$appointment->appointmentStatus->name:''}}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-6">
                <div class="appointment-detail-section">
                    <div class="appointment-detail-section-heading">
                    @if($appointment->patient)
                        <b>{{$appointment->patient->first_name}}</b> {{$appointment->patient->last_name}}
                    @endif
                    </div>

                    <div class="appointment-detail-section-table">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Patient ID</th>
                                <td>{{ $appointment->patient ? $appointment->patient->id : '' }}</td>
                            </tr>

                            <tr>
                                <th>Gender</th>
                                <td>{{ $appointment->patient ? ucfirst(strtolower($appointment->patient->gender)) : '' }}</td>
                            </tr>

                            <tr>
                                <th>Date of Birth</th>
                                <td>
                                    {{ $appointment->patient && $appointment->patient->date_of_birth ? $appointment->patient->date_of_birth->format('d/m/Y') : '' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Address</th>
                                <td>
                                    {{ $appointment->patient ? $appointment->patient->address_street : '' }}

                                    {{ $appointment->patient ? $appointment->patient->address_city : '' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Phone number</th>
                                <td>
                                    {{ $appointment->patient ? $appointment->patient->phone_country_code : '' }}

                                    {{ $appointment->patient ? $appointment->patient->phone_number : '' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <td>{{ $appointment->patient ? $appointment->patient->email : '' }}</td>
                            </tr>

                            <tr>
                                <th>Booked by</th>
                                <td>{{ $appointment->user ? $appointment->user->getFullname() : '' }}</td>
                            </tr>

                            <tr>
                                <th>Country</th>
                                <td>{{ $appointment->patient && $appointment->patient->country ? $appointment->patient->country->nice_name : '' }}</td>
                            </tr>

                            <tr>
                                <th>National ID Number</th>
                                <td>{{ $appointment->patient ? $appointment->patient->id_number : '' }}</td>
                            </tr>
                            </tbody>
                        </table>

                        <p></p>

                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Booking Reason</th>
                                <td>
                                @if($appointment->booking_reason)
                                    <span class="text-info">{{ $appointment->booking_reason }}</span>
                                @else
                                    <span class="text-muted">Nothing was provided.</span>
                                @endif
                                </td>
                            </tr>

                        @if($appointment->isCancelled() && $appointment->cancel_reason)
                            <tr>
                                <th>Cancel Reason</th>
                                <td>
                                    <span class="text-danger">{{$appointment->cancel_reason}}</span>
                                </td>
                            </tr>
                        @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    @include('legacy.pages.doctor.appointment.partials.javascript')
@endpush
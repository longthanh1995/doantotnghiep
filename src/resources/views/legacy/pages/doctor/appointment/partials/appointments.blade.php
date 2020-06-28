<div class="appointment-row row">
    <div class="appointment-user col-md-offset-1 col-md-3 col-sm-3 col-xs-3">
        <a href="{{ route('appointment.show', $appointment->id) }}" target="_blank">
            @if ($appointment->patient && $appointment->patient->profileImage)
                <img src="{{ $appointment->patient->profileImage->getThumbnailUrl() }}" width="100" height="100"/>
            @else
                <img src="{{ \App\Models\Patient::getDefaultAvatarUrl() }}" width="100" height="100"/>
            @endif
        </a>
    </div>

    <div class="appointment-info col-md-4 col-sm-6 col-xs-6">
        <div class="appointment-info-row">
            <i class="fa fa-fw fa-user-md"></i>
            @if($appointment->patient)
                <b>{{$appointment->patient->first_name}}</b> {{$appointment->patient->last_name}}
            @endif
            (#{{ $appointment->patient_id }})
        </div>

        <div class="appointment-info-row">
            <i class="fa fw-fa fa-stethoscope"></i> {{ $appointment->appointmentType ? $appointment->appointmentType->name : '' }}
        </div>

        <div class="appointment-info-row">
            <i class="fa fa-fw fa-hospital-o"></i> {{ $appointment->doctorTimetable ? ($appointment->doctorTimetable->clinic ? $appointment->doctorTimetable->clinic->name : '') : ''}}
        </div>

        <div class="appointment-info-row">
            <i class="fa fa-fw fa-list-alt"></i> {{$appointment->patient && $appointment->patient->country ? $appointment->patient->country->nice_name . ' - ':''}} {{ $appointment->patient ? $appointment->patient->id_number : ''}}
        </div>

    @if($appointment->booking_reason)
        <div class="appointment-info-row text-primary text-italic">
            <i class="fa fa-fw fa-calendar-check-o"></i> {{$appointment->booking_reason}}
        </div>
    @endif

    @if($appointment->cancel_reason)
        <div class="appointment-info-row text-danger text-italic">
            <i class="fa fa-fw fa-calendar-times-o"></i> {{$appointment->cancel_reason}}
        </div>
    @endif
    </div>

    <div class="appointment-actions-section col-md-3 col-md-offset-1 col-sm-3 col-xs-3">
        <div class="appointment-time">
            <div class="appointment-time-date text-primary">
                @if (isset($appointment->doctorTimetable) && isset($appointment->doctorTimetable->clinic))
                    {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable->clinic->time_zone))->format('M, d Y') }}
                @endif
            </div>

            <div class="appointment-time-hour text-danger">
                @if (isset($appointment->doctorTimetable) && isset($appointment->doctorTimetable->clinic))
                    {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable->clinic->time_zone))->format('H:i') }}
                    -
                    {{ with(DateTimeHelper::setTimeZoneByStr($appointment->end_at, $appointment->doctorTimetable->clinic->time_zone))->format('H:i') }}
                @endif
            </div>
        </div>

        <div class="appointment-actions">
            {!! Form::open([
                'route' => ['appointment.cancelSubmit', $appointment->id],
                'id' => 'appointment-cancel-'.$appointment->id
            ]) !!}
                <input type="hidden" id="cancelReasonField" name="cancel_reason" />
            {!! Form::close() !!}

            {!! Form::open([
                'route' => ['appointment.visitSubmit', $appointment->id],
                'id' => 'appointment-visit-'.$appointment->id
            ]) !!}
            {!! Form::close() !!}

            @if ($type == 'visitedBooking')
                <a href="{{ route('appointment.show', $appointment->id) }}" data-toggle="tooltip" title="View appointment's info">
                    <i class="fa fa-fw fa-bars"></i>
                </a>
            @elseif ($type == 'cancelledBooking')
                <a href="{{ route('appointment.show', $appointment->id) }}" data-toggle="tooltip" title="View appointment's info">
                    <i class="fa fa-fw fa-bars"></i>
                </a>
            @elseif ($type == 'confirmedBooking')
                <a href="{{ route('appointment.show', $appointment->id) }}" data-toggle="tooltip" title="View appointment's info">
                    <i class="fa fa-fw fa-bars"></i>
                </a>

                <a href="#" class="btn-visit-appointment" data-appointment-id="{{ $appointment->id }}" data-toggle="tooltip" title="Mark visited">
                    <i class="fa fa-fw fa-check"></i>
                </a>

                <a href="#" class="btn-cancel-appointment" data-appointment-id="{{ $appointment->id }}" data-toggle="tooltip" title="Cancel appointment">
                    <i class="fa fa-fw fa-remove"></i>
                </a>
            @endif
        </div>
    </div>
</div>
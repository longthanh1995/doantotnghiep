<li class="item">
    <div class="product-img">
        @if ($appointment->patient && $appointment->patient->profileImage)
            <img src="{{ $appointment->patient->profileImage->getThumbnailUrl() }}" width="100"/>
        @else
            <img src="{{ \App\Models\Patient::getDefaultAvatarUrl() }}" width="100"/>
        @endif
    </div>
    <div class="product-info">
        <a target="_blank" href="{{ route('appointment.show', $appointment->id) }}" class="product-title">
            @if($appointment->book_source == 'M')
                <i class="fa fa-fw fa-mobile"></i>
            @endif

            @if($appointment->patient)
                <b>{{$appointment->patient->first_name}}</b> {{$appointment->patient->last_name}}
                @if($appointment->patient->imported_name)
                (<span data-toggle="tooltip" title="This value was imported from clinic"><i class="fa fa-sign-in"></i></span> {{$appointment->patient->imported_name}})
                @endif

                (#{{ $appointment->patient_id }})

                @if(!$appointment->patient->verified)
                    <small class="label label-warning">
                        Unverified
                    </small>
                @endif
            @endif

        </a>
        <div class="product-description">
            <div class="pull-right actions">
                @if ($type == 'visitedBooking')
                    <a class="btn btn-xs btn-info no-print" href="{{ route('appointment.show', $appointment->id) }}" data-toggle="tooltip" title="View appointment's info">
                        <i class="fa fa-fw fa-info"></i>
                    </a>
                @elseif ($type == 'cancelledBooking')
                    <a class="btn btn-xs btn-info no-print" href="{{ route('appointment.show', $appointment->id) }}" data-toggle="tooltip" title="View appointment's info">
                        <i class="fa fa-fw fa-info"></i>
                    </a>
                @elseif ($type == 'confirmedBooking')
                    <a href="#"
                       class="btn btn-xs btn-danger no-print"
                       data-action="markAsLate"
                       data-appointment-id="{{ $appointment->id }}"
                       data-toggle="tooltip" title="Mark appointment as late"
                       data-patient-name="{{$appointment->patient ? $appointment->patient->first_name . ' ' . $appointment->patient->last_name : ''}}"
                       data-appointment-time="
                            {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('M, d Y') }}
                       {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('H:i') }}
                               -
                            {{ with(DateTimeHelper::setTimeZoneByStr($appointment->end_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('H:i') }}
                               "
                    >
                        Late
                    </a>

                    <a href="#"
                       class="btn btn-xs btn-warning no-print"
                       data-action="markAsNoShow"
                       data-appointment-id="{{ $appointment->id }}"
                       data-toggle="tooltip" title="Mark appointment as no show"
                       data-patient-name="{{$appointment->patient ? $appointment->patient->first_name . ' ' . $appointment->patient->last_name : ''}}"
                       data-appointment-time="
                            {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('M, d Y') }}
                            {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('H:i') }}
                               -
                            {{ with(DateTimeHelper::setTimeZoneByStr($appointment->end_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('H:i') }}
                       "
                    >
                        No show
                    </a>

                    <a class="btn btn-xs btn-info no-print" href="{{ route('appointment.show', $appointment->id) }}" data-toggle="tooltip" title="View appointment's info">
                        <i class="fa fa-fw fa-info"></i>
                    </a>

                    <a href="#" class="btn btn-xs btn-success no-print" data-action="markVisited" data-appointment-id="{{ $appointment->id }}" data-has-health-summary="{{$appointment->healthSummary?1:0}}" data-toggle="tooltip" title="Mark visited">
                        <i class="fa fa-fw fa-check"></i>
                    </a>

                    <a href="#" class="btn btn-xs btn-warning no-print"
                       data-action="reschedule"
                       data-appointment-id="{{ $appointment->id }}"
                       data-appointment-type-id="{{$appointment->doctorTimetable&&$appointment->doctorTimetable->appointmentType?$appointment->doctorTimetable->appointmentType->id:"0"}}"
                       data-appointment-type-name="{{$appointment->doctorTimetable&&$appointment->doctorTimetable->appointmentType?$appointment->doctorTimetable->appointmentType->name:""}}"
                       data-appointment-type-category="{{$appointment->doctorTimetable&&$appointment->doctorTimetable->appointmentType?$appointment->doctorTimetable->appointmentType->category:""}}"
                       data-toggle="tooltip" title="Reschedule">
                        <i class="fa fa-fw fa-calendar-check-o"></i>
                    </a>

                    <a href="#" class="btn btn-xs btn-danger no-print" data-action="cancel" data-appointment-id="{{ $appointment->id }}" data-toggle="tooltip" title="Cancel appointment">
                        <i class="fa fa-fw fa-remove"></i>
                    </a>
                @endif
            </div>

            <span class="text-primary">
                <i class="fa fa-fw fa-clock-o"></i>
            @if (isset($appointment->doctorTimetable) && isset($appointment->doctorTimetable->clinic))
                {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable->clinic->time_zone))->format('M, d Y') }}
            @endif
            </span>

            <span class="text-danger">
            @if (isset($appointment->doctorTimetable) && isset($appointment->doctorTimetable->clinic))
                {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable->clinic->time_zone))->format('H:i') }}
                -
                {{ with(DateTimeHelper::setTimeZoneByStr($appointment->end_at, $appointment->doctorTimetable->clinic->time_zone))->format('H:i') }}
            @endif
            </span>

            @if (isset($appointment->doctorTimetable) && isset($appointment->doctorTimetable->clinic) && isset($appointment->doctorTimetable->clinic->time_zone))
            GMT+{{\Carbon\Carbon::now($appointment->doctorTimetable->clinic->time_zone)->offsetHours}}
            @endif
            <br/>

            <i class="fa fa-fw fa-stethoscope"></i> {{ $appointment->appointmentType ? $appointment->appointmentType->name : '' }}<br/>
            <i class="fa fa-fw fa-hospital-o"></i> {{ $appointment->doctorTimetable ? ($appointment->doctorTimetable->clinic ? $appointment->doctorTimetable->clinic->name : '') : ''}}<br/>
            <i class="fa fa-fw fa-list-alt"></i> {{$appointment->patient && $appointment->patient->country ? $appointment->patient->country->nice_name . ' - ':''}} {{ $appointment->patient ? $appointment->patient->id_number : ''}}<br/>

            <i class="fa fa-fw fa-phone"></i> {{$appointment->patient && $appointment->patient->phone_country_code ? '('.$appointment->patient->phone_country_code.')':''}} {{$appointment->patient?$appointment->patient->phone_number:''}}
            @if($appointment->patient && $appointment->patient->imported_phone)
                (<span data-toggle="tooltip" title="This value was imported from clinic"><i class="fa fa-sign-in"></i></span> {{$appointment->patient->imported_phone}})
            @endif
            <br/>

            @if($appointment->booker && $appointment->booker->id !== $appointment->patient->id)
                <b>Booked by:</b> {{ $appointment->booker->getFullname() }} ({{ $appointment->booker ? $appointment->booker->phone_country_code : '' }} {{ $appointment->booker ? $appointment->booker->phone_number : '' }})
            @endif

            @if($appointment->booking_reason)
                <div class="text-primary text-italic">
                    <i class="fa fa-fw fa-calendar-check-o"></i> <b>Booking Reason:</b> {!! nl2br($appointment->booking_reason) !!}
                </div>
            @endif

            @if($appointment->cancel_reason)
                <div class="text-danger text-italic">
                    <i class="fa fa-fw fa-calendar-times-o"></i> <b>Cancel Reason:</b> {!! nl2br($appointment->cancel_reason) !!}
                </div>
            @endif

            @if ($appointment->patient && ($appointment->patient->medical_condition || $appointment->patient->drug_allergy))
                <b>Medical Condition:</b> {!! $appointment->patient->medical_condition?nl2br(e($appointment->patient->medical_condition)):' ' !!}
                <b>Drug Allergy:</b> {!! $appointment->patient->drug_allergy?nl2br(e($appointment->patient->drug_allergy)):' ' !!}
            @endif
        </div>
    </div>
</li>
<!-- /.item -->
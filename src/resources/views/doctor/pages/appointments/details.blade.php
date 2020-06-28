@extends('doctor.layouts.base')

@section('pageTitle'){{$authDoctor->name}} - Appointment Details @stop

@section('bodyClass', 'page-appointments-details')

@section('contentHeader')
    @if($appointment->patient)
        <b>{{$appointment->patient->first_name}}</b> {{$appointment->patient->last_name}}
    @endif
@stop

@section('contentHeaderSub')
    {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('M, d Y') }}

    {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('H:i') }}
    -
    {{ with(DateTimeHelper::setTimeZoneByStr($appointment->end_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('H:i') }}

    @if (isset($appointment->doctorTimetable) && isset($appointment->doctorTimetable->clinic) && isset($appointment->doctorTimetable->clinic->time_zone))
        GMT+{{\Carbon\Carbon::now($appointment->doctorTimetable->clinic->time_zone)->offsetHours}}
    @endif
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a>Appointments</a></li>
    @if ($appointment->isCancelled())
        <li><a href="{{route('appointment.cancelledBooking')}}">Cancelled</a></li>
    @elseif ($appointment->isConfirmed())
        <li><a href="{{route('appointment.confirmedBooking')}}">Confirmed</a></li>
    @elseif ($appointment->isNotShowingUp())
        <li><a href="{{route('appointment.notShowingUpBooking')}}">Not Showing Up</a></li>
    @else
        <li><a href="{{route('appointment.visitedBooking')}}">Visited</a></li>
    @endif
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{$appointment->patient?($appointment->patient->profileImage?$appointment->patient->profileImage->getThumbnailUrl():$appointment->patient->getDefaultAvatarUrl($appointment->patient->gender)):\App\Models\Patient::getDefaultAvatarUrl()}}" width="160" height="160"/>

                        <h3 class="profile-username text-center">
                        @if($appointment->patient)
                            <b>{{$appointment->patient->first_name}}</b> {{$appointment->patient->last_name}}
                        @endif
                        </h3>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <i class="fa fa-fw fa-clock-o"></i>

                                {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('M, d Y') }}

                                {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('H:i') }}
                                -
                                {{ with(DateTimeHelper::setTimeZoneByStr($appointment->end_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('H:i') }}

                                @if (isset($appointment->doctorTimetable) && isset($appointment->doctorTimetable->clinic) && isset($appointment->doctorTimetable->clinic->time_zone))
                                    GMT+{{\Carbon\Carbon::now($appointment->doctorTimetable->clinic->time_zone)->offsetHours}}
                                @endif
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-fw fa-hospital-o"></i> {{ $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->name:''}}
                            </li>
                            <li class="list-group-item">
                                <i class="fa fw-fa fa-stethoscope"></i> &nbsp; {{ $appointment->appointmentType ? $appointment->appointmentType->name : '' }}
                            </li>
                            @if($appointment->book_source == 'M')
                                <li class="list-group-item">
                                    <i class="fa fa-fw fa-mobile"></i>
                                    Booked from Mobile App
                                </li>
                            @endif
                            <li class="list-group-item">
                                <i class="fa fa-fw fa-calendar-check-o"></i>
                            @if($appointment->booking_reason)
                                <span class="text-info">{{ $appointment->booking_reason }}</span>
                            @else
                                <span class="text-muted">Nothing was provided.</span>
                            @endif
                            </li>

                            @if($appointment->cancel_reason)
                            <li class="list-group-item">
                                <span class="text-danger text-italic">
                                    <i class="fa fa-fw fa-calendar-times-o"></i> {{$appointment->cancel_reason}}
                                </span>
                            </li>
                            @endif
                            
                            <li class="list-group-item">
                            @if ($appointment->isCancelled())
                                <span class="text-danger">Cancelled</span>
                            @elseif ($appointment->isConfirmed())
                                <span class="text-info">Confirmed</span>
                            @elseif ($appointment->isLate())
                                <span class="text-warning">Late</span>
                            @elseif ($appointment->isNotShowingUp())
                                <span class="text-warning">Not Showing Up</span>
                            @endif
                            </li>

                            @if($appointment->latestStatusChangeActivity->count())
                            <li class="list-group-item">
                                <span class="text-muted">
                                    <i class="fa fa-history"></i> Last status change time:
                                    {{ with(DateTimeHelper::setTimeZoneByStr($appointment->latestStatusChangeActivity->first()->created_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('d/m/Y H:i:s') }}
                                </span>
                            </li>
                            @endif
                        </ul>

                        @if ($appointment->isConfirmed())
                            {!! Form::open([
                                'route' => ['appointment.cancelSubmit', $appointment->id],
                                'id' => 'appointment-cancel-'.$appointment->id
                            ]) !!}
                            <input type="hidden" id="cancelReasonField" name="cancel_reason" />
                            {!! Form::close() !!}

                            {!! Form::open([
                                    'route' => ['appointment.markAsLateSubmit', $appointment->id],
                                    'id' => 'appointment-mark-as-late-'.$appointment->id
                                ]) !!}
                            {!! Form::close() !!}

                            {!! Form::open([
                                    'route' => ['appointment.markAsNoShowSubmit', $appointment->id],
                                    'id' => 'appointment-mark-as-no-show-'.$appointment->id
                                ]) !!}
                            {!! Form::close() !!}
                            <a href="#" class="btn btn-danger btn-block btn-cancel-appointment" data-appointment-id="{{ $appointment->id }}">Cancel</a>
                            <a href="#" class="btn btn-default btn-block btn-mark-as-no-show-appointment" data-appointment-id="{{ $appointment->id }}">No Show</a>
                        @endif
                    </div>
                </div>
            </div>

        @if(count($appointment->files))
            <div class="box box-warning" id="box_files">
                <div class="box-header">
                    <h3 class="box-title">Attachments</h3>
                </div>
                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        @foreach ($appointment->files as $file)
                            <li class="item">
                                <div class="product-img">
                                    <img src="{{$file->getThumbnailUrl()}}" alt=""/>
                                </div>
                                <div class="product-info">
                                    <div class="pull-right">
                                        <a href="{{$file->getThumbnailUrl()}}" data-toggle="tooltip" data-title="Download" download>
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </div>
                                    <a href="{{$file->getThumbnailUrl()}}" class="product-title">{{$file->name}}</a>
                                    <div class="product-description">
                                        {{$file->description}}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        </div>

        <div class="col-md-8">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#patient_info" data-toggle="tab" aria-expanded="true">Patient Info</a></li>
                    {{--<li><a href="#appointment_history" data-toggle="tab" aria-expanded="false">History</a></li>--}}
                    {{--<li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Timeline</a></li>--}}
                    {{--<li class=""><a href="#settings" data-toggle="tab" aria-expanded="false">Settings</a></li>--}}
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="patient_info">
                        <dl class="dl-horizontal">
                            <dt>Name</dt>
                            <dd>
                            @if($appointment->patient)
                                <b>{{$appointment->patient->first_name}}</b> {{$appointment->patient->last_name}}
                            @endif
                            @if($appointment->patient&&$appointment->patient->imported_name)
                            (
                                <span data-toggle="tooltip" title="This value was imported from clinic"><i class="fa fa-sign-in"></i></span>
                                {{$appointment->patient->imported_name}}
                            )
                            @endif
                            @if($appointment->patient&&$appointment->patient->verified)
                                <small class="label label-success">
                                    <i class="fa fa-check"></i>
                                    Verified
                                </small>
                            @endif
                            </dd>

                            <dt>Patient ID</dt>
                            <dd>
                                {{ $appointment->patient ? $appointment->patient->id : '' }}
                            </dd>
                        @if($patientClinicMRID)
                            <dt>MRID</dt>
                            <dd>{{$patientClinicMRID}}</dd>
                        @endif
                            <dt>Gender</dt>
                            <dd>
                                {{ $appointment->patient ? ucfirst(strtolower($appointment->patient->gender)) : '' }}
                            </dd>

                            <dt>Date of birth</dt>
                            <dd>
                                {{ $appointment->patient && $appointment->patient->date_of_birth ? $appointment->patient->date_of_birth->format('d/m/Y') : '' }}
                            </dd>

                            <dt>Address</dt>
                            <dd>
                                {{ $appointment->patient ? $appointment->patient->address_street : '' }}

                                <b>{{ $appointment->patient ? $appointment->patient->address_city : '' }}</b>
                            </dd>

                            <dt>Phone number</dt>
                            <dd>
                                {{ $appointment->patient ? $appointment->patient->phone_country_code : '' }}

                                {{ $appointment->patient ? $appointment->patient->phone_number : '' }}
                            @if($appointment->patient && $appointment->patient->imported_phone)
                            (
                                <span data-toggle="tooltip" title="This value was imported from clinic"><i class="fa fa-sign-in"></i></span>
                                {{$appointment->patient->imported_phone}}
                            )
                            @endif
                            </dd>

                            <dt>Email</dt>
                            <dd>
                            @if($appointment->patient && $appointment->patient->account && $appointment->patient->account->email)
                                <a href="mailto:{{$appointment->patient->account->email}}">
                                    <i class="fa fa-envelope"></i>
                                    {{$appointment->patient->account->email}}
                                </a>
                            @elseif($appointment->patient && $appointment->patient->email)
                                <a href="mailto:{{$appointment->patient->email}}">{{$appointment->patient->email}}</a>
                            @endif

                            @if($appointment->patient && $appointment->patient->imported_email)
                            (
                                <span data-toggle="tooltip" title="This value was imported from clinic"><i class="fa fa-sign-in"></i></span>
                                {{$appointment->patient->imported_email}}
                            )
                            @endif
                            </dd>

                            <dt>Country</dt>
                            <dd>
                                {{ $appointment->patient && $appointment->patient->country ? $appointment->patient->country->nice_name : '' }}
                            </dd>

                            <dt>ID Number</dt>
                            <dd>
                                {{ $appointment->patient ? $appointment->patient->id_number : '' }}
                            </dd>
                        </dl>

                        @if ($appointment->patient && ($appointment->patient->medical_condition || $appointment->patient->drug_allergy))
                            <dl class="dl-horizontal">
                                <dt>Medical Condition</dt>
                                <dd>{!! $appointment->patient->medical_condition?nl2br(e($appointment->patient->medical_condition)):' ' !!}</dd>
                                <dt>Drug Allergy</dt>
                                <dd>{!! $appointment->patient->drug_allergy?nl2br(e($appointment->patient->drug_allergy)):' ' !!}</dd>
                            </dl>
                        @endif

                        <dl class="dl-horizontal">
                        @if($appointment->booker && $appointment->booker->id !== $appointment->patient->id)
                            <dt>Booked by</dt>
                            <dd>
                                {{ $appointment->booker->getFullname() }}
                            </dd>
                        @endif
                            <dt>Booking Reason</dt>
                            <dd>
                            @if($appointment->booking_reason)
                                <span class="text-info">{!! nl2br(e($appointment->booking_reason))!!}</span>
                            @else
                                <span class="text-muted">Nothing was provided.</span>
                            @endif
                            @if($appointment->book_source !== 'M')
                                <a data-action="updateBookingReason" href="#">
                                    <i class="fa fa-fw fa-edit"></i>
                                </a>
                            @endif

                            </dd>

                            <dt>Note</dt>
                            <dd>
                                @if($appointment->note)
                                    {!! nl2br(e($appointment->note))!!}
                                @else
                                    <span class="text-muted">Nothing was provided</span>
                                @endif
                            </dd>

                        @if($appointment->isCancelled() && $appointment->cancel_reason)
                                <dt>Cancel Reason</dt>
                                <dd>
                                    <span class="text-danger">{{$appointment->cancel_reason}}</span>
                                </dd>
                        @endif
                        </dl>

                        @if($appointment->patient && !$appointment->patient->verified)
                        <dl class="dl-horizontal">
                            <dt></dt>
                            <dd>
                                <a href="{{route('doctor.patient.details', $appointment->patient->id)}}">Go to patient profile page to verify information</a>
                            </dd>
                        </dl>
                        @endif
                    </div>

                    {{--<div class="tab-pane" id="appointment_history">--}}
                        {{--Appointment History--}}
                    {{--</div>--}}
                </div>
            </div>

            <div class="box box-solid" id="box_consult_summary" data-appointment-id="{{$appointment->id}}">
                <div class="box-header">
                    <div class="pull-right tools">
                    @if($appointment->healthSummary)
                        <button class="btn btn-box-tool" data-action="update">
                            <i href="#" class="fa fa-pencil"></i>
                        </button>
                    @else
                        <button class="btn btn-box-tool" data-action="add">
                            <i href="#" class="fa fa-plus"></i>
                        </button>
                    @endif
                    </div>
                    <h3 class="box-title">
                        Consult Summary
                    </h3>
                </div>

            @if($appointment->healthSummary)
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt>Title</dt>
                        <dd>{{$appointment->healthSummary->title}}</dd>

                        <dt>Summary</dt>
                        <dd>{!! nl2br(e($appointment->healthSummary->summary))!!}</dd>

                        <dt>Plan</dt>
                        <dd>{!! nl2br(e($appointment->healthSummary->plan))!!}</dd>

                        <dt>Visit doctor if</dt>
                        <dd>{!! nl2br(e($appointment->healthSummary->visit_doctor_if))!!}</dd>
                    </dl>
                </div>
            @endif
            </div>

        @if($appointment->user_id || count($appointment->messages))
            <div class="box box-info" id="box_messages">
                <div class="box-header">
                    <div class="pull-right tools">
                    @if($appointment->user_id)
                        <button class="btn btn-box-tool" data-action="sendMessage" data-toggle="tooltip" data-title="Send Message to booker">
                            <i href="#" class="fa fa-plus"></i>
                        </button>
                    @endif
                    </div>
                    <h3 class="box-title">Messages</h3>
                </div>
            @if(count($appointment->messages))
                <div class="box-body">
                    <ul class="timeline">
                    @foreach ($appointment->messages as $message)
                        <li>
                        @if($message->ack_status == 'done')
                            <i class="fa fa-check bg-green" data-toggle="tooltip" data-title="Patient has acknowledged this message"></i>
                        @else
                            <i class="fa fa-envelope bg-blue"></i>
                        @endif
                            <div class="timeline-item">
                                <span class="time">
                                    {{ with(DateTimeHelper::setTimeZoneByStr($message->created_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('M, d Y') }}
                                    {{ with(DateTimeHelper::setTimeZoneByStr($message->created_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('H:i') }}
                                    @if (isset($appointment->doctorTimetable) && isset($appointment->doctorTimetable->clinic) && isset($appointment->doctorTimetable->clinic->time_zone))
                                        GMT+{{\Carbon\Carbon::now($appointment->doctorTimetable->clinic->time_zone)->offsetHours}}
                                    @endif
                                </span>
                                <div class="timeline-body">
                                    {{$message->message}}
                                </div>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
            @endif
            </div>
        @endif

        @if($appointment->patient)
            <a class="btn btn-info"
               href="#"
               data-action="bookAppointmentToOtherDoctor"
               data-patient-id="{{$appointment->patient->id}}"
               data-patient-text="{{$appointment->patient->id_number}} - {{$appointment->patient->getFullname()?$appointment->patient->getFullname():($appointment->patient->imported_name?$appointment->patient->imported_name:'')}} - {{$appointment->patient->country?$appointment->patient->country->name:''}} - {{$appointment->patient->date_of_birth?$appointment->patient->date_of_birth->format('d-m-Y'):''}} - #{{$appointment->patient->id}}">Book appointment with other doctor</a>
        @endif
        </div>
    </div>
@stop

@push('dataScripts')
<script>
    globalData.context.pageAppointmentDetails = {
        appointment: {!! $appointment->toJson() !!}
    }
</script>
@endpush

@push('customScripts')
<script>
    $(function(){
        $(".btn-cancel-appointment").on('click', function (e) {
            e.preventDefault();

            var appointmentId = $(this).data('appointment-id');

            var box = bootbox.dialog({
                message: 'Are you sure to cancel this appointment? This action cannot undo. <hr />' +
                '<form class="form-horizontal">' +
                '<div class="form-group"> ' +
                '<label class="col-md-3 control-label" for="name">Reason</label> ' +
                '<div class="col-md-8"> ' +
                '<textarea class="form-control" id="cancelReasonTextArea"></textarea> ' +
                '<span class="help-block">Please give me your reason.</span> </div> ' +
                '</div> ' +
                '</form>',
                title: "Cancel Appointment",
                buttons: {
                    danger: {
                        label: "Yes, I'm sure",
                        className: "btn-danger",
                        callback: function() {
                            var $form = $("#appointment-cancel-" + appointmentId);
                            var cancelReason = $('#cancelReasonTextArea').val();

                            $form.find('#cancelReasonField').val(cancelReason);
                            $form.submit();
                        }
                    },
                    cancel: {
                        label: "No, I'm not sure",
                        className: "btn-default"
                    }
                }
            });

            box.on("shown.bs.modal", function() {
                $('#cancelReasonTextArea').focus();
            });
        });

        $(".btn-visit-appointment").on('click', function (e) {
            e.preventDefault();

            var appointmentId = $(this).data('appointment-id');

            bootbox.confirm("Are you sure that the patient has already visited?", function(result) {
                if (result) {
                    var $form = $("#appointment-visit-" + appointmentId);

                    $form.submit();
                }
            });
        });

        $('.btn-mark-as-no-show-appointment')
            .on('click', function (event) {
                event.preventDefault();

                var appointmentId = $(this).data('appointment-id');

                var box = bootbox.dialog({
                    message: 'Patient name: {{$appointment->patient ? $appointment->patient->first_name . ' ' . $appointment->patient->last_name : ''}}<br/>'
                    + 'Appointment time: {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('M, d Y') }}\n' +
                    '\n' +
                    '    {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('H:i') }}\n' +
                    '    -\n' +
                    '    {{ with(DateTimeHelper::setTimeZoneByStr($appointment->end_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('H:i') }}',
                    title: "You are going to mark this appointment as <b>No Show</b>",
                    buttons: {
                        cancel: {
                            label: "Cancel",
                            className: "btn-default"
                        },
                        confirm: {
                            label: "Confirm",
                            className: "btn-primary",
                            callback: function() {
                                var $form = $("#appointment-mark-as-no-show-" + appointmentId);
                                $form.submit();
                            }
                        }
                    }
                });

                box.on("shown.bs.modal", function() {
                    $('#cancelReasonTextArea').focus();
                });
            })
        ;

        $('[data-action=bookAppointmentToOtherDoctor]')
            .on('click', function(event){
                event.preventDefault();

                let $this = $(this),
                    patientId = $this.data('patient-id'),
                    patientText = $this.data('patient-text')
                ;

                manaDrApplication.emit('modalCreateAppointment/show', {
                    data: {
                        patient: {
                            id: patientId,
                            text: patientText
                        }
                    }
                });
            })
        ;
    })
</script>
@endpush
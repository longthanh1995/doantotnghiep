@extends('legacy.layouts.admin.application')

@section('bodyClass', 'page-appointments-details')

@section('pageTitle')Appointment #{{$appointment->id}} Details @stop

@section('header')
    @if($appointment->patient)
        <b>{{$appointment->patient->first_name}}</b> {{$appointment->patient->last_name}}
    @endif
@stop

@section('subheader')
    {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('M, d Y') }}

    {{ with(DateTimeHelper::setTimeZoneByStr($appointment->start_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('H:i') }}
    -
    {{ with(DateTimeHelper::setTimeZoneByStr($appointment->end_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('H:i') }}

    @if (isset($appointment->doctorTimetable) && isset($appointment->doctorTimetable->clinic) && isset($appointment->doctorTimetable->clinic->time_zone))
        GMT+{{\Carbon\Carbon::now($appointment->doctorTimetable->clinic->time_zone)->offsetHours}}
    @endif
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body box-profile" id="box_profile">
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
                                <i class="fa fa-fw fa-user-md"></i> {{($appointment->doctor)?$appointment->doctor->name:''}}
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
                                @if($appointment->booking_reason)
                                    <i class="fa fa-fw fa-calendar-check-o"></i>
                                    <span class="text-info">{{ $appointment->booking_reason }}</span>
                                @else
                                    <i class="fa fa-fw fa-calendar-check-o"></i>
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
                                <span class="text-info">Late</span>
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
                            <a href="#" class="btn btn-danger btn-block" data-action="cancel" data-id="{{ $appointment->id }}">Cancel</a>
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
                    <li><a href="#payment_history" data-toggle="tab" aria-expanded="false">Payment History</a></li>
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
                            @if($appointment->patient&&$appointment->patient->imported_phone)
                            (
                                <span data-toggle="tooltip" title="This value was imported from clinic"><i class="fa fa-sign-in"></i></span>
                                {{$appointment->patient&&$appointment->patient->imported_phone}}
                            )
                            @endif
                            </dd>

                            <dt>Email</dt>
                            <dd>
                            @if($appointment->patient&& $appointment->patient->account && $appointment->patient->account->email)
                                <a href="mailto:{{$appointment->patient->account->email}}">
                                    <i class="fa fa-envelope"></i>
                                    {{$appointment->patient && $appointment->patient->account->email}}
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
                                    <span class="text-info">{{ $appointment->booking_reason }}</span>
                                @else
                                    <span class="text-muted">Nothing was provided.</span>
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
                                <a href="{{route('admin.patient.details', $appointment->patient->id)}}">Go to patient profile page to verify information</a>
                            </dd>
                        </dl>
                        @endif
                    </div>

                    <div class="tab-pane" id="payment_history">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table_fees">
                                <thead>
                                <tr>
                                    <th>Created at</th>
                                    <th>Fee</th>
                                    <th>Tax</th>
                                    <th>Discount</th>
                                    <th>Mobile Invoice</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($appointment->appointmentFees as $appointmentFee)
                                    <tr>
                                        <td>
                                            {{$appointmentFee->created_at}}
                                        </td>
                                        <td>
                                            {{$appointmentFee->fee_amount}}
                                            @if($appointmentFee->fee_currency)
                                                {{$appointmentFee->fee_currency}}
                                            @endif
                                        </td>

                                        <td>
                                            {{$appointmentFee->tax_amount}}
                                        </td>

                                        <td>
                                            {{$appointmentFee->discount_amount}}
                                        </td>

                                        <td>
                                            @if($appointmentFee->chargebee_invoice_id)
                                                <i class="fa fa-mobile"></i>
                                                {{$appointmentFee->chargebee_invoice_id}}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                            <i class="fa fa-envelope bg-blue"></i>
                            <div class="timeline-item">
                                <span class="time">
                                    {{ with(DateTimeHelper::setTimeZoneByStr($message->created_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('M, d Y') }}
                                    {{ with(DateTimeHelper::setTimeZoneByStr($message->created_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('H:i') }}
                                    @if (isset($appointment->doctorTimetable) && isset($appointment->doctorTimetable->clinic) && isset($appointment->doctorTimetable->clinic->time_zone))
                                        GMT+{{\Carbon\Carbon::now($appointment->doctorTimetable->clinic->time_zone)->offsetHours}}
                                    @endif
                                </span>
                                <h3 class="timeline-header"></h3>
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
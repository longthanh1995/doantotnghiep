@extends('legacy.layouts.admin.application')

@section('pageTitle')Patient  {{$patient->first_name}} {{$patient->last_name}} (#{{$patient->id}})@stop

@section('bodyClass', 'page-admin page-patients page-patients-details')

@section('header')
    <b>{{$patient->first_name}}</b>
    {{$patient->last_name}}
@stop

@section('subheader')
    @if($patient->deceased)
        <small class="label label-danger">Deceased</small>
    @endif

    @if($patient->verified)
        <small class="label label-success">
            <i class="fa fa-check"></i>
            Verified
        </small>
    @else
        <small class="label label-warning">
            Unverified
        </small>
        &nbsp;
        <a href="#" data-action="verify" data-id="{{$patient->id}}">Verify</a>
    @endif
@stop

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="
                @if($guardian)
                    col-md-6
                @else
                    col-md-12
                @endif
                ">
                    <div class="box box-solid" id="box_info">
                        <div class="box-header">
                            <div class="box-tools pull-right">
                            {{--@if($canEdit)--}}
                                <button class="btn btn-box-tool" data-action="edit">
                                    <i href="#" class="fa fa-pencil"></i>
                                </button>
                            {{--@endif--}}
                            </div>
                            <h3 class="box-title">
                                Basic Information
                            @if($patient->user_id)
                                <span data-toggle="tooltip" title="This patient used Mobile App (#{{$patient->user_id}})">
                                    <i class="fa fa-mobile"></i>
                                </span>
                            @endif
                            </h3>
                        </div>

                        <div class="box-body">
                            <dl class="dl-horizontal">
                                <dt>Patient ID</dt>
                                <dd>{{$patient->id}}</dd>

                                <dt>Name</dt>
                                <dd>
                                    <b>{{$patient->first_name}}</b> {{$patient->last_name}}
                                @if($patient->imported_name)
                                (
                                    <span data-toggle="tooltip" title="This value was imported from clinic"><i class="fa fa-sign-in"></i></span>
                                    {{$patient->imported_name}}
                                )
                                @endif
                                </dd>

                                <dt>Alias</dt>
                                <dd>{{$patient->alias}}</dd>

                                <dt>Gender</dt>
                                <dd>{{$patient->gender}}</dd>

                                <dt>Date of Birth</dt>
                                <dd>
                                    {{$patient->date_of_birth?$patient->date_of_birth->format('d/m/Y'):''}}
                                </dd>

                                <dt>Race</dt>
                                <dd>{{$patient->race}}</dd>

                                <dt>National ID Issuing Country</dt>
                                <dd>{{$patient->country?$patient->country->nice_name:''}}</dd>

                                <dt>National ID Number</dt>
                                <dd>{{$patient->id_number}}</dd>

                                <dt>Created at</dt>
                                <dd>{{$patient->created_at}} GMT+0</dd>
                            </dl>
                        </div>

                        <div class="box-header">
                            <h3 class="box-title">Contact Information</h3>
                        </div>

                        <div class="box-body">
                            <dl class="dl-horizontal">
                                <dt>Email</dt>
                                <dd>
                                @if($patient->account && $patient->account->email)
                                    <a href="mailto:{{$patient->account->email}}">
                                        <i class="fa fa-envelope"></i>
                                        {{$patient->account->email}}
                                    </a>
                                @elseif($patient->email)
                                    <a href="mailto:{{$patient->email}}">{{$patient->email}}</a>
                                @endif

                                @if($patient->imported_email)
                                (
                                    <span data-toggle="tooltip" title="This value was imported from clinic"><i class="fa fa-sign-in"></i></span>
                                    {{$patient->imported_email}}
                                )
                                @endif
                                </dd>

                                <dt>Phone Number</dt>
                                <dd>
                                    {{$patient->phone_country_code?'('.$patient->phone_country_code.')':''}}
                                    {{$patient->phone_number}}
                                @if($patient->imported_phone)
                                (
                                    <span data-toggle="tooltip" title="This value was imported from clinic"><i class="fa fa-sign-in"></i></span>
                                    {{$patient->imported_phone}}
                                )
                                @endif
                                </dd>

                                <dt>Block</dt>
                                <dd>{{$patient->address_block}}</dd>

                                <dt>Apartment</dt>
                                <dd>{{$patient->apartment_number}}</dd>

                                <dt>Street</dt>
                                <dd>{{$patient->address_street}}</dd>

                                <dt>City</dt>
                                <dd>{{$patient->address_city}}</dd>

                                <dt>Residence Country</dt>
                                <dd>{{$patient->residenceCountry?$patient->residenceCountry->nice_name:''}}</dd>

                                <dt>Zip Code</dt>
                                <dd>{{$patient->address_zip}}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            @if($guardian)
            <div class="col-md-6">
                <div class="box box-danger" id="box_guardian">
                    <div class="box-header">
                        <h3 class="box-title">
                            Guardian
                        @if($patient->user_id)
                            <span data-toggle="tooltip" title="This patient used Mobile App (#{{$patient->user_id}})">
                                <i class="fa fa-mobile"></i>
                            </span>
                        @endif
                        </h3>
                    </div>

                    <div class="box-body">
                        <dl class="dl-horizontal">
                            <dt>Patient ID</dt>
                            <dd>{{$guardian->id}}</dd>

                            <dt>Name</dt>
                            <dd>
                                <b>{{$guardian->first_name}}</b> {{$guardian->last_name}}
                            @if($guardian->imported_name)
                            (
                                <span data-toggle="tooltip" title="This value was imported from clinic"><i class="fa fa-sign-in"></i></span>
                                {{$guardian->imported_name}}
                            )
                            @endif
                            </dd>

                            <dt>Alias</dt>
                            <dd>{{$guardian->alias}}</dd>

                            <dt>Gender</dt>
                            <dd>{{$guardian->gender}}</dd>

                            <dt>Date of Birth</dt>
                            <dd>
                                {{$guardian->date_of_birth?$guardian->date_of_birth->format('d/m/Y'):''}}
                            </dd>

                            <dt>Race</dt>
                            <dd>{{$guardian->race}}</dd>

                            <dt>National ID Issuing Country</dt>
                            <dd>{{$guardian->country?$guardian->country->nice_name:''}}</dd>

                            <dt>National ID Number</dt>
                            <dd>{{$guardian->id_number}}</dd>

                            <dt>Created at</dt>
                            <dd>{{$guardian->created_at}} GMT+0</dd>
                        </dl>
                    </div>

                    <div class="box-header">
                        <h3 class="box-title">&nbsp;</h3>
                    </div>

                    <div class="box-body">
                        <dl class="dl-horizontal">
                            <dt>Email</dt>
                            <dd>
                            @if($guardian->account && $guardian->account->email)
                                <a href="mailto:{{$guardian->account->email}}">
                                    <i class="fa fa-envelope"></i>
                                    {{$guardian->account->email}}
                                </a>
                            @elseif($guardian->email)
                                <a href="mailto:{{$guardian->email}}">{{$guardian->email}}</a>
                            @endif

                            @if($guardian->imported_email)
                            (
                                <span data-toggle="tooltip" title="This value was imported from clinic"><i class="fa fa-sign-in"></i></span>
                                {{$guardian->imported_email}}
                            )
                            @endif
                            </dd>

                            <dt>Phone Number</dt>
                            <dd>
                                {{$guardian->phone_country_code?'('.$guardian->phone_country_code.')':''}}
                                {{$guardian->phone_number}}
                            @if($guardian->imported_phone)
                            (
                                <span data-toggle="tooltip" title="This value was imported from clinic"><i class="fa fa-sign-in"></i></span>
                                {{$guardian->imported_phone}}
                            )
                            @endif
                            </dd>

                            <dt>Address</dt>
                            <dd>{{$guardian->address_street}}
                                @if($guardian->address_city)
                                    , <b>{{$guardian->address_city}}</b>
                                @endif
                            </dd>

                            <dt>Country</dt>
                            <dd>{{$guardian->country?$guardian->country->nice_name:''}}</dd>

                            <dt>Zip Code</dt>
                            <dd>{{$guardian->address_zip}}</dd>
                        </dl>
                    </div>

                @if($guardianDescription)
                    <div class="box-header">
                        <h3 class="box-title">
                            Reason of assigning
                        </h3>
                    </div>

                    <div class="box-body">
                        <p>{{$guardianDescription}}</p>
                    </div>
                @endif
                </div>
            </div>
            @endif
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-danger" id="box_notes">
                        <div class="box-header">
                            <h3 class="box-title">Notes</h3>
                        </div>

                        <div class="box-body">
                            <dl class="dl-horizontal">
                                <dt>Medical Condition</dt>
                                <dd>{!! $patient->medical_condition?nl2br(e($patient->medical_condition)):' ' !!}</dd>
                                <dt>Drug Allergy</dt>
                                <dd>{!! $patient->drug_allergy?nl2br(e($patient->drug_allergy)):' ' !!}</dd>
                            </dl>
                        </div>
                    </div>

                    <div class="box box-success" id="box_medical_record_numbers">
                        <div class="box-header">
                            <h3 class="box-title">Medical Record Numbers</h3>
                        </div>

                        <div class="box-body">
                            <dl class="dl-horizontal">
                                @foreach($patient->clinics as $clinic)
                                @if($authAdminUser->hasRole('super_admin') || in_array($clinic->id, $authAdminUser->clinics->pluck('id')->all()))
                                    <dt>{{($clinic->pivot && $clinic->pivot->medical_record_number)?$clinic->pivot->medical_record_number:'(Undefined)'}}</dt>
                                    <dd>{{$clinic->name}}</dd>
                                @endif
                                @endforeach
                            </dl>
                        </div>
                    </div>

                    <div class="box box-info" id="box_appointments">
                        <div class="box-header">
                            <h3 class="box-title">
                                Appointments
                                <small>Only show the ones that they come to you</small>
                            </h3>
                        </div>
                        <div class="box-body table-responsive">
                            <table class="table table-hover" id="table_appointments">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th></th>
                                    <th>Created at</th>
                                    <th>Type</th>
                                    <th>Doctor</th>
                                    <th>Clinic</th>
                                    <th>Status</th>
                                    <th>
                                        <span data-toggle="tooltip" data-title="Last status change time">
                                            <i class="fa fa-history"></i> Last status change time
                                        </span>
                                    </th>
                                    <th>Time</th>
                                    <th>
                                        Booking User
                                        <span data-toggle="tooltip"
                                              title="Only show if the appointment is booked by another person">
                                            <i class="fa fa-info-circle"></i>
                                        </span>
                                    </th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($patient->appointments as $appointment)
                                    <tr data-id="{{$appointment->id}}">
                                        <td>
                                            {{$appointment->id}}
                                        </td>
                                        <td>
                                        @if($appointment->book_source == 'M')
                                            <i class="fa fa-fw fa-mobile"></i>
                                        @endif
                                        </td>
                                        <td>
                                            {{$appointment->created_at?$appointment->created_at->format('d/m/Y h:i:s'):''}}
                                        </td>
                                        <td>
                                            {{($appointment->appointmentType)?$appointment->appointmentType->name:''}}
                                        </td>
                                        <td>
                                            {{($appointment->doctor)?$appointment->doctor->name:''}}
                                        </td>
                                        <td>
                                            @if($appointment->doctorTimetable && $appointment->doctorTimetable->clinic)
                                                {{$appointment->doctorTimetable->clinic->name}}
                                            @else
                                                <span title="Clinic #{{$appointment->doctorTimetable?$appointment->doctorTimetable->clinic_id:''}} not exists anymore">
                                                <i class="fa fa-warning"></i>
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($appointment->appointmentStatus)
                                                <span class="label" data-type="appointment-type" data-name="{{$appointment->appointmentStatus->name}}">{{$appointment->appointmentStatus->name}}</span>
                                            @endif
                                        </td>
                                        <td>
                                        @if($appointment->latestStatusChangeActivity->count())
                                            {{ with(DateTimeHelper::setTimeZoneByStr($appointment->latestStatusChangeActivity->first()->created_at, $appointment->doctorTimetable && $appointment->doctorTimetable->clinic?$appointment->doctorTimetable->clinic->time_zone:'UTC'))->format('d/m/Y H:i:s') }}
                                        @endif
                                        </td>
                                        <td>
                                            @if($appointment->doctorTimetable)
                                                {{$appointment->doctorTimetable->start_at->tz('UTC')->setTimezone(($appointment->doctorTimetable->clinic)?$appointment->doctorTimetable->clinic->time_zone:'UTC')->format('d/m/Y H:i')}}
                                                -
                                                {{$appointment->doctorTimetable->end_at->setTimezone(($appointment->doctorTimetable->clinic)?$appointment->doctorTimetable->clinic->time_zone:'UTC')->format('H:i P')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($appointment->booker && $appointment->booker->id != $appointment->patient->id)
                                                <a href="{{ route('admin.patient.details', $appointment->booker->id) }}">
                                                    {{$appointment->booker->getFullname()}}
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('admin.appointment.details', $appointment->id)}}" data-toggle="tooltip" data-title="View appointent details">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                        @if($appointment->user_id)
                                            <a href="#" data-action="sendMessage" data-toggle="tooltip" data-title="Send message to booker">
                                                <i class="fa fa-send"></i>
                                            </a>
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
        </div>

        <div class="col-md-3">
            <div class="box box-primary" id="box_linked_patients">
                <div class="box-header">
                    {{--<div class="box-tools pull-right">--}}
                    {{--<div class="btn-group">--}}
                    {{--<button aria-expanded="false" type="button" class="btn btn-box-tool dropdown-toggle"--}}
                    {{--data-toggle="dropdown">--}}
                    {{--<i class="fa fa-plus"></i></button>--}}
                    {{--<ul class="dropdown-menu" role="menu">--}}
                    {{--<li><a href="#" data-action="assign">Assign</a></li>--}}
                    {{--<li><a href="#" data-action="register">Register</a></li>--}}
                    {{--</ul>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    <h3 class="box-title">Family & Friends</h3>
                </div>

                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        @foreach($linkedPatients as $linkedPatient)
                            <li class="item" data-id="{{$linkedPatient->id}}"
                            @if($linkedPatient->guardian_patient_id == $patient->id)
                                data-is-ward="1"
                            @endif
                            >
                                <div class="product-img">
                                    <img
                                        src="{{($linkedPatient->profileImage)?$linkedPatient->profileImage->getThumbnailUrl():$linkedPatient->getDefaultAvatarUrl($linkedPatient->gender)}}"
                                        alt="{{($linkedPatient->profileImage)?$linkedPatient->name:"No image"}}"
                                    >
                                </div>
                                <div class="product-info">
                                    <a href="#" class="product-title" data-action="showInfo">{{$linkedPatient->pivot->first_name}} <b>{{$linkedPatient->pivot->last_name}}</b> <span class="text-muted">(#{{$linkedPatient->id}})</span></a>
                                        @if($patient->guardian_patient_id == $linkedPatient->id)
                                            <span class="label label-danger pull-right">Guardian</span>
                                        @elseif($linkedPatient->guardian_patient_id == $patient->id)
                                            <span class="label label-primary pull-right">Ward</span>
                                        @endif
                                    <div class="product-description" style="overflow: visible">
                                    @if($linkedPatient->pivot && ($linkedPatient->pivot->patient_id != $linkedPatient->pivot->user_patient_id))
                                        <div class="pull-right">
                                            <div class="btn-group dropup">
                                                <button aria-expanded="false" type="button"
                                                        class="btn btn-box-tool dropdown-toggle"
                                                        data-toggle="dropdown">
                                                    <i class="fa fa-pencil"></i></button>
                                                <ul class="dropdown-menu" role="menu" style="right:0;left:auto;">
                                                @if($patient->guardian_patient_id == $linkedPatient->id || $linkedPatient->guardian_patient_id == $patient->id)
                                                    <li><a href="#" data-action="revokeGuardianship">Revoke Guardianship</a></li>
                                                @else
                                                    <li><a href="#" data-action="setAsGuardian">Set as Guardian</a></li>
                                                    <li><a href="#" data-action="setAsWard">Set as Ward</a></li>
                                                @endif
                                                    {{--<li><a href="#" data-action="editSettings">Edit Settings</a></li>--}}
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                        {{$linkedPatient->pivot->relationship_id?$relationships[$linkedPatient->pivot->relationship_id]->name:'Unidentified relationship'}}<br/>
                                        <b>DOB:</b> {{$linkedPatient->pivot->date_of_birth?\Carbon\Carbon::parse($linkedPatient->pivot->date_of_birth)->format('d-m-Y'):''}}<br/>
                                        <b>Created at:</b> {{$linkedPatient->created_at?$linkedPatient->created_at->format('d-m-Y h:i:s'):''}}<br/>
                                    </div>
                                </div>
                            </li>
                            <!-- /.item -->
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="box box-success" id="box_patient_who_added">
                <div class="box-header">
                    {{--<div class="box-tools pull-right">--}}
                    {{--<div class="btn-group">--}}
                    {{--<button aria-expanded="false" type="button" class="btn btn-box-tool dropdown-toggle"--}}
                    {{--data-toggle="dropdown">--}}
                    {{--<i class="fa fa-plus"></i></button>--}}
                    {{--<ul class="dropdown-menu" role="menu">--}}
                    {{--<li><a href="#" data-action="assign">Assign</a></li>--}}
                    {{--<li><a href="#" data-action="register">Register</a></li>--}}
                    {{--</ul>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    <h3 class="box-title">Who added this patient?</h3>
                </div>

                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        @foreach($patientsWhoAdded as $patientWhoAdded)
                            <li class="item" data-id="{{$patientWhoAdded->id}}"
                            @if($patientWhoAdded->guardian_patient_id == $patient->id)
                                data-is-ward="1"
                            @endif
                            >
                                <div class="product-img">
                                    <img
                                        src="{{($patientWhoAdded->profileImage)?$patientWhoAdded->profileImage->getThumbnailUrl():$patientWhoAdded->getDefaultAvatarUrl($patientWhoAdded->gender)}}"
                                        alt="{{($patientWhoAdded->profileImage)?$patientWhoAdded->name:"No image"}}"
                                    >
                                </div>
                                <div class="product-info">
                                    <a href="#" class="product-title" data-action="showInfo">{{$patientWhoAdded->first_name}} <b>{{$patientWhoAdded->last_name}}</b> <span class="text-muted">(#{{$patientWhoAdded->id}})</span></a>
                                    @if($patient->guardian_patient_id == $patientWhoAdded->id)
                                            <span class="label label-danger pull-right">Guardian</span>
                                        @elseif($patientWhoAdded->guardian_patient_id == $patient->id)
                                            <span class="label label-primary pull-right">Ward</span>
                                        @endif
                                    <div class="product-description" style="overflow: visible">
                                        @if($patientWhoAdded->pivot && ($patientWhoAdded->pivot->patient_id != $patientWhoAdded->pivot->user_patient_id))
                                            <div class="pull-right">
                                                <div class="btn-group">
                                                    <button aria-expanded="false" type="button"
                                                            class="btn btn-box-tool dropdown-toggle"
                                                            data-toggle="dropdown">
                                                        <i class="fa fa-pencil"></i></button>
                                                    <ul class="dropdown-menu" role="menu" style="right:0;left:auto;">
                                                        @if($patient->guardian_patient_id == $patientWhoAdded->id || $patientWhoAdded->guardian_patient_id == $patient->id)
                                                            <li><a href="#" data-action="revokeGuardianship">Revoke Guardianship</a></li>
                                                        @else
                                                            <li><a href="#" data-action="setAsGuardian">Set as Guardian</a></li>
                                                            <li><a href="#" data-action="setAsWard">Set as Ward</a></li>
                                                        @endif
                                                        {{--<li><a href="#" data-action="editSettings">Edit Settings</a></li>--}}
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                            {{$patientWhoAdded->pivot->relationship_id?$relationships[$patientWhoAdded->pivot->relationship_id]->name:'Unidentified relationship'}}<br/>
                                            <b>DOB:</b> {{$patientWhoAdded->pivot->date_of_birth?\Carbon\Carbon::parse($patientWhoAdded->pivot->date_of_birth)->format('d-m-Y'):''}}<br/>
                                            <b>Created at:</b> {{$patientWhoAdded->created_at?$patientWhoAdded->created_at->format('d-m-Y h:i:s'):''}}<br/>
                                    </div>
                                </div>
                            </li>
                            <!-- /.item -->
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>



    @if(count($history) > 0)
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger" id="box_history">
                <div class="box-header">
                    <h3 class="box-title">
                        Edit History
                    </h3>
                </div>

                <div class="box-body">

                    {{--{!! $history !!}--}}

                    <ul class="timeline">
                        @foreach($history as $date => $dateData)
                            <li class="time-label">
                            <span class="bg-red">
                                {{$date}}
                            </span>
                            </li>

                            @foreach($dateData as $version)

                                @if($version->type == 'updated')
                                    <li>
                                        <i class="fa fa-pencil bg-blue"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> {{\Carbon\Carbon::parse($version->created_at)->format('h:i:s')}}</span>

                                            <h3 class="timeline-header">Someone changed patients details</h3>

                                            <div class="timeline-body">
                                                @if($version->diffs)
                                                    <table class="table table-bordered table-diffs">
                                                        <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>From</th>
                                                            <th>To</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($version->diffs as $diffKey => $diffValue)
                                                            <tr>
                                                                <th>{{$diffKey}}</th>
                                                                <td>{{$diffValue['previous']}}</td>
                                                                <td>{{$diffValue['current']}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>

                                                    </table>
                                                @endif
                                            </div>

                                            <div class="timeline-footer">
                                                {{--Some actions--}}
                                            </div>
                                        </div>
                                    </li>
                                @elseif($version->type == 'created')
                                    <li>
                                        <i class="fa fa-file-o bg-red"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> </span>

                                            <h3 class="timeline-header">Created at {{$patient->created_at->format('d-m-Y h:i:s')}}</h3>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        @endforeach

                        <li>
                            <i class="fa fa-clock-o bg-gray"></i>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
@stop



@push('scripts')
<script>
    $(function(){
        $('#table_appointments').DataTable();

        var modalEditTemplate = multiline(function(){/*!@preserve
            <form class="form" data-is-submitting="0">
                <input type="hidden" name="id" value="{{ $patient->id }}"/>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="first_name">First Name (*):</label>
                            <input type="text" name="first_name" id="modal_edit_patient__form__input_first_name" class="form-control" value="{{ $patient->first_name }}" placeholder="E.g. Swee Hock Peter, Ibrahim, Ravi"/>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="last_name">Last Name (*):</label>
                            <input type="text" name="last_name" id="modal_edit_patient__form__input_last_name" class="form-control" value="{{ $patient->last_name }}" placeholder="E.g. Wong, bin Salman, Singh" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="issue_country_id">National ID Issuing Country (*):</label>
                            <select class="form-control" name="issue_country_id">
                                <option value="">(Undetermined)</option>
                            {% for country in countries %}
                                <option value="@{{ country.id }}" {%if (country.id == '{{$patient->issue_country_id}}') %}selected{% endif %}>@{{country.nice_name}}</option>
                            {% endfor %}
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="id_number">National ID Number (*):</label>
                            <input type="text" name="id_number" id="modal_edit_patient__form__input_id_number" class="form-control" value="{{ $patient->id_number }}" placeholder="E.g. S3073167J, G9318256K, T4604526U" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth (*):</label>
                            <input class="form-control" name="date_of_birth" id="form_edit_patient__input_date_of_birth" value="{{$patient->date_of_birth?$patient->date_of_birth->format('d/m/Y'):''}}" placeholder="DD/MM/YYYY"/>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <p>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="gender_male" value="Male" {{strcasecmp($patient->gender, 'male') == 0?'checked':''}}/>
                                    Male
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="gender_female" value="Female" {{strcasecmp($patient->gender, 'female') == 0?'checked':''}}/>
                                    Female
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="gender_other" value="Other" {{strcasecmp($patient->gender, 'other') == 0?'checked':''}}/>
                                    Other
                                </label>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" name="email" id="modal_edit_patient__form__input_email" class="form-control" value="{{ $patient->email }}" placeholder="E.g. david@gmail.com" />
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="race">Race:</label>
                                <input type="text" name="race" id="modal_edit_patient__form__input_race" class="form-control" value="{{ $patient->race }}"/>
                            </div>
                        </div>
                    </div>
                </div>

                <label for="phone_number">Phone Number:</label>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <select class="form-control" name="phone_country_code" id="phone_country_code">
                                <option value="">(Undetermined)</option>
                            {% for country in countries %}
                                <option value="@{{ country.phone_country_code }}" {%if (country.phone_country_code == '{{$patient->phone_country_code}}') %}selected{% endif %}>@{{country.nice_name}} (@{{ country.phone_country_code }})</option>
                            {% endfor %}
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <input type="text" name="phone_number" id="modal_edit_patient__form__input_phone_number" class="form-control" value="{{ $patient->phone_number }}"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="address_block">Block:</label>
                            <input type="text" name="address_block" id="modal_edit_patient__form__input_address_block" class="form-control" value="{{ $patient->address_block }}"/>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="apartment_number">Apartment:</label>
                            <input type="text" name="apartment_number" id="modal_edit_patient__form__input_apartment_number" class="form-control" value="{{ $patient->apartment_number }}"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="address_street">Street:</label>
                            <input type="text" name="address_street" id="modal_edit_patient__form__input_address_street" class="form-control" value="{{ $patient->address_street }}"/>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="address_zip">Postal Code:</label>
                            <input type="text" name="address_zip" id="modal_edit_patient__form__input_address_zip" class="form-control" value="{{ $patient->address_zip }}"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="address_city">City:</label>
                            <input type="text" name="address_city" id="modal_edit_patient__form__input_address_city" class="form-control" value="{{ $patient->address_city }}"/>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="resident_country_id">Residence Country:</label>
                            <select class="form-control" name="resident_country_id">
                                <option value="">(Undetermined)</option>
                            {% for country in countries %}
                                <option value="@{{ country.id }}" {%if (country.id == '{{$patient->resident_country_id}}') %}selected{% endif %}>@{{country.nice_name}}</option>
                            {% endfor %}
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label">Medical Condition</label>
                    <textarea class="form-control vertical" name="medical_condition">{{$patient->medical_condition}}</textarea>
                </div>

                <div class="form-group">
                    <label class="control-label">Drug Allergy</label>
                    <textarea class="form-control vertical" name="drug_allergy">{{$patient->drug_allergy}}</textarea>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="deceased" id="deceased" value="1" {% if (1 == "{{$patient->deceased}}") %}checked{% endif %}/>
                                Mark as deceased
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="verified" id="verified" value="1" {% if (1 == "{{$patient->verified}}") %}checked{% endif %}/>
                                Mark as verified
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        */console.log});

        modalInfoTemplate = multiline(function(){/*!@preserve
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <th class="col-xs-4 text-right">Patient ID</th>
                        <td class="col-xs-8 cell-patient-id">@{{relative.pivot.patient_id}}</td>
                    </tr>
                    <tr>
                        <th class="text-right">First name</th>
                        <td class="cell-name">@{{ relative.pivot.first_name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Last name</th>
                        <td class="cell-alias">@{{ relative.pivot.last_name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Gender</th>
                        <td class="cell-race">@{{ relative.pivot.gender }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Date of Birth</th>
                        <td class="cell-country">@{{ relative.pivot.date_of_birth | formatTimestamp1}}</td>
                    </tr>
                    <tr>
                        <th class="text-right">National ID Number</th>
                        <td class="cell-id-number">@{{ relative.pivot.id_number }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Email</th>
                        <td class="cell-gender">@{{ relative.pivot.email }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Address</th>
                        <td class="cell-date-of-birth">@{{ relative.pivot.address}}</td>
                    </tr>
                </tbody>
            </table>
            <p><i>These information was input by user via manaDr Mobile Application.</i></p>
            */console.log})
        ;

        var fetchRelationship = function(patientId, relativeId){
            manaDrApplication.emit('window/loading/show');

                var request = $.ajax({
                    url: laroute.route('admin.patient.fetchRelationship', {patient: patientId, relative: relativeId}),
                    method: "POST",
                    dataType: "json"
                });

                request
                    .error(function(error){
                        var message;
                        if(error.responseJSON
                            && error.responseJSON.message
                            && error.responseJSON.message.length){
                            message = error.responseJSON.message;
                        } else {
                            message = 'Couldn\'t find patient with this ID in the system';
                        }
                        bootbox.alert(message);
                    })
                    .done(function(response){
                        relative = response;

                        var $modal = bootbox.dialog({
                            title: 'Patient Info',
                            message: swig.render(modalInfoTemplate, {
                                locals: {
                                    relative: relative
                                }
                            }),
                            className: 'modal-patient-info'
                        });

                        manaDrApplication.emit('window/loading/hide');
                    })
                ;
        }

        $('#box_info')
            .on('click', '[data-action=edit]', function(event){
                event.preventDefault();

                var message = swig.render(modalEditTemplate, {
                    locals: {
                        countries: {!! $countries->toJson() !!}
                    }
                });

                var $modal = bootbox.dialog({
                    title: 'Edit Patient Info',
                    message: message,
                    backdrop: true,
                    onEscape: true,
                    buttons: {
                        submit: {
                            label: 'Submit',
                            className: 'btn btn-primary',
                            callback: function(){
                                var $form = $(this).find('form');

                                $form.submit();

                                return false;
                            }
                        }
                    }
                });

                $modal
                    .on('shown.bs.modal', function() {
                        var $form = $modal.find('form');

                        $form.find('input').first().focus();

                        $form.find('[name="date_of_birth"]').datepicker({
                            format: 'dd/mm/yyyy',
                            weekStart: 1,
                            minViewMode: "month",
                            maxViewMode: "years",
                            orientation: "bottom",
                            disableTouchKeyboard: true,
                            autoclose: true,
                            defaultViewDate: {
                                year: 1980,
                                month: 0,
                                day: 1
                            },
                            startView: "years"
                        });

                        $form.validate({
                            rules: {
                                first_name: {
                                    required: true,
                                    minlength: 1,
                                    maxlength: 255
                                },

                                last_name: {
                                    required: true,
                                    minlength: 1,
                                    maxlength: 255
                                },

                                date_of_birth: {
                                    required: true,
                                    dateFormatDMY: true
                                },

                                email: {
                                    required: {
                                        depends: function(){
                                            var $this = $(this);
//                                $this.val($.trim($this.escapeHtml()));
                                            return $this.val().length;
                                        }
                                    },
                                    validateEmail: ''
                                },

                                phone_number: {
                                    number: true
                                },

                                issue_country_id: {
                                    required: true,
                                },

                                id_number: {
//                                    required: true
                                },

                                address_zip : {
                                    number: true
                                }
                            },
                            messages: {
                                email: {
                                    required: '',
                                    validateEmail: 'Invalid email format.'
                                }
                            },

                            errorElement: "p",
                            errorClass: "help-block",

                            errorPlacement: function(error, element) {
                                element.closest('div').append(error);
                            },

                            highlight: function(element) {
                                $(element).closest('.form-group').addClass('has-error');
                            },

                            unhighlight: function (element) {
                                $(element).closest('.form-group').removeClass('has-error');
                            },
                            submitHandler: function(form, event){
                                event.preventDefault();

                                var isSubmitting = parseInt($form.data('is-submitting'));

                                if(isSubmitting){
                                    return;
                                }

                                var formData = $(form).serialize();

                                showLoading();
                                $form.data('is-submitting', 1);
                                $modal.find(':input').prop('disabled', true);

                                var request = $.ajax({
                                    url: laroute.route("admin.patient.update", {patient: {{$patient->id}}}),
                                    method: "POST",
                                    data: formData,
                                    dataType: "json"
                                });

                                request
                                    .done(function(response) {
                                        var message = '';
                                        if(response
                                        && response.id){
                                            message =  'Patient info updated successfully!';
                                        } else {
                                            message = 'Request has been processed successfully.';
                                        }
                                        bootbox.alert(message, function(){
//                                            $modal.modal('hide');
//                                            hideLoading();
                                            window.location.reload();
                                        });
                                    })
                                    .fail(function(e, data) {
                                        var message = '';
                                        var template = multiline(function(){/*!@preserve
                                            <p>@{{message}}</p>
                                            {% if error|typeof === 'object' %}
                                            <ul>
                                            {% for key,value in error %}
                                                <li>@{{value}}</li>
                                            {% endfor %}
                                            </ul>
                                            {% endif %}
                                        */console.log});
                                        if(e
                                            && e.responseJSON
                                            && e.responseJSON.message
                                            && e.responseJSON.message.length){
                                            message = swig.render(template, {
                                                locals: e.responseJSON
                                            });
                                        } else {    message = 'The request cannot be processed';
                                        }
                                        bootbox.alert(message, function(){
                                            $form.data('is-submitting', 0);
                                            $modal.find(':input').prop('disabled', false);
                                            hideLoading();
                                        });
                                    })
                                    .always(function(){

                                    })
                                ;
                            }
                        });
                    })
                ;
            })
        ;

        $('#box_linked_patients')
            .on('click', '[data-action=showInfo]', function(event){
                event.preventDefault();
                var targetId = $(this).closest('.item[data-id]').data('id');

                if(!targetId){
                    return false;
                }

                fetchRelationship({{$patient->id}}, targetId);
            })
            .on('click', '[data-action=revokeGuardianship]', function(event){
                var $item = $(this).closest('.item[data-id]'),
                    targetId = $item.data('id'),
                    isWard = $item.data('is-ward')
                ;

                if(!targetId){
                    return false;
                }

                bootbox.confirm('Do you really want to revoke this guardianship?', function(result){
                    if(result){
                        manaDrApplication.emit('window/loading/show');

                        var url = '';

                        if(!isWard){
                            url = laroute.route("doctor.patient.revokeGuardianship", {patient: {{$patient->id}}, guardian: targetId});
                        } else {
                            url = laroute.route("doctor.patient.revokeGuardianship", {patient: targetId, guardian: {{$patient->id}}});
                        }

                        var request = $.ajax({
                            url: url,
                            method: "POST"
                        });

                        request
                            .done(function(response) {
                                window.location.reload();
                            })
                            .fail(function(e, data) {
                                var message = '';
                                if(e
                                    && e.responseJSON
                                    && e.responseJSON.message
                                    && e.responseJSON.message.length){
                                    message = e.responseJSON.message;
                                } else {
                                    message = 'The request cannot be processed';
                                }
                                bootbox.alert(message, function(){
                                    manaDrApplication.emit('window/loading/hide');
                                });
                            })
                            .always(function(){

                            })
                        ;
                    }
                })
            })
            .on('click', '[data-action=setAsGuardian]', function(event){
                var targetId = $(this).closest('.item[data-id]').data('id');

                if(!targetId){
                    return false;
                }

                manaDrApplication.emit('window/loading/show');

                var ward = {},
                    guardian = {}
                ;

                var request1 = $.ajax({
                    url: laroute.route('admin.patient.fetch', {patient: {{$patient->id}}}),
                    method: "POST",
                    dataType: "json"
                });

                request1
                    .error(function(error){
                        var message;
                        if(error.responseJSON
                            && error.responseJSON.message
                            && error.responseJSON.message.length){
                            message = error.responseJSON.message;
                        } else {
                            message = 'Couldn\'t find patient with this ID in the system';
                        }
                        bootbox.alert(message);
                    })
                    .done(function(response){
                        ward = response;
                    })
                ;

                var request2 = $.ajax({
                    url: laroute.route('admin.patient.fetch', {patient: targetId}),
                    method: "POST",
                    dataType: "json"
                });

                request2
                    .error(function(error){
                        var message;
                        if(error.responseJSON
                            && error.responseJSON.message
                            && error.responseJSON.message.length){
                            message = error.responseJSON.message;
                        } else {
                            message = 'Couldn\'t find patient with this ID in the system';
                        }
                        bootbox.alert(message);
                    })
                    .done(function(response){
                        guardian = response;
                    })
                ;

                $
                    .when(request1, request2)
                    .done(function(){
                        var template = multiline(function(){/*!@preserve
                        <table class="table table-bordered text-center" id="table_set_relationship">
                        <thead>
                            <tr>
                                <th class="col-xs-2"></th>
                                <th class="col-xs-5 text-center">Ward</th>
                                <th class="col-xs-5 text-center">Guardian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-right">Patient ID</th>
                                <td class="cell-ward cell-patient-id">@{{ward.id}}</td>
                                <td class="cell-guardian cell-patient-id">@{{guardian.id}}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Name</th>
                                <td class="cell-ward cell-name">@{{ ward.first_name }} <b>@{{ ward.last_name }}</b></td>
                                <td class="cell-guardian cell-name">@{{ guardian.first_name }} <b>@{{ guardian.last_name }}</b></td>
                            </tr>
                            <tr>
                                <th class="text-right">Alias</th>
                                <td class="cell-ward cell-alias">@{{ ward.alias }}</td>
                                <td class="cell-guardian cell-alias">@{{ guardian.alias }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Gender</th>
                                <td class="cell-ward cell-gender">@{{ ward.gender }}</td>
                                <td class="cell-guardian cell-gender">@{{ guardian.gender }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Date of Birth</th>
                                <td class="cell-ward cell-date-of-birth">@{{ ward.date_of_birth | formatTimestamp1 }}</td>
                                <td class="cell-guardian cell-date-of-birth">@{{ guardian.date_of_birth | formatTimestamp1 }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Race</th>
                                <td class="cell-ward cell-race">@{{ ward.race }}</td>
                                <td class="cell-guardian cell-race">@{{ guardian.race }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Country</th>
                                <td class="cell-ward cell-country">@{{ ward.country.nice_name }}</td>
                                <td class="cell-guardian cell-country">@{{ guardian.country.nice_name }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">National ID Number</th>
                                <td class="cell-ward cell-id-number">@{{ ward.id_number }}</td>
                                <td class="cell-guardian cell-id-number">@{{ guardian.id_number }}</td>
                            </tr>
                            {{--<tr>--}}
                                {{--<th class="text-right">MRID</th>--}}
                                {{--<td class="cell-ward cell-mrid">@{{ ward.medical_record_number }}</td>--}}
                                {{--<td class="cell-guardian cell-mrid">@{{ guardian.medical_record_number }}</td>--}}
                            {{--</tr>--}}
                            <tr>
                                <th class="text-right">Reason for assigning</th>
                                <td colspan="2" class="cell-description">
                                    <textarea class="form-control" style="resize:vertical" placeholder="(optional)"></textarea>
                                </td>
                            </tr>
                        </tbody>
                        </div>
                        */console.log});

                        var buttons = {
                            'Set': {
                                label: 'Set',
                                className: 'btn btn-primary',
                                callback: function(event){
                                    event.preventDefault();

                                    $modal.find(':input').prop('disabled', true);
                                    manaDrApplication.emit('window/loading/show');

                                    var request = $.ajax({
                                        url: laroute.route("admin.patient.setGuardianship", {patient: {{$patient->id}}, guardian: targetId}),
                                        method: "POST",
                                        data: {
                                            description: $modal.find('.cell-description textarea').val()
                                        },
                                        dataType: "json"
                                    });

                                    request
                                        .done(function(response) {
                                            window.location.reload();
                                        })
                                        .fail(function(e, data) {
                                            var message = '';
                                            if(e
                                                && e.responseJSON
                                                && e.responseJSON.message
                                                && e.responseJSON.message.length){
                                                message = e.responseJSON.message;
                                            } else {
                                                message = 'The request cannot be processed';
                                            }
                                            bootbox.alert(message, function(){
                                                $modal.find(':input').prop('disabled', false);
                                                manaDrApplication.emit('window/loading/hide');
                                            });
                                        })
                                        .always(function(){

                                        })
                                    ;
                                }
                            },
                            'Cancel': {
                                label: 'Cancel',
                                className: 'btn btn-default'
                            }
                        }

                        var $modal = bootbox.dialog({
                            title: 'Please review the info carefully',
                            message: swig.render(template, {
                                locals: {
                                    ward: ward,
                                    guardian: guardian
                                }
                            }),
                            className: 'modal-set-guardianship',
                            size: 'large',
                            buttons: buttons
                        });
                    })
                    .always(function(){
                        manaDrApplication.emit('window/loading/hide')
                    })
                ;
            })
            .on('click', '[data-action=setAsWard]', function(event){
                var targetId = $(this).closest('.item[data-id]').data('id');

                if(!targetId){
                    return false;
                }

                manaDrApplication.emit('window/loading/show');

                var ward = {},
                    guardian = {}
                ;

                var request1 = $.ajax({
                    url: laroute.route('doctor.patient.fetch', {patient: targetId}),
                    method: "POST",
                    dataType: "json"
                });

                request1
                    .error(function(error){
                        var message;
                        if(error.responseJSON
                            && error.responseJSON.message
                            && error.responseJSON.message.length){
                            message = error.responseJSON.message;
                        } else {
                            message = 'Couldn\'t find patient with this ID in the system';
                        }
                        bootbox.alert(message);
                    })
                    .done(function(response){
                        ward = response;
                        console.log(1, response);
                    })
                ;

                var request2 = $.ajax({
                    url: laroute.route('doctor.patient.fetch', {patient: {{$patient->id}}}),
                    method: "POST",
                    dataType: "json"
                });

                request2
                    .error(function(error){
                        var message;
                        if(error.responseJSON
                            && error.responseJSON.message
                            && error.responseJSON.message.length){
                            message = error.responseJSON.message;
                        } else {
                            message = 'Couldn\'t find patient with this ID in the system';
                        }
                        bootbox.alert(message);
                    })
                    .done(function(response){
                        guardian = response;
                        console.log(2, response);
                    })
                ;

                $
                    .when(request1, request2)
                    .done(function(){
                        var template = multiline(function(){/*!@preserve
                        <table class="table table-bordered text-center" id="table_set_relationship">
                        <thead>
                            <tr>
                                <th class="col-xs-2"></th>
                                <th class="col-xs-5 text-center">Ward</th>
                                <th class="col-xs-5 text-center">Guardian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-right">Patient ID</th>
                                <td class="cell-ward cell-patient-id">@{{ward.id}}</td>
                                <td class="cell-guardian cell-patient-id">@{{guardian.id}}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Name</th>
                                <td class="cell-ward cell-name">@{{ ward.first_name }} <b>@{{ ward.last_name }}</b></td>
                                <td class="cell-guardian cell-name">@{{ guardian.first_name }} <b>@{{ guardian.last_name }}</b></td>
                            </tr>
                            <tr>
                                <th class="text-right">Alias</th>
                                <td class="cell-ward cell-alias">@{{ ward.alias }}</td>
                                <td class="cell-guardian cell-alias">@{{ guardian.alias }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Gender</th>
                                <td class="cell-ward cell-gender">@{{ ward.gender }}</td>
                                <td class="cell-guardian cell-gender">@{{ guardian.gender }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Date of Birth</th>
                                <td class="cell-ward cell-date-of-birth">@{{ ward.date_of_birth | formatTimestamp1 }}</td>
                                <td class="cell-guardian cell-date-of-birth">@{{ guardian.date_of_birth | formatTimestamp1 }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Race</th>
                                <td class="cell-ward cell-race">@{{ ward.race }}</td>
                                <td class="cell-guardian cell-race">@{{ guardian.race }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Country</th>
                                <td class="cell-ward cell-country">@{{ ward.country.nice_name }}</td>
                                <td class="cell-guardian cell-country">@{{ guardian.country.nice_name }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">National ID Number</th>
                                <td class="cell-ward cell-id-number">@{{ ward.id_number }}</td>
                                <td class="cell-guardian cell-id-number">@{{ guardian.id_number }}</td>
                            </tr>
                            {{--<tr>--}}
                                {{--<th class="text-right">MRID</th>--}}
                                {{--<td class="cell-ward cell-mrid">@{{ ward.medical_record_number }}</td>--}}
                                {{--<td class="cell-guardian cell-mrid">@{{ guardian.medical_record_number }}</td>--}}
                            {{--</tr>--}}
                            <tr>
                                <th class="text-right">Reason for assigning</th>
                                <td colspan="2" class="cell-description">
                                    <textarea class="form-control" style="resize:vertical" placeholder="(optional)"></textarea>
                                </td>
                            </tr>
                        </tbody>
                        </div>
                        */console.log});

                        var buttons = {
                            'Set': {
                                label: 'Set',
                                className: 'btn btn-primary',
                                callback: function(event) {
                                    event.preventDefault();

                                    $modal.find(':input').prop('disabled', true);
                                    manaDrApplication.emit('window/loading/show');

                                    var request = $.ajax({
                                        url: laroute.route("doctor.patient.setGuardianship", {patient: targetId, guardian: {{$patient->id}}}),
                                        method: "POST",
                                        data: {
                                            description: $modal.find('.cell-description textarea').val()
                                        },
                                        dataType: "json"
                                    });

                                    request
                                        .done(function(response) {
                                            window.location.reload();
                                        })
                                        .fail(function(e, data) {
                                            var message = '';
                                            if(e
                                                && e.responseJSON
                                                && e.responseJSON.message
                                                && e.responseJSON.message.length){
                                                message = e.responseJSON.message;
                                            } else {
                                                message = 'The request cannot be processed';
                                            }
                                            bootbox.alert(message, function(){
                                                $modal.find(':input').prop('disabled', false);
                                                manaDrApplication.emit('window/loading/hide');
                                            });
                                        })
                                        .always(function(){

                                        })
                                    ;
                                }
                            },
                            'Cancel': {
                                label: 'Cancel',
                                className: 'btn btn-default'
                            }
                        }

                        var $modal = bootbox.dialog({
                            title: 'Please review the info carefully',
                            message: swig.render(template, {
                                locals: {
                                    ward: ward,
                                    guardian: guardian
                                }
                            }),
                            className: 'modal-set-guardianship',
                            size: 'large',
                            buttons: buttons
                        });
                    })
                    .always(function(){
                        manaDrApplication.emit('window/loading/hide')
                    })
                ;
            })
        ;

        $('#box_patient_who_added')
            .on('click', '[data-action=showInfo]', function(event){
                event.preventDefault();
                var targetId = $(this).closest('.item[data-id]').data('id');

                if(!targetId){
                    return false;
                }

                fetchRelationship(targetId, {{$patient->id}});
            })
            .on('click', '[data-action=revokeGuardianship]', function(event){
                var $item = $(this).closest('.item[data-id]'),
                    targetId = $item.data('id'),
                    isWard = $item.data('is-ward')
                ;

                if(!targetId){
                    return false;
                }

                bootbox.confirm('Do you really want to revoke this guardianship?', function(result){
                    if(result){
                        manaDrApplication.emit('window/loading/show');

                        var url = '';

                        if(!isWard){
                            url = laroute.route("doctor.patient.revokeGuardianship", {patient: {{$patient->id}}, guardian: targetId});
                        } else {
                            url = laroute.route("doctor.patient.revokeGuardianship", {patient: targetId, guardian: {{$patient->id}}});
                        }

                        var request = $.ajax({
                            url: url,
                            method: "POST"
                        });

                        request
                            .done(function(response) {
                                window.location.reload();
                            })
                            .fail(function(e, data) {
                                var message = '';
                                if(e
                                    && e.responseJSON
                                    && e.responseJSON.message
                                    && e.responseJSON.message.length){
                                    message = e.responseJSON.message;
                                } else {
                                    message = 'The request cannot be processed';
                                }
                                bootbox.alert(message, function(){
                                    manaDrApplication.emit('window/loading/hide');
                                });
                            })
                            .always(function(){

                            })
                        ;
                    }
                })
            })
            .on('click', '[data-action=setAsGuardian]', function(event){
                var targetId = $(this).closest('.item[data-id]').data('id');

                if(!targetId){
                    return false;
                }

                manaDrApplication.emit('window/loading/show');

                var ward = {},
                    guardian = {}
                ;

                var request1 = $.ajax({
                    url: laroute.route('admin.patient.fetch', {patient: {{$patient->id}}}),
                    method: "POST",
                    dataType: "json"
                });

                request1
                    .error(function(error){
                        var message;
                        if(error.responseJSON
                            && error.responseJSON.message
                            && error.responseJSON.message.length){
                            message = error.responseJSON.message;
                        } else {
                            message = 'Couldn\'t find patient with this ID in the system';
                        }
                        bootbox.alert(message);
                    })
                    .done(function(response){
                        ward = response;
                    })
                ;

                var request2 = $.ajax({
                    url: laroute.route('admin.patient.fetch', {patient: targetId}),
                    method: "POST",
                    dataType: "json"
                });

                request2
                    .error(function(error){
                        var message;
                        if(error.responseJSON
                            && error.responseJSON.message
                            && error.responseJSON.message.length){
                            message = error.responseJSON.message;
                        } else {
                            message = 'Couldn\'t find patient with this ID in the system';
                        }
                        bootbox.alert(message);
                    })
                    .done(function(response){
                        guardian = response;
                    })
                ;

                $
                    .when(request1, request2)
                    .done(function(){
                        var template = multiline(function(){/*!@preserve
                        <table class="table table-bordered text-center" id="table_set_relationship">
                        <thead>
                            <tr>
                                <th class="col-xs-2"></th>
                                <th class="col-xs-5 text-center">Ward</th>
                                <th class="col-xs-5 text-center">Guardian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-right">Patient ID</th>
                                <td class="cell-ward cell-patient-id">@{{ward.id}}</td>
                                <td class="cell-guardian cell-patient-id">@{{guardian.id}}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Name</th>
                                <td class="cell-ward cell-name">@{{ ward.first_name }} <b>@{{ ward.last_name }}</b></td>
                                <td class="cell-guardian cell-name">@{{ guardian.first_name }} <b>@{{ guardian.last_name }}</b></td>
                            </tr>
                            <tr>
                                <th class="text-right">Alias</th>
                                <td class="cell-ward cell-alias">@{{ ward.alias }}</td>
                                <td class="cell-guardian cell-alias">@{{ guardian.alias }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Gender</th>
                                <td class="cell-ward cell-gender">@{{ ward.gender }}</td>
                                <td class="cell-guardian cell-gender">@{{ guardian.gender }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Date of Birth</th>
                                <td class="cell-ward cell-date-of-birth">@{{ ward.date_of_birth | formatTimestamp1 }}</td>
                                <td class="cell-guardian cell-date-of-birth">@{{ guardian.date_of_birth | formatTimestamp1 }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Race</th>
                                <td class="cell-ward cell-race">@{{ ward.race }}</td>
                                <td class="cell-guardian cell-race">@{{ guardian.race }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Country</th>
                                <td class="cell-ward cell-country">@{{ ward.country.nice_name }}</td>
                                <td class="cell-guardian cell-country">@{{ guardian.country.nice_name }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">National ID Number</th>
                                <td class="cell-ward cell-id-number">@{{ ward.id_number }}</td>
                                <td class="cell-guardian cell-id-number">@{{ guardian.id_number }}</td>
                            </tr>
                            {{--<tr>--}}
                                {{--<th class="text-right">MRID</th>--}}
                                {{--<td class="cell-ward cell-mrid">@{{ ward.medical_record_number }}</td>--}}
                                {{--<td class="cell-guardian cell-mrid">@{{ guardian.medical_record_number }}</td>--}}
                            {{--</tr>--}}
                            <tr>
                                <th class="text-right">Reason for assigning</th>
                                <td colspan="2" class="cell-description">
                                    <textarea class="form-control" style="resize:vertical" placeholder="(optional)"></textarea>
                                </td>
                            </tr>
                        </tbody>
                        </div>
                        */console.log});

                        var buttons = {
                            'Set': {
                                label: 'Set',
                                className: 'btn btn-primary',
                                callback: function(event){
                                    event.preventDefault();

                                    $modal.find(':input').prop('disabled', true);
                                    manaDrApplication.emit('window/loading/show');

                                    var request = $.ajax({
                                        url: laroute.route("admin.patient.setGuardianship", {patient: {{$patient->id}}, guardian: targetId}),
                                        method: "POST",
                                        data: {
                                            description: $modal.find('.cell-description textarea').val()
                                        },
                                        dataType: "json"
                                    });

                                    request
                                        .done(function(response) {
                                            window.location.reload();
                                        })
                                        .fail(function(e, data) {
                                            var message = '';
                                            if(e
                                                && e.responseJSON
                                                && e.responseJSON.message
                                                && e.responseJSON.message.length){
                                                message = e.responseJSON.message;
                                            } else {
                                                message = 'The request cannot be processed';
                                            }
                                            bootbox.alert(message, function(){
                                                $modal.find(':input').prop('disabled', false);
                                                manaDrApplication.emit('window/loading/hide');
                                            });
                                        })
                                        .always(function(){

                                        })
                                    ;
                                }
                            },
                            'Cancel': {
                                label: 'Cancel',
                                className: 'btn btn-default'
                            }
                        }

                        var $modal = bootbox.dialog({
                            title: 'Please review the info carefully',
                            message: swig.render(template, {
                                locals: {
                                    ward: ward,
                                    guardian: guardian
                                }
                            }),
                            className: 'modal-set-guardianship',
                            size: 'large',
                            buttons: buttons
                        });
                    })
                    .always(function(){
                        manaDrApplication.emit('window/loading/hide')
                    })
                ;
            })
            .on('click', '[data-action=setAsWard]', function(event){
                var targetId = $(this).closest('.item[data-id]').data('id');

                if(!targetId){
                    return false;
                }

                manaDrApplication.emit('window/loading/show');

                var ward = {},
                    guardian = {}
                ;

                var request1 = $.ajax({
                    url: laroute.route('doctor.patient.fetch', {patient: targetId}),
                    method: "POST",
                    dataType: "json"
                });

                request1
                    .error(function(error){
                        var message;
                        if(error.responseJSON
                            && error.responseJSON.message
                            && error.responseJSON.message.length){
                            message = error.responseJSON.message;
                        } else {
                            message = 'Couldn\'t find patient with this ID in the system';
                        }
                        bootbox.alert(message);
                    })
                    .done(function(response){
                        ward = response;
                        console.log(1, response);
                    })
                ;

                var request2 = $.ajax({
                    url: laroute.route('doctor.patient.fetch', {patient: {{$patient->id}}}),
                    method: "POST",
                    dataType: "json"
                });

                request2
                    .error(function(error){
                        var message;
                        if(error.responseJSON
                            && error.responseJSON.message
                            && error.responseJSON.message.length){
                            message = error.responseJSON.message;
                        } else {
                            message = 'Couldn\'t find patient with this ID in the system';
                        }
                        bootbox.alert(message);
                    })
                    .done(function(response){
                        guardian = response;
                        console.log(2, response);
                    })
                ;

                $
                    .when(request1, request2)
                    .done(function(){
                        var template = multiline(function(){/*!@preserve
                        <table class="table table-bordered text-center" id="table_set_relationship">
                        <thead>
                            <tr>
                                <th class="col-xs-2"></th>
                                <th class="col-xs-5 text-center">Ward</th>
                                <th class="col-xs-5 text-center">Guardian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-right">Patient ID</th>
                                <td class="cell-ward cell-patient-id">@{{ward.id}}</td>
                                <td class="cell-guardian cell-patient-id">@{{guardian.id}}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Name</th>
                                <td class="cell-ward cell-name">@{{ ward.first_name }} <b>@{{ ward.last_name }}</b></td>
                                <td class="cell-guardian cell-name">@{{ guardian.first_name }} <b>@{{ guardian.last_name }}</b></td>
                            </tr>
                            <tr>
                                <th class="text-right">Alias</th>
                                <td class="cell-ward cell-alias">@{{ ward.alias }}</td>
                                <td class="cell-guardian cell-alias">@{{ guardian.alias }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Gender</th>
                                <td class="cell-ward cell-gender">@{{ ward.gender }}</td>
                                <td class="cell-guardian cell-gender">@{{ guardian.gender }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Date of Birth</th>
                                <td class="cell-ward cell-date-of-birth">@{{ ward.date_of_birth | formatTimestamp1 }}</td>
                                <td class="cell-guardian cell-date-of-birth">@{{ guardian.date_of_birth | formatTimestamp1 }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Race</th>
                                <td class="cell-ward cell-race">@{{ ward.race }}</td>
                                <td class="cell-guardian cell-race">@{{ guardian.race }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Country</th>
                                <td class="cell-ward cell-country">@{{ ward.country.nice_name }}</td>
                                <td class="cell-guardian cell-country">@{{ guardian.country.nice_name }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">National ID Number</th>
                                <td class="cell-ward cell-id-number">@{{ ward.id_number }}</td>
                                <td class="cell-guardian cell-id-number">@{{ guardian.id_number }}</td>
                            </tr>
                            {{--<tr>--}}
                                {{--<th class="text-right">MRID</th>--}}
                                {{--<td class="cell-ward cell-mrid">@{{ ward.medical_record_number }}</td>--}}
                                {{--<td class="cell-guardian cell-mrid">@{{ guardian.medical_record_number }}</td>--}}
                            {{--</tr>--}}
                            <tr>
                                <th class="text-right">Reason for assigning</th>
                                <td colspan="2" class="cell-description">
                                    <textarea class="form-control" style="resize:vertical" placeholder="(optional)"></textarea>
                                </td>
                            </tr>
                        </tbody>
                        </div>
                        */console.log});

                        var buttons = {
                            'Set': {
                                label: 'Set',
                                className: 'btn btn-primary',
                                callback: function(event) {
                                    event.preventDefault();

                                    $modal.find(':input').prop('disabled', true);
                                    manaDrApplication.emit('window/loading/show');

                                    var request = $.ajax({
                                        url: laroute.route("doctor.patient.setGuardianship", {patient: targetId, guardian: {{$patient->id}}}),
                                        method: "POST",
                                        data: {
                                            description: $modal.find('.cell-description textarea').val()
                                        },
                                        dataType: "json"
                                    });

                                    request
                                        .done(function(response) {
                                            window.location.reload();
                                        })
                                        .fail(function(e, data) {
                                            var message = '';
                                            if(e
                                                && e.responseJSON
                                                && e.responseJSON.message
                                                && e.responseJSON.message.length){
                                                message = e.responseJSON.message;
                                            } else {
                                                message = 'The request cannot be processed';
                                            }
                                            bootbox.alert(message, function(){
                                                $modal.find(':input').prop('disabled', false);
                                                manaDrApplication.emit('window/loading/hide');
                                            });
                                        })
                                        .always(function(){

                                        })
                                    ;
                                }
                            },
                            'Cancel': {
                                label: 'Cancel',
                                className: 'btn btn-default'
                            }
                        }

                        var $modal = bootbox.dialog({
                            title: 'Please review the info carefully',
                            message: swig.render(template, {
                                locals: {
                                    ward: ward,
                                    guardian: guardian
                                }
                            }),
                            className: 'modal-set-guardianship',
                            size: 'large',
                            buttons: buttons
                        });
                    })
                    .always(function(){
                        manaDrApplication.emit('window/loading/hide')
                    })
                ;
            })
        ;

        $('#table_appointments')
            .on('click', '[data-action=sendMessage]', function(event){
                event.preventDefault();

                var appointmentId = $(this).closest('tr').data('id');

                manaDrApplication.emit('modalSendAppointmentMessage/show', {
                    appointmentId: appointmentId
                })
            })
        ;
    });



</script>
@endpush
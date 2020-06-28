@extends('legacy.layouts.admin.application')

@section('pageTitle')User {{$user->name}}@stop

@section('header')
    {{$user->name}}
@stop

@section('subheader')
{{--    {{ucfirst($user->clinicType->name)}}--}}
@stop

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="box box-solid" id="box_info">
                <div class="box-header">
                    {{--<div class="box-tools pull-right">--}}
                        {{--<button class="btn btn-box-tool" data-action="edit">--}}
                            {{--<i href="#" class="fa fa-edit"></i>--}}
                        {{--</button>--}}

                    {{--</div>--}}
                    <h3 class="box-title">Information</h3>
                </div>

                <div class="box-body">
					<dl class="dl-horizontal">
                        <dt>Name</dt>
                        <dd><b>{{$user->first_name}}</b> {{$user->last_name}}</dd>

                        <dt>Gender</dt>
                        <dd>{{$user->gender}}</dd>

                        <dt>Date of Birth</dt>
                        <dd>
                            {{($user->date_of_birth)?\Carbon\Carbon::createFromFormat('Y-m-d', $user->date_of_birth)->format('d/m/Y'):''}}
                        </dd>

                        <dt>National ID Number</dt>
                        <dd>
                            {{$user->national_id_number}}
                        </dd>

                        <dt>Contact Email</dt>
                        <dd>
                            <a href="mailto:{{$user->email}}">{{$user->email}}</a>
                        </dd>

                        <dt>Phone Number</dt>
                        <dd>
                            {{$user->phone_country_code?'('.$user->phone_country_code.')':''}}
                            {{$user->phone_number}}
                        </dd>

                        <dt>Address</dt>
                        <dd>
                            {{$user->address_street}}
                        @if($user->address_street && $user->address_city)
                            ,
                        @endif
                            <span class="text-muted">{{$user->address_city}}</span>
                        </dd>

                        <dt>Country</dt>
                        <dd>
                            {{$user->country?$user->country->nice_name:''}}
                        </dd>

                        <dt>Zip Code</dt>
                        <dd>
                            {{$user->address_zip}}
                        </dd>
				    </dl>
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
                    <h3 class="box-title">Linked Patient(s)</h3>
                </div>

                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                    @foreach($user->patients as $linkedPatient)
                        <li class="item" data-id="{{$linkedPatient->id}}">
                            <div class="product-img">
                              <img
                                  src="{{($linkedPatient->profileImage)?$linkedPatient->profileImage->getThumbnailUrl():$linkedPatient->getDefaultAvatarUrl($linkedPatient->gender)}}"
                                  alt="{{($linkedPatient->profileImage)?$linkedPatient->name:"No image"}}"
                              >
                            </div>
                            <div class="product-info">
                                <a href="{{ route('admin.patient.details', $linkedPatient->id) }}" class="product-title">{{$linkedPatient->getFullname()}}
                                @if($linkedPatient->title)
                                    <span class="label label-warning pull-right">{{$linkedPatient->title->title}}</span>
                                @endif
                                </a>
                                <div class="product-description" style="overflow: visible">
                                    {{--<div class="pull-right">--}}
                                        {{--<div class="btn-group">--}}
                                            {{--<button aria-expanded="false" type="button" class="btn btn-box-tool dropdown-toggle"--}}
                                                    {{--data-toggle="dropdown">--}}
                                                {{--<i class="fa fa-pencil"></i></button>--}}
                                            {{--<ul class="dropdown-menu" role="menu" style="right:0;left:auto;">--}}
                                                {{--<li><a href="#" data-action="unassign">Unassign from Clinic</a></li>--}}
                                                {{--<li><a href="#" data-action="editSettings">Edit Settings</a></li>--}}
                                            {{--</ul>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{$linkedPatient->pivot->relationship_id?$relationships[$linkedPatient->pivot->relationship_id]->name:'Unidentified relationship'}}<br/>
                                  <b>Created at:</b> {{$linkedPatient->created_at?$linkedPatient->created_at->format('d-m-Y h:i:s'):''}}
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

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info" id="box_appointments">
                <div class="box-header">
                    <h3 class="box-title">Appointments</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-hover" id="table_appointments">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Doctor</th>
                            <th>Clinic</th>
                            <th>Booking User</th>
                            <th>Status</th>
                            <th>Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->appointments as $appointment)
                            <tr data-id="{{$appointment->id}}">
                                <td>
                                    {{$appointment->id}}
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
                                    @if($appointment->user)
                                        <a {{--href="{{ route('admin.user.details', $appointment->user->id) }}"--}}>
                                            {{$appointment->user->getFullname()}}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                @if($appointment->appointmentStatus)
                                    <span class="label" data-type="appointment-type" data-name="{{$appointment->appointmentStatus->name}}">{{$appointment->appointmentStatus->name}}</span>
                                @endif
                                </td>
                                <td>
                                @if($appointment->doctorTimetable)
                                    {{$appointment->doctorTimetable->start_at->format('d/m/Y')}}
                                    {{$appointment->doctorTimetable->start_at->tz('UTC')->setTimezone(($appointment->doctorTimetable->clinic)?$appointment->doctorTimetable->clinic->time_zone:'UTC')->format('H:i')}}
                                    -
                                    {{$appointment->doctorTimetable->end_at->setTimezone(($appointment->doctorTimetable->clinic)?$appointment->doctorTimetable->clinic->time_zone:'UTC')->format('H:i P')}}
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
@stop



@push('scripts')
<script>
    $(function(){
        $('#table_appointments').DataTable();
    })
</script>
@endpush
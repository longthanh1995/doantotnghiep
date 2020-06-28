@extends('legacy.layouts.admin.application')

@section('pageTitle', 'Manage Appointments')

@section('header', 'Recent Appointments')

@section('subheader', ' ')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                {{--<div class="box-header">--}}
                    {{--<h3 class="box-title">Recent Appointments</h3>--}}
                {{--</div>--}}

                <div class="box-body table-responsive">
                    <table class="table table-responsive" id="table_appointments">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Type</th>
                            <th>Doctor</th>
                            <th>Clinic</th>
                            <th>Status</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($appointments as $appointment)
                            <tr data-id="{{$appointment->id}}">
                                <td>
                                    {{$appointment->id}}
                                </td>
                                <td>
                                    @if($appointment->book_source == 'M')
                                        <i class="fa fa-fw fa-mobile"></i>
                                    @endif
                                    {{$appointment->patient?$appointment->patient->first_name:''}}
                                    <b>{{$appointment->patient?$appointment->patient->last_name:''}}</b>
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
                                    @if($appointment->doctorTimetable)
                                        {{$appointment->doctorTimetable->start_at->format('d/m/Y')}}
                                        {{$appointment->doctorTimetable->start_at->tz('UTC')->setTimezone(($appointment->doctorTimetable->clinic)?$appointment->doctorTimetable->clinic->time_zone:'UTC')->format('H:i')}}
                                        -
                                        {{$appointment->doctorTimetable->end_at->setTimezone(($appointment->doctorTimetable->clinic)?$appointment->doctorTimetable->clinic->time_zone:'UTC')->format('H:i P')}}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('admin.appointment.details', $appointment->id)}}" class="btn btn-xs btn-default">
                                        <i class="fa fa-info"></i>
                                        Info
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    @if($appointments->total() > $appointments->perPage())
                        <tfoot>
                        <tr>
                            <td colspan="9" class="text-center">
                                {{$appointments->links()}}
                                <style>
                                    .pagination{
                                        margin-bottom: 0;
                                    }
                                </style>
                            </td>
                        </tr>
                        </tfoot>
                    @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('doctor.layouts.base')

@section('pageTitle'){{$authDoctor->name}} - No-show Appointments @stop

@section('bodyClass', 'page-appointments')

@section('contentHeader', 'Not Showing Up Appointments')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a>Appointments</a></li>
        <li class="active">Not Showing Up</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('doctor.pages.appointments.partials.filters', [
                'doctorClinicsOption' => $doctorClinicsOption
            ])
        </div>

        <div class="col-md-8">
            @include('doctor.pages.appointments.partials.appointmentsList', [
                'appointments' => $appointments,
                'type' => 'cancelledBooking'
            ])
        </div>
    </div>
@stop
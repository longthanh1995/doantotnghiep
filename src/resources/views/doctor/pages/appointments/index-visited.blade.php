@extends('doctor.layouts.base')

@section('pageTitle'){{$authDoctor->name}} - Visited Appointments @stop

@section('bodyClass', 'page-appointments')

@section('contentHeader', 'Visited Appointments')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a>Appointments</a></li>
        <li class="active">Visited</li>
    </ol>
@stop

@section('content')
    <div class="row">
    @if(!request()->get('print'))
        <div class="col-md-4">
            @include('doctor.pages.appointments.partials.filters', [
                'doctorClinicsOption' => $doctorClinicsOption
            ])
        </div>
    @endif

        <div class="col-md-8">
            @include('doctor.pages.appointments.partials.appointmentsList', [
                'appointments' => $appointments,
                'type' => 'visitedBooking'
            ])
        </div>
    </div>
@stop
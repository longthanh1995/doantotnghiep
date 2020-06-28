@extends('doctor.layouts.base')

@section('pageTitle'){{$authDoctor->name}} - Home @stop

@section('bodyClass', 'page-dashboard page-dashboard-index')

@section('contentHeader', 'This week')

@section('contentHeaderSub')
    These statistics of each clinics are limited to you
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active"><a><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
    @foreach($statistics['clinics'] as $clinic)
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title">
                    {{$clinic['info']?$clinic['info']['name']:''}}
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div href="#" class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">New Appointments</span>
                                <span class="info-box-number">
                                    {{$clinic['statistics']['numberOfNewAppointments']}}
                                </span>
                                <span class="progress-description">
                                @if($clinic['statistics']['numberOfNewAppointmentsMadeFromApp'])
                                    <i class="fa fa-mobile"></i>
                                    {{$clinic['statistics']['numberOfNewAppointmentsMadeFromApp']}} made from app
                                @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="info-box bg-teal" href="{{route('doctor.patient.index')}}">
                            <span class="info-box-icon"><i class="fa fa-file-text"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">New Patient Records</span>
                                <span class="info-box-number">
                                    {{$clinic['statistics']['numberOfNewPatients']}}
                                </span>
                                <span class="progress-description">
                                @if($clinic['statistics']['numberOfNewPatientsUsingApp'])
                                    <i class="fa fa-mobile"></i>
                                    {{$clinic['statistics']['numberOfNewPatientsUsingApp']}} using app
                                @endif
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <p class="text-muted text-italic">The statistics will be recalculated every 4 hours</p>
    </div>
</div>
@stop
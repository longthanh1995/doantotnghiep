@extends('legacy.layouts.admin.application')

@section('pageTitle', 'Home')

@section('content')
    <div class="row">
        <div class="col-sm-3">
            <a class="info-box" href="{{route('admin.clinic')}}">
                <span class="info-box-icon bg-aqua"><i class="fa fa-building"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Clinics</span>
                    <span class="info-box-number">
                        {{$statistics['numberOfClinics']}}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </a>
        </div>

        <div class="col-sm-3">
            <a class="info-box" href="#{{--{{route('admin.doctor')}}--}}">
                <span class="info-box-icon bg-red"><i class="fa fa-user-md"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Doctors</span>
                    <span class="info-box-number">
                        {{$statistics['numberOfDoctors']}}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </a>
        </div>

        {{--<div class="col-sm-3">--}}
            {{--<div class="info-box" --}}{{--href="{{route('admin.user')}}"--}}{{-->--}}
                {{--<span class="info-box-icon bg-purple"><i class="fa fa-users"></i></span>--}}

                {{--<div class="info-box-content">--}}
                    {{--<span class="info-box-text">Users</span>--}}
                    {{--<span class="info-box-number">--}}
                        {{--{{$statistics['numberOfUsers']}}--}}
                    {{--</span>--}}
                {{--</div>--}}
                {{--<!-- /.info-box-content -->--}}
            {{--</div>--}}
        {{--</div>--}}

        <div class="col-sm-3">
            <a class="info-box" href="#{{--{{route('admin.patient')}}--}}">
                <span class="info-box-icon bg-teal"><i class="fa fa-file-text"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Patient Records</span>
                    <span class="info-box-number">
                        {{$statistics['numberOfPatients']}}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </a>
        </div>

        <div class="col-sm-3">
            <a class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-calendar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Appointments</span>
                    <span class="info-box-number">
                        {{$statistics['numberOfAppointments']}}
                    </span>
                    <span class="progress-description"></span>
                </div>
                <!-- /.info-box-content -->
            </a>
        </div>
    </div>

    {{--{!! $authAdminUser->roles()->first() !!}}--}}

    {{--@if($authAdminUser->hasRole('clinic_owner'))--}}
        {{--User Role: {!! $authAdminUser->roles()->first()->toJson() !!}--}}
    {{--@endif--}}

    <div class="row">
        <div class="col-xs-12">
            <p class="text-muted text-italic">The statistics will be recalculated every 4 hours</p>
        </div>
    </div>
@stop

@push('scripts')

@endpush
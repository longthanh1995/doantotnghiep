@extends('doctor.layouts.base')

@section('pageTitle'){{$authDoctor->name}} - Settings - Appointment Types @stop

@section('bodyClass', 'page-settings')

@section('contentHeader')
    <i class="fa fa-cog"></i>
    Settings
@stop

@section('contentHeaderSub')
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="/">
                <i class="fa fa-dashboard"></i> Home
            </a>
        </li>
        <li>
            <a>
                <i class="fa fa-cog"></i>
                Settings
            </a>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-9 col-md-push-3">
            <div class="box box-primary" id="box_appointment_types">
                <div class="box-header">
                    <div class="box-tools pull-right">
                        <a data-action="edit" class="btn btn-box-tool">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                    </div>
                    <h3 class="box-title">
                        <i class="fa fa-bar-chart"></i>
                        Appointment Types
                    </h3>
                </div>

                <div class="box-body">
                {!! Form::open(['route' => 'setting.appointmentTypeSubmit', 'class'=> 'form','id' => 'form_appointment_types']) !!}
                    <table class="table" id="table_appointment_types">
                        <thead>
                        <tr>
                            <th class="col-xs-5">
                                Appointment Type
                            </th>
                            <th class="col-xs-5">
                                Duration (minute)
                            </th>
                            <th class="col-xs-2">

                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($doctorAppointmentTypes as $doctorAppointmentType)
                        <tr data-id="{{$doctorAppointmentType->id}}">
                            <td>
                                {!! Form::hidden('appointment_type_id[]', $doctorAppointmentType->pivot->appointment_type_id) !!}
                                <div class="text-right" style="padding-top:7px">
                                    {{$doctorAppointmentType->name}}
                                </div>
                            </td>
                            <td>
                                <div class="form-control-static">
                                    {{$doctorAppointmentType->pivot->duration}} minutes
                                </div>
                                {!! Form::select('appointment_type_duration[]', $listDurations, $doctorAppointmentType->pivot->duration, [
                                    'class' => 'form-control'
                                ]) !!}
                            </td>
                        </tr>
                        @endforeach
                        <tr id="form_appointment_types__row_add">
                            <td class="text-right">
                                {!! Form::select(null, $appointmentTypesArr, null, [
                                    'id' => 'form_appointment_types__row_add__select_appointment_type',
                                    'class' => 'form-control'
                                ]) !!}
                            </td>

                            <td>
                                {!! Form::select(null, $listDurations, null, [
                                    'id' => 'form_appointment_types__row_add__select_duration',
                                    'class' => 'form-control'
                                ]) !!}
                            </td>
                            <td>
                                <a class="btn btn-primary" data-action="add">
                                    <i class="fa fa-plus"></i> Add
                                </a>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td class="text-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </td>
                            <td>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-md-3 col-md-pull-9">
            @include('doctor.pages.settings.partials.leftMenu', [
                'currentPage' => 'appointmentTypes'
            ])
        </div>
    </div>
@stop
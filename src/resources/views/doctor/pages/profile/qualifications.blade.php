@extends('doctor.layouts.base')

@section('pageTitle'){{$authDoctor->name}} - Qualifications @stop

@section('bodyClass', 'page-profile page-profile-avatar')

@section('contentHeader')
    Qualifications
@stop

@section('contentHeaderSub')
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a>Profile</a></li>
        <li class="active">Qualifications</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-9 col-md-push-3">
            <div class="box box-default" id="box_colleges">
                <div class="box-header">
                    <div class="box-tools pull-right">
                        <a href="#" class="btn btn-box-tool btn-xs" data-action="add">
                            <i class="fa fa-plus"></i> Add
                        </a>
                    </div>
                    <h3 class="box-title">
                        <i class="fa fa-mortar-board"></i>
                        Colleges
                    </h3>
                </div>

                <div class="box-body no-padding">
                @if (count($medicalSchools) > 0)
                    <table class="table table-striped table-hover" id="table_colleges">
                        <thead>
                        <tr>
                            <th>Date of Graduation</th>
                            <th>School Name</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($medicalSchools as $medicalSchool)
                        <tr
                            data-id="{{ $medicalSchool->id }}"
                            data-name="{{$medicalSchool->name}}"
                            data-date-of-graduation="{{$medicalSchool->getGraduationDate()}}"
                        >
                            <td>
                                {{ $medicalSchool->getGraduationMonthYear() }}
                            </td>
                            <td>
                                {{ $medicalSchool->name }}
                            </td>
                            <td>
                                <a class="btn btn-xs btn-warning" data-action="edit">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a class="btn btn-xs btn-danger" data-action="delete">
                                    <i class="fa fa-times"></i> Delete
                                </a>

                                {!! Form::open(['route' => ['profile.college.destroy', $medicalSchool->id], 'method' => 'DELETE', 'id' => 'form_delete_college_'. $medicalSchool->id]) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
                </div>
            </div>

            <div class="box box-purple" id="box_qualifications">
                <div class="box-header">
                    <div class="box-tools pull-right">
                        <a href="#" class="btn btn-box-tool btn-xs" data-action="add">
                            <i class="fa fa-plus"></i> Add
                        </a>
                    </div>
                    <h3 class="box-title">
                        <i class="fa fa-certificate"></i>
                        Qualifications
                    </h3>
                </div>

                <div class="box-body no-padding">
                @if (count($qualifications) > 0)
                    <table class="table table-striped table-hover" id="table_qualifications">
                        <thead>
                        <tr>
                            <th>Issued Year</th>
                            <th>Issuer</th>
                            <th>Name</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($qualifications as $qualification)
                            <tr
                                data-id="{{ $qualification->id }}"
                                data-issued-time="{{ $qualification->issued_time?$qualification->issued_time->format('Y'):'' }}"
                                data-issuer="{{ $qualification->issuer }}"
                                data-name="{{ $qualification->name }}"
                            >
                                <td>
                                    {{ $qualification->issued_time?$qualification->issued_time->format('Y'):''}}
                                </td>
                                <td>
                                    {{ $qualification->issuer }}
                                </td>
                                <td>
                                    {{ $qualification->name }}
                                </td>
                                <td>
                                    <a href="" class="btn btn-xs btn-warning" data-action="edit">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="" class="btn btn-xs btn-danger" data-action="delete">
                                        <i class="fa fa-times"></i> Delete
                                    </a>

                                    {!! Form::open(['route' => ['profile.qualification.destroy', $qualification->id], 'method' => 'DELETE', 'id' => 'form_delete_qualification_'. $qualification->id]) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
                </div>
            </div>
        </div>

        <div class="col-md-3 col-md-pull-9">
            @include('doctor.pages.profile.partials.leftMenu', [
                'currentPage' => 'qualifications'
            ])
        </div>
    </div>
@stop
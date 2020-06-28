@extends('doctor.layouts.base')

@section('pageTitle'){{$authDoctor->name}} - Professional Working @stop

@section('bodyClass', 'page-profile page-profile-avatar')

@section('contentHeader')
    Professional Working
@stop

@section('contentHeaderSub')
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a>Profile</a></li>
        <li class="active">Professional Working</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-9 col-md-push-3">
            <div class="box box-primary" id="box_professional_workings">
                <div class="box-header">
                    <h3 class="box-title">
                        <i class="fa fa-hospital"></i>
                        Professional Working
                    </h3>
                </div>

                <div class="box-body">
                    @if (count($doctorClinics) > 0)
                        @foreach ($doctorClinics as $clinic)
                            <div class="media">
                                @if (count($clinic->images) > 0)
                                    <div class="media-left">
                                        <a href="#">
                                            <img class="media-object" src="{{ $clinic->images->first()->getThumbnailUrl() }}" width="140"/>
                                        </a>
                                    </div>
                                @endif
                                <div class="media-body">
                                    <h4 class="media-heading">{{ $clinic->name }}</h4>
                                    <i class="fa fa-fw fa-map-marker">
                                    </i> {{ $clinic->address }}
                                    <br/>

                                    <i class="fa fa-fw fa-phone"></i>
                                    ({{ $clinic->phone_country_code }}) {{ $clinic->phone_number }}
                                    <br/>

                                    <i class="fa fa-fw fa-mail-forward"></i>
                                    {{ $clinic->email }}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center">
                            You haven't been assigned to a clinic yet. Please contact the clinic owner.
                        </p>
                    @endif
                </div>
            </div>

            <div class="box box-primary" id="box_specialities">
                <div class="box-header">
                    <div class="box-tools pull-right">
                        <a data-action="edit" class="btn btn-box-tool"><i class="fa fa-edit"></i> Edit</a>
                    </div>
                    <h3 class="box-title">
                        <i class="fa fa-fw fa-stethoscope"></i>
                        Specialities
                    </h3>
                </div>

                <div class="box-body">
                    {!! Form::open(['route' => ['profile.specialitySubmit'], 'id' => 'form_specialities']) !!}
                        <div class="form-group @if ($errors->getBag('specialityForm')->has('conditions')) has-error @endif">
                        @if (count($patientConditions) > 0)
                            <div class="form-control-static">
                                <h4>
                                    @foreach ($patientConditions as $condition)
                                        <span class="label label-default label-lg">{{$condition->name}}</span>
                                    @endforeach
                                </h4>
                            </div>
                        @endif

                            <select name="conditions[]" id="form_specialities__select_specialities" class="form-control" multiple=""multiple>
                                @foreach ($patientConditionOptions as $conditionKey => $conditionName)
                                    <option value="{{ $conditionKey }}" @if ($patientConditions->has($conditionKey)) selected="selected" @endif>
                                        {{ $conditionName }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($errors->getBag('specialityForm')->has('conditions'))
                                @foreach ($errors->getBag('specialityForm')->get('conditions') as $error)
                                    <p class="help-block">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>

                                <button type="reset" class="btn btn-default btn-sm">Reset</button>
                            </div>
                        </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>

        <div class="col-md-3 col-md-pull-9">
            @include('doctor.pages.profile.partials.leftMenu', [
                'currentPage' => 'professionalWorking'
            ])
        </div>
    </div>
@stop
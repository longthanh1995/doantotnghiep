@extends('doctor.layouts.base')

@section('pageTitle'){{$authDoctor->name}} - Settings - Time @stop

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
            <div class="box box-primary" id="box_time">
                <div class="box-header">
                    <h3 class="box-title">
                        <i class="fa fa-bar-chart"></i>
                        Time
                    </h3>
                </div>

                <div class="box-body">
                    {!! Form::open(['route' => 'setting.timeSubmit', 'class'=> 'form form-horizontal','id' => 'form_time']) !!}
                    <div class="form-group">
                        <div class="col-sm-3 text-right">
                            <label class="control-label">Timezone</label>
                        </div>
                        <div class="col-sm-9">
                            <select name="timezone" class="form-control" autocomplete="off">
                                @foreach(timezone_identifiers_list() as $timezone)
                                    <option
                                        value="{{$timezone}}"
                                        @if($timezoneSetting && $timezoneSetting->value == $timezone)
                                        selected="selected"
                                        @endif
                                    >{{$timezone}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3 text-right"></div>
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-md-3 col-md-pull-9">
            @include('doctor.pages.settings.partials.leftMenu', [
                'currentPage' => 'time'
            ])
        </div>
    </div>
@stop
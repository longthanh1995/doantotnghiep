@extends('doctor.layouts.base')

@section('pageTitle'){{$authDoctor->name}} - Settings - Tele-consults @stop

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
            <div class="box box-primary" id="box_teleconsult_settings">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Tele-consults
                    </h3>
                </div>

                <div class="box-body">
                    <div id="message"></div>
                    <form class="form form-horizontal" id="form_chat_availability"></form>
                    <form class="form form-horizontal" id="form_chat_fee_settings"></form>
                    <form class="form form-horizontal" id="form_video_availability"></form>
                    <form class="form form-horizontal" id="form_video_fee_settings"></form>
                </div>

                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-md-pull-9">
            @include('doctor.pages.settings.partials.leftMenu', [
                'currentPage' => 'teleconsults'
            ])
        </div>
    </div>
@stop
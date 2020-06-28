@extends('legacy.pages.doctor.profile.layout', ['childPage' => 'basicInformation'])

@section('pageHeader')
    <h1>Basic Information</h1>
@stop

@section('childContent')
    @include('legacy.pages.doctor.profile.panels.basicInformationPanel')

    @include('legacy.pages.doctor.profile.panels.personalContactPanel')

    @include('legacy.pages.doctor.profile.panels.sercurityPanel')
@stop
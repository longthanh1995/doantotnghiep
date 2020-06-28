@extends('legacy.pages.doctor.profile.layout', ['childPage' => 'qualification'])

@section('pageHeader')
    <h1>Qualification</h1>
@stop

@section('childContent')
    @include('legacy.pages.doctor.profile.panels.collegePanel')

    @include('legacy.pages.doctor.profile.panels.qualificationPanel')
@stop
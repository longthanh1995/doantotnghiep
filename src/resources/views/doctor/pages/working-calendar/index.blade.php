@extends('doctor.layouts.base')

@section('pageTitle'){{$authDoctor->name}} - Working Calendar @stop

@section('bodyClass', 'page-working-calendar new')

@section('contentHeader')
    <i class="fa fa-calendar"></i>
    Working Calendar
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
                <i class="fa fa-calendar"></i>
                Working Calendar
            </a>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-9 col-md-push-3">
            <div class="box box-primary" id="box_calendar">
                <div class="box-header">
                    <div class="pull-right">
                        <div class="btn-group calendar-nav">
                            <button class="btn btn-primary" data-calendar-nav="prev">&lt;&lt; Prev</button>
                            <button class="btn btn-normal" data-calendar-nav="today">Today</button>
                            <button class="btn btn-primary" data-calendar-nav="next">Next &gt;&gt;</button>
                        </div>
                    </div>
                    <h3 class="box-title">
                        <span></span>
                        <small></small>
                    </h3>
                </div>
                <div class="box-body">
                    <div id="calendar"></div>
                </div>
                <div class="overlay">
                    <i class="fa fa-spin fa-refresh"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-md-pull-9">
            <div class="box box-solid" id="box_calendar_view_modes">
                <div class="box-header">
                    <h3 class="box-title">
                        View Mode
                    </h3>
                </div>

                <div class="box-body">
                    <div class="btn-group">
                        <button class="btn btn-normal" data-calendar-view="year">Year</button>
                        <button class="btn btn-normal" data-calendar-view="month">Month</button>
                        <button class="btn btn-normal" data-calendar-view="week">Week</button>
                        <button class="btn btn-normal" data-calendar-view="day">Day</button>
                    </div>
                </div>
            </div>

            <div class="box box-info" id="box_create_timeslots">
                <div class="box-header">
                    <div class="box-tools">
                        <a data-action="createTimeSlots" class="btn btn-box-tool">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                    <h3 class="box-title">
                        Create Timeslots
                    </h3>
                </div>
            </div>

            <div class="box box-info" id="box_book_appointment_to_other_doctor">
                <div class="box-header">
                    <div class="box-tools">
                        <a data-action="createAppointmentForOtherDoctor" class="btn btn-box-tool">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                    <h3 class="box-title">
                        Book appointment with other doctor
                    </h3>
                </div>
            </div>

            <div class="box box-info" id="box_calendar_filters">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Filters
                    </h3>
                </div>

                <div class="box-body">
                    <b>Appointment Types</b>
                    @if(isset($conditions))
                        @foreach ($conditions as $condition)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="appointment_type" value="{{ $condition->id }}" data-filter-type="condition" data-filter-id="{{ $condition->id }}"
                                           @if (in_array($condition->id, $filtersCollection->has('condition') ? $filtersCollection->get('condition')->keys()->toArray() : []))
                                           checked
                                            @endif
                                    />
                                    {{ $condition->name }}
                                </label>
                            </div>
                        @endforeach
                    @endif

                    <b>Clinics</b>
                    @if(isset($doctorClinics))
                        @foreach ($doctorClinics as $clinic)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="appointment_type" value="{{ $clinic->id }}" data-filter-type="clinic" data-filter-id="{{ $clinic->id }}"
                                           @if (in_array($clinic->id, $filtersCollection->has('clinic') ? $filtersCollection->get('clinic')->keys()->toArray() : []))
                                           checked
                                            @endif
                                    />
                                    {{ $clinic->name }}
                                </label>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- <div class="box box-warning" id="box_timezone">
                <div class="box-body">
                    @if($doctorTimezone && $doctorTimezone->value)
                        Your preferred timezone is {{$doctorTimezone->value}}. <a href="{{route('setting.time')}}">Change</a>
                    @else
                        <a href="{{route('setting.time')}}">Set your preferred timezone.</a>
                    @endif
                </div>
            </div> -->

            <div class="box box-success" id="box_appointment_type_legends">
                <div class="box-header">
                    <h3 class="box-title">Appointment Types</h3>
                </div>
                <div class="box-body">

                </div>
            </div>
        </div>
    </div>
@stop

@push('customStyles')
<style>
@if($doctorTimezone && $doctorTimezone->value)
    [data-timezone="{{$doctorTimezone->value}}"]{
        display: none;
    }
@endif
</style>
@endpush

@push('dataScripts')
<script type="text/javascript">
    globalData.context.pageWorkingCalendar = {!! $pageData?$pageData:'{}' !!};
</script>
@endpush

@push('modals')
<div class="modal fade modal-timeslot-info">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="bootbox-close-button close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Timeslot Info</h4>
            </div>
            <div class="modal-body">
                <div class="bootbox-body"></div>
            </div>
        </div>
    </div>
</div>
@endpush
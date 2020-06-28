@extends('legacy.layouts.doctor.appLayout')

@section('content')
    <div id="calendarSection">
        <div class="row calendar-section">
            <div class="col-md-12">
                <div class="row calendar-control-section">
                    <div class="col-sm-6 col-xs-12">
                        <div class="btn-group calendar-nav">
                            <button class="btn btn-primary" data-calendar-nav="prev">&lt;&lt; Prev</button>
                            <button class="btn btn-normal" data-calendar-nav="today">Today</button>
                            <button class="btn btn-primary" data-calendar-nav="next">Next &gt;&gt;</button>
                        </div>
                    </div>

                    <div class="clearfix visible-xs-block"><br /><br /></div>

                    <div class="col-sm-6 col-xs-12 text-right calendar-view">
                        <div class="btn-group">
                            <button class="btn btn-normal" data-calendar-view="year">Year</button>
                            <button class="btn btn-normal" data-calendar-view="month">Month</button>
                            <button class="btn btn-normal" data-calendar-view="week">Week</button>
                            <button class="btn btn-normal" data-calendar-view="day">Day</button>
                        </div>
                    </div>
                </div>

                <div class="row calendar-heading-section">
                    <div class="col-xs-9">
                        <h3 class="calendar-header"><!-- auto fill--></h3>
                    </div>

                    <div class="col-xs-3 text-right">
                        <a href="#" class="btn btn-sm btn-primary"
                           data-toggle="modal" data-target="#addAvailableTimeModal" data-backdrop="static">
                            <i class="fa fa-fw fa-lg fa-plus"></i>

                            Create Time Slots
                        </a>
                    </div>
                </div>

                <div class="calendar-filters-section" @if ($totalFilters == 0) style="display: none;" @endif>
                    <hr class="bootstrap-calendar" />

                    <div id="calendar-filters-content">
                        <b>Filters:</b>

                        <a href="{{ route('calendar.index') }}" class="clear-filters" @if ($totalFilters == 0) style="display: none;" @endif>
                            <i class="fa fa-fw fa-remove"></i> Clear current search query, filters, and sorts
                        </a>

                        <span class="text-muted no-filters-txt" @if ($totalFilters > 0) style="display: none;" @endif>No filters</span>
                    </div>

                    <div class="calendar-filters-labels">
                        @foreach ($filtersCollection as $type => $filters)
                            @foreach ($filters as $id => $name)
                                <span class="label {{ $filterTypes[$type] }}" id="label-type-{{ $type }}-{{ $id }}">
                                    {{ $name }}
                                </span>
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <hr class="bootstrap-calendar" />

                <div class="clearfix calendar-menu">
                    <div class="pull-left">
                        <b id="count-timetables"><!-- auto fill --></b>
                    </div>

                    <div class="pull-right">
                        <div class="btn-group" role="group" aria-label="...">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" type="button"
                                   id="dropdownSpecial" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Appointment Types
                                    <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="dropdownSpecial">
                                    <li class="disabled">
                                        <a href="#">Filter by Appointment Types</a>
                                    </li>

                                    <li role="separator" class="divider"></li>

                                    <li>
                                        @foreach ($conditions as $condition)
                                            <a href="#" data-filter-type="condition" data-filter-id="{{ $condition->id }}">
                                                @if (in_array($condition->id, $filtersCollection->has('condition') ? $filtersCollection->get('condition')->keys()->toArray() : []))
                                                    <i class="fa fa-fw fa-check"></i>
                                                @endif

                                                {{ $condition->name }}
                                            </a>
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="btn-group" role="group" aria-label="...">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" type="button" id="dropdownClinic"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Clinics
                                    <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="dropdownClinic">
                                    <li class="disabled">
                                        <a href="#">Filter by Clinics</a>
                                    </li>

                                    <li role="separator" class="divider"></li>

                                    @foreach ($doctorClinics as $clinic)
                                        <li>
                                            <a href="#" data-filter-type="clinic" data-filter-id="{{ $clinic->id }}">
                                                @if (in_array($clinic->id, $filtersCollection->has('clinic') ? $filtersCollection->get('clinic')->keys()->toArray() : []))
                                                    <i class="fa fa-fw fa-check"></i>
                                                @endif

                                                {{ $clinic->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="btn-group" role="group" aria-label="...">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" type="button"
                                   id="dropdownLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Labels
                                    <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="dropdownLabel">
                                    <li class="disabled">
                                        <a href="#">Filter by Labels</a>
                                    </li>

                                    <li role="separator" class="divider"></li>

                                    <li>
                                        <a href="#" data-filter-type="label" data-filter-id="blocked">
                                            @if (in_array('blocked', $filtersCollection->has('label') ? $filtersCollection->get('label')->keys()->toArray() : []))
                                                <i class="fa fa-fw fa-check"></i>
                                            @endif

                                            Blocked Only
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="bootstrap-calendar" />

                <div id="calendar"></div>
            </div>
        </div>

        <div style="height: 100px;"></div>
    </div>
@stop

@push('modals')
<div class="modal fade" id="addAvailableTimeModal" tabindex="-1" role="dialog" aria-labelledby="addAvailableTimeModalLabel">
    <div class="modal-dialog">
        <form id="addAvailableTimeForm" onsubmit="return false;">
            <input type="hidden" name="clinicTimeZone" value="" id="addAvailableTimeModal__clinic_time_zone"/>

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <h4 class="modal-title" id="addAvailableTimeModalLabel">
                        Create Time Slots
                    </h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="clinic">Clinic:</label>
                        {!! Form::select('clinic', $doctorClinics->lists('name', 'id'), old('clinic'), [
                            'class' => 'form-control'
                        ]) !!}
                    </div>

                    <div class="form-group">
                        <label for="date">Available Date:</label>

                        <input type="text" class="form-control add-datepicker" name="date" placeholder="Click to pick a date" readonly="readonly" />
                    </div>

                    <div class="form-group">
                        <label for="time">Available Time:</label>

                        <div class="list-available-time">
                            <div class="row add-available-time-row">
                                <div class="col-xs-5">
                                    {!! Form::select('fromTime', \DateTimeHelper::getTimeOptionsForDoctor(), null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="col-xs-2 text-center add-available-time-row-to">to</div>

                                <div class="col-xs-5">
                                    {!! Form::select('endTime', \DateTimeHelper::getTimeOptionsForDoctor(), null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-5">
                                <label for="appointmentType">Appointment Type</label>

                                <select name="appointmentType" class="form-control" id="time-slot-appointment-type-val">
                                    <option value="0">Choose an appointment type</option>

                                    @foreach ($conditions as $condition)
                                        <option
                                                value="{{ $condition->id }}"
                                                data-default-duration="{{ $condition->pivot->duration }}"
                                        >{{ $condition->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xs-2"></div>

                            <div class="col-xs-5">
                                <label for="duration">Duration:</label>

                                {!! Form::select('duration', \App\Models\DoctorTimetable::LIST_DURATIONS , old('duration'), [
                                    'class' => 'form-control'
                                ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="weekly-cycle">Repeat weekly in:</label>
                        <input type="text" class="form-control" name="weekly-cycle"/>
                        <p class="form-control-static">
                            <i>*Experimental feature.</i>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-add-available-time-submit">
                            <i class="fa fa-fw fa-calendar-plus-o"></i>

                            &nbsp;

                            Confirm and submit
                        </button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endpush

@push('modals')
<div class="modal fade" id="displayEventModal" tabindex="-1" role="dialog" aria-labelledby="displayEventModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="displayEventModalLabel"><!-- Filled --></h4>
            </div>

            <div class="modal-body"><!-- Filled --></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('modals')
<div class="modal fade" id="addAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="addAppointmentModal">
    <div class="modal-dialog">
        <form id="addAppointmentForm" onsubmit="return false;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <h4 class="modal-title" id="addAvailableTimeModalLabel">
                        Add New Appointment
                    </h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="date">Date:</label>

                        <input type="text" name="appointment_date" id="add-appointment-date-val" class="form-control" disabled="disabled" />
                    </div>

                    <hr />

                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-10">
                                <label for="patient_id">National ID - Name - Country - #ID</label>

                                {!! Form::select('patient_id', [], null, [
                                    'class' => 'form-control patient-select2',
                                    'placeholder' => 'Search by patient\'s name or patient\'s IC number.',
                                    'autocomplete' => 'off',
                                ]) !!}
                            </div>
                            <div class="col-xs-2">
                                <label for="patient_id">&nbsp;</label>
                                <p class="">
                                    <a href="#" class="btn btn-primary btn-add-new-patient">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="form-group">
                        <label for="clinic">Clinic:</label>

                        {!! Form::select('clinic', $doctorClinics->lists('name', 'id'), old('clinic'), [
                            'class' => 'form-control',
                            'id' => 'add-appointment-clinic-val'
                        ]) !!}
                    </div>

                    <div class="form-group">
                        <label for="appointment-type">Appointment Type</label>

                        <select name="appointment-type" class="form-control" id="add-appointment-type-val">
                            <option value="0">Choose an appointment type</option>

                            @foreach ($conditions as $condition)
                                <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="appointment-type">Time Slot</label>

                        <div class="display-doctor-timetable-message">
                            <div class="text-danger doctor-timetable-selection-message" style="margin-top: 8px;"></div>
                        </div>

                        <div class="display-doctor-timetable-selection" style="display: none;">
                            <select name="appointment-time-slot" id="add-appointment-time-slot-val" class="form-control"></select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="#add-appointment-reason">Reason</label>
                        <textarea class="form-control" name="booking_reason" id="add-appointment-reason"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="text-center">
                        <button type="button" class="btn btn-primary btn-add-appointment-submit">
                            <i class="fa fa-fw fa-calendar-plus-o"></i>

                            &nbsp;

                            Confirm and submit
                        </button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endpush

@push('modals')
<div class="modal fade" id="modal_add_new_patient" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form" id="modal_add_new_patient__form">
                <div class="modal-header">
                    <button type="button" class="bootbox-close-button close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                    <h4 class="modal-title">Add New Patient</h4>
                </div>
                <div class="modal-body">
                    <div class="bootbox-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="first_name">First Name (*):</label>
                                    <input type="text" name="first_name" id="modal_add_new_patient__form__input_first_name" class="form-control" />
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name (*):</label>
                                    <input type="text" name="last_name" id="modal_add_new_patient__form__input_last_name" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="gender">Gender (*):</label>
                                    <p>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" id="gender_male" value="male"/>
                                            Male
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" id="gender_female" value="female"/>
                                            Female
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" id="gender_other" value="other"/>
                                            Other
                                        </label>
                                    </p>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="date_of_birth">Date of Birth (*):</label>
                                    {!! Form::text('date_of_birth', old('date_of_birth'), [
                                        'class' => 'form-control datepicker',
                                        'readonly' => 'readonly',
                                        'placeholder' => 'Click to pick a date'
                                    ]) !!}
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="medical_record_number">MRID:</label>
                                        <input type="text" name="medical_record_number" id="modal_add_new_patient__form__input_medical_record_number" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="race">Race:</label>
                                        <input type="text" name="race" id="modal_add_new_patient__form__input_race" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" name="email" id="modal_add_new_patient__form__input_email" class="form-control" />
                        </div>

                        <label for="phone_number">Phone Number:</label>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    {!! Form::select('phone_country_code', $phoneCountriesOption, old('phone_country_code', $authDoctor->phone_country_code), [
                                    'class' => 'form-control'
                                ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <input type="text" name="phone_number" id="modal_add_new_patient__form__input_phone_number" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address_street">Street:</label>
                            <input type="text" name="address_street" id="modal_add_new_patient__form__input_address_street" class="form-control" />
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="address_city">City:</label>
                                    <input type="text" name="address_city" id="modal_add_new_patient__form__input_email" class="form-control" />
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="country_id">Country:</label>
                                    {!! Form::select('country_id', $countriesOption, old('country_id', $authDoctor->country_id), [
                                        'class' => 'form-control'
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="id_number">National ID Number (*):</label>
                                    <input type="text" name="id_number" id="modal_add_new_patient__form__input_id_number" class="form-control" />
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="address_zip">Zip Code:</label>
                                    <input type="text" name="address_zip" id="modal_add_new_patient__form__input_address_zip" class="form-control" />
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn">Reset</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script type="text/javascript">
    var myCalendar = function () {
        var calendar;
        var filters = {
            'condition': JSON.parse('{!! json_encode($baseFilters->has('condition') ? $baseFilters->get('condition') : []) !!}'),
            'label': JSON.parse('{!! json_encode($baseFilters->has('label') ? $baseFilters->get('label') : []) !!}'),
            'clinic': JSON.parse('{!! json_encode($baseFilters->has('clinic') ? $baseFilters->get('clinic') : []) !!}')
        };
        var filterTypesClasses = JSON.parse('{!! json_encode($filterTypes) !!}');
        var timeSlotData = {};
        var currentView, currentDay;

        this.init = function (view, day) {
            var $this = this;
            currentView = view;
            currentDay = day;

            calendar = $("#calendar").calendar({
                view: currentView,
                first_day: 1,
                // Initial date. No matter month, week or day this will be a starting point. Can be 'now' or a date in format 'yyyy-mm-dd'
                day: day,
                weekbox: false,
                // ID of the element of modal window. If set, events URLs will be opened in modal windows.
                modal: "#displayEventModal",
                //	modal handling setting, one of "iframe", "ajax" or "template"
                modal_type: "template",
                //	function to set modal title, will be passed the event as a parameter
                modal_title: function (event) {
                    var currentTimezone = event.timezone;
                    var startAt = moment(event.start).utcOffset(currentTimezone).tz(currentTimezone);
                    var endAt = moment(event.end).utcOffset(currentTimezone).tz(currentTimezone);

                    return startAt.format('HH:mm') + ' to ' + endAt.format('HH:mm') + ' | ' + startAt.format('dddd DD/MM') + ' <br /> ' + event.clinic.name;
                },
                // Day Start time and end time with time intervals. Time split 10, 15 or 30.
                time_start: '08:00',
                time_end: '24:00',
                time_split: 5,
                tmpl_path: laroute.url('partials/doctor-calendar-js/', []),
                tmpl_cache: false,
                events_source: $this.getEventsSource,
                onAfterViewLoad: $this.onAfterViewLoad,
                onAfterEventsLoad: $this.onAfterEventsLoad
            });

            this.listen();
        };

        this.getEventsSource = function (start, end, browser_timezone) {
            var buildEventsUrl = function(events_url, data) {
                var separator, key, url;
                url = events_url;
                separator = (events_url.indexOf('?') < 0) ? '?' : '&';
                for (key in data) {
                    url += separator + key + '=' + encodeURIComponent(data[key]);
                    separator = '&';
                }
                return url;
            };

            var baseUrl = laroute.route('calendar.feed', {
                'filters': JSON.stringify(filters)
            });

            var events = [];
            var d_from = start;
            var d_to = end;
            var params = {
                from: d_from.getTime(),
                to: d_to.getTime(),
                utc_offset_from: d_from.getTimezoneOffset(),
                utc_offset_to: d_to.getTimezoneOffset()
            };

            if (browser_timezone.length) {
                params.browser_timezone = browser_timezone;
            }

            $.ajax({
                url: buildEventsUrl(baseUrl, params),
                dataType: 'json',
                type: 'GET',
                async: false
            }).done(function(json) {
                if (!json.success) {
                    $.error(json.error);
                }
                if (json.result) {
                    events = json.result;
                }
            });

            return events;
        };

        this.onAfterEventsLoad = function (events) {

            timeSlotData = generateTimeSlotData(events);

            var total = events.length;

            $("#count-timetables").html(total + ' Time Slots');
        };

        this.onAfterViewLoad = function(view) {
            $('.calendar-header').text(this.getTitle().toUpperCase());

            $('.calendar-view .btn-group button')
                    .removeClass('btn-primary')
                    .addClass('btn-normal');

            $('.calendar-view button[data-calendar-view="' + view + '"]')
                    .addClass('btn-primary')
                    .removeClass('btn-normal');

            var p = this.options.position.start;

            var myMoment = moment(p);

            currentDay = myMoment.format('YYYY-MM-DD');
            currentView = view;

            /**
             * 20160816 - Grouping events into numbers
             */
            $('.events-list')
                .each(function(){
                    var $eventList = $(this),
                            eventTypes = {}
                            ;

                    //count event types
                    $eventList.children('.event').each(function(){
                        var $event = $(this),
                                eventType = $event.attr('data-event-class')
                                ;

                        if('undefined' === typeof eventTypes[eventType]){
                            eventTypes[eventType] = 1;
                        } else {
                            eventTypes[eventType]++;
                        }
                    });

                    //group events into number
                    var html = '';

                    $.each(eventTypes, function(key, value){
                        html += value;
                        html += '<span class="event ' + key +'"></span>';
                    });

                    $eventList.html(html);
                })
                .removeClass('hide')
            ;

            pushState();
        };

        this.listen = function ()
        {
            var $container = this;

            $('.btn-group button[data-calendar-nav]').each(function() {
                var $this = $(this);
                $this.click(function() {
                    calendar.navigate($this.data('calendar-nav'));
                });
            });

            $('.btn-group button[data-calendar-view]').each(function() {
                var $this = $(this);
                $this.click(function() {
                    currentView = $this.data('calendar-view');

                    calendar.view(currentView);
                    pushState();
                });
            });

            $("[data-filter-type]").on('click', function (e) {
                e.preventDefault();

                var type = $(this).data('filter-type');
                var id = $(this).data('filter-id');

                if (filters[type].indexOf(id) == -1) {
                    filters[type].push(id);

                    var name = $(this).html();

                    $(".no-filters-txt").hide();
                    $(".clear-filters").show();
                    $(this).prepend('<i class="fa fa-fw fa-check" />');
                    $(".calendar-filters-labels").append('<span class="label '+filterTypesClasses[type]+'" id="label-type-'+ type +'-'+ id +'">'+ name +'</span>');
                } else {
                    filters[type].splice(filters[type].indexOf(id), 1);

                    $(this).find('i').remove();
                    $("#label-type-"+ type +"-"+ id).remove();
                }

                /**
                 * Count all filters
                 */
                var count = 0;

                $.each(filters, function (key) {
                    count += filters[key].length;
                });

                if (count == 0) {
                    $(".no-filters-txt").show();
                    $(".clear-filters").hide();
                    $(".calendar-filters-section").hide();
                } else {
                    $(".calendar-filters-section").show();
                }

                calendar.view(currentView);
                pushState();
            });

            /**
             * Listen Add Available Time Modal
             */
            $('#addAvailableTimeModal').on('show.bs.modal', function (e) {
                // do something
            }).on('shown.bs.modal', function (e) {
                $('.add-datepicker').datepicker({
                    multidate: true,
                    maxViewMode: "month",
                    weekStart: 1,
                    startDate: moment().format('DD/MM/YYYY'),
                    format: 'dd/mm/yyyy',
                    disableTouchKeyboard: true
                });

                var onSubmit = false;

                var btnSubmit = $(".btn-add-available-time-submit");

                var $selectDuration = $('[name="duration"]');

                $('#time-slot-appointment-type-val').on('change', function(){
                    var $selectedOption = $(this).children(':selected'),
                            selectedValue = $selectedOption.val(),
                            selectedDefaultDuration = $selectedOption.data('default-duration')
                            ;

                    if($selectDuration.children('option[value="'+selectedDefaultDuration+'"]').length){
                        $selectDuration.val(selectedDefaultDuration);
                    }
                })

            }).on('hidden.bs.modal', function (e) {
                $('.add-datepicker').datepicker('destroy').val('');
            });

            /**
             * Listen button
             */
            $("#displayEventModal")
                .on('click', '.btn-block-timetable', function (e) {
                    e.preventDefault();

                    var id = $(this).data('timetable-id');

                    bootbox.confirm("Are you sure to block this timetable?", function(result) {
                        if (result) {
                            showLoading();

                            var request = $.ajax({
                                url: laroute.route("calendar.block", {'doctorTimetable': id}),
                                method: "POST",
                                dataType: "json"
                            });

                            request.done(function() {
                                $('#displayEventModal').modal('hide');

                                calendar.view();

                                $.notify({
                                    message: 'Block Timetable Successfully.'
                                },{
                                    type: 'success',
                                    z_index: 1140
                                });
                            }).fail(function(e, data) {
                                $.notify({
                                    // options
                                    message: e.responseJSON.message
                                },{
                                    // settings
                                    type: 'warning',
                                    z_index: 1140
                                });
                            }).always(function() {
                                $('#displayEventModal').data('handled.bootstrapCalendar', false);
                                hideLoading();
                            });
                        }
                    });
                })
                .on('click', '.btn-delete-timetable', function (e) {
                    e.preventDefault();

                    var id = $(this).data('timetable-id');

                    bootbox.confirm("Are you sure to delete this timing? <br /><b>Note: you are only able to delete a timing when it doesn't have any appointment</b>", function(result) {
                        if (result) {
                            showLoading();

                            var request = $.ajax({
                                url: laroute.route("calendar.destroy", {'doctorTimetable': id}),
                                method: "DELETE",
                                dataType: "json"
                            });

                            request.done(function() {
                                $('#displayEventModal').modal('hide');

                                calendar.view();

                                $.notify({
                                    message: 'Delete Timetable Successfully.'
                                },{
                                    type: 'success',
                                    z_index: 1140
                                });
                            }).fail(function(e, data) {
                                $.notify({
                                    // options
                                    message: e.responseJSON.message
                                },{
                                    // settings
                                    type: 'warning',
                                    z_index: 1140
                                });
                            }).always(function() {
                                $('#displayEventModal').data('handled.bootstrapCalendar', false);
                                hideLoading();
                            });
                        }
                    });

                })
                .on('click', '.btn-unblock-timetable', function(e){
                    e.preventDefault();

                    var id = $(this).data('timetable-id');

                    bootbox.confirm("Are you sure to unblock this timetable?", function(result) {
                        if (result) {
                            showLoading();

                            var request = $.ajax({
                                url: laroute.route("calendar.unblock", {'doctorTimetable': id}),
                                method: "POST",
                                dataType: "json"
                            });

                            request.done(function() {
                                $('#displayEventModal').modal('hide');

                                calendar.view();

                                $.notify({
                                    message: 'Unblock Timetable Successfully.'
                                },{
                                    type: 'success',
                                    z_index: 1140
                                });
                            }).fail(function(e, data) {
                                $.notify({
                                    // options
                                    message: e.responseJSON.message
                                },{
                                    // settings
                                    type: 'warning',
                                    z_index: 1140
                                });
                            }).always(function() {
                                $('#displayEventModal').data('handled.bootstrapCalendar', false);
                                hideLoading();
                            });
                        }
                    });
                })
            ;

            /**
             * 20160816 - Batch block/remove feature
             */
            var $calendar = $('#calendar');

            var widgetBatchActionsInterval = setInterval(function(){
                var $widgetBatchActions = $calendar.find('#widget_batch_actions'),
                        selectedEventsStats = getSelectedEventsStats()
                        ;

                if(selectedEventsStats.availableActions.block){
                    $widgetBatchActions.attr('data-can-block', 1);
                } else {
                    $widgetBatchActions.attr('data-can-block', 0);
                }

                if(selectedEventsStats.availableActions.unblock){
                    $widgetBatchActions.attr('data-can-unblock', 1);
                } else {
                    $widgetBatchActions.attr('data-can-unblock', 0);
                }

                if(selectedEventsStats.availableActions.delete){
                    $widgetBatchActions.attr('data-can-delete', 1);
                } else {
                    $widgetBatchActions.attr('data-can-delete', 0);
                }

                if(Object.keys(selectedEventsStats.events).length){
                    $widgetBatchActions
                            .fadeIn(300)
                    ;
                } else {
                    $widgetBatchActions
                            .hide();
                }
            }, 100)

            $calendar
                    .on('click', '#widget_batch_actions [data-action-type]', function(event){
                        event.preventDefault();
                        event.stopPropagation();

                        var actionType = $(this).attr('data-action-type'),
                            selectedEventsStats = getSelectedEventsStats(),
                            confirmMessage = ' ';
                        ;

                        switch(actionType){
                            case 'selectAll':
                                $('#calendar').find('input[type=checkbox][data-event-id]').prop('checked', true);
                                break;
                            case 'deselectAll':
                                $('#calendar').find('input[type=checkbox][data-event-id]').prop('checked', false);
                                break;
                            default:
                                if(!actionType.length
                                    || !selectedEventsStats.availableActions[actionType].length){
                                    hideLoading();
                                    return;
                                }

                                switch(actionType) {
                                    case 'delete':
                                        confirmMessage = '<p class="text-center">Are you sure to delete these timetables?<br/>(Note: Only timetables with no appointment will be deleted)</p>';
                                        break;
                                    case 'block':
                                        confirmMessage = '<p class="text-center">Are you sure to block these timetables?</p>';
                                        break;
                                    case 'unblock':
                                        confirmMessage = '<p class="text-center">Are you sure to unblock these timetables?</p>';
                                        break;
                                }

                                if(selectedEventsStats.availableActions[actionType].length){
                                    bootbox.confirm(confirmMessage, function(result){
                                        if(result){
                                            //should add loading overlay
                                            showLoading();

                                            //generate ajax calls
                                            var ajaxCalls = [],
                                                errorMessages = []
                                                ;

                                            _.each(selectedEventsStats.availableActions[actionType], function(id){
                                                var request;

                                                switch(actionType){
                                                    case 'delete':
                                                        request = $.ajax({
                                                            url: laroute.route("calendar.destroy", {'doctorTimetable': id}),
                                                            method: "DELETE",
                                                            dataType: "json"
                                                        });
                                                        break;
                                                    case 'block':
                                                        request = $.ajax({
                                                            url: laroute.route("calendar.block", {'doctorTimetable': id}),
                                                            method: "POST",
                                                            dataType: "json"
                                                        });
                                                        break;
                                                    case 'unblock':
                                                        request = $.ajax({
                                                            url: laroute.route("calendar.unblock", {'doctorTimetable': id}),
                                                            method: "POST",
                                                            dataType: "json"
                                                        });
                                                        break;
                                                }


                                                request.fail(function(e, data) {
                                                    errorMessages.push(e.responseJSON.message);
                                                });

                                                ajaxCalls.push(request);
                                            })

                                            $.when
                                                .apply(undefined, ajaxCalls)
                                                .always(function(){
                                                    hideLoading();
                                                    if(errorMessages.length){
                                                        bootbox.alert("Error happened while process your requests. Please check again.");
                                                    } else {
                                                        bootbox.alert("Your request was processed successfully.")
                                                    }
                                                    calendar.view();
                                                })
                                            ;
                                        }
                                    });
                                }
                                break;
                        }
                    })
            ;

            /**
             * Listen onClick to add appointment button
             */
            $('body').on('click', '.btn-add-appointment-at-calendar', function (event) {
                event.preventDefault();
                event.stopPropagation();

                var $this = $(this);

                var date = $this.data('appointment-date');

                // Set date
                $("#add-appointment-date-val").val(date);

                //set some more fields if the data exist
                var clinicId = $this.data('clinic-id'),
                    appointmentTypeId = $this.data('appointment-type-id'),
                    timeSlotId = $this.data('timetable-id')
                ;

                if(clinicId){
                    $('#add-appointment-clinic-val').val(clinicId);
                }

                if(appointmentTypeId){
                    $('#add-appointment-type-val').val(appointmentTypeId);
                }

                if(timeSlotId){
                    $('#addAppointmentModal').data('selected-timeslot-id', timeSlotId);
                } else {
                    $('#addAppointmentModal').data('selected-timeslot-id', 0);
                }

                // Show modal
                $('#addAppointmentModal').modal('show');
            });

            var updateListTimeSlot = function () {
                var date = $("#add-appointment-date-val").val();
                var clinicId = $("#add-appointment-clinic-val").val();
                var type = $("#add-appointment-type-val").val();

                var $selectTimeSlot = $("#add-appointment-time-slot-val");

                $(".display-doctor-timetable-message").css('display', 'none');
                $(".display-doctor-timetable-selection").css('display', 'block');

                if (typeof timeSlotData[date] != typeof undefined &&
                        typeof timeSlotData[date][clinicId] != typeof undefined &&
                        typeof timeSlotData[date][clinicId][type] != typeof undefined
                ) {
                    const clinicTimeSlotData = timeSlotData[date][clinicId][type];

                    var html = [];

                    for (var i in clinicTimeSlotData) {
                        const timeSlot = clinicTimeSlotData[i];
                        const currentTimezone = timeSlot.clinic.time_zone;
                        const startAt = moment(moment.utc(timeSlot.start_at).unix() * 1000).utcOffset(currentTimezone).tz(currentTimezone);
                        const endAt = moment(moment.utc(timeSlot.end_at).unix() * 1000).utcOffset(currentTimezone).tz(currentTimezone);

                        html.push('<option value="'+ timeSlot.id +'">'+ startAt.format('HH:mm') +' to '+ endAt.format('HH:mm') +'</option>');
                    }

                    html = html.join('');

                    $selectTimeSlot.html(html);

                    var selectedTimeSlotId = $('#addAppointmentModal').data('selected-timeslot-id');
                    if(selectedTimeSlotId && $selectTimeSlot.children('option[value="'+selectedTimeSlotId+'"]')){
                        $selectTimeSlot.val(selectedTimeSlotId);
                    }
                } else {
                    errorListTimeSlot('Cannot find any time slot with those filters.');
                }
            };

            var errorListTimeSlot = function (message) {
                $("#add-appointment-time-slot-val").html('');

                $(".doctor-timetable-selection-message").html(message);
                $(".display-doctor-timetable-message").css('display', 'block');
                $(".display-doctor-timetable-selection").css('display', 'none');
            };

            $('#addAppointmentModal').on('shown.bs.modal', function (e) {
                $(".patient-select2")
                    .select2({
                        dropdownParent: $("#addAppointmentModal"),
                        ajax: {
                            url: laroute.route('api.patients.searchByIcOrName'),
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    text: $.trim(params.term), // search term
                                    page: params.page
                                };
                            },
                            processResults: function (result, params) {
                                // parse the results into the format expected by Select2
                                // since we are using custom formatting functions we do not need to
                                // alter the remote JSON data, except to indicate that infinite
                                // scrolling can be used
                                params.page = params.page || 1;

                                return {
                                    results: result.data,
                                    pagination: {
                                        more: (params.page * 30) < result.total_count
                                    }
                                };
                            },
                            cache: true
                        },
                        escapeMarkup: function (markup) { return markup; },
                        minimumInputLength: 1,
                        templateResult: function (patient) {
                            if (patient.loading) return patient.text;

                            var markup = [];

                            markup.push("<div class='select2-result-patient clearfix'>");
                            markup.push("<div class='select2-result-patient__avatar pull-left'>");
                            markup.push("<img src='" + patient.profile_image_url + "' width='48' height='48'/>");
                            markup.push("</div>");

                            markup.push("<div class='select2-result-patient__meta pull-left' style='padding-left: 10px;'>");
                            markup.push("<div class='select2-result-patient__title'>" + patient.full_name + " (<b>#" + patient.id +"</b>)</div>");
                            markup.push("<div class='select2-result-patient__statistics'>");
                            if (patient.id_number) {
                                markup.push("<div class='select2-result-patient__forks'>National ID: " + patient.id_number + "</div>");
                            }

                            if (patient.country_name) {
                                markup.push("<div class='select2-result-patient__stargazers'>Country: " + patient.country_name + "</div>");
                            }
                            markup.push("</div>");
                            markup.push("</div>");
                            markup.push("</div>");

                            return markup.join('');
                        },
                        templateSelection: function (patient) {
                            return patient.text;
                        }
                    })
                ;

                /*
                 * Validate
                 */
                $("#addAppointmentForm").validate({
                    rules: {
                        patient_id: {
                            required: true,
                        },

                        "appointment-type": {
                            required: true,
                            min: 1,
                        },

                        clinic: {
                            required: true,
                        },

                        appointment_date: {
                            required: true,
                        },

                        "appointment-time-slot": {
                            required: true,
                        }
                    },

                    errorElement: "p",
                    errorClass: "help-block",

                    errorPlacement: function(error, element) {
                        element.closest('div').append(error);
                    },

                    highlight: function(element) {
                        $(element).closest('.form-group').addClass('has-error');
                    },

                    unhighlight: function (element) {
                        $(element).closest('.form-group').removeClass('has-error');
                    }
                });

                /*
                 * Update time slot
                 */
                updateListTimeSlot();

                $("#add-appointment-clinic-val").on('change', function () {
                    updateListTimeSlot();
                });

                $("#add-appointment-type-val").on('change', function () {
                    updateListTimeSlot();
                });

                var btnAddAppointmentSubmit = $(".btn-add-appointment-submit");
                var onAddAppointmentSubmit = false;

                btnAddAppointmentSubmit.off('click').on('click', function () {
                    if ($('#addAppointmentForm').valid()) {
                        if (onAddAppointmentSubmit) {
                            return;
                        }

                        btnAddAppointmentSubmit.addClass('disabled');
                        onAddAppointmentSubmit = true;

                        var request = $.ajax({
                            url: laroute.route("appointment.store"),
                            method: "POST",
                            data: $("#addAppointmentForm").serialize(),
                            dataType: "json"
                        });

                        request.done(function(data) {
                            $('#addAppointmentModal').modal('hide');

                            //re-render the calendar
                            calendar.view();
                            //clear modal's cache
                            $('#displayEventModal').data('handled.bootstrapCalendar', false);

                            bootbox.dialog({
                                message: "Add appointment successfully.",
                                title: "Successfully"
                            });
                        }).fail(function(e, data) {
                            $.notify({
                                // options
                                message: e.responseJSON.message
                            },{
                                // settings
                                type: 'warning',
                                z_index: 1140
                            });
                        }).always(function() {
                            onAddAppointmentSubmit = false;

                            btnAddAppointmentSubmit.removeClass('disabled');
                        });
                    }
                });
            }).on('hidden.bs.modal', function (e) {
                $(".patient-select2").val('').select2('destroy');
                $('#displayEventModal').modal('hide');
            });

            $("#addAvailableTimeForm").validate({
                rules: {
                    "date": {
                        required: true
                    },
                    "weekly-cycle": {
                        number: true
                    }
                },

                errorElement: "p",
                errorClass: "help-block",

                errorPlacement: function(error, element) {
                    element.closest('div').append(error);
                },

                highlight: function(element) {
                    $(element).closest('.form-group').addClass('has-error');
                },

                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },

                submitHandler: function(form, event){
                    event.preventDefault();

                    var onSubmit = $(form).data('on-submit'),
                        btnSubmit = $(form).find('')

                    if (parseInt(onSubmit)) {
                        return;
                    }

                    $(form).data('on-submit', "1");

                    btnSubmit.addClass('disabled');

                    //for use later in handling response
                    var selectedDate = moment($('#addAvailableTimeForm .add-datepicker').val(), "DD/MM/YYYY");

                    var request = $.ajax({
                        url: laroute.route("calendar.store"),
                        method: "POST",
                        data: $("#addAvailableTimeForm").serialize(),
                        dataType: "json"
                    });

                    request.done(function(data) {
                        $('#addAvailableTimeModal').modal('hide');

                        calendar.view();

                        var message = [];

                        var currentTimezone = data.timezone;

                        if (data.timetables.length > 0) {
                            //get clinic's timezone


                            message.push('<p class="text-success">Succeed to added ' + data.timetables.length +' timeslots:</p>');
                            message.push('<ul>');

                            $.each(data.timetables, function (key, record) {
                                var startDate = moment(record.startDateTime).utcOffset(currentTimezone).tz(currentTimezone);
                                var endDate = moment(record.endDateTime).utcOffset(currentTimezone).tz(currentTimezone);

                                message.push('<li>'+ startDate.format('HH:mm') +' to '+ endDate.format('HH:mm') +' in '+startDate.format('DD/MM/YYYY')+'</li>');
                            });

                            message.push('</ul>');
                        }

                        if (data.timetablesError.length > 0) {
                            message.push('<p class="text-danger">Failed to add '+data.timetablesError.length+' timeslots:</p>');

                            message.push('<ul>');

                            $.each(data.timetablesError, function (key, record) {
                                var startDate = moment(record.startDateTime).utcOffset(currentTimezone).tz(currentTimezone);
                                var endDate = moment(record.endDateTime).utcOffset(currentTimezone).tz(currentTimezone);

                                message.push('<li>'+ startDate.format('HH:mm') +' to '+ endDate.format('HH:mm') +' in '+startDate.format('DD/MM/YYYY')+' <b>Time Loop</b>.</li>');
                            });

                            message.push('</ul>');
                        }

                        message = message.join('');

                        bootbox.dialog({
                            message: message,
                            title: "Results",
                            className: "modal-add-time-slots modal-results"
                        });
                    }).fail(function(e, data) {
                        $.notify({
                            // options
                            message: e.responseJSON.message
                        },{
                            // settings
                            type: 'warning',
                            z_index: 1140
                        });
                    }).always(function() {
                        $(form).data('on-submit', "0");

                        btnSubmit.removeClass('disabled');
                    });
                }
            });
        };

        function getSelectedEventsStats(){
            var selectedEventsStats = {
                availableActions: {},
                events: {}
            };

            $('#calendar').find('input[type=checkbox][data-event-id]:checked').each(function(){
                var $this = $(this),
                        eventId = $this.attr('data-event-id'),
                        eventTypes = $this.attr('data-action-types').split(','),
                        isHidden = $this.closest('#cal-slide-box').css('display');

                //use switch/case for scalabiliy later
                switch(isHidden){
                    case 'block':
                        _.each(eventTypes, function(eventType){
                            if(!selectedEventsStats.availableActions[eventType]){
                                selectedEventsStats.availableActions[eventType] = [];
                            }

                            if(eventId){
                                selectedEventsStats.events[eventId] = eventType;
                                selectedEventsStats.availableActions[eventType].push(eventId);
                            }
                        });
                        break;
                    default:
                        return;
                        break;
                }
            });
            return selectedEventsStats;
        }

        function generateTimeSlotData(events){
            var timeSlotData = {};
            _.forEach(events, function(event, index, list){

                var startAt = moment(event.start).utcOffset(0).format('YYYY-MM-DD HH:mm:ss'),
                        endAt = moment(event.end).utcOffset(0).format('YYYY-MM-DD HH:mm:ss'),
                        date = moment(event.start).utcOffset(event.timezone).tz(event.timezone).format('YYYY-MM-DD'),
                        clinicId = event.clinic.id,
                        appointmentTypeId = 0
                        ;

                if(event.appointmentType && event.appointmentType.id){
                    appointmentTypeId = parseInt(event.appointmentType.id) || 0;
                }

                if(0 == appointmentTypeId || (event.appointments && _.filter(event.appointments, function(appointment){return appointment.appointment_status.name !== 'Cancelled'}).length)){
                    return;
                }

                if('undefined' === typeof timeSlotData[date]){
                    timeSlotData[date] = {};
                }
                if('undefined' === typeof timeSlotData[date][clinicId]){
                    timeSlotData[date][clinicId] = {};
                }
                if('undefined' === typeof timeSlotData[date][clinicId][appointmentTypeId]){
                    timeSlotData[date][clinicId][appointmentTypeId] = [];
                }
                timeSlotData[date][clinicId][appointmentTypeId].push({
                    id: event.id,
                    clinic: {
                        time_zone: event.timezone
                    },
                    start_at: startAt,
                    end_at: endAt,
                })
            });

            return timeSlotData;
        }

        var pushState = function () {
            var url = "/calendar/" + currentView + '?filters=' + JSON.stringify(filters) + '&day=' + currentDay;

            window.history.pushState(null, null, url);
        };


    };

    $(document).ready(function () {
        var calendar = new myCalendar();

        calendar.init('{{ $typeView }}', '{{ $day }}');
    });
</script>
@endpush

@push('scripts')
<script>
    $(function(){
        $('body')
                .on('click', '.btn-add-new-patient', function(event){
                    event.preventDefault();

                    $('#modal_add_new_patient').modal('show');
                })
        ;

        $('#modal_add_new_patient [name="date_of_birth"]').datepicker({
            format: 'dd/mm/yyyy',
            weekStart: 1,
            minViewMode: "month",
            maxViewMode: "years",
            orientation: "bottom",
            disableTouchKeyboard: true,
            autoclose: true,
            defaultViewDate: {
                year: 1980,
                month: 0,
                day: 1
            },
            startView: "years"
        });

        $("#modal_add_new_patient__form").validate({
                rules: {
                    first_name: {
                        required: true,
                        minlength: 1,
                        maxlength: 255
                    },

                    last_name: {
                        required: true,
                        minlength: 1,
                        maxlength: 255
                    },

                date_of_birth: {
                    required: true,
                    dateFormatDMY: true
                },

                gender: {
                    required: true
                },

                email: {
                    required: {
                        depends: function(){
                            var $this = $(this);
//                                $this.val($.trim($this.escapeHtml()));
                            return $this.val().length;
                        }
                    },
                    validateEmail: ''
                },

                phone_number: {
                    number: true
                },

                issue_country_id: {
                    required: true,
                },

                id_number: {
                    required: true
                },

                zip_code: {
                    number: true
                }
            },
            messages: {
                email: {
                    required: '',
                    validateEmail: 'Invalid email format.'
                }
            },

            errorElement: "p",
            errorClass: "help-block",

            errorPlacement: function(error, element) {
                element.closest('div').append(error);
            },

            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },

            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            submitHandler: function(form, event){
                event.preventDefault();

                var btnSubmit = $(form).find('[type=submit]').addClass('disabled');

                var formData = $(form).serialize();

                var request = $.ajax({
                    url: laroute.route("api.patients.store"),
                    method: "POST",
                    data: formData,
                    dataType: "json"
                });

                request.done(function(response){
                    var id = response.data && response.data.id || 0,
                        fullName = response.data && response.data.full_name || '',
                        optionText = response.data.text || id
                    ;

                    $('#modal_add_new_patient').modal('hide');

                    bootbox.dialog({
                        message: 'Patient ' + fullName + ' created successfully!',
                        title: "Results",
                        backdrop: true,
                        onEscape: function(){
                            if(id){
                                $('#addAppointmentModal .patient-select2').append('<option selected value="'+id+'">'+ optionText +'</option>');
                            }
                        }
                    });
                }).fail(function(e, data) {
                    $.notify({
                        // options
                        message: e.responseJSON.message
                    },{
                        // settings
                        type: 'warning',
                        z_index: 1140
                    });
                }).always(function() {
                    btnSubmit.removeClass('disabled');
                });
            }
        });

        $('#modal_add_new_patient__form').on('reset', function(){
            //hide error messages
            validator = $(this).validate().resetForm();
        })

        $('#modal_add_new_patient')
                .on('shown.bs.modal', function(){
                    var $form = $('#modal_add_new_patient__form');
                    $form.find('input').first().focus();
                    $form[0].reset();
                })
                .on('hidden.bs.modal', function(){
                    var $form = $('#modal_add_new_patient__form');
                    $form[0].reset();
                })
        ;
    });
</script>
@endpush
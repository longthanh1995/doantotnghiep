'use strict';

const _assign = require('lodash/assign');
const _get = require('lodash/get');
const _map = require('lodash/map');
const _filter = require('lodash/filter');
const _transform = require('lodash/transform');
const _indexOf = require('lodash/indexOf');

const dashboardType = _get(globalData, 'context.dashboardType', 'doctor');

/**
 * @namespace pageWorkingCalendar
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function (sandbox){
    let _this = this;

    /**
     * @memberOf pageWorkingCalendar
     * @function render
     * @description First rendering
     */
    _this.render = () => {
        _this.renderCalendar();
    };

    /**
     * @memberOf pageWorkingCalendar
     * @function bindEvents
     * @description Bind event listeners
     */
    _this.bindEvents = () => {
        _this.objects.$buttonCreateTimeSlots
            .on('click', function(event){
                event.preventDefault();

                _this.showModalCreateTimeSlots();
            })
        ;

        _this.objects.$viewModeButtons
            .on('click', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget);

                _this.data.currentView = $this.data('calendar-view');
                _this.objects.calendar.view(_this.data.currentView);
            })
        ;

        _this.objects.$nagivationButtons
            .on('click', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget);
                _this.objects.calendar.navigate($this.data('calendar-nav'));
                _this.data.currentDay = _this.objects.calendar.options.day;
            })
        ;

        //filters
        _this.objects.$boxFilters
            .on('change', '[data-filter-type]', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    filters = _this.data.filters,
                    type = $this.data('filter-type'),
                    id = $this.data('filter-id'),
                    isChecked = $(event.currentTarget).prop('checked')
                ;

                if(isChecked){
                    if(filters[type].indexOf(id) == -1){
                        filters[type].push(id);
                    }
                } else {
                    if(filters[type].indexOf(id) != -1){
                        filters[type].splice(filters[type].indexOf(id), 1);
                    }
                }

                _this.objects.calendar.view(_this.data.currentView);

                _this.updateUrl(_this.data);
            })
        ;

        //calendar section
        _this.objects.$boxCalendar
            .on('click', '.btn-add-appointment-at-calendar', (event) => {
                event.preventDefault();
                event.stopPropagation();

                let $this = $(event.currentTarget),
                    selectedDate = $this.data('appointment-date')
                ;

                if(!selectedDate){
                    return false;
                }

                _this.showModalAddNewAppointment({
                    selectedDate: selectedDate,
                    clinics: _this.data.doctorClinics,
                    conditions: _this.data.conditions,
                    timeslots: _this.data.timeSlots[selectedDate],
                });
            })
        ;

        //reload notification
        _this.objects.$body
            .on('click', '[data-action=reloadCalendar]', (event) => {
                event.preventDefault();

                _this.hideShouldUpdateNotification();

                setTimeout(()=>{
                    _this.objects.calendar.view();
                }, 1000);

                _this.scheduleCheckUpdates({
                    doctorId: _get(_this.data, 'doctor.id'),
                    lastUpdatedTime: _get(_this.data, 'lastUpdatedTime')
                });
            })
            .on('click', '[data-action=sendMessage]', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    appointmentId = $this.data('appointment-id')
                ;

                _this.showModalSendAppointmentMessage({appointmentId})
            })
            .on('click', '[data-action=reschedule]', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    appointmentId = $this.data('appointment-id')
                ;

                sandbox.emit('modal/rescheduleAppointment/show', {
                    appointmentId: $this.data('appointment-id'),
                    appointmentTypeId: $this.data('appointment-type-id'),
                    appointmentTypeName: $this.data('appointment-type-name'),
                    appointmentTypeCategory: $this.data('appointment-type-category'),
                    doctorId: $this.data('doctor-id')
                })
            })
            .on('click', '[data-action=markAsVisited]', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    appointmentId = $this.data('appointment-id')
                ;

                _this.showModalMarkAsVisited({
                    appointmentId,
                    doneCallback: (data) => {
                        _this.objects.$modalTimeslotInfo.modal('hide');

                        $.notify({
                            message: 'Appointment marked as visited successfully!'
                        }, {
                            type: 'success',
                            z_index: 1030
                        });

                        _this.objects.calendar.view();
                    }
                });
            })
            .on('click', '[data-action=markAsNoShow]', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    appointmentId = $this.data('appointment-id'),
                    appointmentTime = $this.data('appointment-time'),
                    patientName = $this.data('patient-name')
                ;

                _this.showModalMarkAsNoShow({
                    appointmentId,
                    appointmentTime,
                    patientName,
                    doneCallback: (data) => {
                        _this.objects.$modalTimeslotInfo.modal('hide');

                        $.notify({
                            message: 'Appointment has been marked as no-show successfully!'
                        }, {
                            type: 'success',
                            z_index: 1030
                        });

                        _this.objects.calendar.view();
                    }
                });
            })
            .on('click', '[data-action=markAsLate]', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    appointmentId = $this.data('appointment-id'),
                    appointmentTime = $this.data('appointment-time'),
                    patientName = $this.data('patient-name')
                ;

                _this.showModalMarkAsLate({
                    appointmentId,
                    appointmentTime,
                    patientName,
                    doneCallback: (data) => {
                        _this.objects.$modalTimeslotInfo.modal('hide');

                        $.notify({
                            message: 'Appointment has been marked as late successfully!'
                        }, {
                            type: 'success',
                            z_index: 1030
                        });

                        _this.objects.calendar.view();
                    }
                });
            })
            .on('click', '[data-action=createAppointmentForOtherDoctor]', (event) => {
                event.preventDefault();

                _this.showModalCreateAppointment();
            })
            .on('show.bs.modal', '.modal-timeslot-info', (event) => {
                $('.event-item').tooltip('hide');
            })
        //prevent the collapse of event list when interacting with modals
            .on('click', '.modal-timeslot-info, .modal-add-new-appointment, .modal-add-new-patient', (event) => {
                event.stopPropagation();
            })
        ;

        _this.bindModalTimeslotInfoEvents();
    };

    /**
     * @memberOf pageWorkingCalendar
     * @function fetchAppointment
     * @TODO consolidate it
     * @param appointmentId
     * @param doneCallback
     * @param failCallback
     */
    _this.fetchAppointment = ({appointmentId, doneCallback, failCallback}) => {
        manaDrApplication.emit('window/loading/show');

        let requestRoute;
        switch(dashboardType){
            case 'admin':
                requestRoute = 'admin.appointment.fetch';
                break;
            case 'doctor':
            default:
                requestRoute = 'appointment.fetch';
                break;
        }

        let request = $.ajax({
            url: laroute.route(requestRoute, {appointment: appointmentId}),
            method: 'GET'
        });

        request
            .done((response) => {
                if ('function' === typeof doneCallback) {
                    doneCallback(response);
                }
            })
            .fail((e, data) => {
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            })
            .always(()=>{
                manaDrApplication.emit('window/loading/hide');
            })
        ;
    }

    _this.showModalSendAppointmentMessage = ({appointmentId}) => {
        sandbox.emit('modalSendAppointmentMessage/show', {appointmentId})
    };

    _this.showModalCreateAppointment = () => {
        sandbox.emit('modalCreateAppointment/show', {});
    };

    /**
     * @memberOf pageWorkingCalendar
     * @function bindModalTimeslotInfoEvents
     * @description Bind modal-timeslot-info event listeners
     */
    _this.bindModalTimeslotInfoEvents = () => {
        _this.objects.$modalTimeslotInfo
            .on('click', '[data-action=blockTimeslot]', (event) => {
                event.preventDefault();
                event.stopPropagation();

                let $this = $(event.currentTarget),
                    targetId = $this.data('id'),
                    doctorId = _get(_this.data, 'doctor.id')
                ;

                _this.showmodalBlockTimeslots({
                    ids: [targetId],
                    doctorId,
                    doneCallback: () => {
                        _this.objects.$modalTimeslotInfo.modal('hide');

                        $.notify({
                            message: 'Timeslot blocked successfully!'
                        }, {
                            type: 'success',
                            z_index: 1030
                        });

                        _this.objects.calendar.view();
                    },
                    failCallback: (errorMessages) => {}
                });
            })
            .on('click', '[data-action=deleteTimeslot]', (event) => {
                event.preventDefault();
                event.stopPropagation();

                let $this = $(event.currentTarget),
                    targetId = $this.data('id')
                ;

                bootbox.confirm('Are you sure to delete this timeslot?<br /><b>Note: you are only able to delete a timing when it doesn\'t have any appointment yet</b>', (result) => {
                    if(result){
                        manaDrApplication.emit('window/loading/show');

                        let request = $.ajax({
                            url: laroute.route(_get(_this.data, 'routes.destroyTimeslot'), {doctor: _get(_this.data, 'doctor.id'), doctorTimetable: targetId}),
                            method: 'DELETE',
                            dataType: 'json'
                        });

                        request
                            .done((response) => {
                                _this.objects.$modalTimeslotInfo.modal('hide');

                                $.notify({
                                    message: 'Timeslot deleted successfully!'
                                }, {
                                    type: 'success',
                                    z_index: 1140
                                });

                                _this.objects.calendar.view();
                            })
                            .fail((e, data) => {
                                let message = '';

                                if(e
                                    && e.responseJSON
                                    && e.responseJSON.message
                                    && e.responseJSON.message.length){
                                    message = e.responseJSON.message;
                                } else {
                                    message = 'The request cannot be processed';
                                }

                                $.notify({
                                    message: message
                                }, {
                                    type: 'warning',
                                    z_index: 1140
                                });
                            })
                            .always(() => {
                                _this.objects.$modalTimeslotInfo.data('handled.bootstrapCalendar', false);
                                manaDrApplication.emit('window/loading/hide');
                            })
                        ;
                    }
                })
            })
            .on('click', '[data-action=unblockTimeslot]', (event) => {
                event.preventDefault();
                event.stopPropagation();

                let $this = $(event.currentTarget),
                    targetId = $this.data('id')
                    ;

                bootbox.confirm('Are you sure to unblock this timetable?', (result) => {
                    if(result){
                        manaDrApplication.emit('window/loading/show');

                        let request = $.ajax({
                            url: laroute.route(_get(_this.data, 'routes.unblockTimeslot'), {doctor: _get(_this.data, 'doctor.id'), doctorTimetable: targetId}),
                            method: 'POST',
                            dataType: 'json'
                        });

                        request
                            .done((response) => {
                                _this.objects.$modalTimeslotInfo.modal('hide');

                                $.notify({
                                    message: 'Timeslot unblocked successfully!'
                                }, {
                                    type: 'success',
                                    z_index: 1140
                                });

                                _this.objects.calendar.view();
                            })
                            .fail((e, data) => {
                                let message = '';

                                if(e
                                    && e.responseJSON
                                    && e.responseJSON.message
                                    && e.responseJSON.message.length){
                                    message = e.responseJSON.message;
                                } else {
                                    message = 'The request cannot be processed';
                                }

                                $.notify({
                                    message: message
                                }, {
                                    type: 'warning',
                                    z_index: 1140
                                });
                            })
                            .always(()=> {
                                manaDrApplication.emit('window/loading/hide');
                            })
                    }
                })
            })
            .on('click', '[data-action=addAppointment]', (event) => {
                event.preventDefault();
                event.stopPropagation();

                let $this = $(event.currentTarget),
                    selectedDate = $this.data('date'),
                    selectedClinicId = $this.data('clinic-id'),
                    selectedAppointmentTypeId = $this.data('appointment-type-id'),
                    selectedTimeslotId = $this.data('timetable-id')
                ;

                _this.showModalAddNewAppointment({
                    clinics: _this.data.doctorClinics,
                    conditions: _this.data.conditions,
                    timeslots: _this.data.timeSlots[selectedDate],

                    selectedDate: selectedDate,
                    selectedClinicId: selectedClinicId,
                    selectedAppointmentTypeId: selectedAppointmentTypeId,
                    selectedTimeslotId: selectedTimeslotId
                });
            })
            .on('hide.bs.modal', (event) => {
                let $this = $(event.currentTarget);

                $this.data('handled.bootstrapCalendar', false);
            })
        ;
    }

    /**
     * @memberOf pageWorkingCalendar
     * @function showModalCreateTimeSlots
     * @description Show modal-create-timeslots
     */
    _this.showModalCreateTimeSlots = () => {
        let $modal = bootbox.dialog({
            title: 'Create Timeslots',
            message: swig.render(_this.templates.modalCreateTimeSlots, {
                locals: _this.data
            }),
            className: 'modal-create-timeslots',
            buttons: {
                'submit': {
                    label: '<i class="fa fa-fw fa-calendar-plus-o"></i> Confirm and submit',
                    className: 'btn btn-primary',
                    callback: (event) => {
                        var $form = $(event.delegateTarget).find('form');
                        $form.submit();
                        return false;
                    }
                }
            }
        });

        $modal
            .on('shown.bs.modal', () => {
                let $form = $modal.find('form'),
                    $selectAppointmentType = $form.find('#form_create_timeslots__select_appointment_type'),
                    $selectDuration = $form.find('#form_create_timeslots__select_duration')
                ;

                $('.add-datepicker').datepicker({
                    multidate: true,
                    maxViewMode: "month",
                    weekStart: 1,
                    startDate: moment().format('DD/MM/YYYY'),
                    format: 'dd/mm/yyyy',
                    disableTouchKeyboard: true,
                    clearBtn: true
                });

                $selectDuration.chosen({
                    width: '100%'
                });

                $selectAppointmentType
                    .on('change', (event) => {
                        let $this = $(event.currentTarget),
                            $selectedOption = $this.children(':selected'),
                            selectedDefaultDuration = $selectedOption.data('default-duration')
                        ;

                        if($selectDuration.children('option[value="'+selectedDefaultDuration+'"]').length){
                            $selectDuration
                                .val(selectedDefaultDuration)
                                .trigger('chosen:updated')
                            ;
                        }
                    })
                ;

                $form.validate({
                    rules:{
                        clinic: {
                            required: true
                        },
                        date: {
                            required: true
                        },
                        fromTime: {
                            required: true
                        },
                        endTime: {
                            required: true
                        },
                        appointmentType: {
                            required: true
                        },
                        duration :{
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

                        let isSubmitting = parseInt($form.data('is-submitting'));

                        if(isSubmitting){
                            return;
                        }

                        let formData = $form.serialize();

                        manaDrApplication.emit('window/loading/show');
                        $form.data('is-submitting', 1);
                        $modal.find(':input').prop('disabled', true);

                        var request = $.ajax({
                            url: laroute.route(_get(_this.data, 'routes.createTimeslots'), {doctor: _get(_this.data, 'doctor.id')}),
                            method: "POST",
                            data: formData,
                            dataType: "json"
                        });

                        request
                            .done(function(data) {
                                var currentTimezone = data.timezone;
                                if (data.success) {
                                    //get clinic's timezone

                                    let message = swig.render(_this.templates.modalCreateTimeSlotsResults, {
                                        locals: _assign({}, data, {
                                            currentTimezone: currentTimezone
                                        })
                                    });

                                    //1. Show response message
                                    let $modalResults = bootbox.dialog({
                                        title: 'Results',
                                        message: message,
                                        className: "modal-add-timeslots modal-results"
                                    });

                                    $modalResults.on('hidden.bs.modal', (event) => {
                                        //2. Hide the modal
                                        $modal.modal('hide');
                                        manaDrApplication.emit('window/loading/hide');

                                        //3. Re-render the calendar
                                        _this.objects.calendar.view();

                                    });
                                }
                            })
                            .fail((e, data) => {
                                let message = '';

                                if(e
                                    && e.responseJSON
                                    && e.responseJSON.message
                                    && e.responseJSON.message.length){
                                    message = e.responseJSON.message;
                                } else {
                                    message = 'The request cannot be processed';
                                }

                                bootbox.alert(message, () => {
                                    $form.data('is-submitting', 0);
                                    $modal.find(':input').prop('disabled', false);
                                    manaDrApplication.emit('window/loading/hide');
                                })
                            })
                        ;
                    }
                })
            })
        ;
    }

    _this.showmodalBlockTimeslots = ({ids, doctorId, doneCallback, failCallback}) => {
        manaDrApplication.emit('modalBlockTimeslots/show', {ids, doctorId, doneCallback, failCallback})
    }

    /**
     * @memberOf pageWorkingCalendar
     * @function showModalAddNewAppointment
     * @description Show modal-add-new-appointment
     * @param   {Object}    data
     */
    _this.showModalAddNewAppointment = (data) => {
        let $modal = bootbox.dialog({
                title: 'Add New Appointment',
                message: swig.render(_this.templates.modalAddNewAppointment, {
                    locals: data
                }),
                className: 'modal-add-new-appointment',
                buttons: {
                    'reset': {
                        label: 'Reset',
                        className: 'btn',
                        callback: (event) => {
                            var $form = $(event.delegateTarget).find('form');
                            $form.validate().resetForm();
                            //@TODO: Run reset twice to make sure all the timeslots will be cleared
                            $form[0].reset();
                            $form[0].reset();
                            return false;
                        }
                    },
                    'submit': {
                        label: 'Submit',
                        className: 'btn btn-primary',
                        callback: (event) => {
                            var $form = $(event.delegateTarget).find('form');
                            $form.submit();
                            return false;
                        }
                    }
                }
            }),
            selectedTimeslotId = data.selectedTimeslotId
        ;

        $modal
            .on('shown.bs.modal', (event) => {
                let $form = $modal.find('form'),
                    $selectClinic = $form.find('#form_add_new_appointment__select_clinic_id'),
                    $selectAppointmentType = $form.find('#form_add_new_appointment__select_appointment_type'),
                    $inputPatient = $form.find('#form_add_new_appointment__input_search_patient'),
                    $selectPatient = $form.find('#form_add_new_appointment__select_patient_id'),
                    $groupAttachments = $form.find('#form_add_new_appointment__group_attachments'),
                    updateListTimeslots = (data) => {
                        let clinicId = $selectClinic.val(),
                            appointmentTypeId = $selectAppointmentType.val()
                        ;

                        if(!clinicId || !appointmentTypeId){
                            return [];
                        }
                        let timeslots = _get(data, 'timeslots['+clinicId+']['+appointmentTypeId+']', []);

                        let formattedTimeslots = _map(timeslots, (availableTimeslot) => {
                            let currentTimezone = _get(availableTimeslot, 'clinic.time_zone', '');

                            return {
                                id: availableTimeslot.id,
                                currentTimezone,
                                startAt: moment(moment.utc(availableTimeslot.start_at).unix() * 1000).utcOffset(currentTimezone).tz(currentTimezone),
                                endAt: moment(moment.utc(availableTimeslot.end_at).unix() * 1000).utcOffset(currentTimezone).tz(currentTimezone)
                            }
                        });

                        return _filter(formattedTimeslots, (timeslots) => {
                            return {

                            }
                        });
                    },
                    renderSelectTimeslots = (data) => {
                        let availableTimeslots = updateListTimeslots(data),
                            html = swig.render(_this.templates.modalAddNewAppointment_SelectTimeslot, {
                                locals: {
                                    timeslots: availableTimeslots,
                                    selectedTimeslotId: selectedTimeslotId
                                }
                            })
                        ;

                        $('#form_add_new_appointment__group_timeslot').html(html);
                    },
                    searchPatients = (term) => {
                        let $select2Object = $selectPatient.data('select2'),
                            $search = $select2Object.dropdown.$search || $select2Object.selection.$search
                        ;

                        $select2Object.results.clear();

                        $select2Object.trigger('open');
                        $search.val(term);
                        $search.trigger('keyup');
                    },
                    renderHouseCallAdditionalInformation = () => {
                        let shouldShow = parseInt($selectAppointmentType.find(':selected').attr('is-house-call-appointment-type')),
                            $additionalGroups = $('#form_add_new_appointment__group_patient_address, #form_add_new_appointment__group_patient_location')
                        ;

                        if(shouldShow){
                            $additionalGroups.removeClass('hide')
                        } else {
                            $additionalGroups.addClass('hide');
                        }
                    }
                ;

                $selectPatient
                    .select2({
                        dropdownParent: $modal,
                        placeholder: "Search by Name/ID Number",
                        ajax: {
                            url: laroute.route(_get(_this.data, 'routes.searchPatients')),
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    text: $.trim(params.term), // search term
                                    page: params.page || 1,
                                };
                            },
                            transport: function (params, success, failure) {
                                let request = new $.ajax(params.url, params);
                                request
                                    .done((response) => {
                                        success(response);
                                    })
                                    .fail(() => {
                                        failure();
                                    })
                                ;

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
                                        more: (params.page * 20) < result.count
                                    }
                                };
                            },
                            cache: true
                        },
                        escapeMarkup: function (markup) { return markup; },
                        minimumInputLength: 3,
                        minimumResultsForSearch: Infinity,
                        templateResult: function (patient) {
                            if (patient.loading) return patient.text;

                            var markupTemplate = multiline(function(){/*!@preserve
                            <div class='select2-result-patient clearfix'>
                                <div class='select2-result-patient__avatar pull-left'>
                                    <img src='{{patient.profile_image_url}}' width='48' height='48'/>
                                </div>
                                <div class='select2-result-patient__meta pull-left' style='padding-left: 10px;'>
                                    <div class='select2-result-patient__title'>{{ patient.full_name }} (<b>#{{ patient.id }}</b>)</div>
                                    <div class='select2-result-patient__statistics'>
                                    {% if (patient.date_of_birth && patient.date_of_birth.length) %}
                                        <div class='select2-result-patient__forks'>Date of Birth: {{ patient.date_of_birth }}</div>
                                    {% endif %}

                                    {% if (patient.id_number && patient.id_number.length) %}
                                        <div class='select2-result-patient__forks'>National ID: {{ patient.id_number }}</div>
                                    {% endif %}

                                    {% if (patient.country_name && patient.country_name.length) %}
                                        <div class='select2-result-patient__stargazers'>Country: {{ patient.country_name }}</div>
                                    {% endif %}

                                    {% if (patient.imported_name && patient.imported_name.length) %}
                                        <div class='select2-result-patient__stargazers text-red'><i>Imported Name: {{ patient.imported_name }}</i></div>
                                    {% endif %}

                                    {% if (patient.imported_email && patient.imported_email.length) %}
                                        <div class='select2-result-patient__stargazers text-red'><i>Imported Email: {{ patient.imported_email }}</i></div>
                                    {% endif %}

                                    {% if (patient.phone && patient.phone.length) %}
                                        <div class='select2-result-patient__stargazers text-red'><i>Imported Phone: {{ patient.phone }}</i></div>
                                    {% endif %}
                                    </div>
                                </div>
                            </div>
                            */console.log});

                            return swig.render(markupTemplate, {
                                locals: {
                                    patient: patient
                                }
                            });
                        },
                        templateSelection: function (patient) {
                            return patient.text;
                        }
                    })
                ;

                $inputPatient
                    .on('focus', (event) => {
                        $inputPatient.val('');
                    })
                ;

                $groupAttachments
                    .dropzone({
                        acceptedFiles: '.jpg, .jpeg, .png',
                        paramName: 'file',
                        previewsContainer: '#form_add_new_appointment__group_attachments__previews',
                        clickable: '#form_add_new_appointment__group_attachments__button_upload',
                        previewTemplate: `<div class="item">
                            <div class="thumbnail">
                                <img data-dz-thumbnail />
                                <div class="xxs progress">
                                    <div class="dz-upload progress-bar progress-bar-green" data-dz-uploadprogress></div>
                                </div>
                                <div class="overlay loading">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </div>
                            </div>
                            <div class="content">
                                <div class="title">
                                    <span data-dz-name></span>
                                    <div class="pull-right">
                                        <a data-dz-remove href="#" data-toggle="tooltip" data-title="Remove">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="description">
                                    <textarea class="form-control" placeholder="Description"></textarea>
                                </div>
                                <div class="text error">
                                    <span data-dz-errormessage></span>
                                </div>
                            </div>
                        </div>`,
                        url: laroute.route(_get(_this.data, 'routes.uploadFile')),
                        autoProcessQueue: true,
                        params: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        processing: () => {

                        },
                        success: (file, response) => {
                            let $previewElement = $(file.previewElement),
                                uploadedFileId = _get(response, 'file.id')
                            ;
                            //assign uploaded file's id to textarea name so we can attach file to created appointment later
                            if(uploadedFileId){
                                $previewElement.find('textarea').attr('name', `files[${uploadedFileId}][description]`);
                            }
                        }
                    })
                ;

                $form
                    .validate({
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
                            },

                            patient_address: {
                                required: () => {
                                    return parseInt($('[name=appointment-type] :selected').attr('is-house-call-appointment-type'));
                                }
                            },

                            patient_location_lat: {
                                required: () => {
                                    return parseInt($('[name=appointment-type] :selected').attr('is-house-call-appointment-type'));
                                }
                            },

                            patient_location_lng: {
                                required: () => {
                                    return parseInt($('[name=appointment-type] :selected').attr('is-house-call-appointment-type'));
                                }
                            }
                        },
                        messages: {
                            "appointment-type": {
                                min: 'Please select an appointment type',
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
                        submitHandler: (form, event) => {
                            event.preventDefault();

                            let isSubmitting = parseInt($form.data('is-submitting'));

                            if(isSubmitting){
                                return;
                            }

                            let formData = $(form).serialize(),
                                timeslotId = $(form).find('[name=appointment-time-slot]').val()
                            ;

                            manaDrApplication.emit('window/loading/show');
                            $form.data('is-submitting', 1);
                            $modal.find(':input').prop('disabled', true);

                            let request = $.ajax({
                                url: laroute.route(_get(_this.data, 'routes.createAppointment'), {doctor: _get(_this.data, 'doctor.id'), doctorTimetable: timeslotId}),
                                method: "POST",
                                data: formData,
                                dataType: "json"
                            });

                            request
                                .done((response) => {
                                    let message = 'New appointment has been created';

                                    //@TODO clear calendar modal's cache
                                    bootbox.alert(message, ()=>{
                                        bootbox.hideAll();
                                        $('.modal-timeslot-info').modal('hide');
                                        manaDrApplication.emit('window/loading/hide');
                                        _this.objects.calendar.view();
                                    });
                                })
                                .fail((e, data) => {
                                    let message = '';

                                    if(e
                                        && e.responseJSON
                                        && e.responseJSON.message
                                        && e.responseJSON.message.length){
                                        message = e.responseJSON.message;
                                    } else {
                                        message = 'The request cannot be processed';
                                    }

                                    bootbox.alert(message, () => {
                                        $form.data('is-submitting', 0);
                                        $modal.find(':input').prop('disabled', false);
                                        manaDrApplication.emit('window/loading/hide');
                                    })
                                })
                            ;
                        }
                    })
                ;

                $form
                    .on('click', '[data-action=addNewPatient]', (event) => {
                        event.preventDefault();

                        let $this = $(event.currentTarget);

                        _this.showModalAddNewPatient({
                            data: {
                                clinics: _this.data.doctorClinics,
                                phoneCountryCodes: _this.data.phoneCountryCodes,
                                countries: _this.data.countries
                            },
                            objects: {
                                $selectPatient: $selectPatient
                            }
                        });
                    })
                    .on('click', '[data-action=searchPatients]', (event) => {
                        event.preventDefault();

                        searchPatients($inputPatient.val());
                    })
                    .on('click', '[data-action=showLocationPicker]', (event) => {
                        event.preventDefault();

                        let address = $form.find('[name=patient_address]').val(),
                            position = {
                                lat: parseInt($form.find('[name=patient_location_lat]').val()),
                                lng: parseInt($form.find('[name=patient_location_lng]').val())
                            },
                            doneCallback = ({position, address}) => {
                                $form.find('[name=patient_address]').val(address);
                                $form.find('[name=patient_location_lat]').val(position.lat);
                                $form.find('[name=patient_location_lng]').val(position.lng);
                            }
                        ;

                        manaDrApplication.emit('modalLocationPicker/show', {
                            address,
                            position,
                            doneCallback
                        })
                    })
                    .on('change', '#form_add_new_appointment__select_clinic_id', (event) => {
                        renderSelectTimeslots(data);
                    })
                    .on('change', '#form_add_new_appointment__select_appointment_type', (event) => {
                        renderHouseCallAdditionalInformation();
                        renderSelectTimeslots(data);
                    })
                    .on('reset', (event) => {
                        $selectPatient.html('').trigger('change')
                        renderSelectTimeslots(data);
                    })
                ;

                $selectClinic.trigger('change');
                $selectAppointmentType.trigger('change');
            })
        ;
    };

    /**
     * @memberOf pageWorkingCalendar
     * @function showModalAddNewPatient
     * @description Show modal-add-new-patient
     * @param   {Object}    data
     */
    _this.showModalAddNewPatient = ({data, objects}) => {
        let $modal = bootbox.dialog({
                title: 'Add New Patient',
                message: swig.render(_this.templates.modalAddNewPatient, {
                    locals: data
                }),
                size: 'large',
                className: 'modal-add-new-patient',
                buttons: {
                    'reset': {
                        label: 'Reset',
                        className: 'btn',
                        callback: (event) => {
                            var $form = $(event.delegateTarget).find('form');
                            $form.validate().resetForm();
                            $form[0].reset();
                            return false;
                        }
                    },
                    'submit': {
                        label: 'Submit',
                        className: 'btn btn-primary',
                        callback: (event) => {
                            var $form = $(event.delegateTarget).find('form');
                            $form.submit();
                            return false;
                        }
                    }
                }
            }),
            $form = $modal.find('form'),
            $inputDateOfBirth = $form.find('[name=date_of_birth]')
        ;

        $inputDateOfBirth
            .datepicker({
                format: 'dd/mm/yyyy',
                weekStart: 1,
                minViewMode: "month",
                maxViewMode: "years",
                disableTouchKeyboard: true,
                autoclose: true,
                defaultViewDate: {
                    year: 1980,
                    month: 0,
                    day: 1
                },
                startView: "years",
                clearBtn: true
            })
        ;

        $modal
            .on('shown.bs.modal', (event) => {
                let $form = $modal.find('form'),
                    $selectIssueCountryId = $form.find('[name="issue_country_id"]'),
                    $inputNationalIDNumber = $form.find('[name=id_number]'),
                    $inputGroupIDNumber = $inputNationalIDNumber.closest('.form-group'),
                    checkIDNumberExistence = function(){
                        let issueCountryId = $selectIssueCountryId.val(),
                            idNumber = $inputNationalIDNumber.val()
                        ;

                        if(idNumber.length) {
                            $selectIssueCountryId.prop('disabled', true);
                            $inputNationalIDNumber
                                .prop('disabled', true)
                                .data('value', idNumber)
                            ;
                            $inputGroupIDNumber.data('is-loading', 1);

                            let queryData = {
                                issue_country_id: issueCountryId,
                                id_number: idNumber,
                            },
                                $message = $inputGroupIDNumber.find('.help-block')
                            ;

                            let requestChannel = (dashboardType === 'admin') ? 'service/admin/patients/getByIdNumber' : 'service/doctor/patients/getByIdNumber';

                            sandbox.emit(requestChannel, {
                                data: queryData,
                                doneCallback: response => {
                                    //a patient already exist with the given query
                                    let message = swig.render(_this.templates.messageIDNumberExisted, {
                                            locals: response,
                                        });

                                    $inputGroupIDNumber.addClass('has-error');
                                    if($message.length) {
                                        $message.html(message).css('display','');
                                    } else {
                                        $message = $(`<p id="form_add_new_patient__input_id_number-error" class="help-block">${message}</p>`)
                                            .appendTo($inputGroupIDNumber)
                                        ;
                                    }

                                    $selectIssueCountryId.prop('disabled', false);
                                    $inputNationalIDNumber.prop('disabled', false);
                                    $inputGroupIDNumber.data('is-loading', 0);
                                    $message.on('click', '[data-action=selectPatient]', event => {
                                        event.preventDefault();

                                        let id = _get(response, 'data.id', 0),
                                            optionText = _get(response, 'data.text', id)
                                        ;

                                        if(id && objects.$selectPatient){
                                            objects.$selectPatient.append(`<option selected value="${id}">${optionText}</option>`);
                                        }
                                        $modal.modal('hide');
                                    });
                                },
                                failCallback: (e, data) => {
                                    if(e.status === 422){
                                        //invalid NRIC
                                        let $message = $inputGroupIDNumber.find('.help-block');
                                        let message = _get(e, 'responseJSON.message', '');
                                        $inputGroupIDNumber.addClass('has-error');
                                        if($message.length) {
                                            $message.html(message).css('display','');
                                        } else {
                                            $message = $(`<p id="form_add_new_patient__input_id_number-error" class="help-block">${message}</p>`)
                                                .appendTo($inputGroupIDNumber)
                                            ;
                                        }
                                    } else {
                                        $inputGroupIDNumber.removeClass('has-error');
                                    }
                                    $selectIssueCountryId.prop('disabled', false);
                                    $inputNationalIDNumber.prop('disabled', false);
                                    $inputGroupIDNumber.data('is-loading', 0);
                                    $message.remove();
                                },
                            });
                        }
                    }
                ;

                $form
                    .on('reset', event => {
                        setTimeout(() => $inputNationalIDNumber.data('value', ''));
                    })
                ;

                $form
                    .validate({
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
                                        return $this.val().length;
                                    }
                                },
                                validateEmail: '',
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
                        submitHandler: (form, event) => {
                            event.preventDefault();

                            let isSubmitting = parseInt($form.data('is-submitting'));

                            if(isSubmitting){
                                return;
                            }

                            let formData = $(form).serialize();

                            manaDrApplication.emit('window/loading/show');
                            $form.data('is-submitting', 1);
                            $modal.find(':input').prop('disabled', true);

                            let request = $.ajax({
                                url: laroute.route(_get(_this.data, 'routes.createPatient')),
                                method: "POST",
                                data: formData,
                                dataType: "json"
                            });

                            request
                                .done((response) => {
                                    let id = _get(response, 'data.id', 0),
                                        fullName = _get(response, 'data.full_name', ''),
                                        optionText = _get(response, 'data.text', id)
                                    ;

                                    let message = `Patient <b>${fullName}</b> created successfully!`;

                                    bootbox.alert(message, ()=>{
                                        if(id && objects.$selectPatient){
                                            objects.$selectPatient.append(`<option selected value="${id}">${optionText}</option>`);
                                        }
                                        $modal.modal('hide');
                                        manaDrApplication.emit('window/loading/hide');
                                    });
                                })
                                .fail((e, data) => {
                                    let message = '';

                                    if(e
                                        && e.responseJSON
                                        && e.responseJSON.message
                                        && e.responseJSON.message.length){
                                        message = e.responseJSON.message;
                                    } else {
                                        message = 'The request cannot be processed';
                                    }

                                    bootbox.alert(message, () => {
                                        $form.data('is-submitting', 0);
                                        $modal.find(':input').prop('disabled', false);
                                        manaDrApplication.emit('window/loading/hide');
                                    })
                                })
                            ;
                        }
                    });

                $selectIssueCountryId
                    .on('change', event => {
                        event.preventDefault();

                        checkIDNumberExistence();
                    })
                ;

                $inputNationalIDNumber
                    .on('blur', event => {
                        event.preventDefault();

                        let inputNationalIDNumberValue = $inputNationalIDNumber.val(),
                            oldInputNationalIDNumberValue = $inputNationalIDNumber.data('value')
                        ;

                        if(inputNationalIDNumberValue !== oldInputNationalIDNumberValue) {
                            checkIDNumberExistence();
                        }
                    })
                ;
            })
        ;
    };

    _this.showModalCreateHealthSummary = ({appointmentId, doneCallback, failCallback}) => {

    }

    /**
     * @memberOf pageWorkingCalendar
     * @function markAppointmentAsVisited
     * @param appointmentId
     * @param doneCallback
     * @param failCallback
     */
    _this.markAppointmentAsVisited = ({appointmentId, doneCallback, failCallback}) => {
        manaDrApplication.emit('window/loading/show');

        //@TODO: Organize this better
        let requestRoute;
        switch(dashboardType){
            case 'admin':
                requestRoute = 'admin.appointment.markAsVisited';
                break;
            case 'doctor':
            default:
                requestRoute = 'appointment.markAsVisited';
                break;
        }

        manaDrApplication.emit('window/loading/show');

        let request = $.ajax({
            url: laroute.route(requestRoute, {appointment: appointmentId}),
            method: 'GET'
        });

        request
            .done((response) => {
                if ('function' === typeof doneCallback) {
                    doneCallback(response);
                }
            })
            .fail((e, data) => {
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            })
            .always(()=>{
                manaDrApplication.emit('window/loading/hide');
            })
        ;
    };

    /**
     * @memberOf pageWorkingCalendar
     * @function markAppointmentAsNoShow
     * @param appointmentId
     * @param doneCallback
     * @param failCallback
     */
    _this.markAppointmentAsNoShow = ({appointmentId, doneCallback, failCallback}) => {
        manaDrApplication.emit('window/loading/show');

        //@TODO: Organize this better
        let requestRoute;
        switch(dashboardType){
            case 'admin':
                requestRoute = 'admin.appointment.markAsNoShow';
                break;
            case 'doctor':
            default:
                requestRoute = 'appointment.markAsNoShow';
                break;
        }

        manaDrApplication.emit('window/loading/show');

        let request = $.ajax({
            url: laroute.route(requestRoute, {appointment: appointmentId}),
            method: 'GET'
        });

        request
            .done((response) => {
                if ('function' === typeof doneCallback) {
                    doneCallback(response);
                }
            })
            .fail((e, data) => {
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            })
            .always(()=>{
                manaDrApplication.emit('window/loading/hide');
            })
        ;
    };

    /**
     * @memberOf pageWorkingCalendar
     * @function markAppointmentAsLate
     * @param appointmentId
     * @param doneCallback
     * @param failCallback
     */
    _this.markAppointmentAsLate = ({appointmentId, doneCallback, failCallback}) => {
        manaDrApplication.emit('window/loading/show');

        //@TODO: Organize this better
        let requestRoute;
        switch(dashboardType){
            case 'admin':
                requestRoute = 'admin.appointment.markAsLate';
                break;
            case 'doctor':
            default:
                requestRoute = 'appointment.markAsLate';
                break;
        }

        manaDrApplication.emit('window/loading/show');

        let request = $.ajax({
            url: laroute.route(requestRoute, {appointment: appointmentId}),
            method: 'GET'
        });

        request
            .done((response) => {
                if ('function' === typeof doneCallback) {
                    doneCallback(response);
                }
            })
            .fail((e, data) => {
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            })
            .always(()=>{
                manaDrApplication.emit('window/loading/hide');
            })
        ;
    };

    /**
     * @memberOf pageWorkingCalendar
     * @function showModalMarkAsVisited
     * @param appointmentId
     * @param doneCallback
     * @param failCallback
     */
    _this.showModalMarkAsVisited = ({appointmentId, doneCallback, failCallback}) => {
        bootbox.confirm('Are you sure that the patient has already visited?', (result) => {
            if(result){
                _this.fetchAppointment({
                    appointmentId,
                    doneCallback: (data) => {
                        let appointment = humps.camelizeKeys(data);
                        if(!appointment.healthSummary){
                            manaDrApplication.emit('modalHealthSummary/showAdd', {
                                appointmentId,
                                doneCallback: function () {
                                    _this.markAppointmentAsVisited({appointmentId, doneCallback, failCallback});
                                }
                            });
                        } else {
                            _this.markAppointmentAsVisited({appointmentId, doneCallback, failCallback});
                        }
                    },
                    failCallback: (e, data) => {
                        if ('function' === typeof failCallback) {
                            failCallback(e, data);
                        }
                    }
                });
            }
        })
    };

    /**
     * @memberOf pageWorkingCalendar
     * @function showModalMarkAsNoShow
     * @param appointmentId
     * @param patientName
     * @param appointmentTime
     * @param doneCallback
     * @param failCallback
     */
    _this.showModalMarkAsNoShow = ({appointmentId, patientName, appointmentTime, doneCallback, failCallback}) => {
        bootbox.dialog({
            title: "You are going to mark this appointment as <b>No Show</b>",
            message: swig.render(_this.templates.modalMarkAsNoShowContent, {
                locals: {
                    patientName,
                    appointmentTime,
                }
            }),
            buttons: {
                cancel: {
                    label: "Cancel",
                    className: "btn-default"
                },
                confirm: {
                    label: "Confirm",
                    className: "btn-primary",
                    callback: (event) => {
                        _this.markAppointmentAsNoShow({ appointmentId, doneCallback, failCallback });
                    }
                }
            }
        });
    };

    /**
     * @memberOf pageWorkingCalendar
     * @function showModalMarkAsLate
     * @param appointmentId
     * @param patientName
     * @param appointmentTime
     * @param doneCallback
     * @param failCallback
     */
    _this.showModalMarkAsLate = ({appointmentId, patientName, appointmentTime, doneCallback, failCallback}) => {
        bootbox.dialog({
            title: "You are going to mark this appointment as <b>Late</b>",
            message: swig.render(_this.templates.modalMarkAsLateContent, {
                locals: {
                    patientName,
                    appointmentTime,
                }
            }),
            buttons: {
                cancel: {
                    label: "Cancel",
                    className: "btn-default"
                },
                confirm: {
                    label: "Confirm",
                    className: "btn-primary",
                    callback: (event) => {
                        _this.markAppointmentAsLate({ appointmentId, doneCallback, failCallback });
                    }
                }
            }
        });
    };

    /**
     * @memberOf pageWorkingCalendar
     * @function renderBoxViewModes
     * @description switch the calendar to selected view mode
     * @param   {String} viewMode
     */
    _this.renderBoxViewModes = (viewMode) => {
        $('#box_calendar_view_modes button[data-calendar-view="' + viewMode + '"]')
            .removeClass('btn-normal')
            .addClass('btn-primary')
            .siblings('.btn-primary')
            .removeClass('btn-primary')
            .addClass('btn-normal')
        ;
    }

    /**
     * @memberOf pageWorkingCalendar
     * @function renderFilter
     * @description render the filter widget
     */
    _this.renderFilters = () => {}

    /**
     * @memberOf pageWorkingCalendar
     * @function renderCalendar
     * @description render the calendar section
     */
    _this.renderCalendar = () => {
        let currentView = _this.data.currentView || 'month',
            currentDay = _this.data.currentDay
        ;

        if(!_this.objects.$calendar.length){
            return console.log('Please check the DOM');
        }

        _this.objects.calendar = _this.objects.$calendar
            .calendar({
                view: currentView,
                weekbox: false,
                first_day: 1,
                day: currentDay,
                time_start: '07:00',
                time_end: '24:00',
                time_split: 5,
                tmpl_path: laroute.url('partials/doctor-calendar-js/', []),
                tmpl_cache: false,

                modal: '.modal-timeslot-info',
                modal_type: 'template',
                modal_title: (event) => {
                    let currentTimezone = event.timezone,
                        startAt = moment(event.start).utcOffset(currentTimezone).tz(currentTimezone),
                        endAt = moment(event.end).utcOffset(currentTimezone).tz(currentTimezone)
                    ;

                    return `${startAt.format('HH:mm')} to ${endAt.format('HH:mm')} <span data-timezone="${currentTimezone}">(${startAt.format('Z')})</span> | ${startAt.format('dddd DD/MM')} <br/> ${event.clinic.name}`;
                },

                events_source: (start, end, browser_timezone) => {
                    let buildEventsUrl = (events_url, data) => {
                        let separator = (events_url.indexOf('?') < 0) ? '?' : '&',
                            url = events_url,
                            key
                        ;
                        for (key in data) {
                            url += separator + key + '=' + encodeURIComponent(data[key]);
                            separator = '&';
                        }
                        return url;
                    }

                    let baseUrl = laroute.route(_get(_this.data,'routes.feedTimeslots'), {
                        doctor: _this.data.doctor.id,
                        filters: JSON.stringify(_this.data.filters)
                    });

                    let events = [],
                        d_from = start,
                        d_to = end,
                        params = {
                            from: d_from.getTime(),
                            to: d_to.getTime(),
                            utc_offset_from: d_from.getTimezoneOffset(),
                            utc_offset_to: d_to.getTimezoneOffset()
                        }
                    ;

                    if(browser_timezone.length){
                        params.browser_timezone = browser_timezone;
                    }

                    $
                        .ajax({
                            url: buildEventsUrl(baseUrl, params),
                            dataType: 'json',
                            type: 'GET',
                            async: false
                        })
                        .done((json) => {
                            if (!json.success) {
                                $.error(json.error);
                            }
                            if (json.result) {
                                events = json.result;
                            }
                        })
                    ;

                    return events
                },
                onAfterViewLoad: function(view){
                    _this.objects.$boxCalendarHeaderTitle.text(this.getTitle().toUpperCase());

                    _this.data.currentView = view;
                    _this.renderBoxViewModes(view);

                    //display appointment type counters of each day
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
                                html += `${value} <span class="event bg-${key}"></span>`;
                            });

                            $eventList.html(html);
                        })
                        .removeClass('hide')
                    ;

                    _this.updateUrl(_this.data);

                    if(!_this.data.isCheckUpdatesScheduled){
                        _this.scheduleCheckUpdates({
                            doctorId: _get(_this.data, 'doctor.id'),
                            lastUpdatedTime: _get(_this.data, 'lastUpdatedTime')
                        });
                    }
                },
                onBeforeEventsLoad: (next) => {
                    _this.objects.$boxCalendarOverlay.removeClass('hide');
                    _this.objects.$boxCalendarHeaderTitle.html('');
                    _this.objects.$boxCalendarHeaderSubtitle.html('');
                    next();
                },
                onAfterEventsLoad: function(events){
                    let timeSlotData = _this.generateTimeSlotData(events),
                        total = events.length
                    ;

                    _this.data.timeSlots = timeSlotData;
                    _this.data.lastUpdatedTime = Date.now();
                    _this.objects.$boxCalendarHeaderSubtitle.html(total + ' timeslots');
                    _this.objects.$boxCalendarOverlay.addClass('hide');

                    if(_indexOf(['day','week'],this.options.view) >= 0){
                        let updatedStartHour = _.first(_.sortBy(_.map(events, event => moment(event.start).utcOffset(event.timezone).tz(event.timezone).format('HH:mm'))));
                        updatedStartHour = updatedStartHour < "07:00" ? updatedStartHour : "07:00";
                        this.setOptions({
                            time_start: updatedStartHour,
                        });
                        this._render();
                    }

                    let appointmentTypes = _this.generateAppointmentTypesData(events);
                    _this.renderBoxAppointmentTypeLegends({appointmentTypes});
                },
                onBeforeViewLoad: (test) => {
                    console.log('this onBeforeViewLoad', test);
                }
            });
    };

    /**
     * @memberOf pageWorkingCalendar
     * @function renderBoxAppointmentTypeLegends
     * @description render the appointment type legends box, should be triggered after each render of the calendar
     * @param appointmentTypes
     */
    _this.renderBoxAppointmentTypeLegends = ({appointmentTypes}) => {
        let html = swig.render(_this.templates.boxAppointmentTypeLegends_body, {
            locals: {appointmentTypes}
        });

        _this.objects.$boxAppointmentTypeLegends_body.html(html);
    }

    /**
     * @memberOf pageWorkingCalendar
     * @function generateTimeSlotData
     * @description convert the raw events data to a proper format
     * @param   {Array} events
     * @returns {{}}
     */
    _this.generateTimeSlotData = (events) => {
        let timeSlotData = {};
        _.forEach(events, (event, index, list) => {
            var startAt = moment(event.start).utcOffset(0).format('YYYY-MM-DD HH:mm:ss'),
                endAt = moment(event.end).utcOffset(0).format('YYYY-MM-DD HH:mm:ss'),
                date = moment(event.start).utcOffset(event.timezone).tz(event.timezone).format('YYYY-MM-DD'),
                clinicId = event.clinic.id,
                appointmentTypeId = 0
            ;

            if(event.appointmentType && event.appointmentType.id){
                appointmentTypeId = parseInt(event.appointmentType.id) || 0;
            }

            //@TODO: Bypass filtering the timeslots so we can allow multiple booking
            // if(0 == appointmentTypeId || (event.appointments && _.filter(event.appointments, function(appointment){
            //     return appointment.appointment_status.name !== "Cancelled" && appointment.appointment_status.name !== "Verification Failed"
            // }).length)){
            //     return;
            // }

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
            });
        });

        return timeSlotData;
    }

    _this.generateAppointmentTypesData = (events) => {
        return _transform(events, (result, value, key) => {
            let currentAppointmentType = _get(value, 'appointmentType'),
                currentAppointmentTypeId = _get(currentAppointmentType, 'id') +'',
                currentAppointmentTypeClass = _get(value, 'class')
            ;
            if(currentAppointmentType && currentAppointmentTypeId && !result[currentAppointmentTypeId]){
                result[currentAppointmentTypeId] = currentAppointmentType;
                result[currentAppointmentTypeId]['class'] = currentAppointmentTypeClass;
            }
        }, {});
    }

    /**
     * @memberOf pageWorkingCalendar
     * @function updateUrl
     * @description update browser's url according to current state
     * @param   {Object}    data
     */
    _this.updateUrl = (data) => {
        let url = laroute.route(_get(_this.data, 'routes.base'), {
            doctor: _get(_this.data, 'doctor.id' ),
            view: data.currentView,
            filters: JSON.stringify(data.filters),
            day: data.currentDay,
        });

        window.history.pushState(null, null, url);
    }

    _this.hideShouldUpdateNotification = () => {
        if(_this.objects.$checkUpdatesNotification){
            _this.objects.$checkUpdatesNotification.close();
        }
    }

    _this.showShouldUpdateNotification = () => {
        _this.hideShouldUpdateNotification();

        setTimeout(()=>{
            _this.objects.$checkUpdatesNotification = $.notify({
                message: '<span data-action="reloadCalendar">Your calendar got some updates, please click here to keep it up-to-date</span>'
            }, {
                type: 'info',
                z_index: 1030,
                delay: 0,
                allow_dismiss: false,
                placement: {
                    from: 'top',
                    align: 'right'
                }
            });
        }, 1000);
    }

    _this.scheduleCheckUpdates = ({doctorId, lastUpdatedTime}) => {
        // console.log(`Start check updates: ${doctorId}, ${lastUpdatedTime}, ${_this.data.checkUpdatesInterval}`);
        setTimeout(() => {
            let request = $.ajax({
                url: laroute.route(_get(_this.data, 'routes.checkUpdates'), {doctor: doctorId}),
                method: 'POST',
                dataType: 'json',
                data: {
                    last_updated_time: lastUpdatedTime
                }
            });

            request
                .done((response) => {
                    if(response && response.shouldUpdate){
                        _this.showShouldUpdateNotification();
                    } else {
                        _this.scheduleCheckUpdates({doctorId, lastUpdatedTime});
                    }
                })
                .fail((e, data) => {
                    _this.scheduleCheckUpdates({doctorId, lastUpdatedTime});
                })
            ;

            _this.data.isCheckUpdatesScheduled = true;
        }, _this.data.checkUpdatesInterval);
    };

    sandbox.on('pageWorkingCalendar/checkUpdates/request', ({doctorId, lastUpdatedTime}) => {
        _this.scheduleCheckUpdates({doctorId, lastUpdatedTime});
    });

    /**
     * @memberOf pageWorkingCalendar
     * @function init
     * @param   {Object} data
     */
    _this.init = (data) => {
        _this.data = data || {};
        _this.data.checkUpdatesInterval = 120000;
        _this.data.isCheckUpdatesScheduled = false;

        _this.objects = {};
        _this.objects.$body = $('body');
        _this.objects.$boxViewModes = $('#box_calendar_view_modes');
        _this.objects.$viewModeButtons = $('[data-calendar-view]');
        _this.objects.$nagivationButtons = $('[data-calendar-nav]');
        _this.objects.$buttonCreateTimeSlots = $('[data-action="createTimeSlots"]');

        _this.objects.$boxFilters = $('#box_calendar_filters');

        _this.objects.$boxCalendar = $('#box_calendar');
        _this.objects.$boxCalendarHeaderTitle = _this.objects.$boxCalendar.find('>.box-header>.box-title>span');
        _this.objects.$boxCalendarHeaderSubtitle = _this.objects.$boxCalendar.find('>.box-header>.box-title>small');
        _this.objects.$boxCalendarOverlay = _this.objects.$boxCalendar.find('.overlay');
        _this.objects.$boxAppointmentTypeLegends = $('#box_appointment_type_legends');
        _this.objects.$boxAppointmentTypeLegends_body = _this.objects.$boxAppointmentTypeLegends.children('.box-body');
        _this.objects.$calendar = $('#calendar');
        _this.objects.$modalTimeslotInfo = $('.modal-timeslot-info');

        _this.templates = {};
        _this.templates.modalCreateTimeSlots = multiline(()=>{/*!@preserve
        <form class="form" id="form_create_timeslots">
            <div class="form-group">
                <label for="form_create_timeslots__select_clinic_id">Clinic:</label>
                <select class="form-control" name="clinic">
                {% for clinic in doctorClinics %}
                    <option value="{{clinic.id}}">
                        {{clinic.name}}
                    </option>
                {% endfor %}
                </select>
            </div>
            <div class="form-group">
                <label for="form_create_timeslots__input_available_date">Available Date:</label>
                <input type="text" class="form-control add-datepicker" id="form_create_timeslots__input_available_date" name="date" placeholder="Click to pick a date" readonly="readonly"/>
            </div>
            <div class="form-group">
                <label for="form_create_timeslots__input_available_time">Available Time:</label>
                <div class="list-available-time">
                    <div class="row add-available-time-row">
                        <div class="col-xs-5">
                            <select class="form-control" name="fromTime" id="form_create_timeslots__select_from_time">
                            {% for value, title in timeOptions %}
                                <option value="{{value}}" {% if title == '07:00' %}selected{% endif %}>{{title}}</option>
                            {% endfor %}
                            </select>
                        </div>

                        <div class="col-xs-2 text-center add-available-time-row-to">to</div>

                        <div class="col-xs-5">
                            <select class="form-control" name="endTime" for="form_create_timeslots__select_end_time">
                            {% for value, title in timeOptions %}
                                <option value="{{value}}" {% if title == '07:00' %}selected{% endif %}>{{title}}</option>
                            {% endfor %}
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-5">
                        <label for="form_create_timeslots__select_appointment_type">Appointment Type</label>

                        <select name="appointmentType" class="form-control" id="form_create_timeslots__select_appointment_type">
                            <option value="0" disabled="disabled" selected="selected">Choose an appointment type</option>
                        {% for condition in conditions %}
                            <option
                                value="{{condition.id}}"
                                data-default-duration="{{condition.pivot.duration}}"
                            >{{condition.name}}</option>
                        {% endfor %}
                        </select>
                    </div>

                    <div class="col-xs-2"></div>

                    <div class="col-xs-5">
                        <label for="form_create_timeslots__select_duration">Duration:</label>
                        <select name="duration" class="form-control" id="form_create_timeslots__select_duration">
                        {% for duration in Array(180) %}
                            <option value="{{loop.index}}">{{loop.index}}</option>
                        {% endfor %}
                        </select>
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
        </form>
        */console.log});
        _this.templates.modalCreateTimeSlotsResults = multiline(()=>{/*!@preserve
        {% if (timetables && timetables.length) %}
            <p class="text-success">Succeed to add {{timetables.length}} timeslots:</p>
            <ul>
            {% for timeslot in timetables %}
                <li>{{timeslot.startDateTime|formatTimestamp2(currentTimezone, 'HH:mm')}} to {{timeslot.endDateTime|formatTimestamp2(currentTimezone, 'HH:mm')}} in {{timeslot.startDateTime|formatTimestamp2(currentTimezone, 'DD/MM/YYYY')}}</li>
            {% endfor %}
            </ul>
        {% endif %}
        {% if (timetablesError && timetablesError.length) %}
            <p class="text-danger">Failed to add {{timetablesError.length}} timeslots:</p>
            <ul>
            {% for timeslot in timetablesError %}
                <li>{{timeslot.startDateTime|formatTimestamp2(currentTimezone, 'HH:mm')}} to {{timeslot.endDateTime|formatTimestamp2(currentTimezone, 'HH:mm')}} in {{timeslot.startDateTime|formatTimestamp2(currentTimezone, 'DD/MM/YYYY')}}</li>
            {% endfor %}
            </ul>
        {% endif %}
        */console.log});
        _this.templates.modalBlockTimeslots = multiline(()=>{/*!@preserve
        <form class="form" id="form_block_timeslot">
            <div class="form-group">
                <textarea></text
            </div>
        </form>
        */console.log});
        _this.templates.modalAddNewAppointment = multiline(()=>{/*!@preserve
        <form class="form" id="form_add_new_appointment">
            <div class="form-group">
                <label for="form_add_new_appointment__input_date">Date</label>
                <input type="text" name="appointment_date" id="form_add_new_appointment__input_date" class="form-control" disabled="disabled" value="{{selectedDate}}"/>
            </div>
            <div class="form-group">
                <label for="form_add_new_appointment__select_patient_id">National ID - Name - Country - DoB - #ID</label>
                <div class="input-group">
                    <select id="form_add_new_appointment__select_patient_id" class="form-control" name="patient_id" autocomplete="off"></select>
                    <span class="input-group-btn">
                        <a href="#" class="btn btn-primary" data-action="addNewPatient" data-toggle="tooltip" data-title="Create new patient record">
                            <i class="fa fa-plus"></i>
                        </a>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label for="form_add_new_appointment__select_clinic_id">Clinic</label>
                <select class="form-control" name="clinic_id" id="form_add_new_appointment__select_clinic_id">
                {% for clinic in clinics %}
                    <option
                        value="{{clinic.id}}"
                    {% if (selectedClinicId && clinic.id == selectedClinicId) %}
                        selected="selected"
                    {% endif %}
                    >
                        {{clinic.name}}
                    </option>
                {% endfor %}
                </select>
            </div>
            <div class="form-group">
                <label for="form_add_new_appointment__select_appointment_type">Appointment Type</label>
                <select class="form-control" name="appointment-type" id="form_add_new_appointment__select_appointment_type">
                    <option value="0">Choose an appointment type</option>
                {% for condition in conditions %}
                    <option
                        value="{{condition.id}}"
                    {% if (selectedAppointmentTypeId && condition.id == selectedAppointmentTypeId) %}
                        selected="selected"
                    {% endif %}
                        is-house-call-appointment-type="{% if (condition.category == 'house_call') %}1{% else %}0{% endif %}"
                    >
                        {{condition.name}}
                    </option>
                {% endfor %}
                </select>
            </div>
            <div class="form-group hide" id="form_add_new_appointment__group_patient_address">
                <label class="control-label">Patient Address:</label>
                <input class="form-control" type="text" name="patient_address"/>
            </div>
            <div class="form-group hide" id="form_add_new_appointment__group_patient_location">
                <label class="control-label">Patient Location:</label>
                <div class="row">
                    <div class="col-xs-5">
                        <input class="form-control" name="patient_location_lat" type="text" placeholder="Lat" value="" readonly="readonly"/>
                    </div>
                    <div class="col-xs-5">
                        <input class="form-control" name="patient_location_lng" type="text" placeholder="Lng" value="" readonly="readonly"/>
                    </div>
                    <div class="col-xs-2">
                        <a class="btn btn-primary" href="#" data-action="showLocationPicker">
                            <i class="fa fa-map-marker"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="form-group" id="form_add_new_appointment__group_timeslot">
                <label for="form_add_new_appointment__select_timeslot">Timeslot</label>
                <p class="form-control-static text-danger">Please select clinic & appointment type</p>
            </div>
            <div class="form-group">
                <label for="form_add_new_appointment__textarea_reason">Reason</label>
                <textarea class="form-control" name="booking_reason" id="form_add_new_appointment__textarea_reason"></textarea>
            </div>
            <div class="form-group" id="form_add_new_appointment__group_attachments">
                <label>Attachments <i id="form_add_new_appointment__group_attachments__button_upload" class="fa fa-upload" data-toggle="tooltip" data-title="Click here to upload"></i></label>
                <div id="form_add_new_appointment__group_attachments__previews"></div>
            </div>
            <div class="form-group">
                <label for="form_add_new_appointment__textarea_note">Note</label>
                <textarea class="form-control" name="note" id="form_add_new_appointment__textarea_note" placeholder="Referrer, additional information,..."></textarea>
            </div>
        </form>
        */console.log});
        _this.templates.modalAddNewAppointment_SelectTimeslot = multiline(()=>{/*!@preserve
            <label for="form_add_new_appointment__select_timeslot">Timeslot</label>
        {% if (timeslots.length > 0) %}
            <select class="form-control" name="appointment-time-slot" id="form_add_new_appointment__select_timeslot">
            {% for timeslot in timeslots %}
                <option
                    value="{{timeslot.id}}"
                {% if (selectedTimeslotId && timeslot.id == selectedTimeslotId) %}
                    selected="selected"
                {% endif %}
                >
                    {{timeslot.startAt|formatTimestamp2(timeslot.currentTimezone, 'HH:mm')}} to {{timeslot.endAt|formatTimestamp2(timeslot.currentTimezone, 'HH:mm')}}
                </option>
            {% endfor %}
            </select>
        {% else %}
            <p class="form-control-static text-danger">Cannot find any available timeslots with selected clinic & appointment type</p>
        {% endif %}
        */console.log})
        _this.templates.modalAddNewPatient = multiline(()=>{/*!@preserve
        <form class="form" id="form_add_new_patient">
            <div class="row">
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="form_add_new_patient__input_first_name" class="control-label">First Name (*)</label>
                                <input type="text" class="form-control" name="first_name" id="form_add_new_patient__input_first_name" placeholder="E.g. Swee Hock Peter, Ibrahim, Ravi"/>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="form_add_new_patient__input_last_name" class="control-label">Last Name (*)</label>
                                <input type="text" class="form-control" name="last_name" id="form_add_new_patient__input_last_name" placeholder="E.g. Wong, bin Salman, Singh" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_add_new_patient__select_issue_country">National ID Issuing Country (*):</label>
                                <select type="text" class="form-control" name="issue_country_id" id="form_add_new_patient__select_issue_country">
                                    <option value="">Undetermined</option>
                                {% for id, name in countries %}
                                    <option value="{{id}}">{{name}}</option>
                                {% endfor %}
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_add_new_patient__input_id_number">National ID (*):</label>
                                <input type="text" class="form-control" name="id_number" id="form_add_new_patient__input_id_number" placeholder="E.g. S3073167J, G9318256K, T4604526U"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_add_new_patient__input_date_of_birth">Date of Birth (*)</label>
                                <input type="text" class="form-control" name="date_of_birth" id="form_add_new_patient__input_date_of_birth" placeholder="DD/MM/YYYY" />
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label">Gender (*)</label>
                                <p>
                                    <label class="radio-inline">
                                        <input name="gender" id="form_add_new_patient__select_gender_male" value="Male" aria-required="true" type="radio">
                                        Male
                                    </label>
                                    <label class="radio-inline">
                                        <input name="gender" id="form_add_new_patient__select_gender_female" value="Female" type="radio">
                                        Female
                                    </label>
                                    <label class="radio-inline">
                                        <input name="gender" id="form_add_new_patient__select_gender_other" value="Other" type="radio">
                                        Other
                                    </label>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_add_new_patient__input_phone_number">Phone Number</label>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <select class="form-control" name="phone_country_code">
                                            <option value="">Undetermined</option>
                                        {% for code, name in phoneCountryCodes %}
                                            <option value="{{code}}">{{code}}</option>
                                        {% endfor %}
                                        </select>
                                    </div>
                                    <div class="col-xs-6">
                                        <input type="text" class="form-control" name="phone_number" id="form_add_new_patient__input_phone_number"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_add_new_patient__input_email">Email</label>
                                <input type="text" class="form-control" name="email" id="form_add_new_patient__input_email" placeholder="E.g. david@gmail.com"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_add_new_patient__input_block">Block</label>
                                <input type="text" class="form-control" name="address_block" id="form_add_new_patient__input_block"/>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_add_new_patient__input_apartment_number">Apartment</label>
                                <input type="text" class="form-control" name="apartment_number" id="form_add_new_patient__input_apartment_number"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_add_new_patient__input_street">Street</label>
                                <input type="text" class="form-control" name="address_street" id="form_add_new_patient__input_street"/>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_add_new_patient__input_zip_code">Postal Code</label>
                                <input type="text" class="form-control" name="address_zip" id="form_add_new_patient__input_zip_code"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_add_new_patient__input_city">City</label>
                                <input type="text" class="form-control" name="address_city" id="form_add_new_patient__input_city"/>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_add_new_patient__select_residence_country">Residence Country</label>
                                <select type="text" class="form-control" name="resident_country_id" id="form_add_new_patient__select_residence_country">
                                    <option value="">Undetermined</option>
                                {% for id, name in countries %}
                                    <option value="{{id}}">{{name}}</option>
                                {% endfor %}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-xs-6 col-sm-12">
                            <div class="form-group">
                                <label for="form_add_new_patient__select_clinic" class="control-label">Clinic</label>
                                <select id="form_add_new_patient__select_clinic" class="form-control" name="clinic_id">
                                {% for clinic in clinics %}
                                    <option value="{{clinic.id}}">{{clinic.name}}</option>
                                {% endfor %}
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-12">
                            <div class="form-group">
                                <label class="control-label" id="form_add_new_patient__input_race">Race</label>
                                <input type="text" class="form-control" name="race" id="form_add_new_patient__input_race"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Medical Condition</label>
                        <textarea class="form-control vertical" name="medical_condition" style="height:108px"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Drug Allergy</label>
                        <textarea class="form-control vertical" name="drug_allergy" style="height:108px"></textarea>
                    </div>
                </div>
            </div>
        </form>
        */console.log});
        _this.templates.boxAppointmentTypeLegends_body = multiline(() => {/*!@preserve
        <div class="list">
        {% for appointmentType in appointmentTypes %}
            <div class="item">
                <i class="fa fa-circle text-{{appointmentType.class}}"></i> {{appointmentType.name}}
            </div>
        {% endfor %}
        </div>
        */console.log});
        _this.templates.modalMarkAsNoShowContent = multiline(() => {/*!@preserve
            Patient name: {{patientName}}<br/>
            Appointment time: {{appointmentTime}}
        */console.log});
        _this.templates.modalMarkAsLateContent = multiline(() => {/*!@preserve
            Patient name: {{patientName}}<br/>
            Appointment time: {{appointmentTime}}
        */console.log});
        _this.templates.messageIDNumberExisted = multiline(() => {/*!@preserve
        Sorry, this ID Number already exists in our system. <a href="#" data-action="selectPatient" data-id="{id}">Use this record instead</a>
        */console.log});

        _this.render();
        _this.bindEvents();

        sandbox.sub.register('widgetBatchActions', require('../modules/working-calendar.widget-batch-actions'), {
            data: data,
            objects: {
                calendar: _this.objects.calendar,
                $calendar: _this.objects.$calendar
            }
        })
        sandbox.sub.start();
    }

    /**
     * @memberOf pageWorkingCalendar
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
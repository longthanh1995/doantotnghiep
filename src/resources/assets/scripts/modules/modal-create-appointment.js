const _find = require('lodash/find');
const _get = require('lodash/get');
const _map = require('lodash/map');
const _filter = require('lodash/filter');

/**
 * @module modalCreateAppointment
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function(sandbox) {
    let _this = this;

    _this.render = ({data, doneCallback, failCallback}) => {
        sandbox.emit('window/loading/show');
        sandbox.emit('service/doctor/clinics/list', {
            doneCallback: (clinics) => {
                sandbox.emit('window/loading/hide');
                _this.data.clinics = clinics;
                let doctorTitle = _get(globalData, 'doctor.title', ''),
                    doctorName = _get(globalData, 'doctor.name', ''),
                    $modal = bootbox.dialog({
                    title: `Add new appointment <span class="text-primary">(book from ${doctorTitle} ${doctorName})</span>`,
                    message: swig.render(_this.templates.modalContent, {
                        locals: {
                            clinics,
                        }
                    }),
                    className: 'modal-create-appointment',
                    buttons: {
                        'back': {
                            label: 'Back',
                            className: 'btn hide back',
                            callback: (event) => {
                                let $form = $(event.delegateTarget).find('form');
                                _this.objects.$wizard.wizard('backward');
                                return false;
                            }
                        },
                        'next': {
                            label: 'Next',
                            className: 'btn btn-primary next',
                            callback: (event) => {
                                _this.objects.$wizard.wizard('forward');
                                return false;
                            }
                        },
                        'submit': {
                            label: 'Submit',
                            className: 'btn btn-primary hide submit',
                            callback: (event) => {
                                let $form = $(event.delegateTarget).find('form');
                                $form.submit();
                                return false;
                            }
                        }
                    }
                });

                $modal
                    .on('shown.bs.modal', (event) => {
                        let $buttonNext = $modal.find('.modal-footer .btn.next'),
                            $buttonBack = $modal.find('.modal-footer .btn.back'),
                            $buttonSubmit = $modal.find('.modal-footer .btn.submit'),
                            $form = $modal.find('form'),
                            $groupSelectDoctor = $form.find('#form_create_appointment__group_select_doctor'),
                            $groupSelectAppointmentType = $form.find('#form_create_appointment__group_select_appointment_type'),
                            $selectClinic = $modal.find('[name=clinic_id]'),
                            $inputDate = $modal.find('[name=date]'),
                            $step2 = $modal.find('.step-2'),
                            renderGroupSelectAppointmentType = (doctor, clinic) => {
                                let html = swig.render(_this.templates.groupSelectAppointmentTypeContent, {
                                    locals: {
                                        doctor,
                                        clinic
                                    }
                                });
                                $groupSelectAppointmentType.html(html);
                                $groupSelectAppointmentType.find('select.chosen').chosen();
                            },
                            renderGroupSelectDoctor = (clinic) => {
                                let html = swig.render(_this.templates.groupSelectDoctorContent, {
                                    locals: {
                                        clinic
                                    }
                                });
                                $groupSelectDoctor.html(html);
                                $groupSelectDoctor.find('select.chosen').chosen();

                                let $selectDoctor = $form.find('[name=doctor_id]');
                                $selectDoctor
                                    .on('change', (event) => {
                                        let $this = $(event.currentTarget),
                                            selectedClinicId = parseInt($this.data('clinic-id')),
                                            selectedDoctorId = parseInt($this.val());

                                        if(!selectedDoctorId){
                                            return false;
                                        };

                                        let selectedClinicData = _find(_this.data.clinics, (clinic) => clinic.id === selectedClinicId),
                                            selectedDoctorData = _find(selectedClinicData.doctors, (doctor) => doctor.id === selectedDoctorId)
                                        ;

                                        renderGroupSelectAppointmentType(selectedDoctorData, selectedClinicData);
                                    })
                                    .trigger('change')
                                ;
                            },
                            renderStep2 = ({clinic, doctor, appointmentType, date, doctorTimeslots}) => {
                                let html = swig.render(_this.templates.step2Content, {
                                    locals: {
                                        clinic,
                                        doctor,
                                        appointmentType,
                                        date,
                                        doctorTimeslots,
                                        patient: _get(data, 'patient', undefined)
                                    }
                                });

                                $step2.html(html);

                                let $inputPatient = $form.find('#form_create_appointment__input_search_patient'),
                                    $selectPatient = $form.find('#form_create_appointment__select_patient_id'),
                                    $groupAttachments = $form.find('#form_create_appointment__group_attachments'),
                                    searchPatients = (term) => {
                                        let $select2Object = $selectPatient.data('select2'),
                                            $search = $select2Object.dropdown.$search || $select2Object.selection.$search
                                        ;

                                        $select2Object.results.clear();

                                        $select2Object.trigger('open');
                                        $search.val(term);
                                        $search.trigger('keyup');
                                    }
                                ;

                                $selectPatient
                                    .select2({
                                        dropdownParent: $modal,
                                        placeholder: "Search by Name/ID Number",
                                        ajax: {
                                            url: laroute.route('api.patients.search'),
                                            dataType: 'json',
                                            delay: 250,
                                            data: function (params) {
                                                return {
                                                    text: $.trim(params.term), // search term
                                                    page: params.page
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
                                                        more: (params.page * 30) < result.total_count
                                                    }
                                                };
                                            },
                                            cache: true
                                        },
                                        escapeMarkup: function (markup) { return markup; },
                                        minimumInputLength: 1,
                                        minimumResultsForSearch: Infinity,
                                        templateResult: function (patient) {
                                            if (patient.loading) return patient.text;

                                            let markupTemplate = multiline(function(){/*!@preserve
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

                                if(_get(data, 'patient.id', undefined)){
                                    $selectPatient.append(`<option selected value="${data.patient.id}">${data.patient.text}</option>`);
                                }

                                $step2.find('[name=appointment-time-slot]').chosen({
                                    disable_search_threshold: 5,
                                });

                                $groupAttachments
                                    .dropzone({
                                        acceptedFiles: '.jpg, .jpeg, .png',
                                        paramName: 'file',
                                        previewsContainer: '#form_create_appointment__group_attachments__previews',
                                        clickable: '#form_create_appointment__group_attachments__button_upload',
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
                                        url: laroute.route('doctor.file.store'),
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

                                $step2
                                    .on('click', '[data-action=addNewPatient]', (event) => {
                                        event.preventDefault();

                                        sandbox.emit('modal/createPatient/show', {
                                            doneCallback: (response) => {
                                                let id = _get(response, 'data.id', 0),
                                                    optionText = _get(response, 'data.text');
                                                
                                                $selectPatient.append(`<option selected value="${id}">${optionText}</option>`);
                                            },
                                            failCallback: (e, data) => {}
                                        });
                                    })
                                    .on('click', '[data-action=searchPatients]', (event) => {
                                        event.preventDefault();

                                        searchPatients($inputPatient.val());
                                    })
                                ;
                            },
                            transformDoctorTimeslotsData = (timeslots = []) => {
                                let formattedTimeslots = _map(timeslots, (timeslot) => {
                                    let startAt = moment(timeslot.start).utcOffset(0).format('YYYY-MM-DD HH:mm:ss'),
                                        endAt = moment(timeslot.end).utcOffset(0).format('YYYY-MM-DD HH:mm:ss'),
                                        currentTimezone = timeslot.timezone
                                    ;

                                    return {
                                        id: timeslot.id,
                                        currentTimezone,
                                        startAt: moment(moment.utc(startAt).unix() * 1000).utcOffset(currentTimezone).tz(currentTimezone),
                                        endAt: moment(moment.utc(endAt).unix() * 1000).utcOffset(currentTimezone).tz(currentTimezone),
                                        appointments: timeslot.appointments,
                                        available: timeslot.available,
                                        isBlocked: timeslot.isBlocked,
                                    }
                                });

                                return _filter(formattedTimeslots, (timeslot) => {
                                    return timeslot.startAt.diff(moment()) > 0 && !timeslot.appointments.length && timeslot.available && !timeslot.isBlocked;
                                });
                            }
                        ;

                        $form.find('select.chosen').chosen();
                        $inputDate
                            .datepicker({
                                maxViewMode: "month",
                                weekStart: 1,
                                startDate: moment().format('DD/MM/YYYY'),
                                format: 'dd/mm/yyyy',
                                disableTouchKeyboard: true,
                                clearBtn: true
                            });
                        $form.validate({
                            rules: {
                                clinic_id: {
                                    required: true,
                                },
                                doctor_id: {
                                    required: true,
                                },
                                "appointment-type": {
                                    required: true,
                                },
                                date: {
                                    required: true,
                                },
                                patient_id: {
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
                            ignore: ":hidden:not(select)",
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
                                let formData = $form.serialize();
                                sandbox.emit('window/loading/show');
                                $form.data('is-submitting', 1);
                                $modal.find(':input').prop('disabled', true);

                                sandbox.emit('service/doctor/appointments/create', {
                                    data: formData,
                                    doneCallback: (appointment) => {
                                        sandbox.emit('window/loading/hide');

                                        let appointmentTypeName = _get(appointment, 'appointmentType.name', ''),
                                            patientFirstName = _get(appointment, 'patient.firstName', ''),
                                            patientLastName = _get(appointment, 'patient.lastName', ''),
                                            doctorTitle = _get(appointment, 'doctor.title.title', ''),
                                            doctorName = _get(appointment, 'doctor.name'),
                                            timezone = _get(appointment, 'clinic.timeZone', 'UTC'),
                                            startAt = moment.tz(_get(appointment, 'startAt',''), 'YYYY-MM-DD HH:mm:ss', 'UTC').utcOffset(timezone).tz(timezone)
                                            // endAt = moment.tz(_get(appointment, 'endAt',''), 'YYYY-MM-DD HH:mm:ss', 'UTC').utcOffset(timezone).tz(timezone)
                                        ;

                                        bootbox.alert(`<i>${appointmentTypeName}</i> appointment for patient <b>${patientFirstName} ${patientLastName}</b> has been booked to ${doctorTitle} <b>${doctorName}</b> at ${startAt.format('DD/MM/YYYY HH:mm')} (${startAt.format('[GMT]Z')}).`, () => {
                                            $modal.modal('hide');
                                        });
                                    },
                                    failCallback: (e, data) => {
                                        let html = swig.render(_this.templates.modalErrorsContent, {
                                            locals: _get(e, 'responseJSON', {
                                                message: 'The request cannot be processed'
                                            })
                                        });
                                        bootbox.alert(html);
                                        $form.data('is-submitting', 0);
                                        $modal.find(':input').prop('disabled', false);
                                        sandbox.emit('window/loading/hide');
                                    }
                                });
                            }
                        })
                        _this.objects.$wizard = $(_this.DOMSelectors.wizard).wizard({
                            afterSelect: (event, state) => {
                                if(state.isLastStep && !$buttonNext.hasClass('hide')){
                                    $buttonNext.addClass('hide');
                                    $buttonSubmit.removeClass('hide');
                                } else {
                                    $buttonNext.removeClass('hide');
                                    $buttonSubmit.addClass('hide');
                                }

                                if(state.isFirstStep && $buttonBack.hasClass('hide')){
                                    $buttonBack.addClass('hide');
                                } else {
                                    $buttonBack.removeClass('hide');
                                }

                                $modal.find(_this.DOMSelectors.stepIndex).text(state.stepIndex + 1);
                            },
                            beforeForward: (event, state) => {
                                return $form.valid();
                            },
                            beforeBackward: (event, state) => {
                                //assume that there're 2 steps only
                                let html = swig.render(_this.templates.step2EmptyContent);
                                $step2.html(html);
                            },
                            afterForward: (event, state) => {
                                switch(state.stepIndex){
                                    case 1:
                                        let formData = $form.serialize();

                                        sandbox.emit('window/loading/show');
                                        sandbox.emit('service/doctor/doctorTimeslots/list', {
                                            data: formData,
                                            doneCallback: (response) => {
                                                let doctorTimeslots = transformDoctorTimeslotsData(_get(response,'result', []));

                                                if(doctorTimeslots.length){
                                                    renderStep2({
                                                        clinic: {
                                                            name: $form.find('[name=clinic_id] :selected').text(),
                                                        },
                                                        doctor: {
                                                            name: $form.find('[name=doctor_id] :selected').text(),
                                                        },
                                                        appointmentType: {
                                                            name: $form.find('[name=appointment-type] :selected').text(),
                                                        },
                                                        date: $form.find('[name=date]').val(),
                                                        doctorTimeslots
                                                    });
                                                } else {
                                                    bootbox.alert(`There's no available timeslot for given criterias. Please check again.`, () => {
                                                        _this.objects.$wizard.wizard('backward');
                                                    });
                                                }

                                                sandbox.emit('window/loading/hide');
                                            },
                                            failCallback: (e, data) => {
                                                let html = swig.render(_this.templates.modalErrorsContent, {
                                                    locals: _get(e, 'responseJSON', {
                                                        message: 'The request cannot be processed'
                                                    })
                                                });
                                                bootbox.alert(html);
                                                sandbox.emit('window/loading/hide');
                                            }
                                        });
                                        break;
                                    default:
                                        return true;
                                }
                            }
                        });

                        $selectClinic
                            .on('change', (event) => {
                                let $this = $(event.currentTarget),
                                    selectedClinicId = parseInt($this.val()),
                                    selectedClinicData = _find(_this.data.clinics, (clinic) => clinic.id === selectedClinicId);
                                ;

                                renderGroupSelectDoctor(selectedClinicData);
                            })
                            .trigger('change')
                        ;

                        $form
                            .on('reset', (event) => {
                                setTimeout(()=>{
                                    $form.find('select.chosen').trigger('chosen:updated');
                                },0);
                            })
                    })
                ;
            },
            failCallback: (e, data) => {
                let html = swig.render(_this.templates.modalErrorsContent, {
                    locals: _get(e, 'responseJSON', {
                        message: 'The request cannot be processed'
                    })
                });
                bootbox.alert(html);
                sandbox.emit('window/loading/hide');
            }
        });
    };

    sandbox.on('modalCreateAppointment/show', ({data, doneCallback, failCallback}) => {
        _this.render({data, doneCallback, failCallback});
    });

    /**
     * @module modalCreateAppointment
     * @function init
     * @param data
     */
    _this.init = (data) => {
        _this.data = data || {};

        _this.DOMSelectors = {};
        _this.DOMSelectors.wizard = '#wizard_create_appointment';
        _this.DOMSelectors.stepIndex = '.step-index';

        _this.objects = {};

        _this.templates = {};
        _this.templates.modalContent = multiline(()=>{/*!@preserve
        <div class="wizard" id="wizard_create_appointment">
            <p class="text-muted">Step <span class="step-index">1</span> of 2</p>
            <form class="form" id="form_create_appointment">
                <div class="step step-1">
                    <div class="form-group">
                        <label class="control-label">Clinic</label>
                        <select class="form-control chosen" name="clinic_id" data-placeholder="Please choose a clinic">
                            <option></option>
                        {% for clinic in clinics %}
                            <option value="{{clinic.id}}">{{clinic.name}}</option>
                        {% endfor %}
                        </select>
                    </div>
                    <div class="form-group" id="form_create_appointment__group_select_doctor"></div>
                    <div class="form-group" id="form_create_appointment__group_select_appointment_type"></div>
                    <div class="form-group">
                        <label class="control-label">Date</label>
                        <input type="text" class="form-control" name="date" placeholder="Click to pick a date" readonly="readonly"/>
                    </div>
                </div>
                <div class="step step-2">
                    <i class="fa fa-spin fa-refresh"></i>
                    Loading...
                </div>
            </form>
        </div>
        */console.log});
        _this.templates.groupSelectDoctorContent = multiline(()=>{/*!@preserve
        <label class="control-label">Doctor</label>
            <select class="form-control chosen" name="doctor_id" data-clinic-id="{{clinic.id}}" data-placeholder="{% if clinic.id %}Please choose a doctor{% else %}Please choose a clinic first{% endif %}">
                <option></option>
            {% for doctor in clinic.doctors %}
                <option value="{{doctor.id}}" data-clinic-id="doctor.clinicId">{{doctor.name}}</option>
            {% endfor %}
            </select>
        */console.log});
        _this.templates.groupSelectAppointmentTypeContent = multiline(()=>{/*!@preserve
        <label class="control-label">Appointment Type</label>
            <select class="form-control chosen" name="appointment-type" data-placeholder="{% if clinic.id %}Please choose an appointment type{% else %}Please choose a doctor first{% endif %}">
                <option></option>
            {% for appointmentType in doctor.timetableConfigs %}
                <option value="{{appointmentType.id}}" data-doctor-id="doctor.id">{{appointmentType.name}}</option>
            {% endfor %}
            </select>
        */console.log});
        _this.templates.step2Content = multiline(()=>{/*!@preserve
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group">
                    <label class="control-label">Clinic</label>
                    <div class="form-control-static">{{clinic.name}}</div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <label class="control-label">Doctor</label>
                    <div class="form-control-static">{{doctor.name}}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group">
                    <label class="control-label">Appointment type</label>
                    <div class="form-control-static">{{appointmentType.name}}</div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <label class="control-label">Date</label>
                    <div class="form-control-static">{{date}}</div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>National ID - Name - Country - DoB - #ID</label>
        {% if patient.id && patient.text %}
            <div class="form-control-static">
                <input type="hidden" name="patient_id" id="form_create_appointment__input_search_patient" value="{{patient.id}}"/>
                {{patient.text}}
            </div>
        {% else %}
            <div class="input-group">
                <select id="form_create_appointment__select_patient_id" class="form-control" name="patient_id" autocomplete="off"></select>
                <span class="input-group-btn">
                    <a href="#" class="btn btn-primary" data-action="addNewPatient" data-toggle="tooltip" data-title="Create new patient record">
                        <i class="fa fa-plus"></i>
                    </a>
                </span>
            </div>
        {% endif %}
        </div>


        <div class="form-group">
            <label class="control-label">Timeslot</label>
            <select class="form-control" name="appointment-time-slot">
            {% for timeslot in doctorTimeslots %}
                <option value="{{timeslot.id}}">
                    {{timeslot.startAt|formatTimestamp2(timeslot.currentTimezone, 'HH:mm')}} to {{timeslot.endAt|formatTimestamp2(timeslot.currentTimezone, 'HH:mm')}}
                </option>
            {% endfor %}
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">Reason</label>
            <textarea class="form-control" name="booking_reason"></textarea>
        </div>
        <div class="form-group" id="form_create_appointment__group_attachments">
            <label>Attachments <i id="form_create_appointment__group_attachments__button_upload" class="fa fa-upload" data-toggle="tooltip" data-title="Click here to upload"></i></label>
            <div id="form_create_appointment__group_attachments__previews"></div>
        </div>
        <div class="form-group">
            <label>Note</label>
            <textarea class="form-control" name="note" placeholder="Referrer, additional information,..."></textarea>
        </div>
        */console.log});
        _this.templates.step2EmptyContent = multiline(() => {/*!@preserve
        <i class="fa fa-spin fa-refresh"></i>
        Loading...
        */console.log});
        _this.templates.modalErrorsContent = multiline(()=>{/*!@preserve
        <p>{{message}}</p>
        {% if errors|typeof === 'object' %}
        <ul>
        {% for field,message in errors %}
            <li data-field="{{field}}">{{message}}</li>
        {% endfor %}
        </ul>
        {% endif %}
        */console.log});
    };

    /**
     * @module modalCreateAppointment
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
};
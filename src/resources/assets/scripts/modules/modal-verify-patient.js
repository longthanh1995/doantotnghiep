'use strict';

/**
 * @module moduleModalVerifyPatient
 * @param sandbox
 */

const _get = require('lodash/get');

const dashboardType = _get(globalData, 'context.dashboardType', 'doctor');

module.exports = function(sandbox){
    let _this = this;

    /**
     * @module moduleModalVerifyPatient
     * @function fetchPatientInformation
     * @param patientId {Integer}
     * @param doneCallback {Function}
     * @param failCallback {Function}
     */
    _this.fetchPatientInformation = ({patientId, doneCallback, failCallback}) => {
        manaDrApplication.emit('window/loading/show');

        let requestRoute;
        switch(dashboardType){
            case 'admin':
                requestRoute = 'admin.patient.fetch';
                break;
            case 'doctor':
            default:
                requestRoute = 'doctor.patient.fetch';
                break;
        }
        let request = $.ajax({
            url: laroute.route(requestRoute, {patient: patientId}),
            method: 'POST'
        });

        request
            .done((response) => {
                manaDrApplication.emit('window/loading/hide');
                if('function' === typeof doneCallback){
                    doneCallback(response);
                }
            })
            .fail((e, data) => {
                manaDrApplication.emit('window/loading/hide');
                if('function' === typeof failCallback){
                    failCallback(e, data);
                }
            })
        ;
    }

    /**
     * @module moduleModalVerifyPatient
     * @function fetchCountries
     * @param doneCallback {Function}
     * @param failCallback {Function}
     */
    _this.fetchCountries = ({doneCallback, failCallback}) => {
        manaDrApplication.emit('window/loading/show');

        let request = $.ajax({
            url: laroute.route('public.resource.country'),
            method: 'GET'
        });

        request
            .done((response) => {
                manaDrApplication.emit('window/loading/hide');
                if('function' === typeof doneCallback){
                    doneCallback(response);
                }
            })
            .fail((e, data) => {
                manaDrApplication.emit('window/loading/hide');
                if('function' === typeof failCallback){
                    failCallback(e, data);
                }
            })
        ;
    }

    /**
     * @module moduleModalVerifyPatient
     * @function showModal
     * @param patientData {Object}
     * @param countriesData {Object}
     * @param doneCallback {Function}
     * @param failCallback {Function}
     */
    _this.showModal = ({patientData, countriesData, doneCallback, failCallback}) => {
        let patientId = patientData.id,
            $modal = bootbox.dialog({
            title: "Verify Patient Information",
            message: swig.render(_this.templates.modal, {
                locals: {
                    patient: patientData,
                    countries: countriesData
                }
            }),
            buttons: {
                'reset': {
                    label: 'Reset',
                    className: 'btn',
                    callback: (event) => {
                        let $form = $(event.delegateTarget).find('form');
                        $form.validate().resetForm();
                        $form[0].reset();
                        $form[0].reset();
                        return false;
                    }
                },
                'submit': {
                    label: 'Verify & Submit',
                    className: 'btn btn-primary',
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
                let $form = $modal.find('form');

                $form.find('input').first().focus();

                $form.find('[name="date_of_birth"]').datepicker({
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

                $form.validate({
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

                        id_number: {
//                                    required: true
                        },

                        address_zip : {
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

                        var isSubmitting = parseInt($form.data('is-submitting'));

                        if(isSubmitting){
                            return;
                        }

                        var formData = $(form).serialize();

                        manaDrApplication.emit('window/loading/show');
                        $form.data('is-submitting', 1);
                        $modal.find(':input').prop('disabled', true);

                        let requestRoute;
                        switch(dashboardType){
                            case 'admin':
                                requestRoute = 'admin.patient.update';
                                break;
                            case 'doctor':
                            default:
                                requestRoute = 'doctor.patient.update';
                                break;
                        }
                        let request = $.ajax({
                            url: laroute.route(requestRoute, {patient: patientId}),
                            method: "POST",
                            data: formData,
                            dataType: "json"
                        });

                        request
                            .done((response) => {
                                let message = '';
                                if(response && response.id){
                                    message = 'Patient info has been verified!';
                                } else {
                                    message = 'Request has been processed successfully';
                                }

                                bootbox.alert(message, () => {
                                    $modal.modal('hide');
                                    manaDrApplication.emit('window/loading/hide');
                                    if ('function' === typeof doneCallback) {
                                        doneCallback(response);
                                    }
                                });
                            })
                            .fail((e, data) => {
                                let message = '';

                                let template = multiline(function(){/*!@preserve
                                    <p>{{message}}</p>
                                    {% if error|typeof === 'object' %}
                                    <ul>
                                    {% for key,value in error %}
                                        <li>{{value}}</li>
                                    {% endfor %}
                                    </ul>
                                    {% endif %}
                                */console.log});
                                if(e
                                    && e.responseJSON
                                    && e.responseJSON.message
                                    && e.responseJSON.message.length){
                                    message = swig.render(template, {
                                        locals: e.responseJSON
                                    });
                                } else {
                                    message = 'The request cannot be processed';
                                }

                                bootbox.alert(message, () => {
                                    $form.data('is-submitting', 0);
                                    $modal.find(':input').prop('disabled', false);
                                    manaDrApplication.emit('window/loading/hide');

                                    if ('function' === typeof failCallback) {
                                        failCallback(e, data);
                                    }
                                });
                            })
                    }
                })
            })
    };

    //@TODO: replace callback hell with promises
    sandbox
        .on('modalVerifyPatient/show', ({patientId, doneCallback, failCallback}) => {
            //get patient information

            _this.fetchPatientInformation({
                patientId,
                doneCallback: (data) => {
                    let patientData = humps.camelizeKeys(data);

                    _this.fetchCountries({
                        doneCallback: (countries) => {
                            let countriesData = humps.camelizeKeys(countries);

                            _this.showModal({
                                patientData,
                                countriesData,
                                doneCallback: (response) => {
                                    if('function' === typeof doneCallback){
                                        doneCallback(response);
                                    }
                                },
                                failCallback: (e, data) => {
                                    if('function' === typeof failCallback){
                                        failCallback(e, data);
                                    }
                                }
                            });
                        },
                        failCallback: (e, data) => {
                            if('function' === typeof failCallback){
                                failCallback(e, data);
                            }
                        }
                    });
                },
                failCallback: (e, data) => {
                    if('function' === typeof failCallback){
                        failCallback(e, data);
                    }
                }
            });
        })

    /**
     * @module moduleModalVerifyPatient
     * @function init
     * @param data
     */
    _this.init = (data) => {
        _this.data = data || {};

        _this.templates = {};
        _this.templates.modal = multiline(() => {/*!@preserve
         <form class="form" data-is-submitting="0">
            <input type="hidden" name="verified" id="verified" value="1"/>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="first_name">First Name (*):</label>
                        <input type="text" name="first_name" id="modal_edit_patient__form__input_first_name" class="form-control" value="{{patient.firstName}}"/>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="last_name">Last Name (*):</label>
                        <input type="text" name="last_name" id="modal_edit_patient__form__input_last_name" class="form-control" value="{{patient.lastName}}"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="gender">Gender (*):</label>
                        <p>
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="gender_male" value="Male" {% if patient.gender|lower === 'male' %}checked{% endif %}/>
                                Male
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="gender_male" value="Female" {% if patient.gender|lower === 'female' %}checked{% endif %}/>
                                Female
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="gender_male" value="Other" {% if patient.gender|lower === 'other' %}checked{% endif %}/>
                                Other
                            </label>
                        </p>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth (*):</label>
                        <input class="form-control" name="date_of_birth" id="form_edit_patient__input_date_of_birth" value="{{patient.dateOfBirth|date('d/m/Y')}}"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" name="email" id="modal_edit_patient__form__input_email" class="form-control" value="{{patient.email}}"/>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="race">Race:</label>
                            <input type="text" name="race" id="modal_edit_patient__form__input_race" class="form-control" value="{{patient.race}}"/>
                        </div>
                    </div>
                </div>
            </div>

            <label for="phone_number">Phone Number:</label>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <select class="form-control" name="phone_country_code" id="phone_country_code">
                            <option value="">(Undetermined)</option>
                        {% for country in countries %}
                            <option value="{{country.phoneCountryCode }}" {% if country.phoneCountryCode == patient.phoneCountryCode %}selected{% endif %}>{{country.niceName}} ({{ country.phoneCountryCode }})</option>
                        {% endfor %}
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <input type="text" name="phone_number" id="modal_edit_patient__form__input_phone_number" class="form-control" value="{{patient.phoneNumber }}"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="address_street">Street:</label>
                        <input type="text" name="address_street" id="modal_edit_patient__form__input_address_street" class="form-control" value="{{patient.addressStreet }}"/>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="address_zip">Zip Code:</label>
                        <input type="text" name="address_zip" id="modal_edit_patient__form__input_address_zip" class="form-control" value="{{patient.addressZip }}"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="address_city">City:</label>
                        <input type="text" name="address_city" id="modal_edit_patient__form__input_address_city" class="form-control" value="{{patient.addressCity}}"/>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="resident_country_id">Residence Country:</label>
                        <select class="form-control" name="resident_country_id">
                            <option value="">(Undetermined)</option>
                        {% for country in countries %}
                            <option value="{{ country.id }}" {% if country.id == patient.residentCountryId %}selected{% endif %}>{{country.niceName}}</option>
                        {% endfor %}
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="id_number">National ID Number (*):</label>
                        <input type="text" name="id_number" id="modal_edit_patient__form__input_id_number" class="form-control" value="{{patient.idNumber}}"/>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="issue_country_id">National ID Issuing Country (*):</label>
                        <select class="form-control" name="issue_country_id">
                            <option value="">(Undetermined)</option>
                        {% for country in countries %}
                            <option value="{{ country.id }}" {% if country.id == patient.issueCountryId %}selected{% endif %}>{{country.niceName}}</option>
                        {% endfor %}
                        </select>
                    </div>
                </div>
            </div>

             <div class="form-group">
                <label class="control-label">Medical Condition</label>
                <textarea class="form-control vertical" name="medical_condition">{{patient.medicalCondition}}</textarea>
            </div>

            <div class="form-group">
                <label class="control-label">Drug Allergy</label>
                <textarea class="form-control vertical" name="drug_allergy">{{patient.drugAllergy}}</textarea>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="deceased" id="deceased" value="1" {% if patient.deceased %}checked{% endif %}/>
                            Mark as deceased
                        </label>
                    </div>
                </div>
            </div>
         </form>
        */console.log});
    }

    /**
     * @module moduleModalVerifyPatient
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
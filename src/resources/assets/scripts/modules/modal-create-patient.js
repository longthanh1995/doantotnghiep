const _get = require('lodash/get');

const dashboardType = _get(globalData, 'context.dashboardType', 'doctor');

/**
 * @module modalCreatePatient
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function(sandbox){
    let _this = this;

    _this.listClinics = ({data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('profile.clinics'),
            data,
            dataType: 'json',
        });

        return request
            .done((response) => {
                if ('function' === typeof doneCallback) {
                    doneCallback(humps.camelizeKeys(response));
                }
            })
            .fail((e, data) => {
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            })
            ;
    };

    /**
     * @module modalCreatePatient
     * @function render
     */
    _this.render = ({doneCallback, failCallback}) => {
        sandbox.emit('window/loading/show');
        sandbox.emit('service/countries/list', {
            doneCallback: (countries) => {
                _this.listClinics({
                    doneCallback: (clinics) => {
                        sandbox.emit('window/loading/hide');
                        let $modal = bootbox.dialog({
                                title: 'Add new patient 2',
                                message: swig.render(_this.templates.modalContent, {
                                    locals: {
                                        countries,
                                        clinics,
                                    }
                                }),
                                size: 'large',
                                className: 'modal-create-patient',
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
                                orientation: "bottom",
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

                        $form.find('select.chosen').chosen({
                            width: '100%',
                            search_contains: true,
                        });

                        $form.validate({
                            ignore: ":hidden:not(select)",
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

                                let requestRoute;
                                switch(dashboardType){
                                    case 'admin':
                                        requestRoute = 'admin.patients.store';
                                        break;
                                    case 'doctor':
                                    default:
                                        requestRoute = 'api.patients.store';
                                        break;
                                }

                                console.log('dashboardType', dashboardType, requestRoute);

                                let request = $.ajax({
                                    url: laroute.route(requestRoute),
                                    method: "POST",
                                    data: formData,
                                    dataType: "json"
                                });

                                request
                                    .done((response) => {
                                        let id = _get(response, 'data.id', 0),
                                            fullName = _get(response, 'data.full_name', '')
                                        ;

                                        let message = `Patient <b>${fullName}</b> has been created successfully!`;

                                        bootbox.alert(message, ()=>{
                                            if ('function' === typeof doneCallback) {
                                                doneCallback(response);
                                            }
                                            $modal.modal('hide');
                                            manaDrApplication.emit('window/loading/hide');
                                        });
                                    })
                                    .fail((e, data) => {
                                        if ('function' === typeof failCallback) {
                                            failCallback(e, data);
                                        }

                                        $form.data('is-submitting', 0);
                                        $modal.find(':input').prop('disabled', false);
                                        manaDrApplication.emit('window/loading/hide');
                                    })
                                ;
                            }
                        });

                        $form
                            .on('reset', (event) => {
                                setTimeout(() => {
                                    $form.find('select.chosen').trigger('chosen:updated');
                                }, 0);
                            })
                        ;
                    },
                    failCallback: (e, data) => {
                        sandbox.emit('window/loading/hide');
                        if ('function' === typeof failCallback) {
                            failCallback(e, data);
                        }
                    },
                });
            },
            failCallback: (e, data) => {
                sandbox.emit('window/loading/hide');
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            }
        })
    };

    sandbox.on('modal/createPatient/show', ({doneCallback, failCallback}) => {
        _this.render({doneCallback, failCallback});
    });

    /**
     * @module modalCreatePatient
     * @function init
     * @param data
     */
    _this.init = (data) => {
        _this.data = data || {};

        _this.templates = {};
        _this.templates.modalContent = multiline(()=>{/*!@preserve
        <form class="form" id="form_create_patient">
            <div class="row">
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="form_create_patient__input_first_name" class="control-label">First Name (*)</label>
                                <input type="text" class="form-control" name="first_name" id="form_create_patient__input_first_name"/>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="form_create_patient__input_last_name" class="control-label">Last Name (*)</label>
                                <input type="text" class="form-control" name="last_name" id="form_create_patient__input_last_name"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label">Gender (*)</label>
                                <p>
                                    <label class="radio-inline">
                                        <input name="gender" id="form_create_patient__select_gender_male" value="Male" aria-required="true" type="radio">
                                        Male
                                    </label>
                                    <label class="radio-inline">
                                        <input name="gender" id="form_create_patient__select_gender_female" value="Female" type="radio">
                                        Female
                                    </label>
                                    <label class="radio-inline">
                                        <input name="gender" id="form_create_patient__select_gender_other" value="Other" type="radio">
                                        Other
                                    </label>
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_create_patient__input_date_of_birth">Date of Birth (*)</label>
                                <input type="text" class="form-control" name="date_of_birth" id="form_create_patient__input_date_of_birth" readonly="readonly"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_create_patient__select_issue_country">National ID Issuing Country (*)</label>
                                <select type="text" class="form-control chosen" name="issue_country_id" id="form_create_patient__select_issue_country">
                                    <option value="">Undetermined</option>
                                {% for country in countries %}
                                    <option value="{{country.id}}">{{country.niceName}}</option>
                                {% endfor %}
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_create_patient__input_id_number">National ID (*)</label>
                                <input type="text" class="form-control" name="id_number" id="form_create_patient__input_id_number"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_create_patient__input_phone_number">Phone Number</label>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <select class="form-control chosen" name="phone_country_code">
                                            <option value="">Undetermined</option>
                                        {% for code, name in phoneCountryCodes %}
                                            <option value="{{code}}">{{code}}</option>
                                        {% endfor %}
                                        {% for country in countries %}
                                            <option value="{{country.phoneCountryCode}}">{{country.niceName}} ({{country.phoneCountryCode}})</option>
                                        {% endfor %}
                                        </select>
                                    </div>
                                    <div class="col-xs-6">
                                        <input type="text" class="form-control" name="phone_number" id="form_create_patient__input_phone_number"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_create_patient__input_email">Email</label>
                                <input type="text" class="form-control" name="email" id="form_create_patient__input_email"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_create_patient__input_street">Street</label>
                                <input type="text" class="form-control" name="address_street" id="form_create_patient__input_street"/>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_create_patient__input_zip_code">Zip Code</label>
                                <input type="text" class="form-control" name="address_zip" id="form_create_patient__input_zip_code"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_create_patient__input_city">City</label>
                                <input type="text" class="form-control" name="address_city" id="form_create_patient__input_city"/>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" id="form_create_patient__select_residence_country">Residence Country</label>
                                <select type="text" class="form-control chosen" name="resident_country_id" id="form_create_patient__select_residence_country">
                                    <option value="">Undetermined</option>
                                {% for country in countries %}
                                    <option value="{{country.id}}">{{country.niceName}}</option>
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
                                <label for="form_create_patient__select_clinic" class="control-label">Clinic</label>
                                <select id="form_create_patient__select_clinic" class="form-control chosen" name="clinic_id">
                                {% for clinic in clinics %}
                                    <option value="{{clinic.id}}">{{clinic.name}}</option>
                                {% endfor %}
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-12">
                            <div class="form-group">
                                <label class="control-label" id="form_create_patient__input_race">Race</label>
                                <input type="text" class="form-control" name="race" id="form_create_patient__input_race"/>
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
    };

    /**
     * @module modalCreatePatient
     * @function destroy
     */
    _this.destroy = () => {};

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
};
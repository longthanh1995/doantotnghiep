const _get = require('lodash/get');

/**
 * pageAdminSuperClinic
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function (sandbox) {
    let _this = this;

    /**
     * @memberOf pageAdminSuperClinic
     * @function showModalCreateAccount
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.showModalCreateDoctorAccount = ({id, doneCallback, failCallback}) => {
        sandbox.emit('window/loading/show');
        sandbox.emit('service/countries/list', {
            doneCallback: countries => {
                sandbox.emit('service/superClinicData/fetch', {
                    id,
                    doneCallback: superClinicDatum => {
                        let $modal = bootbox.dialog({
                            size: 'large',
                            title: 'Create doctor account',
                            message: swig.render(_this.templates.modalCreateDoctorAccount, {
                                locals: {
                                    superClinicDatum,
                                    countries,
                                },
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
                                    label: 'Submit',
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
                            .on('shown.bs.modal', event => {
                                let $form = $modal.find('form');

                                $form.find('select[name=phone_country_code]').selectize({
                                    placeholder: 'Country code',
                                });

                                $form.find('select[name=phone_number]').selectize({
                                    placeholder: 'Phone number',
                                    create: function(input) {
                                        return {
                                            value: input,
                                            text: input,
                                        };
                                    },
                                });

                                $form.find('select[name=languages]').selectize({
                                    maxItems: null,
                                });

                                $form.validate({
                                    ignore: ":hidden:not(select)",
                                    rules:{
                                        name: {
                                            required: true,
                                        },
                                        email: {
                                            required: true,
                                            validateEmail: '',
                                        },
                                        phone_number: {
                                            required: true,
                                            number: true,
                                        },
                                        phone_country_code: {},
                                        website: {},
                                        address: {},
                                        languages: {},
                                        license_no: {},
                                        password: {
                                            required: true,
                                            validatePassword: true,
                                            minlength: 6,
                                            maxlength: 30,
                                        },
                                        confirm_password: {
                                            required: true,
                                            validatePassword: true,
                                            minlength: 6,
                                            maxlength: 30,
                                            equalTo: '[name=password]'
                                        },
                                    },
                                    messages: {
                                        email: {
                                            validateEmail: 'Invalid email format.'
                                        },
                                        password: {
                                            required: 'This field is required',
                                            validatePassword: 'Invalid format password',
                                        },
                                        confirm_password: {
                                            required: 'This field is required',
                                            validatePassword: 'Invalid format password',
                                            equalTo: 'Please reenter the same password'
                                        },
                                    },
                                    errorElement: "p",
                                    errorClass: "help-block",
                                    errorPlacement: function(error, element) {
                                        element.closest('td,th').append(error);
                                    },
                                    highlight: function(element) {
                                        $(element).closest('td,th').addClass('has-error');
                                    },
                                    unhighlight: function (element) {
                                        $(element).closest('td,th').removeClass('has-error');
                                    },
                                    submitHandler: (form, event) => {
                                        event.preventDefault();

                                        let isSubmitting = parseInt($form.data('is-submitting'));

                                        if(isSubmitting){
                                            return;
                                        }

                                        let formData = $(form).serialize();

                                        sandbox.emit('window/loading/show');
                                        $form.data('is-submitting', 1);
                                        $modal.find(':input').prop('disabled', true);

                                        let request = $.ajax({
                                            url: laroute.route('admin.superClinicData.createDoctorAccount'),
                                            method: "POST",
                                            data: formData,
                                            dataType: "json"
                                        });

                                        request
                                            .done(response => {
                                                let message = `Doctor account for <b>${_get(response, 'data.doctor.name')}</b> has been created successfully!`;

                                                bootbox.alert(message, () => {
                                                    bootbox.hideAll();
                                                    sandbox.emit('window/loading/hide');
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
                                                    sandbox.emit('window/loading/hide');
                                                })
                                            })
                                        ;
                                    }
                                })
                            })
                        ;

                        sandbox.emit('window/loading/hide');
                    },
                    failCallback: (e, data) => {
                        sandbox.emit('window/loading/hide');
                    }
                });
            },
            failCallback: (e, data) => {
                sandbox.emit('window/loading/hide');
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            }
        });
    };

    /**
     * @memberOf pageAdminSuperClinic
     * @function bindEvents
     */
    _this.bindEvents = () => {
        _this.objects.$tableSuperClinicData
            .on('click', '[data-action=createAccount]', event => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    $targetRow = $this.closest('tr[data-id]'),
                    targetId = $targetRow.data('id')
                ;

                if (!targetId) {
                    return false;
                }

                _this.showModalCreateDoctorAccount({
                    id: targetId,
                    doneCallback: data => {
                        alert('success');
                    },
                    failCallback: () => {
                        alert('error');
                    }
                })
                ;
            })
        ;
    };

    _this.init = data => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$tableSuperClinicData = $('#table_super_clinic_data');

        _this.templates = {};
        _this.templates.modalCreateDoctorAccount = multiline(() => {/*!@preserve
        <form class="form" id="form_create_doctor_account">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="20%"></th>
                        <th width="40%" class="text-center">Raw data</th>
                        <th width="40%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="text-right" style="vertical-align:middle;">Name<sup class="text-danger">*</sup></th>
                        <td style="vertical-align:middle;">{{superClinicDatum.name}}</td>
                        <td>
                            <input class="form-control" name="name" value="{{superClinicDatum.name}}"/>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right" style="vertical-align:middle;">Email<sup class="text-danger">*</sup></th>
                        <td style="vertical-align:middle;">{{superClinicDatum.email}}</td>
                        <td>
                            <input class="form-control" name="email" value="{{superClinicDatum.email}}"/>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right" style="vertical-align:middle;">Phone number<sup class="text-danger">*</sup></th>
                        <td style="vertical-align:middle;">{{ superClinicDatum.phoneNumbers|join(', ')}}</td>
                        <td>
                            <div class="row">
                                <div class="col-xs-6">
                                    <select class="form-control" name="phone_country_code">
                                        <option></option>
                                    {% for country in countries %}
                                        <option value="{{country.phoneCountryCode}}">{{country.niceName}} ({{country.phoneCountryCode}})</option>
                                    {% endfor %}
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <select class="form-control" name="phone_number">
                                        <option></option>
                                    {% for phoneNumber in superClinicDatum.phoneNumbers %}
                                        <option value="{{phoneNumber}}">{{phoneNumber}}</option>
                                    {% endfor %}
                                    </select>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right" style="vertical-align:middle;">Website</th>
                        <td style="vertical-align:middle;">{{superClinicDatum.website}}</td>
                        <td>
                            <input class="form-control" name="website" value="{{superClinicDatum.website}}"/>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right" style="vertical-align:middle;">Spoken languages</th>
                        <td style="vertical-align:middle;">{{superClinicDatum.languages}}</td>
                        <td>
                            <select class="form-control" name="languages" multiple>
                                <option></option>
                            {% for language in superClinicDatum.languages|split(', ') %}
                                <option value="{{language}}" selected>{{language}}</option>
                            {% endfor %}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right" style="vertical-align:middle;">License Number</th>
                        <td style="vertical-align:middle;">{{superClinicDatum.licenseNo}}</td>
                        <td>
                            <input class="form-control" name="license_no" value="{{superClinicDatum.licenseNo}}"/>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right" style="vertical-align:middle;">Address</th>
                        <td style="vertical-align:middle;">{{superClinicDatum.address}}</td>
                        <td>
                            <input class="form-control" name="address" value="{{superClinicDatum.address}}"/>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-right" style="vertical-align:middle;">Password</th>
                        <td></td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" type="password" name="password" placeholder="Password" />
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" name="confirm_password" placeholder="Confirm password" />
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
        */console.log});

        _this.bindEvents();
    };

    _this.destroy = () => {
    };

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
};
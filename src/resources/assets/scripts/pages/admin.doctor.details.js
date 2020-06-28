'use strict';

const _get = require('lodash/get');

const modalButtons = {
    submit: {
        label: 'Submit',
        className: 'btn btn-danger',
        callback: function () {
            let $form = $(this).find('form');
            $form.submit();

            return false;
        }
    }
}

const datepickerConfig = {
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
    startDate: "01/01/1930",
    clearBtn: true
};

/**
 * @namespace pageAdminDoctorDetails
 */
module.exports = function (sandbox) {
    let _this = this;

    /**
     * @memberOf pageAdminDoctorDetails
     * @function showModalUpdateBasicInformation
     */
    _this.showModalUpdateBasicInformation = () => {
        console.log('xxx', _this.data);
        let $modal = bootbox.dialog({
            title: 'Update Basic Information',
            message: swig.render(_this.templates.modalUpdateBasicInformation, {
                locals: _this.data
            }),
            className: 'modal-update-basic-information',
            buttons: modalButtons
        });

        $modal
            .on('shown.bs.modal', (event) => {
                let $form = $modal.find('form'),
                    $inputDateOfBirth = $form.find('[name=date_of_birth]'),
                    $selectLanguages = $form.find('#select_languages'),
                    $table = $form.find('#table_profession_ids'),
                    $tableProfessionIds__body = $table.find('tbody')
                    ;

                $inputDateOfBirth.datepicker(datepickerConfig);

                $selectLanguages.chosen({
                    width: '100%'
                });

                let nextRowIndex = $tableProfessionIds__body.children().length;

                $table
                    .on('click', '[data-action=addProfession]', (event) => {
                        event.preventDefault();

                        let html = swig.render(_this.templates.modalUpdateBasicInformation__tableProfessionIds__row, {
                            locals: {
                                index: nextRowIndex++
                            }
                        });

                        $tableProfessionIds__body.append(html);
                    })
                    .on('click', '[data-action=removeProfession]', (event) => {
                        event.preventDefault();

                        let $this = $(event.currentTarget);

                        $this.closest('tr').remove();
                    })
                    ;

                $form.validate({
                    rules: {
                        title: {
                            required: true
                        },
                        name: {
                            required: true
                        },
                        gender: {
                            required: true
                        },
                        date_of_birth: {
                            required: true
                        }
                    },
                    messages: {
                    },
                    errorElement: "p",
                    errorClass: "help-block",

                    errorPlacement: function (error, element) {
                        element.closest('div').append(error);
                    },

                    highlight: function (element) {
                        $(element).closest('div').addClass('has-error');
                    },

                    unhighlight: function (element) {
                        $(element).closest('div').removeClass('has-error');
                    },

                    submitHandler: (form, event) => {
                        event.preventDefault();

                        let isSubmitting = parseInt($form.data('is-submitting'));

                        if (isSubmitting) {
                            return;
                        }

                        let formData = $(form).serialize();

                        manaDrApplication.emit('window/loading/show');
                        $form.data('is-submitting', 1);
                        $modal.find(':input').prop('disabled', true);

                        let request = $.ajax({
                            url: laroute.route('admin.doctor.updateBasicInformation', { doctor: _get(_this.data, 'doctor.id') }),
                            method: "POST",
                            data: formData,
                            dataType: "json"
                        });

                        request
                            .done((response) => {
                                let message = '';

                                if (response
                                    && response.message
                                    && response.message.length) {
                                    message = response.message;
                                } else {
                                    message = 'Request has been processed successfully';
                                }

                                bootbox.alert(message, () => {
                                    // $modal.modal('hide');
                                    window.location.reload();
                                })
                            })
                            .fail((e, data) => {
                                let message = '';

                                if (e
                                    && e.responseJSON
                                    && e.responseJSON.message
                                    && e.responseJSON.message.length) {
                                    message = e.responseJSON.message;
                                } else {
                                    message = 'The request cannot be processed';
                                }

                                bootbox.alert(message, function () {
                                    $form.data('is-submitting', 0);
                                    $modal.find(':input').prop('disabled', false);
                                    manaDrApplication.emit('window/loading/hide');
                                });
                            })
                            .always(() => {
                                // manaDrApplication.emit('window/loading/hide');
                            })
                            ;
                    }
                })
            })
            ;
    }

    /**
     * @memberOf pageAdminDoctorDetails
     * @function showModalUpdatePersonalContact
     */
    _this.showModalUpdatePersonalContact = () => {
        let $modal = bootbox.dialog({
            title: 'Update Personal Contact',
            message: swig.render(_this.templates.modalUpdatePersonalContact, {
                locals: _this.data
            }),
            className: 'modal-update-personal-contact',
            buttons: modalButtons
        });

        $modal
            .on('shown.bs.modal', (event) => {
                let $form = $modal.find('form'),
                    $selectPhoneCountryCode = $form.find('[name=phone_country_code]'),
                    $selectCountry = $form.find('[name=country_id]')
                    ;

                $selectPhoneCountryCode.chosen();
                $selectCountry.chosen();

                $form.validate({
                    rules: {
                        phone_country_code: {
                            required: true
                        },
                        phone_number: {
                            required: true,
                            number: true,
                            minlength: 6,
                            maxlength: 15,
                        },
                        email: {
                            validateEmail: true,
                        },
                        website: {
                            url: true,
                        },
                        address: {
                            required: true,
                        }
                    },
                    messages: {
                        email: {
                            validateEmail: 'Please enter a valid email address'
                        }
                    },
                    errorElement: "p",
                    errorClass: "help-block",
                    errorPlacement: function (error, element) {
                        element.closest('div').append(error);
                    },
                    highlight: function (element) {
                        $(element).closest('div').addClass('has-error');
                    },
                    unhighlight: function (element) {
                        $(element).closest('div').removeClass('has-error');
                    },
                    submitHandler: (form, event) => {
                        event.preventDefault();

                        let isSubmitting = parseInt($form.data('is-submitting'));

                        if (isSubmitting) {
                            return;
                        }

                        let formData = $(form).serialize();

                        manaDrApplication.emit('window/loading/show');
                        $form.data('is-submitting', 1);
                        $modal.find(':input').prop('disabled', true);

                        let request = $.ajax({
                            url: laroute.route('admin.doctor.updatePersonalContact', { doctor: _get(_this.data, 'doctor.id') }),
                            method: "POST",
                            data: formData,
                            dataType: "json"
                        });

                        request
                            .done((response) => {
                                let message = '';

                                if (response
                                    && response.message
                                    && response.message.length) {
                                    message = response.message;
                                } else {
                                    message = 'Request has been processed successfully';
                                }

                                bootbox.alert(message, () => {
                                    // $modal.modal('hide');
                                    window.location.reload();
                                })
                            })
                            .fail((e, data) => {
                                let message = '';

                                if (e
                                    && e.responseJSON
                                    && e.responseJSON.message
                                    && e.responseJSON.message.length) {
                                    message = e.responseJSON.message;
                                } else {
                                    message = 'The request cannot be processed';
                                }

                                bootbox.alert(message, function () {
                                    $form.data('is-submitting', 0);
                                    $modal.find(':input').prop('disabled', false);
                                    manaDrApplication.emit('window/loading/hide');
                                });
                            })
                            .always(() => {
                                // manaDrApplication.emit('window/loading/hide');
                            })
                            ;
                    }
                });
            })
    }

    /**
     * @memberOf pageAdminDoctorDetails
     * @function showModalUpdateMedicalSchools
     */
    _this.showModalUpdateMedicalSchools = () => {
        let $modal = bootbox.dialog({
            title: 'Update Medical Schools',
            message: swig.render(_this.templates.modalUpdateMedicalSchools, {
                locals: _this.data
            }),
            className: 'modal-update-medical-schools'
        });

        $modal
            .on('hidden.bs.modal', (event) => {
                //@TODO: reload to make sure displayed info is synced with db
                manaDrApplication.emit('window/loading/show');
                window.location.reload();
            })
            .on('click', '[data-action=addMedicalSchool]', (event) => {
                event.preventDefault();

                let $table = $modal.find('#table_medical_schools'),
                    $modalCreateMedicalSchool = bootbox.dialog({
                        title: 'Add new Medical School',
                        message: swig.render(_this.templates.modalCreateMedicalSchool),
                        className: 'modal-create-medical-school',
                        buttons: modalButtons
                    });

                $modalCreateMedicalSchool
                    .on('shown.bs.modal', (event) => {
                        let $form = $modalCreateMedicalSchool.find('form'),
                            $inputDateOfGraduation = $form.find('[name=date_of_graduation]')
                            ;

                        $inputDateOfGraduation.datepicker(datepickerConfig);

                        $form.validate({
                            rules: {
                                name: {
                                    required: true
                                },
                                date_of_graduation: {
                                    required: true
                                }
                            },
                            messages: {},
                            errorElement: "p",
                            errorClass: "help-block",
                            errorPlacement: function (error, element) {
                                element.closest('div').append(error);
                            },
                            highlight: function (element) {
                                $(element).closest('div').addClass('has-error');
                            },
                            unhighlight: function (element) {
                                $(element).closest('div').removeClass('has-error');
                            },
                            submitHandler: (form, event) => {
                                event.preventDefault();

                                let isSubmitting = parseInt($form.data('is-submitting'));

                                if (isSubmitting) {
                                    return;
                                }

                                let formData = $(form).serialize();

                                manaDrApplication.emit('window/loading/show');
                                $form.data('is-submitting', 1);
                                $modalCreateMedicalSchool.find(':input').prop('disabled', true);

                                let request = $.ajax({
                                    url: laroute.route('admin.doctor.storeMedicalSchool', { doctor: _get(_this.data, 'doctor.id') }),
                                    method: "POST",
                                    data: formData,
                                    dataType: "json"
                                });

                                request
                                    .done((response) => {
                                        let message = '';

                                        if (response
                                            && response.message
                                            && response.message.length) {
                                            message = response.message;
                                        } else {
                                            message = 'Request has been processed successfully';
                                        }

                                        bootbox.alert(message, () => {
                                            // $modal.modal('hide');
                                            if (response && response.data) {
                                                let data = humps.camelizeKeys(response.data),
                                                    html = swig.render(_this.templates.modalUpdateMedicalSchools__tableMedicalSchools__row, {
                                                        locals: {
                                                            medicalSchool: data
                                                        }
                                                    });

                                                $table.find('tbody').append(html);
                                            }

                                            $modalCreateMedicalSchool.modal('hide');
                                            manaDrApplication.emit('window/loading/hide');
                                        });
                                    })
                                    .fail((e, data) => {
                                        let message = '';

                                        if (e
                                            && e.responseJSON
                                            && e.responseJSON.message
                                            && e.responseJSON.message.length) {
                                            message = e.responseJSON.message;
                                        } else {
                                            message = 'The request cannot be processed';
                                        }

                                        bootbox.alert(message, function () {
                                            $form.data('is-submitting', 0);
                                            $modalCreateMedicalSchool.find(':input').prop('disabled', false);
                                            manaDrApplication.emit('window/loading/hide');
                                        });
                                    })
                                    .always(() => {
                                        // manaDrApplication.emit('window/loading/hide');
                                    })
                                    ;
                            }
                        });
                    })
                    ;
            })
            .on('click', '[data-action=updateMedicalSchool]', (event) => {
                event.preventDefault();

                let $targetRow = $(event.currentTarget).closest('tr'),
                    targetId = $targetRow.attr('data-id'),
                    targetName = $targetRow.attr('data-name'),
                    targetDateOfGraduation = $targetRow.attr('data-date-of-graduation'),
                    $modalUpdateMedicalSchool = bootbox.dialog({
                        title: 'Update Medical School',
                        message: swig.render(_this.templates.modalUpdateMedicalSchool, {
                            locals: {
                                medicalSchool: {
                                    name: targetName,
                                    pivot: {
                                        dateOfGraduation: targetDateOfGraduation
                                    }
                                }
                            }
                        }),
                        className: 'modal-update-medical-school',
                        buttons: modalButtons
                    })
                    ;

                $modalUpdateMedicalSchool
                    .on('shown.bs.modal', (event) => {
                        let $form = $modalUpdateMedicalSchool.find('form'),
                            $inputDateOfGraduation = $form.find('[name=date_of_graduation]')
                            ;

                        $inputDateOfGraduation.datepicker(datepickerConfig);

                        $form.validate({
                            rules: {
                                name: {
                                    required: true
                                },
                                date_of_graduation: {
                                    required: true
                                }
                            },
                            messages: {},
                            errorElement: "p",
                            errorClass: "help-block",
                            errorPlacement: function (error, element) {
                                element.closest('div').append(error);
                            },
                            highlight: function (element) {
                                $(element).closest('div').addClass('has-error');
                            },
                            unhighlight: function (element) {
                                $(element).closest('div').removeClass('has-error');
                            },
                            submitHandler: (form, event) => {
                                event.preventDefault();

                                let isSubmitting = parseInt($form.data('is-submitting'));

                                if (isSubmitting) {
                                    return;
                                }

                                let formData = $(form).serialize();

                                manaDrApplication.emit('window/loading/show');
                                $form.data('is-submitting', 1);
                                $modalUpdateMedicalSchool.find(':input').prop('disabled', true);

                                let request = $.ajax({
                                    url: laroute.route('admin.doctor.updateMedicalSchool', { doctor: _get(_this.data, 'doctor.id'), medicalSchool: targetId }),
                                    method: "POST",
                                    data: formData,
                                    dataType: "json"
                                });

                                request
                                    .done((response) => {
                                        let message = '';

                                        if (response
                                            && response.message
                                            && response.message.length) {
                                            message = response.message;
                                        } else {
                                            message = 'Request has been processed successfully';
                                        }

                                        bootbox.alert(message, () => {
                                            // $modal.modal('hide');
                                            if (response && response.data) {
                                                let data = humps.camelizeKeys(response.data),
                                                    html = swig.render(_this.templates.modalUpdateMedicalSchools__tableMedicalSchools__row, {
                                                        locals: {
                                                            medicalSchool: data
                                                        }
                                                    });

                                                $targetRow.replaceWith(html);
                                            }

                                            $modalUpdateMedicalSchool.modal('hide');
                                            manaDrApplication.emit('window/loading/hide');
                                        });
                                    })
                                    .fail((e, data) => {
                                        let message = '';

                                        if (e
                                            && e.responseJSON
                                            && e.responseJSON.message
                                            && e.responseJSON.message.length) {
                                            message = e.responseJSON.message;
                                        } else {
                                            message = 'The request cannot be processed';
                                        }

                                        bootbox.alert(message, function () {
                                            $form.data('is-submitting', 0);
                                            $modalUpdateMedicalSchool.find(':input').prop('disabled', false);
                                            manaDrApplication.emit('window/loading/hide');
                                        });
                                    })
                                    .always(() => {
                                        // manaDrApplication.emit('window/loading/hide');
                                    })
                                    ;
                            }
                        });
                    })
                    ;
            })
            .on('click', '[data-action=removeMedicalSchool]', (event) => {
                event.preventDefault();

                let $targetRow = $(event.currentTarget).closest('tr'),
                    targetId = $targetRow.data('id')
                    ;

                if (!targetId) {
                    return;
                }

                bootbox.confirm('Do you really want to remove this entry?', (result) => {
                    if (result) {
                        let request = $.ajax({
                            url: laroute.route('admin.doctor.deleteMedicalSchool', {
                                doctor: _get(_this.data, 'doctor.id'),
                                medicalSchool: targetId
                            }),
                            method: "DELETE",
                            data: {},
                            dataType: "json"
                        });

                        request
                            .done((response) => {
                                let message = '';

                                if (response
                                    && response.message
                                    && response.message.length) {
                                    message = response.message;
                                } else {
                                    message = 'Request has been processed successfully';
                                }

                                bootbox.alert(message, () => {
                                    $targetRow.remove();
                                });
                            })
                            .fail((e, data) => {
                                let message = '';

                                if (e
                                    && e.responseJSON
                                    && e.responseJSON.message
                                    && e.responseJSON.message.length) {
                                    message = e.responseJSON.message;
                                } else {
                                    message = 'The request cannot be processed';
                                }

                                bootbox.alert(message, function () {
                                    $form.data('is-submitting', 0);
                                    $modal.find(':input').prop('disabled', false);
                                    manaDrApplication.emit('window/loading/hide');
                                });
                            })
                            .always(() => {
                                // manaDrApplication.emit('window/loading/hide');
                            })
                            ;
                    }
                });
            })
            ;
    }

    /**
     * @memberOf pageAdminDoctorDetails
     * @function showModalUpdateQualifications
     */
    _this.showModalUpdateQualifications = () => {
        let $modal = bootbox.dialog({
            title: 'Update Qualifications',
            message: swig.render(_this.templates.modalUpdateQualifications, {
                locals: _this.data
            }),
            className: 'modal-update-qualifications'
        });

        $modal
            .on('hidden.bs.modal', (event) => {
                //@TODO: reload to make sure displayed info is synced with db
                manaDrApplication.emit('window/loading/show');
                window.location.reload();
            })
            .on('click', '[data-action=addQualification]', (event) => {
                event.preventDefault();

                let $table = $modal.find('#table_qualifications'),
                    $modalCreateQualification = bootbox.dialog({
                        title: 'Add new Qualification',
                        message: swig.render(_this.templates.modalCreateQualification),
                        className: 'modal-create-qualification',
                        buttons: modalButtons
                    });

                $modalCreateQualification
                    .on('shown.bs.modal', (event) => {
                        let $form = $modalCreateQualification.find('form')
                            ;

                        $form.validate({
                            rules: {
                                name: {
                                    required: true
                                },
                                issuer: {
                                    required: true
                                },
                                issued_time: {
                                    required: true,
                                    digits: true,
                                    minlength: 4,
                                    maxlength: 4
                                }
                            },
                            messages: {},
                            errorElement: "p",
                            errorClass: "help-block",
                            errorPlacement: function (error, element) {
                                element.closest('div').append(error);
                            },
                            highlight: function (element) {
                                $(element).closest('div').addClass('has-error');
                            },
                            unhighlight: function (element) {
                                $(element).closest('div').removeClass('has-error');
                            },
                            submitHandler: (form, event) => {
                                event.preventDefault();

                                let isSubmitting = parseInt($form.data('is-submitting'));

                                if (isSubmitting) {
                                    return;
                                }

                                let formData = $(form).serialize();

                                manaDrApplication.emit('window/loading/show');
                                $form.data('is-submitting', 1);
                                $modalCreateQualification.find(':input').prop('disabled', true);

                                let request = $.ajax({
                                    url: laroute.route('admin.doctor.storeQualification', { doctor: _get(_this.data, 'doctor.id') }),
                                    method: "POST",
                                    data: formData,
                                    dataType: "json"
                                });

                                request
                                    .done((response) => {
                                        let message = '';

                                        if (response
                                            && response.message
                                            && response.message.length) {
                                            message = response.message;
                                        } else {
                                            message = 'Request has been processed successfully';
                                        }

                                        bootbox.alert(message, () => {
                                            // $modal.modal('hide');
                                            if (response && response.data) {
                                                let data = humps.camelizeKeys(response.data),
                                                    html = swig.render(_this.templates.modalUpdateQualifications__tableQualifications__row, {
                                                        locals: {
                                                            qualification: data
                                                        }
                                                    });

                                                $table.find('tbody').append(html);
                                            }

                                            $modalCreateQualification.modal('hide');
                                            manaDrApplication.emit('window/loading/hide');
                                        });
                                    })
                                    .fail((e, data) => {
                                        let message = '';

                                        if (e
                                            && e.responseJSON
                                            && e.responseJSON.message
                                            && e.responseJSON.message.length) {
                                            message = e.responseJSON.message;
                                        } else {
                                            message = 'The request cannot be processed';
                                        }

                                        bootbox.alert(message, function () {
                                            $form.data('is-submitting', 0);
                                            $modalCreateQualification.find(':input').prop('disabled', false);
                                            manaDrApplication.emit('window/loading/hide');
                                        });
                                    })
                                    .always(() => {
                                        // manaDrApplication.emit('window/loading/hide');
                                    })
                                    ;
                            }
                        });
                    })
                    ;
            })
            .on('click', '[data-action=updateQualification]', (event) => {
                event.preventDefault();

                let $targetRow = $(event.currentTarget).closest('tr'),
                    targetId = $targetRow.attr('data-id'),
                    targetName = $targetRow.attr('data-name'),
                    targetIssuer = $targetRow.attr('data-issuer'),
                    targetIssuedTime = $targetRow.attr('data-issued-time'),
                    $modalUpdateQualification = bootbox.dialog({
                        title: 'Update Qualification',
                        message: swig.render(_this.templates.modalUpdateQualification, {
                            locals: {
                                qualification: {
                                    name: targetName,
                                    issuer: targetIssuer,
                                    issuedTime: targetIssuedTime
                                }
                            }
                        }),
                        className: 'modal-update-qualification',
                        buttons: modalButtons
                    })
                    ;

                $modalUpdateQualification
                    .on('shown.bs.modal', (event) => {
                        let $form = $modalUpdateQualification.find('form')
                            ;

                        $form.validate({
                            rules: {
                                name: {
                                    required: true
                                },
                                issuer: {
                                    required: true
                                },
                                issued_time: {
                                    required: true,
                                    digits: true,
                                    minlength: 4,
                                    maxlength: 4
                                }
                            },
                            messages: {},
                            errorElement: "p",
                            errorClass: "help-block",
                            errorPlacement: function (error, element) {
                                element.closest('div').append(error);
                            },
                            highlight: function (element) {
                                $(element).closest('div').addClass('has-error');
                            },
                            unhighlight: function (element) {
                                $(element).closest('div').removeClass('has-error');
                            },
                            submitHandler: (form, event) => {
                                event.preventDefault();

                                let isSubmitting = parseInt($form.data('is-submitting'));

                                if (isSubmitting) {
                                    return;
                                }

                                let formData = $(form).serialize();

                                manaDrApplication.emit('window/loading/show');
                                $form.data('is-submitting', 1);
                                $modalUpdateQualification.find(':input').prop('disabled', true);

                                let request = $.ajax({
                                    url: laroute.route('admin.doctor.updateQualification', { doctor: _get(_this.data, 'doctor.id'), qualification: targetId }),
                                    method: "POST",
                                    data: formData,
                                    dataType: "json"
                                });

                                request
                                    .done((response) => {
                                        let message = '';

                                        if (response
                                            && response.message
                                            && response.message.length) {
                                            message = response.message;
                                        } else {
                                            message = 'Request has been processed successfully';
                                        }

                                        bootbox.alert(message, () => {
                                            // $modal.modal('hide');
                                            if (response && response.data) {
                                                let data = humps.camelizeKeys(response.data),
                                                    html = swig.render(_this.templates.modalUpdateQualifications__tableQualifications__row, {
                                                        locals: {
                                                            qualification: data
                                                        }
                                                    });

                                                $targetRow.replaceWith(html);
                                            }

                                            $modalUpdateQualification.modal('hide');
                                            manaDrApplication.emit('window/loading/hide');
                                        });
                                    })
                                    .fail((e, data) => {
                                        let message = '';

                                        if (e
                                            && e.responseJSON
                                            && e.responseJSON.message
                                            && e.responseJSON.message.length) {
                                            message = e.responseJSON.message;
                                        } else {
                                            message = 'The request cannot be processed';
                                        }

                                        bootbox.alert(message, function () {
                                            $form.data('is-submitting', 0);
                                            $modalUpdateQualification.find(':input').prop('disabled', false);
                                            manaDrApplication.emit('window/loading/hide');
                                        });
                                    })
                                    .always(() => {
                                        // manaDrApplication.emit('window/loading/hide');
                                    })
                                    ;
                            }
                        });
                    })
            })
            .on('click', '[data-action=removeQualification]', (event) => {
                event.preventDefault();

                let $targetRow = $(event.currentTarget).closest('tr'),
                    targetId = $targetRow.data('id')
                    ;

                if (!targetId) {
                    return;
                }

                bootbox.confirm('Do you really want to remove this entry?', (result) => {
                    if (result) {
                        let request = $.ajax({
                            url: laroute.route('admin.doctor.deleteQualification', {
                                doctor: _get(_this.data, 'doctor.id'),
                                qualification: targetId
                            }),
                            method: "DELETE",
                            data: {},
                            dataType: "json"
                        });

                        request
                            .done((response) => {
                                let message = '';

                                if (response
                                    && response.message
                                    && response.message.length) {
                                    message = response.message;
                                } else {
                                    message = 'Request has been processed successfully';
                                }

                                bootbox.alert(message, () => {
                                    $targetRow.remove();
                                });
                            })
                            .fail((e, data) => {
                                let message = '';

                                if (e
                                    && e.responseJSON
                                    && e.responseJSON.message
                                    && e.responseJSON.message.length) {
                                    message = e.responseJSON.message;
                                } else {
                                    message = 'The request cannot be processed';
                                }

                                bootbox.alert(message, function () {
                                    $form.data('is-submitting', 0);
                                    $modal.find(':input').prop('disabled', false);
                                    manaDrApplication.emit('window/loading/hide');
                                });
                            })
                            .always(() => {
                                // manaDrApplication.emit('window/loading/hide');
                            })
                            ;
                    }
                });
            })
            ;
    }

    /**
     * @memberOf pageAdminDoctorDetails
     * @function showModalChangePassword
     */
    _this.showModalChangePassword = () => {
        let $modal = bootbox.dialog({
            title: 'Change password',
            message: swig.render(_this.templates.modalChangePassword, {
                locals: _this.data
            }),
            buttons: modalButtons
        });

        $modal
            .on('shown.bs.modal', () => {
                let $form = $modal.find('form');

                $form.validate({
                    rules: {
                        new_password: {
                            required: true,
                            minlength: 6,
                            maxlength: 30
                        }
                    },
                    messages: {},
                    errorElement: "p",
                    errorClass: "help-block",

                    errorPlacement: function (error, element) {
                        element.closest('div').append(error);
                    },

                    highlight: function (element) {
                        $(element).closest('div').addClass('has-error');
                    },

                    unhighlight: function (element) {
                        $(element).closest('div').removeClass('has-error');
                    },

                    submitHandler: (form, event) => {
                        event.preventDefault();

                        let isSubmitting = parseInt($form.data('is-submitting'));

                        if (isSubmitting) {
                            return;
                        }

                        let formData = $(form).serialize();

                        manaDrApplication.emit('window/loading/show');
                        $form.data('is-submitting', 1);
                        $modal.find(':input').prop('disabled', true);

                        let request = $.ajax({
                            url: laroute.route('admin.doctor.changePassword', { doctor: _get(_this.data, 'doctor.id') }),
                            method: "POST",
                            data: formData,
                            dataType: "json"
                        });

                        request
                            .done((response) => {
                                let message = '';

                                if (response
                                    && response.message
                                    && response.message.length) {
                                    message = response.message;
                                } else {
                                    message = 'Request has been processed successfully';
                                }

                                bootbox.alert(message, () => {
                                    // $modal.modal('hide');
                                    window.location.reload();
                                })
                            })
                            .fail((e, data) => {
                                let message = '';

                                if (e
                                    && e.responseJSON
                                    && e.responseJSON.message
                                    && e.responseJSON.message.length) {
                                    message = e.responseJSON.message;
                                } else {
                                    message = 'The request cannot be processed';
                                }

                                bootbox.alert(message, function () {
                                    $form.data('is-submitting', 0);
                                    $modal.find(':input').prop('disabled', false);
                                    manaDrApplication.emit('window/loading/hide');
                                });
                            })
                            .always(() => {
                                // manaDrApplication.emit('window/loading/hide');
                            })
                            ;
                    }
                })
            })
            ;
    }

    /**
     * @memberOf pageAdminDoctorDetails
     * @function showModalChangeAuthenticationPhoneNumber
     */
    _this.showModalChangeAuthenticationPhoneNumber = () => {
        let $modal = bootbox.dialog({
            title: 'Change authentication number',
            message: swig.render(_this.templates.modalChangeAuthenticationPhoneNumber, {
                locals: _this.data
            }),
            buttons: modalButtons
        });

        $modal
            .on('shown.bs.modal', () => {
                let $form = $modal.find('form');

                $form.validate({
                    rules: {
                        new_phone_country_code: {
                            required: true
                        },
                        new_phone_number: {
                            required: true,
                            number: true,
                            minlength: 6,
                            maxlength: 15
                        }
                    },
                    messages: {

                    },
                    errorElement: "p",
                    errorClass: "help-block",

                    errorPlacement: function (error, element) {
                        element.closest('div').append(error);
                    },

                    highlight: function (element) {
                        $(element).closest('div').addClass('has-error');
                    },

                    unhighlight: function (element) {
                        $(element).closest('div').removeClass('has-error');
                    },

                    submitHandler: (form, event) => {
                        event.preventDefault();

                        let isSubmitting = parseInt($form.data('is-submitting'));

                        if (isSubmitting) {
                            return;
                        }

                        let formData = $(form).serialize();

                        manaDrApplication.emit('window/loading/show');
                        $form.data('is-submitting', 1);
                        $modal.find(':input').prop('disabled', true);

                        let request = $.ajax({
                            url: laroute.route('admin.doctor.updateAuthenticationPhoneNumber', { doctor: _get(_this.data, 'doctor.id') }),
                            method: "POST",
                            data: formData,
                            dataType: "json"
                        });

                        request
                            .done((response) => {
                                let message = '';

                                if (response
                                    && response.message
                                    && response.message.length) {
                                    message = response.message;
                                } else {
                                    message = 'Request has been processed successfully';
                                }

                                bootbox.alert(message, () => {
                                    // $modal.modal('hide');
                                    window.location.reload();
                                })
                            })
                            .fail((e, data) => {
                                let message = '';

                                if (e
                                    && e.responseJSON
                                    && e.responseJSON.message
                                    && e.responseJSON.message.length) {
                                    message = e.responseJSON.message;
                                } else {
                                    message = 'The request cannot be processed';
                                }

                                bootbox.alert(message, function () {
                                    $form.data('is-submitting', 0);
                                    $modal.find(':input').prop('disabled', false);
                                    manaDrApplication.emit('window/loading/hide');
                                });
                            })
                            .always(() => {
                                // manaDrApplication.emit('window/loading/hide');
                            })
                            ;
                    }
                })
            })
            ;
    }

    /**
     * @memberOf pageAdminDoctorDetails
     * @function render
     */
    _this.render = () => { }

    /**
     * @memberOf pageAdminDoctorDetails
     * @function bindEvents
     */
    _this.bindEvents = () => {
        _this.objects.$boxInfo
            .on('click', '[data-action=showModalUpdateBasicInformation]', (event) => {
                event.preventDefault();
                _this.showModalUpdateBasicInformation();
            })
            .on('click', '[data-action=showModalUpdatePersonalContact]', (event) => {
                event.preventDefault();
                _this.showModalUpdatePersonalContact();
            })
            .on('click', '[data-action=showModalUpdateMedicalSchools]', (event) => {
                event.preventDefault();
                _this.showModalUpdateMedicalSchools();
            })
            .on('click', '[data-action=showModalUpdateQualifications]', (event) => {
                _this.showModalUpdateQualifications();
            })
            ;

        _this.objects.$boxOperations
            .on('click', '[data-action=showModalChangeAuthenticationPhoneNumber]', (event) => {
                event.preventDefault();

                _this.showModalChangeAuthenticationPhoneNumber();
            })
            .on('click', '[data-action=showModalChangePassword]', (event) => {
                event.preventDefault();

                _this.showModalChangePassword();
            })
            ;
    }

    /**
     * @memberOf pageAdminDoctorDetails
     * @function init
     * @param data
     */
    _this.init = ({ data }) => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$boxInfo = $('#box_info');
        _this.objects.$boxOperations = $('#box_operations');

        _this.templates = {};
        _this.templates.modalUpdateBasicInformation = multiline(() => {/*!@preserve
        <form class="form" data-is-submitting="0">
            <div class="form-group">
                <label class="control-label">Title</label>
                <select class="form-control" name="title">
                    <option value="">Undefined</option>
                {% for title in doctorTitles %}
                    <option
                        value="{{title.id}}"
                    {% if (title.id == doctor.doctorTitleId) %}
                        selected="selected"
                    {% endif %}
                    >{{title.title}}</option>
                {% endfor %}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Fullname</label>
                <input class="form-control" name="name" value="{{doctor.name}}"/>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="control-label">Gender</label>
                        <p>
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="male" {% if (doctor.gender == 'male') %}checked="checked"{% endif %}/>
                                Male
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="female" {% if (doctor.gender == 'female') %}checked="checked"{% endif %}/>
                                Female
                            </label>
                        </p>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="control-label">Date of Birth</label>
                        <input class="form-control" name="date_of_birth" value="{{doctor.dateOfBirth|formatWithoutTimezone('DD/MM/YYYY')}}" readonly="readonly"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label">Languages</label>
                <select class="form-control hide" name="languages[]" id="select_languages" multiple="multiple">
                {% for language in languages %}
                    <option
                        value="{{language.id}}"
                        {{language.id|renderSelectedOption(doctor.languages, 'id')}}
                    >{{language.name}}</option>
                {% endfor %}
                </select>
            </div>

            <div class="form-group">
                <label class="control-label">Profession IDs</label>
                <table class="table" id="table_profession_ids">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>License</th>
                            <th class="text-center">
                                <a href="#" class="btn btn-sm btn-primary" data-action="addProfession">
                                    <i class="fa fa-fw fa-plus"></i> Add
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    {% for profession in doctor.professions %}
                        <tr>
                            <td>
                                <input class="form-control input-sm" value="{{profession.name}}" name="professions[{{loop.index0}}][name]">
                            </td>
                            <td>
                                <input class="form-control input-sm" value="{{profession.licenseNo}}" name="professions[{{loop.index0}}][license]">
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-danger" data-action="removeProfession">
                                    <i class="fa fa-times"></i> Remove
                                </a>
                            </td>
                        </tr>
                    {% endfor %}
                    </tbody>
                </table>
            </div>
        </form>
        */console.log
        });
        _this.templates.modalUpdateBasicInformation__tableProfessionIds__row = multiline(() => {/*!@preserve
        <tr>
            <td>
                <input class="form-control input-sm" value="" name="professions[{{index}}][name]">
            </td>
            <td>
                <input class="form-control input-sm" value="" name="professions[{{index}}][license]">
            </td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-danger" data-action="removeProfession">
                    <i class="fa fa-times"></i> Remove
                </a>
            </td>
        </tr>
        */console.log
        });
        _this.templates.modalUpdatePersonalContact = multiline(() => {/*!@preserve
        <form class="form" data-is-submitting="0">
            <div class="form-group">
                <label>Phone Number<sup class="text-danger">*</sup></label>
                <div class="row">
                    <div class="col-xs-6">
                        <select class="form-control" name="phone_country_code">
                            <option value="">Undetermined</option>
                        {% for phoneCountryCode in phoneCountryCodes %}
                            <option
                                value="{{phoneCountryCode}}"
                            {% if (doctor.phoneCountryCode == phoneCountryCode) %}
                                selected="selected"
                            {% endif %}
                            >{{phoneCountryCode}}</option>
                        {% endfor %}
                        </select>
                    </div>
                    <div class="col-xs-6">
                        <input class="form-control" name="phone_number" type="text" value="{{doctor.phoneNumber}}"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6">
                        <label class="control-label">Email<sup class="text-danger">*</sup></label>
                        <input class="form-control" name="email" value="{% if (doctor.account) %}{{doctor.account.email}}{% else %}{{doctor.email}}{% endif %}"/>
                    </div>
                    <div class="col-xs-6">
                        <label class="control-label">Website</label>
                        <input class="form-control" name="website" value="{{doctor.website}}"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6">
                        <label class="control-label">Address<sup class="text-danger">*</sup></label>
                        <input class="form-control" name="address" value="{{doctor.address}}"/>
                    </div>
                    <div class="col-xs-6">
                        <label class="control-label">Country</label>
                        <select class="form-control" name="country_id">
                            <option value="">Please select</option>
                        {% for countryId, countryName in countries %}
                            <option
                                value="{{countryId}}"
                            {% if (countryId == doctor.countryId) %}
                                selected="selected"
                            {% endif %}
                            >{{countryName}}</option>
                        {% endfor %}
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Office Hours</label>
                <textarea class="form-control" name="office_hours">{{doctor.officeHours}}</textarea>
            </div>
        </form>
        */console.log
        });
        _this.templates.modalUpdateMedicalSchools = multiline(() => {/*!@preserve
        <table class="table table-bordered" id="table_medical_schools">
            <thead>
                <tr>
                    <th>Date of Graduation</th>
                    <th>School Name</th>
                    <th class="text-center">
                        <a href="#" class="btn btn-xs btn-primary" data-action="addMedicalSchool">
                            <i class="fa fa-fw fa-plus"></i> Add
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
            {% for medicalSchool in doctor.medicalSchools %}
                <tr data-id="{{medicalSchool.id}}" data-name="{{medicalSchool.name}}" data-date-of-graduation="{{medicalSchool.pivot.dateOfGraduation|formatTimestamp1}}">
                    <td>
                        {{medicalSchool.pivot.dateOfGraduation|formatTimestamp1}}
                    </td>
                    <td>
                        {{medicalSchool.name}}
                    </td>
                    <td class="text-center">
                        <a href="#" class="btn btn-xs btn-warning" data-action="updateMedicalSchool">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <a href="#" class="btn btn-xs btn-danger" data-action="removeMedicalSchool">
                            <i class="fa fa-times"></i> Remove
                        </a>
                    </td>
                </tr>
            {% endfor %}
            </tbody>
        </table>
        */console.log
        });
        _this.templates.modalCreateMedicalSchool = multiline(() => {/*!@preserve
        <form class="form">
            <div class="form-group">
                <label class="control-label">School Name:</label>
                <input class="form-control" name="name"/>
            </div>
            <div class="form-group">
                <label class="control-label">Date of Graduation</label>
                <input class="form-control" name="date_of_graduation" placeholder="Click to pick a date" readonly="readonly"/>
            </div>
        </form>
        */console.log
        });
        _this.templates.modalUpdateMedicalSchool = multiline(() => {/*!@preserve
        <form class="form">
            <div class="form-group">
                <label class="control-label">School Name:</label>
                <input class="form-control" name="name" value="{{medicalSchool.name}}"/>
            </div>
            <div class="form-group">
                <label class="control-label">Date of Graduation</label>
                <input class="form-control" name="date_of_graduation" placeholder="Click to pick a date" readonly="readonly" value="{{medicalSchool.pivot.dateOfGraduation}}"/>
            </div>
        </form>
        */console.log
        });
        _this.templates.modalUpdateMedicalSchools__tableMedicalSchools__row = multiline(() => {/*!@preserve
        <tr data-id="{{medicalSchool.id}}" data-name="{{medicalSchool.name}}" data-date-of-graduation="{{medicalSchool.pivot.dateOfGraduation|formatTimestamp1}}">
            <td>
                {{medicalSchool.pivot.dateOfGraduation|formatTimestamp1}}
            </td>
            <td>
                {{medicalSchool.name}}
            </td>
            <td class="text-center">
                <a href="#" class="btn btn-xs btn-warning" data-action="updateMedicalSchool">
                    <i class="fa fa-pencil"></i> Edit
                </a>
                <a href="#" class="btn btn-xs btn-danger" data-action="removeMedicalSchool">
                    <i class="fa fa-times"></i> Remove
                </a>
            </td>
        </tr>
        */console.log
        });
        _this.templates.modalUpdateQualifications = multiline(() => {/*!@preserve
        <table class="table table-bordered" id="table_qualifications">
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Issuer</th>
                    <th>Name</th>
                    <th class="text-center">
                        <a href="#" class="btn btn-xs btn-primary" data-action="addQualification">
                            <i class="fa fa-fw fa-plus"></i> Add
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
            {% for qualification in doctor.qualifications %}
                <tr data-id="{{qualification.id}}" data-name="{{qualification.name}}" data-issued-time="{{qualification.issuedTime}}" data-issuer="{{qualification.issuer}}">
                    <td>{{qualification.issuedTime|formatWithoutTimezone("YYYY")}}</td>
                    <td>{{qualification.issuer}}</td>
                    <td>{{qualification.name}}</td>
                    <td class="text-center">
                        <a href="#" class="btn btn-xs btn-warning" data-action="updateQualification">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <a href="#" class="btn btn-xs btn-danger" data-action="removeQualification">
                            <i class="fa fa-times"></i> Remove
                        </a>
                    </td>
                </tr>
            {% endfor %}
            </tbody>
        </table>
        */console.log
        });
        _this.templates.modalCreateQualification = multiline(() => {/*!@preserve
        <form class="form">
            <div class="form-group">
                <label class="control-label">Name:</label>
                <input class="form-control" name="name"/>
            </div>
            <div class="form-group">
                <label class="control-label">Issuer</label>
                <input class="form-control" name="issuer"/>
            </div>
            <div class="form-group">
                <label class="control-label">Year</label>
                <input class="form-control" name="issued_time"/>
            </div>
        </form>
        */console.log
        });
        _this.templates.modalUpdateQualification = multiline(() => {/*!@preserve
        <form class="form">
            <div class="form-group">
                <label class="control-label">Name:</label>
                <input class="form-control" name="name" value="{{qualification.name}}"/>
            </div>
            <div class="form-group">
                <label class="control-label">Issuer</label>
                <input class="form-control" name="issuer" value="{{qualification.issuer}}"/>
            </div>
            <div class="form-group">
                <label class="control-label">Year</label>
                <input class="form-control" name="issued_time" value="{{qualification.issuedTime|formatWithoutTimezone("YYYY")}}"/>
            </div>
        </form>
        */console.log
        });
        _this.templates.modalUpdateQualifications__tableQualifications__row = multiline(() => {/*!@preserve
        <tr data-id="{{qualification.id}}" data-name="{{qualification.name}}" data-issued-time="{{qualification.issuedTime}}" data-issuer="{{qualification.issuer}}">
            <td>{{qualification.issuedTime|formatWithoutTimezone("YYYY")}}</td>
            <td>{{qualification.issuer}}</td>
            <td>{{qualification.name}}</td>
            <td class="text-center">
                <a href="#" class="btn btn-xs btn-warning" data-action="updateQualification">
                    <i class="fa fa-pencil"></i> Edit
                </a>
                <a href="#" class="btn btn-xs btn-danger" data-action="removeQualification">
                    <i class="fa fa-times"></i> Remove
                </a>
            </td>
        </tr>
        */console.log
        });
        _this.templates.modalChangeAuthenticationPhoneNumber = multiline(() => {/*!@preserve
        <form class="form" data-is-submitting="0">
            <div class="form-group">
                <label>New authentication phone number for this doctor</label>
                <div class="row">
                    <div class="col-xs-6">
                        <select class="form-control" name="new_phone_country_code">
                            <option value="">Undetermined</option>
                        {% for phoneCountryCode in phoneCountryCodes %}
                            <option
                                value="{{phoneCountryCode}}"
                            {% if (doctor.account.phoneCountryCode == phoneCountryCode) %}
                                selected="selected"
                            {% endif %}
                            >{{phoneCountryCode}}</option>
                        {% endfor %}
                        </select>
                    </div>
                    <div class="col-xs-6">
                        <input class="form-control" name="new_phone_number" type="text" value="{{doctor.account.phoneNumber}}"/>
                    </div>
                </div>
            </div>
        </form>
        */console.log
        });
        _this.templates.modalChangePassword = multiline(() => {/*!@preserve
        <form class="form" data-is-submitting="0">
            <div class="form-group">
                <label>New password for this doctor</label>
                <input class="form-control" name="new_password" type="text" value=""/>
            </div>
        </form>
        */console.log
        });

        _this.render();
        _this.bindEvents();
    }

    /**
     * @memberOf pageAdminDoctorDetails
     * @function destroy
     */
    _this.destroy = () => { }

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
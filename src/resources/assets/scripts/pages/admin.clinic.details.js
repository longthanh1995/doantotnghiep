'use strict';

const _get = require('lodash/get');

let clinicId = _get(globalData, 'context.pageAdminClinicDetails.clinic.id');
/**
 * @namespace pageAdminClinicDetails
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @memberOf pageAdminClinicDetails
     * @function showModalCreateAppointmentType
     * @param clinicId
     * @param doneCallback
     * @param failCallback
     */
    _this.showModalCreateAppointmentType = ({clinicId, doneCallback, failCallback}) => {
        let $modal = bootbox.dialog({
            title: 'Create Appointment Type',
            message: swig.render(_this.templates.modalAppointmentType, {
                locals: {
                    clinicId
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
            .on('shown.bs.modal', (event) => {
                let $form = $modal.find('form');

                $form.validate({
                    rules: {
                        name: {
                            required: true
                        },
                        clinic_id: {
                            required: true
                        }
                    },
                    errorElement: "p",
                    errorClass: "help-block",
                    errorPlacement: function (error, element) {
                        element.closest('div').append(error);
                    },
                    highlight: function (element) {
                        $(element).closest('.form-group').addClass('has-error');
                    },
                    unhighlight: function (element) {
                        $(element).closest('.form-group').removeClass('has-error');
                    },
                    submitHandler: (form, event) => {
                        event.preventDefault();

                        let isSubmitting = parseInt($form.data('is-submitting'));

                        if (isSubmitting) {
                            return;
                        }

                        let formData = $form.serialize();

                        manaDrApplication.emit('window/loading/show');
                        $form.data('is-submitting', 1);

                        $modal.find(':input').prop('disabled', true);

                        let request = $.ajax({
                            url: laroute.route('admin.appointmentType.store'),
                            method: 'POST',
                            data: formData,
                            dataType: 'json'
                        });

                        request
                            .done((response) => {
                                let appointmentTypeName = response.name,
                                    message = `Appointment type <b>${appointmentTypeName}</b> has been created for you clinic only!`
                                ;

                                bootbox.alert(message, () => {
                                    $modal.modal('hide');
                                    manaDrApplication.emit('window/loading/hide');
                                    if ('function' === typeof doneCallback) {
                                        doneCallback(humps.camelizeKeys(response));
                                    }
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

                                bootbox.alert(message, () => {
                                    $form.data('is-submitting', 0);
                                    $modal.find(':input').prop('disabled', false);
                                    manaDrApplication.emit('window/loading/hide');

                                    if ('function' === typeof failCallback) {
                                        failCallback(e, data);
                                    }
                                });
                            })
                        ;
                    }
                });
            })
        ;
    }

    /**
     * @memberOf pageAdminClinicDetails
     * @function showModalUpdateAppointmentType
     * @param clinicId
     * @param doneCallback
     * @param failCallback
     */
    _this.showModalUpdateAppointmentType = ({clinicId, id, name, doneCallback, failCallback}) => {
        let $modal = bootbox.dialog({
            title: 'Update Appointment Type',
            message: swig.render(_this.templates.modalAppointmentType, {
                locals: {
                    id,
                    name,
                    clinicId,
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
            .on('shown.bs.modal', (event) => {
                let $form = $modal.find('form');

                $form.validate({
                    rules: {
                        name: {
                            required: true
                        }
                    },
                    errorElement: "p",
                    errorClass: "help-block",
                    errorPlacement: function (error, element) {
                        element.closest('div').append(error);
                    },
                    highlight: function (element) {
                        $(element).closest('.form-group').addClass('has-error');
                    },
                    unhighlight: function (element) {
                        $(element).closest('.form-group').removeClass('has-error');
                    },
                    submitHandler: (form, event) => {
                        event.preventDefault();

                        let isSubmitting = parseInt($form.data('is-submitting'));

                        if (isSubmitting) {
                            return;
                        }

                        let formData = $form.serialize();

                        manaDrApplication.emit('window/loading/show');
                        $form.data('is-submitting', 1);

                        $modal.find(':input').prop('disabled', true);

                        let request = $.ajax({
                            url: laroute.route('admin.appointmentType.update', {appointmentType: id}),
                            method: 'PUT',
                            data: formData,
                            dataType: 'json'
                        });

                        request
                            .done((response) => {
                                let appointmentTypeName = response.name,
                                    message = `Appointment type <b>${appointmentTypeName}</b> has been updated!`
                                ;

                                bootbox.alert(message, () => {
                                    $modal.modal('hide');
                                    manaDrApplication.emit('window/loading/hide');
                                    if ('function' === typeof doneCallback) {
                                        doneCallback(humps.camelizeKeys(response));
                                    }
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

                                bootbox.alert(message, () => {
                                    $form.data('is-submitting', 0);
                                    $modal.find(':input').prop('disabled', false);
                                    manaDrApplication.emit('window/loading/hide');

                                    if ('function' === typeof failCallback) {
                                        failCallback(e, data);
                                    }
                                });
                            })
                        ;
                    }
                });
            })
        ;
    }

    _this.showModalDeactivateAppointmentType = ({id, name, doneCallback, failCallback}) => {
        bootbox.confirm(`Are you sure you want to deactivate this appointment type?<br/><i>The existed available timeslots will be booked from Dashboard only.</i>`, (result) => {
            if(result){
                manaDrApplication.emit('window/loading/show');

                let request = $.ajax({
                    url: laroute.route('admin.appointmentType.deactivate', {
                        appointmentType: id
                    }),
                    method: "POST",
                });

                request
                    .done((response) => {
                        let appointmentTypeName = response.name,
                            message = `Appointment type <b>${appointmentTypeName}</b> has been deactivated!`
                        ;

                        bootbox.alert(message, () => {
                            manaDrApplication.emit('window/loading/hide');
                            if ('function' === typeof doneCallback) {
                                doneCallback(humps.camelizeKeys(response));
                            }
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

                        bootbox.alert(message, () => {
                            manaDrApplication.emit('window/loading/hide');

                            if ('function' === typeof failCallback) {
                                failCallback(e, data);
                            }
                        });
                    })
                ;
            }
        });
    }

    _this.showModalActivateAppointmentType = ({id, doneCallback, failCallback}) => {
        bootbox.confirm(`Are you sure you want to activate this appointment type?<br/><i>The existed available timeslots will be booked through apps also.</i>`, (result) => {
            if(result){
                manaDrApplication.emit('window/loading/show');

                let request = $.ajax({
                    url: laroute.route('admin.appointmentType.activate', {
                        appointmentType: id
                    }),
                    method: "POST",
                });

                request
                    .done((response) => {
                        let appointmentTypeName = response.name,
                            message = `Appointment type <b>${appointmentTypeName}</b> has been activated!`
                        ;

                        bootbox.alert(message, () => {
                            manaDrApplication.emit('window/loading/hide');
                            if ('function' === typeof doneCallback) {
                                doneCallback(humps.camelizeKeys(response));
                            }
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

                        bootbox.alert(message, () => {
                            manaDrApplication.emit('window/loading/hide');

                            if ('function' === typeof failCallback) {
                                failCallback(e, data);
                            }
                        });
                    })
                ;
            }
        });
    }

    _this.showModalManageHouseCallReasons = ({data = {}, doneCallback, failCallback}) => {
        sandbox.emit('service/houseCallReason/list', {data, doneCallback, failCallback});
    };

    _this.showModalSetWorkingWeekDays = ({data: { workingWeekDays }, doneCallback, failCallback}) => {
        let $modal = bootbox.dialog({
            title: 'Set working week days',
            message: swig.render(_this.templates.modalEditWorkingWeekDaysContent, {
                locals: {
                    workingWeekDays,
                    weekDays: _this.data.weekDays
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

                $form.validate({
                    rules: {},
                    errorElement: "p",
                    errorClass: "help-block",
                    errorPlacement: function (error, element) {
                        element.closest('div').append(error);
                    },
                    highlight: function (element) {
                        $(element).closest('.form-group').addClass('has-error');
                    },
                    unhighlight: function (element) {
                        $(element).closest('.form-group').removeClass('has-error');
                    },
                    submitHandler: (form, event) => {
                        event.preventDefault();

                        let isSubmitting = parseInt($form.data('is-submitting'));

                        if (isSubmitting) {
                            return;
                        }

                        let formData = $form.serialize();

                        manaDrApplication.emit('window/loading/show');
                        $form.data('is-submitting', 1);

                        $modal.find(':input').prop('disabled', true);

                        sandbox.emit('service/admin/clinic/setWorkingWeekDays', {
                            clinicId,
                            data: formData,
                            doneCallback: response => {
                                let message = `Working week days of this clinic have been updated!`;

                                bootbox.alert(message, () => {
                                    $modal.modal('hide');
                                    manaDrApplication.emit('window/loading/hide');
                                    if ('function' === typeof doneCallback) {
                                        doneCallback(humps.camelizeKeys(response));
                                    }
                                });
                            },
                            failCallback: (e, data) => {
                                let message = '';

                                if (e
                                    && e.responseJSON
                                    && e.responseJSON.message
                                    && e.responseJSON.message.length) {
                                    message = e.responseJSON.message;
                                } else {
                                    message = 'The request cannot be processed';
                                }

                                bootbox.alert(message, () => {
                                    manaDrApplication.emit('window/loading/hide');

                                    if ('function' === typeof failCallback) {
                                        failCallback(e, data);
                                    }
                                });
                            },
                        });
                    }
                });
            })
        ;
    };

    _this.showModalRemoveHoliday = ({holiday: {id, date}, doneCallback, failCallback}) => {
        bootbox.confirm(`Are you sure you want to remove <b>${date}</b> from holidays list?`, result => {
            if(result){
                manaDrApplication.emit('window/loading/show');

                sandbox.emit('service/admin/clinic/holiday/delete', {
                    clinicId,
                    id,
                    doneCallback: response => {
                        let message = `This holiday has been deleted!`;

                        bootbox.alert(message, () => {
                            manaDrApplication.emit('window/loading/hide');
                            if ('function' === typeof doneCallback) {
                                doneCallback(humps.camelizeKeys(response));
                            }
                        });
                    },
                    failCallback: (e, data) => {
                        let message = '';

                        if (e
                            && e.responseJSON
                            && e.responseJSON.message
                            && e.responseJSON.message.length) {
                            message = e.responseJSON.message;
                        } else {
                            message = 'The request cannot be processed';
                        }

                        bootbox.alert(message, () => {
                            manaDrApplication.emit('window/loading/hide');

                            if ('function' === typeof failCallback) {
                                failCallback(e, data);
                            }
                        });
                    },
                })
            }
        });
    };

    _this.enableQueueFeature = ({ id, doneCallback, failCallback }) => {
        sandbox.emit('service/admin/clinic/queue/enable', {
            clinicId,
            doneCallback: (response) => {
                if ('function' === typeof doneCallback) {
                    doneCallback(humps.camelizeKeys(response));
                }
            },
            failCallback: (e, data) => {
                let message = '';

                if (e
                    && e.responseJSON
                    && e.responseJSON.message
                    && e.responseJSON.message.length) {
                    message = e.responseJSON.message;
                } else {
                    message = 'The request cannot be processed';
                }

                bootbox.alert(message, () => {
                    if ('function' === typeof failCallback) {
                        failCallback(e, data);
                    }
                });
            },
        })
    };

    _this.disableQueueFeature = ({ id, doneCallback, failCallback }) => {
        sandbox.emit('service/admin/clinic/queue/disable', {
            clinicId,
            doneCallback: (response) => {
                if ('function' === typeof doneCallback) {
                    doneCallback(humps.camelizeKeys(response));
                }
            },
            failCallback: (e, data) => {
                let message = '';

                if (e
                    && e.responseJSON
                    && e.responseJSON.message
                    && e.responseJSON.message.length) {
                    message = e.responseJSON.message;
                } else {
                    message = 'The request cannot be processed';
                }

                bootbox.alert(message, () => {
                    if ('function' === typeof failCallback) {
                        failCallback(e, data);
                    }
                });
            },
        })
    };

    /**
     * @memberOf pageAdminClinicDetails
     * @function bindEvents
     */
    _this.bindEvents = () => {
        _this.objects.$tabAppointmentTypeSettings
            .on('click', '[data-action=createAppointmentType]', (event) => {
                event.preventDefault();

                _this.showModalCreateAppointmentType({
                    clinicId,
                    doneCallback: (data) => {
                        let html = swig.render(_this.templates.appointmentTypeRowTemplate, {
                            locals: data
                        });

                        _this.objects.$tableClinicAppointmentTypes_tbody.append(html);
                    }
                })
            })
            .on('click', '[data-action=updateAppointmentType]', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    $targetRow = $this.closest('tr[data-id]'),
                    targetId = $targetRow.data('id'),
                    targetName = $targetRow.data('name')
                ;

                _this.showModalUpdateAppointmentType({
                    clinicId,
                    id: targetId,
                    name: targetName,
                    doneCallback: (data) => {
                        let html = swig.render(_this.templates.appointmentTypeRowTemplate, {
                            locals: data
                        });

                        $targetRow.replaceWith(html);
                    }
                })
            })
            .on('click', '[data-action=deactivateAppointmentType]', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    $targetRow = $this.closest('tr[data-id]'),
                    targetId = $targetRow.data('id'),
                    targetName = $targetRow.data('name')
                ;

                _this.showModalDeactivateAppointmentType({
                    id: targetId,
                    name: targetName,
                    doneCallback: (data) => {
                        let html = swig.render(_this.templates.appointmentTypeRowTemplate, {
                            locals: data
                        });

                        $targetRow.replaceWith(html);
                    }
                })
            })
            .on('click', '[data-action=activateAppointmentType]', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    $targetRow = $this.closest('tr[data-id]'),
                    targetId = $targetRow.data('id'),
                    targetName = $targetRow.data('name')
                ;

                _this.showModalActivateAppointmentType({
                    id: targetId,
                    name: targetName,
                    doneCallback: (data) => {
                        let html = swig.render(_this.templates.appointmentTypeRowTemplate, {
                            locals: data
                        });

                        $targetRow.replaceWith(html);
                    }
                })
            })
            .on('click', '[data-action=manageHouseCallReasons]', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    $targetRow = $this.closest('tr[data-id]'),
                    targetId = $targetRow.data('id'),
                    targetName = $targetRow.data('name')
                ;

                sandbox.emit('modal/manageHouseCallReasons/show', {
                    appointmentTypeId: targetId,
                    appointmentTypeName: targetName,
                    clinicId,
                    doneCallback: () => {},
                    failCallback: () => {},
                })
            })
        ;

        _this.objects.$tabWorkingDaysSettings
            .on('click', '[data-action=editWorkingWeekDays]', event => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    workingWeekDays = $this.data('working-week-days')
                ;

                _this.showModalSetWorkingWeekDays({
                    clinicId,
                    data: {
                        workingWeekDays,
                    },
                    doneCallback: response => {
                        let {workingWeekDays} = response,
                            html = swig.render(_this.templates.listWorkingWeekDays, {
                                locals: {
                                    workingWeekDays,
                                    weekDays: _this.data.weekDays,
                                },
                            })
                        ;

                        console.log('workingWeekDays', workingWeekDays);
                        console.log('_this.data.weekDays', _this.data.weekDays);
                        console.log('html', html);

                        $this.data('working-week-days', workingWeekDays);
                        _this.objects.$tabWorkingDaysSettings_listWorkingWeekDays.replaceWith(html);
                    },
                    failCallback: (e, data) => {

                    },
                });
            })
            .on('click', '[data-action=removeHoliday]', event => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    $targetHoliday = $this.closest('li[data-id]'),
                    targetId = $targetHoliday.data('id'),
                    targetDate = $targetHoliday.data('date')
                ;

                _this.showModalRemoveHoliday({
                    holiday: {
                        id: targetId,
                        date: targetDate,
                    },
                    doneCallback: response => {
                        $targetHoliday.remove();
                    },
                    failCallback: (e, data) => {},
                })
            })
        ;

        _this.objects.$tabWorkingDaysSettings_formAddHoliday
            .validate({
                rules: {
                    date: {
                        required: true,
                        // dateFormatDMY: true
                    },
                },
                errorElement: "p",
                errorClass: "help-block",
                errorPlacement: function (error, element) {
                    element.closest('.form-group').append(error);
                },
                highlight: function (element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                submitHandler: (form, event) => {
                    event.preventDefault();

                    let $form = _this.objects.$tabWorkingDaysSettings_formAddHoliday,
                        isSubmitting = parseInt($form.data('is-submitting'));

                    if (isSubmitting) {
                        return;
                    }

                    manaDrApplication.emit('window/loading/show');
                    $form.data('is-submitting', 1);

                    $form.find(':input').prop('disabled', true);

                    sandbox.emit('service/admin/clinic/holiday/create', {
                        clinicId,
                        data: {
                            clinicId,
                            date: moment(_this.objects.$tabWorkingDaysSettings_formAddHoliday_inputDate.val(), 'DD/MM/YYYY').format('YYYY-MM-DD'),
                        },
                        doneCallback: response => {
                            let {date} = response,
                                message = swig.render(_this.templates.messageHolidateCreatedSuccessfully, {
                                    locals: {
                                        date,
                                    }
                                }),
                                html = swig.render(_this.templates.holidaysListItem, {
                                    locals: response,
                                })
                            ;

                            _this.objects.$tabWorkingDaysSettings_listHolidays.append(html);

                            bootbox.alert(message, () => {
                                $form.data('is-submitting', 0);
                                $form.find(':input').prop('disabled', false);
                                manaDrApplication.emit('window/loading/hide');
                            });
                        },
                        failCallback: (e, data) => {
                            let message = '';

                            if (e
                                && e.responseJSON
                                && e.responseJSON.message
                                && e.responseJSON.message.length) {
                                message = e.responseJSON.message;
                            } else {
                                message = 'The request cannot be processed';
                            }

                            bootbox.alert(message, () => {
                                $form.data('is-submitting', 0);
                                $form.find(':input').prop('disabled', false);
                                manaDrApplication.emit('window/loading/hide');

                                if ('function' === typeof failCallback) {
                                    failCallback(e, data);
                                }
                            });
                        }
                    });
                }
            })
        ;

        _this.objects.$checkboxToggleQueueFeature
            .on('click', event => {
                let $target = $(event.currentTarget),
                    value = $(event.currentTarget).prop('checked');
                ;

                $target.prop('disabled', true);

                if(value) {
                    _this.enableQueueFeature({
                        clinicId,
                        doneCallback: response => {
                            let message = 'Queue feature has been enabled!';

                            bootbox.alert(message, () => {
                                $target.prop('disabled', false);
                            });
                        },
                        failCallback: () => {
                            $target.prop('disabled', false);
                        }
                    });
                } else {
                    _this.disableQueueFeature({
                        clinicId,
                        doneCallback: response => {
                            let message = 'Queue feature has been disabled!';

                            bootbox.alert(message, () => {
                                $target.prop('disabled', false);
                            });
                        },
                        failCallback: () => {
                            $target.prop('disabled', false);
                        }
                    });
                }
            })
        ;
    };

    _this.render = () => {
        _this.objects.$tabWorkingDaysSettings_formAddHoliday_inputDate
            .datepicker({
                format: 'dd/mm/yyyy',
                weekStart: 1,
                maxViewMode: "years",
                orientation: "bottom",
                disableTouchKeyboard: true,
                autoclose: true,
                clearBtn: true,
                todayHighlight: true,
                showWeekDays: true,
            })
        ;
    }

    /**
     * @memberOf pageAdminClinicDetails
     * @function init
     * @param data
     */
    _this.init = ({data}) => {
        _this.data = data || {};
        _this.data.weekDays = [
            {
                id: 1,
                label: "Sunday",
            },{
                id: 2,
                label: "Monday",
            },{
                id: 3,
                label: "Tuesday",
            },{
                id: 4,
                label: "Wednesday",
            },{
                id: 5,
                label: "Thursday",
            },{
                id: 6,
                label: "Friday",
            },{
                id: 7,
                label: "Saturday",
            },
        ];

        _this.objects = {};
        _this.objects.$tabAppointmentTypeSettings =  $('#tab_appointment_types_settings');
        _this.objects.$tabWorkingDaysSettings = $('#tab_working_days_settings');
        _this.objects.$tabWorkingDaysSettings_formAddHoliday = _this.objects.$tabWorkingDaysSettings.find('#form_add_holiday');
        _this.objects.$tabWorkingDaysSettings_listHolidays = _this.objects.$tabWorkingDaysSettings.find('#list_holidays');
        _this.objects.$tabWorkingDaysSettings_formAddHoliday_inputDate = _this.objects.$tabWorkingDaysSettings_formAddHoliday.find('input[name=date]');
        _this.objects.$tabWorkingDaysSettings_listWorkingWeekDays = _this.objects.$tabWorkingDaysSettings.find('#list_working_week_days');
        _this.objects.$tabOtherSettings = $('#tab_other_settings');
        _this.objects.$tableClinicAppointmentTypes = $('#table_clinic_appointment_types');
        _this.objects.$tableClinicAppointmentTypes_tbody = _this.objects.$tableClinicAppointmentTypes.children('tbody');
        _this.objects.$checkboxToggleQueueFeature = _this.objects.$tabOtherSettings.find('[data-action="toggleQueueFeature"]');

        _this.templates = {
            modalAppointmentType: multiline(()=>{/*!@preserve
            <form class="form">
                <input type="hidden" name="clinic_id" value="{{clinicId}}"/>
                <div class="form-group">
                    <label class="control-label">Name</label>
                    <input class="form-control" name="name" value="{{name}}" />
                </div>
            </form>
            */console.log}),
            appointmentTypeRowTemplate: multiline(()=>{/*!@preserve
            <tr data-id="{{id}}" data-name="{{name}}" class="{% if !isActive %}text-muted{% endif %}">
                <td>{{name}}</td>
                <td class="text-right">
                    <a href="#" class="btn-box-tool" data-action="updateAppointmentType" data-toggle="tooltip" data-title="Edit">
                        <i class="fa fa-edit"></i>
                    </a>
                {% if isActive %}
                    <a href="#" class="btn-box-tool" data-action="deactivateAppointmentType" data-toggle="tooltip" data-title="Deactivate">
                        <i class="fa fa-times"></i>
                    </a>
                {% else %}
                    <a href="#" class="btn-box-tool" data-action="activateAppointmentType" data-toggle="tooltip" data-title="Activate">
                        <i class="fa fa-check"></i>
                    </a>
                {% endif %}
                </td>
            </tr>
            */console.log}),
            modalManageHouseCallReasons: multiline(function(){/*!@preserve
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Reason</th>
                            <th></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    {% for reason in reasons %}
                        <tr>
                            <td>{{reason.name}}</td>
                            <td class="text-right">
                                <a class="btn btn-xs btn-default" data-id="{{ reason.id }}" data-action="manageDoctors">
                                    <i class="fa fa-user-md" />
                                {% if reason.doctors.length == 1 %}
                                    1 doctor
                                {% elseif (reason.doctors.length > 1) %}
                                    {{ reason.doctors.length }} doctors
                                {% else %}
                                    Manage doctors
                                {% endif %}
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-xs btn-warning">
                                    <i class="fa fa-pencil" /> Edit
                                </a>
                                <a class="btn btn-xs btn-danger">
                                    <i class="fa fa-trash" /> Delete
                                </a>
                            </td>
                        </tr>
                    {% endfor %}
                    </tbody>
                </table>
            */console.log}),
            holidaysListItem: multiline(function(){/*!@preserve
            <li data-id="{{id}}" data-date="{{date|formatTimestamp3}}">
                <h4>
                    <span class="label label-default">
                        {{date|formatTimestamp3}}
                        <a href="#" data-action="removeHoliday">
                            <i class="fa fa-times text-muted"></i>
                        </a>
                    </span>
                </h4>
            </li>
            */console.log}),
            messageHolidateCreatedSuccessfully: multiline(function(){/*!@preserve
            Holiday <b>{{date|formatTimestamp3}}</b> has been created for you clinic
            */console.log}),
            modalEditWorkingWeekDaysContent: multiline(function(){/*!@preserve
            <form class="form" id="form_set_working_week_days">
                <div class="form-group">
                {% for weekDay in weekDays %}
                    <label class="checkbox-inline">
                      <input type="checkbox" name="working_week_days[]" value="{{weekDay.id}}"
                        {% if weekDay.id|checkIfIndexOf(workingWeekDays) == 1 %}
                            checked
                        {% endif %}
                      > {{weekDay.label}}
                    </label>
                {% endfor %}
                </div>
            </form>
            */console.log}),
            listWorkingWeekDays: multiline(function(){/*!@preserve
            <ul class="list-inline" id="list_working_week_days">
            {% for weekDay in weekDays %}
                <li>
                    <i style="vertical-align:middle;" class="fa
                    {% if weekDay.id|checkIfIndexOf(workingWeekDays) == 1 %}
                        fa-check-square-o
                    {% else %}
                        fa-square-o
                    {% endif %}
                    "/>
                    {{ weekDay.label }}
                </li>
            {% endfor %}
            </ul>
            */console.log}),
        };

        _this.render();
        _this.bindEvents();

        if($('#form_booking_fee_settings').length){
            sandbox.sub.register('formBookingFeeSettings', require('./../modules/form-booking-fee-settings'));
        }
        sandbox.sub.start();
    }

    /**
     * @memberOf pageAdminClinicDetails
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
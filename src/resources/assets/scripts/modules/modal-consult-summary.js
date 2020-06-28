'use strict';

const _get = require('lodash/get');

const dashboardType = _get(globalData, 'context.dashboardType', 'doctor');

/**
 * @namespace moduleModalHealthSummary
 * @param sandbox
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @memberOf modalHealthSummary
     * @function showModalAddHealthSummary
     */
    _this.showModalAddHealthSummary = ({appointmentId, doneCallback, failCallback}) => {
        let targetAppointmentId = appointmentId,
            $modal = bootbox.dialog({
                title: 'Add Consult Summary',
                message: swig.render(_this.templates.modal, {
                    locals: {
                        appointmentId: targetAppointmentId
                    }
                }),
                buttons: {
                    'reset': {
                        label: 'Reset',
                        className: 'btn',
                        callback: (event) => {
                            var $form = $(event.delegateTarget).find('form');
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
                            var $form = $(event.delegateTarget).find('form');
                            $form.submit();
                            return false;
                        }
                    },
                    'skip': {
                        label: 'Skip for now',
                        className: 'btn btn-warning',
                        callback: event => {
                            let message = 'You\'ve marked this appointment as visited without a health summary. Please note that you can always add this later in appointment details page.';

                            bootbox.alert(message, () => {
                                if('function' === typeof doneCallback){
                                    doneCallback();
                                }
                            });
                        }
                    }
                }
            })
            ;

        $modal
            .on('shown.bs.modal', (event) => {
                let $form = $modal.find('form');

                $form.validate({
                    rules: {
                        summary: {
                            require_from_group: [1, 'textarea']
                        },
                        plan: {
                            require_from_group: [1, 'textarea']
                        },
                        visit_doctor_if: {
                            require_from_group: [1, 'textarea']
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

                        let formData = $form.serialize();

                        manaDrApplication.emit('window/loading/show');
                        $form.data('is-submitting', 1);

                        $modal.find(':input').prop('disabled', true);

                        let requestRoute;
                        switch(dashboardType){
                            case 'admin':
                                requestRoute = 'admin.appointment.createHealthSummary';
                                break;
                            case 'doctor':
                            default:
                                requestRoute = 'appointment.createHealthSummary';
                                break;
                        }

                        let request = $.ajax({
                            url: laroute.route(requestRoute, {appointment: targetAppointmentId}),
                            method: 'POST',
                            data: formData,
                            dataType: 'json'
                        });

                        request
                            .done((response) => {
                                let message = 'Health summary has been added';

                                bootbox.alert(message, () => {
                                    $modal.modal('hide');
                                    manaDrApplication.emit('window/loading/hide');
                                    // window.location.reload();
                                    if('function' === typeof doneCallback){
                                        doneCallback();
                                    }
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

                                    if('function' === typeof failCallback){
                                        failCallback();
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
     * @memberOf modalHealthSummary
     * @function showModalUpdateHealthSummary
     */
    _this.showModalUpdateHealthSummary = ({appointmentId, content, doneCallback, failCallback}) => {
        let targetAppointmentId = appointmentId,
            $modal = bootbox.dialog({
                title: 'Update Consult Summary',
                message: swig.render(_this.templates.modal, {
                    locals: {
                        appointmentId: targetAppointmentId,
                        title: content.title,
                        summary: content.summary,
                        plan: content.plan,
                        visitDoctorIf: content.visitDoctorIf
                    }
                }),
                buttons: {
                    'reset': {
                        label: 'Reset',
                        className: 'btn',
                        callback: (event) => {
                            var $form = $(event.delegateTarget).find('form');
                            $form.validate().resetForm();
                            $form[0].reset();
                            $form[0].reset();
                            return false;
                        }
                    },
                    'submit': {
                        label: 'Update',
                        className: 'btn btn-primary',
                        callback: (event) => {
                            var $form = $(event.delegateTarget).find('form');
                            $form.submit();
                            return false;
                        }
                    }
                }
            })
            ;

        $modal
            .on('shown.bs.modal', (event) => {
                let $form = $modal.find('form');

                $form.validate({
                    rules: {
                        summary: {
                            require_from_group: [1, 'textarea']
                        },
                        plan: {
                            require_from_group: [1, 'textarea']
                        },
                        visit_doctor_if: {
                            require_from_group: [1, 'textarea']
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

                        let formData = $form.serialize();

                        manaDrApplication.emit('window/loading/show');
                        $form.data('is-submitting', 1);

                        $modal.find(':input').prop('disabled', true);

                        let request = $.ajax({
                            url: laroute.route('appointment.updateHealthSummary', {appointment: targetAppointmentId}),
                            method: 'POST',
                            data: formData,
                            dataType: 'json'
                        });

                        request
                            .done((response) => {
                                let message = 'Health summary has been updated';

                                bootbox.alert(message, () => {
                                    $modal.modal('hide');
                                    manaDrApplication.emit('window/loading/hide');
                                    // window.location.reload();
                                    if('function' === typeof doneCallback){
                                        doneCallback();
                                    }
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

                                    if('function' === typeof failCallback){
                                        failCallback();
                                    }
                                });
                            })
                        ;
                    }
                });
            })
        ;
    }

    sandbox
        .on('modalHealthSummary/showAdd', ({appointmentId, doneCallback, failCallback}) => {
            _this.showModalAddHealthSummary({appointmentId, doneCallback, failCallback});
        })
    ;

    sandbox
        .on('modalHealthSummary/showUpdate', ({appointmentId, content, doneCallback, failCallback}) => {
            _this.showModalUpdateHealthSummary({appointmentId, content, doneCallback, failCallback});
        })
    ;

    /**
     * @namespace moduleModalHealthSummary
     * @function init
     * @param data
     */
    _this.init = (data) => {
        _this.data = data || {};

        _this.templates = {};
        _this.templates.modal = multiline(() => {/*!@preserve
        <form class="form">
            <input type="hidden" name="appointment_id" value="{{appointmentId}}"/>
            <div class="form-group">
                <label for="form__input_title" class="control-label">Title:</label>
                <input class="form-control" name="title" value="{{title}}"/>
            </div>
            <div class="form-group">
                <label for="form__textarea_summary" class="control-label">Summary:</label>
                <textarea class="form-control" name="summary">{{summary}}</textarea>
            </div>
            <div class="form-group">
                <label for="form__textarea_plan" class="control-label">Plan:</label>
                <textarea class="form-control" name="plan">{{plan}}</textarea>
            </div>
            <div class="form-group">
                <label for="form__textarea_visit_doctor_if" class="control-label">Visit doctor if:</label>
                <textarea class="form-control" name="visit_doctor_if">{{visitDoctorIf}}</textarea>
            </div>
        </form>
        */console.log});
    }

    /**
     * @namespace moduleModalHealthSummary
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
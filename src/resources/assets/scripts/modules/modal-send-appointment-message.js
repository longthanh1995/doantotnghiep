'use strict';

const _get = require('lodash/get');

const dashboardType = _get(globalData, 'context.dashboardType', 'doctor');

module.exports = function (sandbox) {
    let _this = this;

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

    _this.showModal = ({appointment, doneCallback, failCallback}) => {
        let appointmentId = appointment.id,
            bookerFirstName = _get(appointment, 'booker.firstName',''),
            bookerLastName = _get(appointment, 'booker.lastName',''),
            patientName = (!bookerFirstName.length && !bookerLastName.length)?'booker':`${bookerFirstName} ${bookerLastName}`,
            $modal = bootbox.dialog({
                title: 'Send appointment message',
                message: swig.render(_this.templates.modal, {
                    locals: appointment
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
                        message: {
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

                        let requestRoute;
                        switch(dashboardType){
                            case 'admin':
                                requestRoute = 'admin.appointment.sendMessage';
                                break;
                            case 'doctor':
                            default:
                                requestRoute = 'appointment.sendMessage';
                                break;
                        }

                        let request = $.ajax({
                            url: laroute.route(requestRoute, {appointment: appointmentId}),
                            method: 'POST',
                            data: formData,
                            dataType: 'json'
                        });

                        request
                            .done((response) => {
                                let message = `The message has been sent to ${patientName}'s device.`;

                                bootbox.alert(message, () => {
                                    $modal.modal('hide');
                                    manaDrApplication.emit('window/loading/hide');
                                    if ('function' === typeof doneCallback) {
                                        doneCallback();
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
                                })
                            })
                        ;
                    }
            })
    }
    )
}

sandbox
    .on('modalSendAppointmentMessage/show', ({appointmentId, doneCallback, failCallback}) => {
        //get appointment details
        _this.fetchAppointment({
            appointmentId,
            doneCallback: (data) => {
                let appointment = humps.camelizeKeys(data);
                _this.showModal({appointment, doneCallback, failCallback});
            },
            failCallback: (e, data) => {
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            }
        });
    })

_this.init = (data) => {
    _this.data = data || {};

    _this.templates = {};
    _this.templates.modal = multiline(() => {/*!@preserve
    <form class="form" data-is-submitting="0">
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" name="message" maxlength="250"></textarea>
        </div>
    </form>
    */console.log
    });
}
}
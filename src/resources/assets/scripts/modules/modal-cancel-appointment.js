const _get = require('lodash/get');

const dashboardType = _get(globalData, 'context.dashboardType', 'doctor');

/**
 * @module modalCancelAppointment
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     *
     * @param appointmentId
     * @param doneCallback
     * @param failCallback
     */
    _this.render = ({appointmentId, doneCallback, failCallback}) => {
        let $modal = bootbox.dialog({
            title: `Cancel appointment`,
            message: swig.render(_this.templates.modalContent, {
                locals: {
                    appointmentId,
                }
            }),
            className: 'modal-cancel-appointment',
            buttons: {
                'submit': {
                    label: 'Yes, I\'m sure',
                    className: 'btn btn-danger',
                    callback: (event) => {
                        let $form = $(event.delegateTarget).find('form');
                        $form.submit();
                        return false;
                    }
                },
                'cancel': {
                    label: 'No, I\'m not sure',
                    className: 'btn btn-default',
                },
            }
        });

        $modal
            .on('shown.bs.modal', event => {
                let $form = $modal.find('form');

                $form.on('submit', event => {
                    event.preventDefault();

                    let isSubmitting = parseInt($form.data('is-loading'));
                    if(isSubmitting){
                        return;
                    }
                    let formData = $form.serialize();
                    sandbox.emit('window/loading/show');
                    $form.data('is-submitting', 1);
                    $modal.find(':input').prop('disabled', true);

                    let requestChannel = (dashboardType === 'admin') ? 'service/admin/appointments/cancel' : 'service/doctor/appointments/cancel';
                    sandbox.emit(requestChannel, {
                        appointmentId,
                        data: formData,
                        doneCallback: response => {
                            let message = '';
                            if(response && response.id){
                                message = 'This appointment has been cancelled!';
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
                        },
                        failCallback: (e, data) => {
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
                        }
                    });
                })
            })
        ;
    };

    _this.init = data => {
        _this.templates = {};
        _this.templates.modalContent = multiline(()=>{{/*!@preserve
        <form class="form" id="form_cancel_appointment">
            <div class="form-group">
                <p class="form-control-static">Are you sure to cancel this appointment? This action cannot be undone.</p>
            </div>
            <div class="form-group">
                <label for="form_cancel_appointment__textarea_cancel_reason" class="control-label">Cancel reason</label>
                <textarea class="form-control" id="form_cancel_appointment__textarea_cancel_reason" name="cancel_reason"></textarea>
            </div>
        </form>
        */console.log}});
    };

    _this.destroy = () => {};

    sandbox.on('modalCancelAppointment/show', ({appointmentId, doneCallback, failCallback}) => {
        _this.render({appointmentId, doneCallback, failCallback});
    });

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
};
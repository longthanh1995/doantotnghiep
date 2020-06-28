'use strict';

/**
 * @namespace moduleModalUpdateBookingReason
 * @param sandbox
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @namespace moduleModalUpdateBookingReason
     * @param appointmentId
     * @param doneCallback
     * @param failCallback
     */
    _this.showModal = ({appointmentId, content, doneCallback, failCallback}) => {
        let $modal = bootbox.dialog({
                title: 'Update Booking Reason',
                message: swig.render(_this.templates.modal, {
                    locals: {
                        appointmentId,
                        content
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
            })
        ;

        $modal
            .on('shown.bs.modal', (event) => {
                let $form = $modal.find('form');

                $form.validate({
                    rules: {},
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
                            url: laroute.route('appointment.updateBookingReason', {appointment: appointmentId}),
                            method: 'POST',
                            data: formData,
                            dataType: 'json'
                        });

                        request
                            .done((response) => {
                                let message = 'Booking reason has been updated';

                                bootbox.alert(message, () => {
                                    $modal.modal('hide');
                                    manaDrApplication.emit('window/loading/hide');
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

                                bootbox.alert(message, ()=> {
                                    $form.data('is-submitting', 0);
                                    $modal.find(':input').prop('disabled', false);
                                    manaDrApplication.emit('window/loading/hide');

                                    if('function' === typeof failCallback){
                                        failCallback();
                                    }
                                })
                            });
                        ;
                    }
                })
            })
        ;
    }

    _this.init = (data) => {
        _this.data = data || {};

        _this.templates = {};
        _this.templates.modal = multiline(() => {/*!@preserve
         <form class="form">
            <input type="hidden" name="appointment_id" value="{{appointmentId}}"/>
            <div class="form-group">
                <label for="form__input_title" class="control-label">Booking Reason:</label>
                <textarea class="form-control" name="booking_reason">{{content.bookingReason}}</textarea>
            </div>
         </form>
        */console.log});
    }

    sandbox
        .on('modalUpdateBookingReason/show', ({appointmentId, content, doneCallback, failCallback}) => {
            _this.showModal({appointmentId, content, doneCallback, failCallback});
        })

    /**
     * @namespace moduleModalUpdateBookingReason
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
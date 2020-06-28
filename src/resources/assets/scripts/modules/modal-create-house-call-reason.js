module.exports = function(sandbox){
    let _this = this;

    _this.showModal = ({ appointmentTypeId, appointmentTypeName, clinicId, doneCallback, failCallback }) => {
        let $modal = bootbox.dialog({
                title: `Add reason for <b>${appointmentTypeName}</b>`,
                message: swig.render(_this.templates.modalContent, {
                    locals: {
                        clinicId,
                        appointmentTypeId,
                        appointmentTypeName,
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
                },
            })
        ;

        $modal
            .on('shown.bs.modal', event => {
                let $form = $modal.find('form');

                $form.validate({
                    ignore: ":hidden:not(select)",
                    rules: {
                        reason: {
                            required: true,
                            minlength: 1,
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

                        sandbox.emit('window/loading/show');
                        $form.data('is-submitting', 1);
                        $modal.find(':input').prop('disabled', true);

                        sandbox.emit('service/houseCallReason/create', {
                            data: formData,
                            doneCallback: response => {
                                let houseCallReason = response;

                                let message = `House call reason <b>${houseCallReason.reason}</b> has been created successfully!`;

                                bootbox.alert(message, () => {
                                    if ('function' === typeof doneCallback) {
                                        doneCallback(response);
                                    }
                                    $modal.modal('hide');
                                    sandbox.emit('window/loading/hide');
                                })
                            },
                            failCallback: (e, data) => {
                                if ('function' === typeof failCallback) {
                                    failCallback(e, data);
                                }

                                $form.data('is-submitting', 0);
                                $modal.find(':input').prop('disabled', false);
                                sandbox.emit('window/loading/hide');
                            }
                        });
                    }
                });

                $form
                    .on('reset', event => {
                        setTimeout(() => {
                            $form.find('select.chosen').trigger('chosen:updated');
                        }, 0);
                    })
                ;
            })
        ;
    }

    sandbox.on('modal/createHouseCallReason/show', ({appointmentTypeId, appointmentTypeName, clinicId, doneCallback, failCallback}) => {
        _this.showModal({appointmentTypeId, appointmentTypeName, clinicId, doneCallback, failCallback});
    });

    /**
     * @module modalCreateHouseCallReason
     * @function init
     */
    _this.init = (data) => {
        _this.data = data || {};

        _this.templates = {};
        _this.templates.modalContent = multiline(() => {/*!@preserve
        <form class="form" id="form_create_house_call_reasons">
            <input type="hidden" name="clinic_id" value="{{clinicId}}" />
            <input type="hidden" name="appointment_type_id" value="{{appointmentTypeId}}" />
            <div class="form-group">
                <label class="control-label" for="form_create_house_call_reasons__input_reason">Reason</label>
                <input type="text" class="form-control" id="form_create_house_call_reasons__input_reason" name="reason" />
            </div>
        </form>
        */console.log});
    }

    /**
     * @module modalCreateHouseCallReason
     * @function destroy
     */
    _this.destroy = () => {};

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
};
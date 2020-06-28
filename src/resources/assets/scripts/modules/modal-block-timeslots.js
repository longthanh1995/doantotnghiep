'use strict';

const _get = require('lodash/get');

const dashboardType = _get(globalData, 'context.dashboardType', 'doctor');

/**
 * @module modalBlockTimeslots
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    _this.showModal = ({ids, doctorId, doneCallback, failCallback}) => {
        let $modal = bootbox.dialog({
            title: 'Block timeslot',
            message: swig.render(_this.templates.modal,{
                locals: {}
            }),
            buttons: {
                'submit': {
                    label: 'Submit',
                    className: 'btn btn-warning',
                    callback: (event) => {
                        let $form = $(event.delegateTarget).find('form');
                        $form.submit();
                        return false;
                    }
                },
                'cancel': {
                    label: 'Cancel',
                    className: 'btn',
                },
            }
        });

        $modal
            .on('shown.bs.modal', (event) => {
                let $form = $modal.find('form');

                $form.validate({
                    rules: {
                        block_reason: {
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

                        sandbox.emit('service/timeslot/block', {
                            ids: ids,
                            doctorId,
                            data:formData,
                            doneCallback: () => {
                                let message = `Selected ${ids.length>1?'timeslots':'timeslot'} has been blocked!`;

                                bootbox.alert(message, () => {
                                    $modal.modal('hide');
                                    manaDrApplication.emit('window/loading/hide');
                                    if ('function' === typeof doneCallback) {
                                        doneCallback();
                                    }
                                });
                            },
                            failCallback: (errorMessages) => {
                                let message = 'The request cannot be processed';

                                bootbox.alert(message, () => {
                                    $form.data('is-submitting', 0);
                                    $modal.find(':input').prop('disabled', false);
                                    manaDrApplication.emit('window/loading/hide');

                                    if ('function' === typeof failCallback) {
                                        failCallback(errorMessages);
                                    }
                                });
                            }
                        })
                    }
                })
            })
        ;
    }

    sandbox.on('modalBlockTimeslots/show', ({ids, doctorId, doneCallback, failCallback}) => {
        _this.showModal({ids, doctorId, doneCallback, failCallback});
    });

    /**
     * @module modalBlockTimeslots
     * @function init
     * @param data
     */
    _this.init = (data) => {
        _this.data = data || {};

        _this.templates = {};
        _this.templates.modal = multiline(()=>{/*!@preserve
        <form class="form" data-is-submitting="0">
            <div class="form-group">
                <p class="form-control-static">Are you sure you want to block this timeslot?</p>
            </div>
            <div class="form-group">
                <label for="message">Reason:</label>
                <textarea class="form-control" name="block_reason"></textarea>
            </div>
        </form>
        */console.log});
    }

    /**
     * @module modalBlockTimeslots
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
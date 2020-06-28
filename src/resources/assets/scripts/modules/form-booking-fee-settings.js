const _get = require('lodash/get');

let clinicId = _get(globalData, 'context.pageAdminClinicDetails.clinic.id');

/**
 * /**
 * @namespace moduleTableBookingFeeSettings
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function (sandbox) {
    let _this = this;

    _this.render = () => {
        _this.objects.$self.find('.select2')
            .select2({
                minimumResultsForSearch: Infinity
            })
        ;
    }

    _this.bindEvents = () => {
        _this.objects.$self
            .validate({
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

                    let isSubmitting = parseInt(_this.objects.$self.data('is-submitting'));

                    if (isSubmitting) {
                        return;
                    }

                    let formData = _this.objects.$self.serialize();

                    manaDrApplication.emit('window/loading/show');

                    _this.objects.$self
                        .data('is-submitting', 1)
                    ;

                    let request = $.ajax({
                        url: laroute.route('admin.clinic.updateBookingFeeSettings', {clinic: clinicId}),
                        method: 'POST',
                        data: formData,
                        dataType: 'json'
                    });

                    request
                        .done((response) => {
                            let message = `Doctors' booking fee settings have been saved!`;

                            bootbox.alert(message, () => {
                                _this.objects.$self
                                    .data('is-submitting', 0)
                                ;

                                window.location.reload();
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
                                _this.objects.$self
                                    .data('is-submitting', 0)
                                ;

                                window.location.reload();
                            });
                        })
                    ;
                }
            })
        ;

        //add more validation rules to child inputs
        _this.objects.$self.find('input[name$="[amount]"]').each((event) => {
            $(event.currentTarget).rules('add', {number: true});
        })

        _this.objects.$self
            .on('change', ':checkbox', (event) => {
                event.preventDefault();

                let $checkbox = $(event.currentTarget),
                    $cell = $checkbox.closest('.cell'),
                    $otherInputs = $cell.find(':input:not(:checkbox)')
                ;

                let isCheckboxEnabled = $checkbox.prop('checked');

                $otherInputs.prop('disabled', !isCheckboxEnabled);
            })
            .on('click', '[data-action=manageSurchargeSettings]', event => {
                event.preventDefault();

                let $currentTarget = $(event.currentTarget),
                    $cell = $currentTarget.closest('.cell'),
                    doctorBookingFeeId = $cell.data('id')
                ;

                if(!doctorBookingFeeId){
                    return bootbox.alert(`You need to set the appointment fee & click <b>Submit</b> first.`);
                }

                sandbox.emit('modal/manageSurchageSettings/show', {
                    doctorBookingFeeId,
                    doneCallback: response => {
                        sandbox.emit('service/doctorBookingFee/surchargeSetting/list',{
                            doctorBookingFeeId,
                            doneCallback: doctorBookingFee => {
                                sandbox.emit('window/loading/hide');
                                let { surchargeSettings } = doctorBookingFee,
                                    html = swig.render(_this.templates.labelManageSurchargeSettings, {
                                        locals: {
                                            surchargeSettings,
                                        }
                                    })
                                ;

                                $currentTarget.replaceWith(html);
                            },
                            failCallback: (e, data) => {
                                sandbox.emit('window/loading/hide');
                            },
                        });
                    }
                });
            })
        ;
    }

    /**
     * @memberOf moduleTableBookingFeeSettings
     * @function init
     * @param data
     */
    _this.init = (data) => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$self = $('#form_booking_fee_settings');
        _this.objects.$cells = _this.objects.$self.find('.cell');

        _this.templates = {};
        _this.templates.labelManageSurchargeSettings = multiline(function(){/*!@preserve
        <a href="#" data-action="manageSurchargeSettings">
            <i class="fa fa-flash"></i> Surcharge settings
        {% if surchargeSettings.length %}
            ({{surchargeSettings.length}})
        {% endif %}
        </a>
        */console.log});

        _this.render();
        _this.bindEvents();
    }

    /**
     * @memberOf moduleTableBookingFeeSettings
     * @function destroy
     */
    _this.destroy = () => {
    }

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
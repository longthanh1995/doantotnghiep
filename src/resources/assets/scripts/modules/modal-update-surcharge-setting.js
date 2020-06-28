const _range = require('lodash/range');
const _forEach = require('lodash/forEach');
const _padStart = require('lodash/padStart');
const _toNumber = require('lodash/toNumber');

module.exports = function(sandbox){
    let _this = this;

    _this.generateTimeOptions = (startHour = 0, endHour = 24, stepInMinutes = 5) => {
        let timeOptions = [];

        _forEach(
            _range(startHour, endHour),
            hour => {
                hour = _padStart(String(hour), 2, '0');
                _forEach(
                    _range(0, 60, stepInMinutes),
                    minute => {
                        minute = _padStart(String(minute), 2, '0');
                        timeOptions.push({
                            value: `${hour}:${minute}:00`,
                            title: `${hour}:${minute}`,
                        });
                    }
                )
            }
        );

        return timeOptions;
    };

    _this.showModal = ({ surchargeSetting, doneCallback, failCallback }) => {
        let $modal = bootbox.dialog({
                title: `Update surcharge setting <b>${surchargeSetting.name}</b>`,
                message: swig.render(_this.templates.modalContent, {
                    locals: {
                        surchargeSetting,
                        weekDays: _this.data.weekDays,
                        timeOptions: _this.generateTimeOptions(),
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
                }
            })
        ;

        $modal
            .on('shown.bs.modal', event => {
                let $form = $modal.find('form'),
                    $totalAmount = $modal.find(_this.DOMSelectors.totalAmount)
                ;

                $form.find('select').chosen();

                $form.validate({
                    ignore: ":hidden:not(select)",
                    rules: {
                        doctor_booking_fee_id: {
                            required: true,
                        },
                        name: {
                            required: true,
                            minlength: 1,
                        },
                        start_hour: {
                            required: true,
                        },
                        end_hour: {
                            required: true,
                        },
                        "week_days[]": {},
                        amount: {
                            required: true,
                            number: true,
                        },
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

                        sandbox.emit('service/doctorBookingFee/surchargeSetting/update', {
                            id: surchargeSetting.id,
                            data: formData,
                            doneCallback: response => {
                                let message = `Surcharge setting <b>${surchargeSetting.name}</b> has been updated successfully!`;

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
                    .on('change', '[name=amount]', event => {
                        let $this = $(event.currentTarget),
                            convertedValue = _toNumber($this.val())
                        ;

                        if(typeof convertedValue === 'number'  && !isNaN(convertedValue)){
                            $totalAmount.html(`= ${convertedValue + parseFloat(surchargeSetting.doctorBookingFee.feeAmount)}`);
                        } else {
                            $totalAmount.html('');
                        }
                    });
                ;
            })
        ;
    };

    sandbox.on('modal/updateSurchargeSetting/show', ({id, doneCallback, failCallback}) => {
        sandbox.emit('window/loading/show');
        sandbox.emit('service/doctorBookingFee/surchargeSetting/fetch', {
            id,
            doneCallback: response => {
                let surchargeSetting = response;
                _this.showModal({ surchargeSetting, doneCallback, failCallback });
                sandbox.emit('window/loading/hide');
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
                    sandbox.emit('window/loading/hide');
                    if ('function' === typeof failCallback) {
                        failCallback(e, data);
                    }
                });
            }
        });
    });

    /**
     * @module modalUpdateSurchargeSetting
     * @function init
     */
    _this.init = (data) => {
        _this.data = data || {};
        _this.data.weekDays = [
            {
                symbol: "MON",
                label: "Monday",
            },{
                symbol: "TUE",
                label: "Tuesday",
            },{
                symbol: "WED",
                label: "Wednesday",
            },{
                symbol: "THU",
                label: "Thursday",
            },{
                symbol: "FRI",
                label: "Friday",
            },{
                symbol: "SAT",
                label: "Saturday",
            },{
                symbol: "SUN",
                label: "Sunday",
            },
        ];

        _this.DOMSelectors = {
            totalAmount: '.total-amount',
        };

        _this.templates = {};
        _this.templates.modalContent = multiline(() => {/*!@preserve
        <form class="form" id="form_update_surcharge_setting">
            <input type="hidden" name="doctor_booking_fee_id" value="{{surchargeSetting.doctorBookingFee.id}}" />

            <div class="form-group">
                <label class="control-label">Name</label>
                <div class="radio">
                    <label>
                        <input type="radio" name="name" value="After Office Hour"
                            {% if surchargeSetting.name == "After Office Hour" %}
                                checked
                            {% endif %}
                        />
                        After Office Hour
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="name" value="After Midnight"
                            {% if surchargeSetting.name == "After Midnight" %}
                                checked
                            {% endif %}
                        />
                        After Midnight
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="name" value="Weekend"
                            {% if surchargeSetting.name == "Weekend" %}
                                checked
                            {% endif %}
                        />
                        Weekend
                    </label>
                </div>
            </div>

            <div class="form-group">
                From
                <select class="form-control" name="start_hour" style="width:100px;display:inline-block;">
                {% for timeOption in timeOptions %}
                    <option value="{{timeOption.value}}"
                        {% if timeOption.value == surchargeSetting.startHour %}
                            selected
                        {% endif %}
                    >{{timeOption.title}}</option>
                {% endfor %}
                </select>
                to
                <select class="form-control" name="end_hour" style="width:100px;display:inline-block;">
                {% for timeOption in timeOptions %}
                    <option value="{{timeOption.value}}"
                        {% if timeOption.value == surchargeSetting.endHour %}
                            selected
                        {% endif %}
                    >{{timeOption.title}}</option>
                {% endfor %}
                </select>
            </div>

            <div class="form-group">
            {% for weekDay in weekDays %}
                <label class="checkbox-inline">
                  <input type="checkbox" name="week_days[]" value="{{weekDay.symbol}}"
                    {% if weekDay.symbol|checkIfIndexOf(surchargeSetting.weekDays) == 1 %}
                        checked
                    {% endif %}
                  > {{weekDay.label}}
                </label>
            {% endfor %}
            </div>

            <div class="form-group">
                Surcharge Price = Normal Price + <input class="form-control" name="amount" style="width:80px;display:inline-block" value="{{parseFloat(surchargeSetting.amount)}}" /> <span class="total-amount">= {{parseFloat(surchargeSetting.amount) + parseFloat(surchargeSetting.doctorBookingFee.feeAmount)}}</span> {{surchargeSetting.doctorBookingFee.feeCurrency}}
            </div>
        </form>
        */console.log});
    }

    /**
     * @module modalUpdateSurchargeSetting
     * @function destroy
     */
    _this.destroy = () => {};

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
};
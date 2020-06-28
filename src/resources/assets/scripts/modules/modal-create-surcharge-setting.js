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

    _this.fetchSurchargeSettings = ({doctorBookingFeeId, doneCallback, failCallback}) => {
        sandbox.emit('window/loading/show');
        manaDrApplication.emit('service/doctorBookingFee/surchargeSetting/list',{
            doctorBookingFeeId,
            doneCallback: response => {
                sandbox.emit('window/loading/hide');
                if('function' === typeof doneCallback){
                    doneCallback(response);
                }
            },
            failCallback: (e, data) => {
                sandbox.emit('window/loading/hide');
                if('function' === typeof failCallback){
                    failCallback(e, data);
                }
            },
        });
    };

    _this.showModal = ({ doctorBookingFeeId, data, doneCallback, failCallback }) => {
        let $modal = bootbox.dialog({
            title: `Add Surcharge Setting`,
            message: swig.render(_this.templates.modalContent, {
                locals: {
                    data,
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
            },
        });

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
                        "week_days[]": {
                            required: true,
                        },
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

                        sandbox.emit('service/doctorBookingFee/surchargeSetting/create', {
                            doctorBookingFeeId,
                            data: formData,
                            doneCallback: response => {
                                let message = `New surcharge setting has been created successfully!`;

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
                            $totalAmount.html(`= ${convertedValue + parseFloat(data.feeAmount)}`);
                        } else {
                            $totalAmount.html('');
                        }
                    });
                ;
            })
        ;
    };

    sandbox.on('modal/createSurchargeSetting/show', ({doctorBookingFeeId, doneCallback, failCallback}) => {
        _this.fetchSurchargeSettings({
            doctorBookingFeeId,
            doneCallback: data => {
                _this.showModal({
                    doctorBookingFeeId,
                    data,
                    doneCallback: (response) => {
                        if('function' === typeof doneCallback){
                            doneCallback(response);
                        }
                    },
                    failCallback: (e, data) => {
                        if('function' === typeof failCallback){
                            failCallback(e, data);
                        }
                    }
                });
            },
            failCallback: (e, data) => {
                if('function' === typeof failCallback){
                    failCallback(e, data);
                }
            }
        });
    });

    _this.init = data => {
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
        <form class="form" id="form_create_surcharge_setting">
            <input type="hidden" name="doctor_booking_fee_id" value="{{data.id}}" />

            <div class="form-group">
                <label class="control-label">Name</label>
                <div class="radio">
                    <label>
                        <input type="radio" name="name" value="After Office Hour" />
                        After Office Hour
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="name" value="After Midnight" />
                        After Midnight
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="name" value="Weekend" />
                        Weekend
                    </label>
                </div>
            </div>

            <div class="form-group">
                From
                <select class="form-control" name="start_hour" style="width:100px;display:inline-block;">
                {% for timeOption in timeOptions %}
                    <option value="{{timeOption.value}}">{{timeOption.title}}</option>
                {% endfor %}
                </select>
                to
                <select class="form-control" name="end_hour" style="width:100px;display:inline-block;">
                {% for timeOption in timeOptions %}
                    <option value="{{timeOption.value}}">{{timeOption.title}}</option>
                {% endfor %}
                </select>
            </div>

            <div class="form-group">
            {% for weekDay in weekDays %}
                <label class="checkbox-inline">
                  <input type="checkbox" name="week_days[]" value="{{weekDay.symbol}}"> {{weekDay.label}}
                </label>
            {% endfor %}
            </div>

            <div class="form-group">
                Surcharge Price = Normal Price + <input class="form-control" name="amount" style="width:80px;display:inline-block" /> <span class="total-amount"></span> {{data.feeCurrency}}
            </div>
        </form>
        */console.log});
    };

    _this.destroy = () => {};

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
}
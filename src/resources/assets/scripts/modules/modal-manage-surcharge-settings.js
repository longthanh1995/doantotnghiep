module.exports = function(sandbox){
    let _this = this;

    _this.fetchSurchargeSettings = ({doctorBookingFeeId, doneCallback, failCallback}) => {
        sandbox.emit('window/loading/show');
        sandbox.emit('service/doctorBookingFee/surchargeSetting/list',{
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

    _this.showModal = ({ data, doneCallback, failCallback }) => {
        let doctorBookingFee = data,
            $modal = bootbox.dialog({
            title: `Manage Surcharge Settings for ${doctorBookingFee.doctor.name}`,
            message: swig.render(_this.templates.modalContent, {
                locals: {
                    ...doctorBookingFee,
                    weekDays: _this.data.weekDays,
                }
            })
        });

        $modal
            .on('shown.bs.modal', event => {
                $modal
                    .on('click', '[data-action=add]', event => {
                    event.preventDefault();

                    const doctorBookingFeeId = doctorBookingFee.id;

                    sandbox.emit('modal/createSurchargeSetting/show', {
                        doctorBookingFeeId,
                        doneCallback: response => {
                            let surchargeSetting = response,
                                $listSurchargeSettings = $modal.find(_this.DOMSelectors.listSurchargeSettings),
                                html = swig.render(_this.templates.surchargeSettingItem, {
                                    locals: {
                                        surchargeSetting,
                                        doctorBookingFee,
                                        weekDays: _this.data.weekDays,
                                    }
                                })
                            ;

                            $listSurchargeSettings.append(html);
                            if ('function' === typeof doneCallback) {
                                doneCallback(response);
                            }
                        },
                        failCallback: (e, data) => {
                            let message = '';

                            if(e
                                && e.responseJSON
                                && e.responseJSON.message
                                && e.responseJSON.message.length){
                                message = e.responseJSON.message;
                            } else {
                                message = 'The request cannot be processed';
                            }

                            bootbox.alert(message, (e, data) => {
                                if ('function' === typeof failCallback) {
                                    failCallback(e, data);
                                }
                            });
                        },
                    });
                })
                    .on('click', '[data-action=edit]', event => {
                        event.preventDefault();

                        let $this = $(event.currentTarget),
                            $targetItem = $this.closest('li'),
                            targetId = $targetItem.data('id')
                        ;

                        sandbox.emit('modal/updateSurchargeSetting/show', {
                            id: targetId,
                            doneCallback: response => {
                                let surchargeSetting = response,
                                    html = swig.render(_this.templates.surchargeSettingItem, {
                                        locals: {
                                            surchargeSetting,
                                            doctorBookingFee,
                                            weekDays: _this.data.weekDays,
                                        }
                                    });

                                $targetItem.replaceWith(html);
                                if ('function' === typeof doneCallback) {
                                    doneCallback(response);
                                }
                            },
                            failCallback: (e, data) => {
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
                                    if ('function' === typeof failCallback) {
                                        failCallback(e, data);
                                    }
                                });
                            }
                        })

                    })
                    .on('click', '[data-action=delete]', event => {
                        event.preventDefault();

                        let $this = $(event.currentTarget),
                            $targetItem = $this.closest('li'),
                            targetId = $targetItem.data('id'),
                            targetName = $targetItem.data('name')
                        ;

                        bootbox.confirm(`Are you sure to delete surcharge setting <b>${targetName}</b>?`, result => {
                            if(result){
                                sandbox.emit('window/loading/show');
                                sandbox.emit('service/doctorBookingFee/surchargeSetting/delete', {
                                    id: targetId,
                                    doneCallback: response => {
                                        let message = `Surcharge setting <b>${targetName}</b> has been deleted successfully!`;
                                        bootbox.alert(message, () => {
                                            $targetItem.remove();
                                            sandbox.emit('window/loading/hide');
                                            if ('function' === typeof doneCallback) {
                                                doneCallback(response);
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
                                            sandbox.emit('window/loading/hide');
                                            if ('function' === typeof failCallback) {
                                                failCallback(e, data);
                                            }
                                        });
                                    }
                                })
                            }
                        })
                    })
                ;
            })
        ;
    };

    sandbox.on('modal/manageSurchageSettings/show', ({doctorBookingFeeId, doneCallback, failCallback}) => {
        _this.fetchSurchargeSettings({
            doctorBookingFeeId,
            doneCallback: data => {
                _this.showModal({
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
        })
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
            listSurchargeSettings: '#list_surcharge_settings',
        };

        _this.templates = {};
        _this.templates.modalContent = multiline(() => {/*!@preserve
        <p>
            Normal price for <span class="text-primary">{{appointmentType.name}}</span> is <span class="text-bold">{{parseFloat(feeAmount)}} {{feeCurrency}}</span>.
        </p>

        <p>
            <a href="#" data-action="add">
                <i class="fa fa-plus"></i> Add Surcharge
            </a>
        </p>

        <ul class="list-unstyled" id="list_surcharge_settings">
        {% for surchargeSetting in surchargeSettings %}
            <li data-id="{{surchargeSetting.id}}" data-name="{{surchargeSetting.name}}">
                <div class="pull-right">
                    <a href="#" data-action="edit" style="margin-right:10px;">
                        Edit
                    </a>
                    <a href="#" data-action="delete">
                        Delete
                    </a>
                </div>
                <b>{{surchargeSetting.name}}</b><br/>
                From {{moment(surchargeSetting.startHour, "HH:mm:ss").format("HH:mm")}} to {{moment(surchargeSetting.endHour, "HH:mm:ss").format("HH:mm")}}<br/>
                <ul class="list-inline">
                {% for weekDay in weekDays %}
                    <li>
                        <i style="vertical-align:middle;" class="fa
                        {% if weekDay.symbol|checkIfIndexOf(surchargeSetting.weekDays) == 1 %}
                            fa-check-square-o
                        {% else %}
                            fa-square-o
                        {% endif %}
                        "/>
                        {{ weekDay.label }}
                    </li>
                {% endfor %}
                </ul>
                Price: {{parseFloat(feeAmount)}} + {{parseFloat(surchargeSetting.amount)}} = {{parseFloat(feeAmount) + parseFloat(surchargeSetting.amount)}} {{feeCurrency}}
                </p>
            </li>
        {% endfor %}
        </ul>
        */console.log});
        _this.templates.surchargeSettingItem = multiline(function(){/*!@preserve
        <li data-id="{{surchargeSetting.id}}" data-name="{{surchargeSetting.name}}">
            <div class="pull-right">
                <a href="#" data-action="edit" style="margin-right:10px;">
                    Edit
                </a>
                <a href="#" data-action="delete">
                    Delete
                </a>
            </div>
            <b>{{surchargeSetting.name}}</b><br/>
            From {{moment(surchargeSetting.startHour, "HH:mm:ss").format("HH:mm")}} to {{moment(surchargeSetting.endHour, "HH:mm:ss").format("HH:mm")}}<br/>
            <ul class="list-inline">
            {% for weekDay in weekDays %}
                <li>
                    <i style="vertical-align:middle;" class="fa
                    {% if weekDay.symbol|checkIfIndexOf(surchargeSetting.weekDays) == 1 %}
                        fa-check-square-o
                    {% else %}
                        fa-square-o
                    {% endif %}
                    "/>
                    {{ weekDay.label }}
                </li>
            {% endfor %}
            </ul>
            Price: {{parseFloat(doctorBookingFee.feeAmount)}} + {{parseFloat(surchargeSetting.amount)}} = {{parseFloat(doctorBookingFee.feeAmount) + parseFloat(surchargeSetting.amount)}} {{doctorBookingFee.feeCurrency}}
            </p>
        </li>
        */console.log});
    };

    _this.destroy = () => {};

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
}
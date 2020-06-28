import {map as _map} from 'lodash';

module.exports = function (sandbox) {
    let _this = this;

    _this.fetchHouseCallReason = ({id, clinicId, doneCallback, failCallback}) => {
        sandbox.emit('window/loading/show');
        sandbox.emit('service/houseCallReason/fetch', {
            id,
            data: {
                clinic_id: clinicId,
            },
            doneCallback: response => {
                sandbox.emit('window/loading/hide');
                if ('function' === typeof doneCallback) {
                    doneCallback(response);
                }
            },
            failCallback: (e, data) => {
                sandbox.emit('window/loading/hide');
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            }
        });
    };

    _this.showModal = ({reason, clinicId, doneCallback, failCallback}) => {
        let $modal = bootbox.dialog({
            title: `Manage doctors for house call reason <b>${reason.reason}</b>`,
            message: swig.render(_this.templates.modalContent, {
                locals: {
                    doctors: reason.doctors
                }
            }),
        });

        $modal
            .on('shown.bs.modal', event => {
                let $tableHouseCallReasonDoctors = $modal.find('#table_house_call_reason_doctors'),
                    $tableHouseCallReasonDoctors_body = $tableHouseCallReasonDoctors.find('tbody')
                ;

                $tableHouseCallReasonDoctors
                    .on('click', '[data-action=add]', event => {
                        event.preventDefault();

                        let excludeIds = [];
                        $tableHouseCallReasonDoctors_body.children('tr').each(function(){
                            let $this = $(this);
                            excludeIds.push($this.data('id'));
                        });

                        sandbox.emit('modal/clinicDoctorsPicker/show', {
                            clinicId,
                            excludeIds,
                            doneCallback: doctors => {
                                let doctorIds = _map(doctors, doctor => doctor.id);
                                sandbox.emit('service/houseCallReason/assignDoctors', {
                                    id: reason.id,
                                    clinicId,
                                    doctorIds,
                                    doneCallback: response => {
                                        let html = swig.render(_this.templates.rows, {
                                            locals: {
                                                doctors,
                                            }
                                        });
                                        $tableHouseCallReasonDoctors_body.append(html);
                                    },
                                    failCallback: (e, data) => {
                                        if ('function' === typeof failCallback) {
                                            failCallback(e, data);
                                        }
                                    },
                                })
                            },
                            failCallback: (e, data) => {
                                console.log('error', e, data);
                            }
                        });
                    })
                    .on('click', '[data-action=remove]', event=> {
                        event.preventDefault();

                        let $this = $(event.currentTarget),
                            $targetRow = $this.closest('tr[data-id]'),
                            targetId = $targetRow.data('id'),
                            targetName = $targetRow.data('name')
                        ;

                        bootbox.confirm(`Are you sure to remove <b>${targetName}</b> from this house call reason?`, result => {
                            if(result){
                                sandbox.emit('window/loading/show');

                                sandbox.emit('service/houseCallReason/removeDoctor', ({
                                    id: reason.id,
                                    clinicId,
                                    doctorId: targetId,
                                    doneCallback: response => {
                                        let message = `<b>${targetName}</b> has been removed from this house call reason successfully!`;
                                        bootbox.alert(message, () => {
                                            $targetRow.remove();
                                            sandbox.emit('window/loading/hide');
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
                                        });
                                    }
                                }));
                            }
                        })
                    })
                ;
            })
            .on('hidden.bs.modal', event => {
                let $tableHouseCallReasonDoctors = $modal.find('#table_house_call_reason_doctors'),
                    $tableHouseCallReasonDoctors_body = $tableHouseCallReasonDoctors.find('tbody')
                ;

                //It's a bit hardcoded here: The doneCallback would receive the total number of doctors
                let doctorAmount = $tableHouseCallReasonDoctors_body.children().length;

                if('function' === typeof doneCallback){
                    doneCallback(doctorAmount);
                }
            })
        ;
    };

    sandbox.on('modal/manageHouseCallReasonDoctors/show', ({id, clinicId, doneCallback, failCallback}) => {
        _this.fetchHouseCallReason({
            id,
            clinicId,
            doneCallback: response => {
                let reason = response;
                _this.showModal({
                    reason,
                    clinicId,
                    doneCallback: response => {
                        if ('function' === typeof doneCallback) {
                            doneCallback(response);
                        }
                    },
                    failCallback: (e, data) => {
                        if ('function' === typeof failCallback) {
                            failCallback(e, data);
                        }
                    }
                })
            },
            failCallback: (e, data) => {
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            }
        })
    });

    /**
     * @memberOf modalManageHouseCallReasonDoctors
     * @function init
     * @param data
     */
    _this.init = (data) => {
        _this.data = data || {};

        _this.templates = {};
        _this.templates.modalContent = multiline(() => {/*!@preserve
        <table class="table table-hover table-striped" id="table_house_call_reason_doctors">
            <thead>
                <tr>
                    <th>Doctor</th>
                    <th>
                        <a class="btn btn-xs btn-primary" data-action="add">
                            <i class="fa fa-plus" />
                            Add
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
            {% for doctor in doctors %}
                <tr data-id="{{doctor.id}}" data-name="{{doctor.name}}">
                    <td>{{doctor.name}}</td>
                    <td>
                        <a href="#" class="btn btn-xs btn-danger" data-action="remove">
                            <i class="fa fa-times" /> Remove
                        </a>
                    </td>
                </tr>
            {% endfor %}
            </tbody>
        </table>
        */console.log});
        _this.templates.row = multiline(() => {/*!@preserve
        <tr data-id="{{doctor.id}}" data-name="{{doctor.name}}">
            <td>{{doctor.name}}</td>
            <td>
                <a href="#" class="btn btn-xs btn-danger" data-action="remove">
                    <i class="fa fa-times" /> Remove
                </a>
            </td>
        </tr>
        */console.log});

        _this.templates.rows = multiline(() => {/*!@preserve
        {% for doctor in doctors %}
        <tr data-id="{{doctor.id}}" data-name="{{doctor.name}}">
            <td>{{doctor.name}}</td>
            <td>
                <a href="#" class="btn btn-xs btn-danger" data-action="remove">
                    <i class="fa fa-times" /> Remove
                </a>
            </td>
        </tr>
        {% endfor %}
        */console.log})
    };

    /**
     * @memberOf modalManageHouseCallReasonDoctors
     * @function destroy
     */
    _this.destroy = () => {
    };

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
};
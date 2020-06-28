module.exports = function(sandbox){
    let _this = this;

    _this.fetchHouseCallReasons = ({appointmentTypeId, clinicId, doneCallback, failCallback}) => {
        sandbox.emit('window/loading/show');
        sandbox.emit('service/houseCallReason/list', {
            data: {
                appointmentTypeId,
                clinicId,
            },
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
        })
    };

    _this.showModal = ({appointmentTypeId, appointmentTypeName, clinicId, reasons, doneCallback, failCallback}) => {
        let $modal = bootbox.dialog({
            title: `Manage reasons for ${appointmentTypeName}`,
            message: swig.render(_this.templates.modalContent, {
                locals: {
                    reasons
                }
            })
        });

        $modal
            .on('shown.bs.modal', event => {
                let $tableHouseCallReasons = $modal.find('#table_house_call_reasons'),
                    $tableHouseCallReasons_body = $tableHouseCallReasons.find('tbody')
                ;

                $tableHouseCallReasons
                    .on('click', '[data-action=add]', event => {
                        event.preventDefault();

                        sandbox.emit('modal/createHouseCallReason/show', {
                            appointmentTypeId,
                            appointmentTypeName,
                            clinicId,
                            doneCallback: response => {
                                let reason = response,
                                    html = swig.render(_this.templates.row, {
                                    locals: {
                                        reason
                                    }
                                });

                                $tableHouseCallReasons_body.append(html);
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

                                bootbox.alert(message);
                            }
                        })
                    })
                    .on('click', '[data-action=edit]', event => {
                        event.preventDefault();

                        let $this = $(event.currentTarget),
                            $targetRow = $this.closest('tr[data-id]'),
                            targetId = $targetRow.data('id')
                        ;

                        sandbox.emit('modal/updateHouseCallReason/show', {
                            id: targetId,
                            doneCallback: response => {
                                let reason = response,
                                    html = swig.render(_this.templates.row, {
                                        locals: {
                                            reason
                                        }
                                    });

                                $targetRow.replaceWith(html);
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

                                bootbox.alert(message);
                            }
                        })
                    })
                    .on('click', '[data-action=delete]', event => {
                        event.preventDefault();

                        let $this = $(event.currentTarget),
                            $targetRow = $this.closest('tr[data-id]'),
                            targetId = $targetRow.data('id'),
                            targetName = $targetRow.data('reason')
                        ;

                        bootbox.confirm(`Are you sure to delete <b>${targetName}</b>?`, result => {
                            if(result){
                                sandbox.emit('window/loading/show');

                                sandbox.emit('service/houseCallReason/delete', ({
                                    id: targetId,
                                    doneCallback: response => {
                                        let message = `<b>${targetName}</b> has been deleted successfully!`;
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
                    .on('click', '[data-action=manageDoctors]', event => {
                        event.preventDefault();

                        let $this = $(event.currentTarget),
                            $targetRow = $this.closest('tr[data-id]'),
                            targetId = $targetRow.data('id')
                        ;

                        sandbox.emit('modal/manageHouseCallReasonDoctors/show', {
                            id: targetId,
                            clinicId,
                            doneCallback: response => {
                                //update the number of doctors
                                let $manageDoctorsButton = $targetRow.find('[data-action=manageDoctors]'),
                                    html = swig.render(_this.templates.manageDoctorsButton, {
                                        locals: {
                                            doctorAmount: response,
                                        },
                                    })
                                ;

                                $manageDoctorsButton.replaceWith(html);
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

                                bootbox.alert(message);
                            }
                        })
                    })
                ;
            })
        ;
    };

    sandbox.on('modal/manageHouseCallReasons/show', ({appointmentTypeId, appointmentTypeName, clinicId, doneCallback, failCallback}) => {
        _this.fetchHouseCallReasons({
            appointmentTypeId,
            clinicId,
            doneCallback: data => {
                _this.showModal({
                    appointmentTypeId,
                    appointmentTypeName,
                    clinicId,
                    reasons: data,
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

    /**
     * @memberOf modalManageHouseCallReasons
     * @function init
     * @param data
     */
    _this.init = (data) => {
        _this.data = data || {};

        _this.templates = {};
        _this.templates.modalContent = multiline(() => {/*!@preserve
        <table class="table table-hover table-striped" id="table_house_call_reasons">
            <thead>
                <tr>
                    <th>Reason</th>
                    <th></th>
                    <th>
                        <a class="btn btn-xs btn-primary" data-action="add">
                            <i class="fa fa-plus" />
                            Add
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
            {% for reason in reasons %}
                <tr data-id="{{reason.id}}" data-reason="{{reason.reason}}">
                    <td>{{reason.reason}}</td>
                    <td class="text-right">
                        <a class="btn btn-xs btn-default" data-id="{{ reason.id }}" data-action="manageDoctors">
                            <i class="fa fa-user-md" />
                        {% if reason.doctors.length == 1 %}
                            1 doctor
                        {% elseif (reason.doctors.length > 1) %}
                            {{ reason.doctors.length }} doctors
                        {% else %}
                            Manage doctors
                        {% endif %}
                        </a>
                    </td>
                    <td>
                        <a href="#" class="btn btn-xs btn-warning" data-action="edit">
                            <i class="fa fa-pencil" /> Edit
                        </a>
                        <a href="#" class="btn btn-xs btn-danger" data-action="delete">
                            <i class="fa fa-trash" /> Delete
                        </a>
                    </td>
                </tr>
            {% endfor %}
            </tbody>
        </table>
        */console.log});
        _this.templates.row = multiline(()=>{/*!@preserve
        <tr data-id="{{reason.id}}" data-reason="{{reason.reason}}">
            <td>{{reason.reason}}</td>
            <td class="text-right">
                <a class="btn btn-xs btn-default" data-id="{{ reason.id }}" data-action="manageDoctors">
                    <i class="fa fa-user-md" />
                {% if reason.doctors.length == 1 %}
                    1 doctor
                {% elseif (reason.doctors.length > 1) %}
                    {{ reason.doctors.length }} doctors
                {% else %}
                    Manage doctors
                {% endif %}
                </a>
            </td>
            <td>
                <a href="#" class="btn btn-xs btn-warning" data-action="edit">
                    <i class="fa fa-pencil" /> Edit
                </a>
                <a href="#" class="btn btn-xs btn-danger" data-action="delete">
                    <i class="fa fa-trash" /> Delete
                </a>
            </td>
        </tr>
        */console.log});
        _this.templates.manageDoctorsButton = multiline(()=>{/*!@preserve
        <a class="btn btn-xs btn-default" data-action="manageDoctors">
            <i class="fa fa-user-md" />
        {% if doctorAmount == 1 %}
            1 doctor
        {% elseif (doctorAmount > 1) %}
            {{ doctorAmount }} doctors
        {% else %}
            Manage doctors
        {% endif %}
        </a>
        */console.log});
    };

    /**
     * @memberOf modalManageHouseCallReasons
     * @function destroy
     */
    _this.destroy = () => {};

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
};
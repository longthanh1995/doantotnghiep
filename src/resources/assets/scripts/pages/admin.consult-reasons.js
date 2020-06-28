/**
 * @module pageConsultReasons
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @memberOf pageConsultReasons
     * @function showModalCreateConsultReason
     */
    _this.showModalCreateConsultReason = ({doneCallback, failCallback}) => {
        manaDrApplication.emit('window/loading/show');

        sandbox.emit('service/appointmentType/fetchAll', {
            doneCallback: (appointmentTypes) => {
                let data = {appointmentTypes},
                    $modal = bootbox.dialog({
                        title: 'Create consult reason',
                        message: swig.render(_this.templates.modalCreateConsultReason, {
                            locals: data
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

                        $form.find('[name=appointment_type_id]')
                            .chosen({
                                search_contains: true
                            })
                        ;

                        $form.validate({
                            rules: {
                                name: {
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

                                sandbox.emit('service/consultReason/create', {
                                    data: formData,
                                    doneCallback: (response) => {
                                        let message = `Consult reason <b>${response.reason}</b> has been created!`;

                                        bootbox.alert(message, () => {
                                            $modal.modal('hide');
                                            manaDrApplication.emit('window/loading/hide');
                                            if ('function' === typeof doneCallback) {
                                                doneCallback(humps.camelizeKeys(response));
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
                                            $form.data('is-submitting', 0);
                                            $modal.find(':input').prop('disabled', false);
                                            manaDrApplication.emit('window/loading/hide');

                                            if ('function' === typeof failCallback) {
                                                failCallback(e, data);
                                            }
                                        });
                                    }
                                });
                            }
                        })
                    })
                ;

                manaDrApplication.emit('window/loading/hide');
            },
            failCallback: (e, data) => {
                manaDrApplication.emit('window/loading/hide');
            }
        });
    }

    /**
     * @memberOf pageConsultReasons
     * @function showModalUpdateConsultReason
     */
    _this.showModalUpdateConsultReason = ({id, doneCallback, failCallback}) => {
        manaDrApplication.emit('window/loading/show');

        sandbox.emit('service/appointmentType/fetchAll', {
            doneCallback: (appointmentTypes) => {
                manaDrApplication.emit('window/loading/show');

                sandbox.emit('service/consultReason/fetch', {
                    id,
                    doneCallback: (consultReason) => {
                        let data = {appointmentTypes, consultReason},
                            $modal = bootbox.dialog({
                                title: 'Update consult reason',
                                message: swig.render(_this.templates.modalUpdateConsultReason, {
                                    locals: data
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

                                $form.find('[name=appointment_type_id]')
                                    .chosen({
                                        search_contains: true
                                    })
                                ;

                                $form.validate({
                                    rules: {
                                        name: {
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

                                        sandbox.emit('service/consultReason/update', {
                                            id,
                                            data: formData,
                                            doneCallback: (response) => {
                                                let message = `Consult reason <b>${response.reason}</b> has been updated!`;

                                                bootbox.alert(message, () => {
                                                    $modal.modal('hide');
                                                    manaDrApplication.emit('window/loading/hide');
                                                    if ('function' === typeof doneCallback) {
                                                        doneCallback(humps.camelizeKeys(response));
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
                                                    $form.data('is-submitting', 0);
                                                    $modal.find(':input').prop('disabled', false);
                                                    manaDrApplication.emit('window/loading/hide');

                                                    if ('function' === typeof failCallback) {
                                                        failCallback(e, data);
                                                    }
                                                });
                                            }
                                        });
                                    }
                                })
                            })
                        ;

                        manaDrApplication.emit('window/loading/hide');
                    },
                    failCallback: (e, data) => {
                        manaDrApplication.emit('window/loading/hide');
                    }
                })
            },
            failCallback: (e, data) => {
                manaDrApplication.emit('window/loading/hide');
            }
        });
    }

    _this.showModalDeleteConsultReason = ({id, doneCallback, failCallback}) => {
        let $modal = bootbox.confirm(`Do you really want to remove this consult reason?`, (result) => {
            if(result){
                sandbox.emit('service/consultReason/delete', {
                    id,
                    doneCallback: (response) => {
                        let message = `Consult reason has been deleted!`;

                        bootbox.alert(message, () => {
                            $modal.modal('hide');
                            manaDrApplication.emit('window/loading/hide');
                            if ('function' === typeof doneCallback) {
                                doneCallback(humps.camelizeKeys(response));
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
                            $form.data('is-submitting', 0);
                            $modal.find(':input').prop('disabled', false);
                            manaDrApplication.emit('window/loading/hide');

                            if ('function' === typeof failCallback) {
                                failCallback(e, data);
                            }
                        });
                    }
                });
            }
        })
    }

    /**
     * @memberOf pageConsultReasons
     * @function bindEvents
     */
    _this.bindEvents = () => {
        _this.objects.$tableConsultReasons
            .on('click', '[data-action=add]', (event) => {
                event.preventDefault();

                _this.showModalCreateConsultReason({
                    doneCallback: (data) => {
                        let html = swig.render(_this.templates.rowTemplate, {
                            locals: data
                        });

                        _this.objects.$tableConsultReasons_tbody.append(html);
                    }
                });
            })
            .on('click', '[data-action=edit]', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    $targetRow = $this.closest('tr[data-id]'),
                    targetId = $targetRow.data('id')
                ;

                if(!targetId){
                    return;
                }

                _this.showModalUpdateConsultReason({
                    id: targetId,
                    doneCallback: (data) => {
                        let html = swig.render(_this.templates.rowTemplate, {
                            locals: data
                        });

                        $targetRow.replaceWith(html);
                    }
                })
            })
            .on('click', '[data-action=delete]', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    $targetRow = $this.closest('tr[data-id]'),
                    targetId = $targetRow.data('id')
                ;

                if(!targetId){
                    return;
                }

                _this.showModalDeleteConsultReason({
                    id: targetId,
                    doneCallback: (data) => {
                        $targetRow.remove();
                    }
                });
            })
        ;
    }

    /**
     * @memberOf pageConsultReasons
     * @function init
     * @param data
     */
    _this.init = (data) => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$tableConsultReasons = $('#table_consult_reasons');
        _this.objects.$tableConsultReasons_tbody = _this.objects.$tableConsultReasons.children('tbody');

        _this.templates = {};
        _this.templates.modalCreateConsultReason = multiline(() => {/*!@preserve
        <form class="form" data-is-submitting="0">
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" name="reason" type="text"/>
            </div>
            <div class="form-group">
                <label for="name">Appointment Type</label>
                <select class="form-control" name="appointment_type_id">
                {% for appointmentType in appointmentTypes %}
                    <option value="{{appointmentType.id}}">{{appointmentType.name}}</option>
                {% endfor %}
                </select>
            </div>
        </form>
        */console.log});
        _this.templates.modalUpdateConsultReason = multiline(() => {/*!@preserve
        <form class="form" data-is-submitting="0">
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" name="reason" type="text" value="{{consultReason.reason}}"/>
            </div>
            <div class="form-group">
                <label for="name">Appointment Type</label>
                <select class="form-control" name="appointment_type_id">
                {% for appointmentType in appointmentTypes %}
                    <option value="{{appointmentType.id}}"
                        {% if appointmentType.id == consultReason.appointmentTypeId %}
                            select="selected"
                        {% endif %}
                    >{{appointmentType.name}}</option>
                {% endfor %}
                </select>
            </div>
        </form>
        */console.log});
        _this.templates.rowTemplate = multiline(() => {/*!@preserve
        <tr data-id="{{id}}" data-reason="{{reason}}" data-appointment-type-id="{{appointmentType.id}}">
            <td>{{reason}}</td>
            <td>{{appointmentType.name}}</td>
            <td>
                <a href="#" class="btn btn-xs btn-warning" data-action="edit">
                    <i class="fa fa-pencil"></i>
                    Edit
                </a>
                <a href="#" class="btn btn-xs btn-default" data-action="delete">
                    <i class="fa fa-times"></i>
                    Delete
                </a>
            </td>
        </tr>
        */console.log});

        _this.bindEvents();
    }

    /**
     * @memberOf pageConsultReasons
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
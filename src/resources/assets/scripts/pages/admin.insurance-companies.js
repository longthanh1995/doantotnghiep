'use strict';

/**
 * @module pageInsuranceCompanies
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @memberOf pageInsuranceCompanies
     * @function showModalCreateInsuranceCompany
     */
    _this.showModalCreateInsuranceCompany = ({doneCallback, failCallback}) => {
        let $modal = bootbox.dialog({
            title: 'Create insurance company',
            message: swig.render(_this.templates.modalCreateInsuranceCompany, {
                locals: {}
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
        });

        $modal
            .on('shown.bs.modal', (event) => {
                let $form = $modal.find('form');

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

                        let request = $.ajax({
                            url: laroute.route('admin.insuranceCompany.store'),
                            method: 'POST',
                            data: formData,
                            dataType: 'json'
                        });

                        request
                            .done((response) => {
                                let companyName = response.name,
                                    message = `Insurance company <b>${companyName}</b> has been created!`;

                                bootbox.alert(message, () => {
                                    $modal.modal('hide');
                                    manaDrApplication.emit('window/loading/hide');
                                    if ('function' === typeof doneCallback) {
                                        doneCallback(response);
                                    }
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
                                    $form.data('is-submitting', 0);
                                    $modal.find(':input').prop('disabled', false);
                                    manaDrApplication.emit('window/loading/hide');

                                    if ('function' === typeof failCallback) {
                                        failCallback();
                                    }
                                });
                            })
                    }
                })
            })
        ;
    }

    /**
     * @memberOf pageInsuranceCompanies
     * @function showModalUpdateInsuranceCompany
     */
    _this.showModalUpdateInsuranceCompany = ({id, name, doneCallback, failCallback}) => {
        let $modal = bootbox.dialog({
            title: 'Update insurance company',
            message: swig.render(_this.templates.modalUpdateInsuranceCompany, {
                locals: {
                    id,
                    name
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
        });

        $modal
            .on('shown.bs.modal', (event) => {
                let $form = $modal.find('form');

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

                        let request = $.ajax({
                            url: laroute.route('admin.insuranceCompany.update', {insuranceCompany: id}),
                            method: 'PATCH',
                            data: formData,
                            dataType: 'json'
                        });

                        request
                            .done((response) => {
                                let companyName = name,
                                    message = `Insurance company <b>${companyName}</b> has been updated!`;

                                bootbox.alert(message, () => {
                                    $modal.modal('hide');
                                    manaDrApplication.emit('window/loading/hide');
                                    if ('function' === typeof doneCallback) {
                                        doneCallback(response);
                                    }
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
                                    $form.data('is-submitting', 0);
                                    $modal.find(':input').prop('disabled', false);
                                    manaDrApplication.emit('window/loading/hide');

                                    if ('function' === typeof failCallback) {
                                        failCallback();
                                    }
                                });
                            })
                        ;
                    }
                })
            })
        ;
    }

    /**
     * @memberOf pageInsuranceCompanies
     * @function showModalUpdateInsuranceCompany
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.showModalDeactivateInsuranceCompany = ({id, name, doneCallback, failCallback}) => {
        let $modal = bootbox.confirm(`Do you really want to deactivate insurance company <b>${name}</b>`, (result) => {
            if(result){
                manaDrApplication.emit('window/loading/show');

                let request = $.ajax({
                    url: laroute.route('admin.insuranceCompany.destroy', {insuranceCompany: id}),
                    method: 'DELETE',
                });

                request
                    .done((response) => {
                        let companyName = name,
                            message = `Insurance company <b>${companyName}</b> has been deactivated!`;

                        bootbox.alert(message, () => {
                            $modal.modal('hide');
                            manaDrApplication.emit('window/loading/hide');
                            if ('function' === typeof doneCallback) {
                                doneCallback(response);
                            }
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
                            manaDrApplication.emit('window/loading/hide');

                            if ('function' === typeof failCallback) {
                                failCallback();
                            }
                        });
                    })
                ;
            }
        });
    }

    /**
     * @memberOf pageInsuranceCompanies
     * @function showModalUpdateInsuranceCompany
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.showModalActivateInsuranceCompany = ({id, name, doneCallback, failCallback}) => {
        let $modal = bootbox.confirm(`Do you really want to activate insurance company <b>${name}</b>`, (result) => {
            if(result){
                manaDrApplication.emit('window/loading/show');

                let request = $.ajax({
                    url: laroute.route('admin.insuranceCompany.restore'),
                    method: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json'
                });

                request
                    .done((response) => {
                        let companyName = name,
                            message = `Insurance company <b>${companyName}</b> has been activated!`;

                        bootbox.alert(message, () => {
                            $modal.modal('hide');
                            manaDrApplication.emit('window/loading/hide');
                            if ('function' === typeof doneCallback) {
                                doneCallback(response);
                            }
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
                            manaDrApplication.emit('window/loading/hide');

                            if ('function' === typeof failCallback) {
                                failCallback();
                            }
                        });
                    })
                ;
            }
        });
    }


    /**
     * @memberOf pageInsuranceCompanies
     * @function bindEvents
     */
    _this.bindEvents = () => {
        _this.objects.$tableInsuranceCompanies
            .on('click', '[data-action=add]', (event) => {
                event.preventDefault();

                _this.showModalCreateInsuranceCompany({
                    doneCallback: (data) => {
                        let html = swig.render(_this.templates.rowTemplate, {
                            locals: data
                        });

                        _this.objects.$tableInsuranceCompanies_tbody.append(html);
                    }
                });
            })
            .on('click', '[data-action=edit]', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    $targetRow = $this.closest('tr[data-id]'),
                    targetId = $targetRow.data('id'),
                    targetName = $targetRow.data('name')
                ;

                if(!targetId){
                    return false;
                }

                _this.showModalUpdateInsuranceCompany({
                    id: targetId,
                    name: targetName,
                    doneCallback: (data) => {
                        let html = swig.render(_this.templates.rowTemplate, {
                            locals: data
                        });

                        $targetRow.replaceWith(html);
                    }
                });
            })
            .on('click', '[data-action=deactivate]', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    $targetRow = $this.closest('tr[data-id]'),
                    targetId = $targetRow.data('id'),
                    targetName = $targetRow.data('name')
                ;

                if(!targetId){
                    return false;
                }

                _this.showModalDeactivateInsuranceCompany({
                    id: targetId,
                    name: targetName,
                    doneCallback: (data) => {
                        let html = swig.render(_this.templates.rowTemplate, {
                            locals: data
                        });

                        $targetRow.replaceWith(html);
                    }
                })
            })
            .on('click', '[data-action=activate]', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    $targetRow = $this.closest('tr[data-id]'),
                    targetId = $targetRow.data('id'),
                    targetName = $targetRow.data('name')
                ;

                if(!targetId){
                    return false;
                }

                _this.showModalActivateInsuranceCompany({
                    id: targetId,
                    name: targetName,
                    doneCallback: (data) => {
                        let html = swig.render(_this.templates.rowTemplate, {
                            locals: data
                        });

                        $targetRow.replaceWith(html);
                    }
                })
            })
        ;
    }

    /**
     * @memberOf pageInsuranceCompanies
     * @function init
     * @param data
     */
    _this.init = (data) => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$tableInsuranceCompanies = $('#table_insurance_companies');
        _this.objects.$tableInsuranceCompanies_tbody = _this.objects.$tableInsuranceCompanies.children('tbody');

        _this.templates = {};
        _this.templates.modalCreateInsuranceCompany = multiline(() => {/*!@preserve
        <form class="form" data-is-submitting="0">
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" name="name" type="text"/>
            </div>
        </form>
        */console.log});
        _this.templates.modalUpdateInsuranceCompany = multiline(() => {/*!@preserve
        <form class="form" data-is-submitting="0">
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" name="name" type="text" value="{{name}}"/>
            </div>
        </form>
        */console.log});
        _this.templates.rowTemplate = multiline(() => {/*!@preserve
        <tr data-id="{{id}}" data-name="{{name}}">
            <td>{{name}}</td>
            <td>
                <a href="#" class="btn btn-xs btn-default" data-action="edit">
                    <i class="fa fa-pencil"></i>
                    Edit
                </a>
                {% if deleted_at %}
                    <a href="#" class="btn btn-xs btn-default" data-action="activate">
                        <i class="fa fa-check"></i>
                        Activate
                    </a>
                {% else %}
                    <a href="#" class="btn btn-xs btn-default" data-action="deactivate">
                        <i class="fa fa-times"></i>
                        Deactivate
                    </a>
                {% endif %}
            </td>
        </tr>
        */console.log});

        _this.bindEvents();
    }

    /**
     * @memberOf pageInsuranceCompanies
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
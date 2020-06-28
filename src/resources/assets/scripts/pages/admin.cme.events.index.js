/**
 * @module pageAdminCMEEvents
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function(sandbox){
    let _this = this;

    _this.showModalApprove = ({id, doneCallback, failCallback}) => {
        let $modal = bootbox.confirm(`Are you sure to approve this event?`, result => {
            if(result){
                manaDrApplication.emit('window/loading/show');
                sandbox.emit('service/admin/cme/events/approve', {
                    id,
                    doneCallback: response => {
                        let message = 'This event has been approved!';

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
                            manaDrApplication.emit('window/loading/hide');

                            if ('function' === typeof failCallback) {
                                failCallback(e, data);
                            }
                        });
                    }
                })
            }
        })
    };

    _this.showModalReject = ({id, doneCallback, failCallback}) => {
        let $modal = bootbox.dialog({
            message: swig.render(_this.templates.modalRejectContent),
            buttons: {
                'reset': {
                    label: 'Reset',
                    className: 'btn',
                    callback: (event) => {
                        var $form = $(event.delegateTarget).find('form');
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
                        var $form = $(event.delegateTarget).find('form');
                        $form.submit();
                        return false;
                    }
                }
            }
        });

        $modal
            .on('shown.bs.modal', event => {
                let $form = $modal.find('form');

                $form.validate({
                    rules: {
                        comment: {
                            required: true
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

                        let formData = $form.serializeObject();

                        manaDrApplication.emit('window/loading/show');
                        $form.data('is-submitting', 1);

                        $modal.find(':input').prop('disabled', true);

                        sandbox.emit('service/admin/cme/events/reject', {
                            id,
                            data: formData,
                            doneCallback: response => {
                                let message = 'This event has been rejected';

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
                                    manaDrApplication.emit('window/loading/hide');
                                    $form.data('is-submitting', 0);
                                    $modal.find(':input').prop('disabled', false);
                                    if ('function' === typeof failCallback) {
                                        failCallback(e, data);
                                    }
                                });
                            }
                        });
                    }
                });
            })
        ;
    };

    _this.bindEvents = () => {
        _this.objects.$table
            .on('click', '[data-action=approve]', event => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    $targetRow = $this.closest('tr'),
                    targetId = $targetRow.data('id')
                ;

                _this.showModalApprove({
                    id: targetId,
                    doneCallback: response => {
                        return window.location.reload();
                        let event = response,
                            html = swig.render(_this.templates.row, {
                                locals: event,
                            })
                        ;

                        console.log('html', html);

                        $targetRow.replaceWith(html);
                    },
                    failCallback: (e, data) => {
                        console.log('errorApprove', e, data);
                    }
                })
            })
            .on('click', '[data-action=reject]', event => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    $targetRow = $this.closest('tr'),
                    targetId = $targetRow.data('id')
                ;

                _this.showModalReject({
                    id: targetId,
                    doneCallback: response => {
                        return window.location.reload();
                        console.log('reject', response);
                    },
                    failCallback: (e, data) => {
                        console.log('errorReject', e, data);
                    }
                })
            })
        ;
    };

    /**
     * @memberOf pageAdminCMEEvents
     * @function init
     */
    _this.init = data => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$table = $('#table_cme_events');

        _this.templates = {
            modalRejectContent: multiline(()=>{/*!@preserve
            <form class="form" id="form_reject_event">
                <p class="form-control-static">Are you sure to reject this event?</p>
                <div class="form-group">
                    <textarea class="form-control vertical" name="comment"></textarea>
                </div>
            </form>
            */console.log}),
            row: multiline(()=>{/*!@preserve
            <tr data-id="{{id}}">
                <td>
                    <img src="{{attachments.data[0].url_preview}}" width="80"/>
                </td>
                <td>
                    <a href="{{laroute.route('admin.cme.events.details', {'id': id})}}">
                        {{name}}
                    </a>
                </td>
                <td>
                {% if status == 0 %}
                    <span class="label label-default">
                        Draft
                    </span>
                {% elseif status == 1 %}
                    <span class="label label-warning">
                        Approval pending
                    </span>
                {% elseif status == 2 %}
                    <span class="label label-primary">
                        Published
                    </span>
                {% elseif status == 3 %}
                    <span class="label label-aqua">
                        Ongoing
                    </span>
                {% elseif status == 4 %}
                    <span class="label label-muted">
                        Closed
                    </span>
                {% elseif status == 5 %}
                    <span class="label label-danger">
                        Cancelled
                    </span>
                {% elseif status == 6 %}
                    <span class="label label-success">
                        Approved
                    </span>
                {% elseif status == 7 %}
                    <span class="label label-danger">
                        Rejected
                    </span>
                {% endif %}
                </td>
                <td>
                    {{createdAt}}
                </td>
                <td>
                    {{startTime}}
                </td>
                <td>
                    <span title="{{organizer.data.email}}">
                        {{organizer.data.fullName}}
                    </span>
                </td>
                <td>
                {% if status == 1 %}
                    <a href="#" class="btn btn-xs btn-info" data-action="approve">
                        <i class="fa fa-check"></i>
                        Approve
                    </a>
                    <a href="#" class="btn btn-xs btn-warning" data-action="reject">
                        <i class="fa fa-times"></i>
                        Reject
                    </a>
                {% endif %}
                </td>
            </tr>
            */console.log}),
        };

        _this.bindEvents();
    };

    /**
     * @memberOf pageAdminCMEEvents
     * @function destroy
     */
    _this.destroy = () => {};

    return {
        init: _this.init,
        destroy: _this.destroy
    }
};
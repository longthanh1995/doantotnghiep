module.exports = function(sandbox){
    let _this = this;

    _this.showModalRegister = ({doneCallback, failCallback}) => {
        sandbox.emit('window/loading/show');
        sandbox.emit('service/countries/list', {
            doneCallback: countries => {
                sandbox.emit('window/loading/hide');
                let $modal = bootbox.dialog({
                        title: 'Register new CME Organizer',
                        message: swig.render(_this.templates.modalRegisterContent, {
                            locals: {
                                countries,
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
                    })
                ;

                $modal
                    .on('shown.bs.modal', event => {
                        let $form = $modal.find('form');

                        $form.find('select.chosen').chosen({
                            width: '100%',
                            search_contains: true,
                        });

                        $form.validate({
                            ignore: ":hidden:not(select)",
                            rules: {
                                name: {
                                    required: true,
                                    minlength: 1,
                                    maxlength: 255
                                },

                                official_name: {
                                    required: true,
                                    minlength: 1,
                                    maxlength: 255
                                },

                                email: {
                                    required: {
                                        depends: function(){
                                            let $this = $(this);
//                                $this.val($.trim($this.escapeHtml()));
                                            return $this.val().length;
                                        }
                                    },
                                    validateEmail: ''
                                },

                                password: {
                                    required: true,
                                    validatePassword: true,
                                },

                                phone_number: {
                                    required: true,
                                    number: true
                                },

                                phone_country_code: {
                                    required: true
                                },

                                country_id: {
                                    required: true,
                                },
                            },
                            messages: {
                                email: {
                                    required: '',
                                    validateEmail: 'Invalid email format.'
                                },
                                password: {
                                    validatePassword: 'Invalid password format'
                                }
                            },
                            errorElement: "p",
                            errorClass: "help-block",
                            errorPlacement: function(error, element) {
                                element.closest('.form-group').append(error);
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

                                let formData = $(form).serializeObject();

                                manaDrApplication.emit('window/loading/show');
                                $form.data('is-submitting', 1);
                                $modal.find(':input').prop('disabled', true);

                                sandbox.emit('service/admin/cme/organizers/register', {
                                    data: formData,
                                    doneCallback: response => {
                                        let message = 'New CME Organizer has been registered!';

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
                                })
                            }
                        });
                    })
                ;
            },
            failCallback: (e, data) => {
                sandbox.emit('window/loading/hide');
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            },
        });

    };

    _this.showModalUpdate = ({id, doneCallback, failCallback}) => {
        sandbox.emit('window/loading/show');
        sandbox.emit('service/countries/list', {
            doneCallback: countries => {
                sandbox.emit('window/loading/hide');

                sandbox.emit('service/admin/cme/organizers/fetch', {
                    id,
                    doneCallback: response => {
                        console.log('response', response);
                        const { user, organizer } = response.data;
                        let $modal = bootbox.dialog({
                                title: 'Update CME Organizer Information',
                                message: swig.render(_this.templates.modalUpdateContent, {
                                    locals: {
                                        countries,
                                        user,
                                        organizer,
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
                            })
                        ;

                        $modal
                            .on('shown.bs.modal', event => {
                                let $form = $modal.find('form');

                                $form.find('select.chosen').chosen({
                                    width: '100%',
                                    search_contains: true,
                                });

                                $form.validate({
                                    ignore: ":hidden:not(select)",
                                    rules: {
                                        name: {
                                            required: true,
                                            minlength: 1,
                                            maxlength: 255
                                        },

                                        official_name: {
                                            required: true,
                                            minlength: 1,
                                            maxlength: 255
                                        },

                                        email: {
                                            required: {
                                                depends: function(){
                                                    let $this = $(this);
//                                $this.val($.trim($this.escapeHtml()));
                                                    return $this.val().length;
                                                }
                                            },
                                            validateEmail: ''
                                        },

                                        password: {
                                            required: true,
                                            validatePassword: true,
                                        },

                                        phone_number: {
                                            required: true,
                                            number: true
                                        },

                                        phone_country_code: {
                                            required: true
                                        },

                                        country_id: {
                                            required: true,
                                        },
                                    },
                                    messages: {
                                        email: {
                                            required: '',
                                            validateEmail: 'Invalid email format.'
                                        },
                                        password: {
                                            validatePassword: 'Invalid password format'
                                        }
                                    },
                                    errorElement: "p",
                                    errorClass: "help-block",
                                    errorPlacement: function(error, element) {
                                        element.closest('.form-group').append(error);
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

                                        let formData = $(form).serializeObject();

                                        manaDrApplication.emit('window/loading/show');
                                        $form.data('is-submitting', 1);
                                        $modal.find(':input').prop('disabled', true);

                                        sandbox.emit('service/admin/cme/organizers/update', {
                                            id,
                                            data: formData,
                                            doneCallback: response => {
                                                let message = 'CME Organizer has been updated!';

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
                                        })
                                    }
                                });
                            })
                        ;
                    },
                    failCallback: (e, data) => {
                        sandbox.emit('window/loading/hide');
                        if ('function' === typeof failCallback) {
                            failCallback(e, data);
                        }
                    }
                });
            },
            failCallback: (e, data) => {
                sandbox.emit('window/loading/hide');
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            },
        });

    };

    _this.bindEvents = () => {
        _this.objects.$table
            .on('click', '[data-action=register]', event => {
                event.preventDefault();

                _this.showModalRegister({
                    doneCallback: response => {
                        let {organizer, user} = response.data,
                            html = swig.render(_this.templates.row, {
                                locals: {
                                    organizer,
                                    user,
                                },
                            })
                        ;

                        _this.objects.$table_tbody.append(html);
                    },
                    failCallback: (e, data) => {}
                });
            })
            .on('click', '[data-action=edit]', event => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    $targetRow = $this.closest('tr[data-id]'),
                    targetId = $targetRow.data('id')
                ;

                _this.showModalUpdate({
                    id: targetId,
                    doneCallback: response => {
                        let {organizer, user} = response.data,
                            html = swig.render(_this.templates.row, {
                                locals: {
                                    organizer,
                                    user,
                                },
                            })
                        ;

                        $targetRow.replaceWith(html);
                    },
                    failCallback: (e, data) => {}
                });
            })
        ;
    };

    /**
     * @memberOf pageAdminCMEOrganizers
     * @function init
     */
    _this.init = data => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$table = $('#table_cme_organizers');
        _this.objects.$table_tbody = _this.objects.$table.find('tbody');

        _this.templates = {
            modalRegisterContent: multiline(()=>{/*!@preserve
            <form class="form" id="form_register_organizer">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control" name="name" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Official name</label>
                            <input class="form-control" name="official_name" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input class="form-control" name="email" />
                </div>
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input class="form-control" name="password" type="password" />
                </div>
                <div class="form-group">
                    <label class="control-label">Country</label>
                    <select class="form-control chosen" name="country_id">
                        <option value="">Select country</option>
                    {% for country in countries %}
                        <option value="{{country.id}}">{{country.niceName}}</option>
                    {% endfor %}
                    </select>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Phone number</label>
                            <select class="form-control chosen" name="phone_country_code">
                            <option value="">Select country</option>
                            {% for country in countries %}
                                <option value="{{country.phoneCountryCode}}">{{country.niceName}} ({{country.phoneCountryCode}})</option>
                            {% endfor %}
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">&nbsp;</label>
                            <input class="form-control" name="phone_number" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Description</label>
                    <textarea class="form-control vertical" name="description">{{organizer.description}}</textarea>
                </div>
            </form>
            */console.log}),
            modalUpdateContent: multiline(()=>{/*!@preserve
            <form class="form" id="form_register_organizer">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control" name="name" value="{{organizer.name}}" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Official name</label>
                            <input class="form-control" name="official_name" value="{{organizer.officialName}}" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Country</label>
                    <select class="form-control chosen" name="country_id">
                        <option value="">Select country</option>
                    {% for country in countries %}
                        <option
                            value="{{country.id}}"
                        {% if country.id == user.countryId %}selected{% endif %}
                        >{{country.niceName}}</option>
                    {% endfor %}
                    </select>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Phone number</label>
                            <select class="form-control chosen" name="phone_country_code">
                            <option value="">Select country</option>
                            {% for country in countries %}
                                <option
                                    value="{{country.phoneCountryCode}}"
                                {% if country.phoneCountryCode == user.phoneCountryCode %}selected{% endif %}
                                >{{country.niceName}} ({{country.phoneCountryCode}})</option>
                            {% endfor %}
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">&nbsp;</label>
                            <input class="form-control" name="phone_number" value="{{user.phoneNumber}}" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Description</label>
                    <textarea class="form-control vertical" name="description">{{organizer.description}}</textarea>
                </div>
            </form>
            */console.log}),
            row: multiline(()=>{/*!@preserve
            <tr data-id="{{organizer.id}}">
                <td>
                {% if organizer.profileImageUrl %}
                    <img
                        class="img-rounded"
                        src="{{organizer.profileImageUrl}}"
                        alt="{{organizer.name}}"
                        style="height:20px;vertical-align:top;"
                    />
                {% endif %}
                    {{organizer.name}}
                </td>
                <td>{{organizer.officialName}}</td>
                <td>{{user.phoneNumber}}</td>
                <td>{{user.email}}</td>
                <td>{{organizer.description}}</td>
                <td><a class="btn btn-xs btn-default" data-action="edit"><i class="fa fa-edit" /> Update</a></td>
            </tr>
            */console.log}),
        };

        _this.bindEvents();
    };

    /**
     * @memberOf pageAdminCMEOrganizers
     * @function destroy
     */
    _this.destroy = () => {};

    return {
        init: _this.init,
        destroy: _this.destroy
    }
};
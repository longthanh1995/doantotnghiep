/**
 * @namespace moduleSettingsTeleconsults
 */
module.exports = function (sandbox) {
    let _this = this;

    /**
     * @memberOf moduleSettingsTeleconsults
     * @function activateChat
     * @param availability
     * @param doneCallback
     * @param failCallback
     */
    _this.activateChat = ({ doneCallback, failCallback }) => {
        sandbox.emit('service/teleconsultSettings/updateChatAvailability', { availability: true, doneCallback, failCallback })
    };

    /**
     * @memberOf moduleSettingsTeleconsults
     * @function deactivateChat
     * @param availability
     * @param doneCallback
     * @param failCallback
     */
    _this.deactivateChat = ({ doneCallback, failCallback }) => {
        sandbox.emit('service/teleconsultSettings/updateChatAvailability', { availability: false, doneCallback, failCallback })
    };

    /**
     * @memberOf moduleSettingsTeleconsults
     * @function activateVideo
     * @param availability
     * @param doneCallback
     * @param failCallback
     */
    _this.activateVideo = ({ doneCallback, failCallback }) => {
        sandbox.emit('service/teleconsultSettings/updateVideoAvailability', { availability: true, doneCallback, failCallback })
    };

    /**
     * @memberOf moduleSettingsTeleconsults
     * @function deactivateVideo
     * @param availability
     * @param doneCallback
     * @param failCallback
     */
    _this.deactivateVideo = ({ doneCallback, failCallback }) => {
        sandbox.emit('service/teleconsultSettings/updateVideoAvailability', { availability: false, doneCallback, failCallback })
    };

    /**
     * @memberOf moduleSettingsTeleconsults
     * @function showLoadingOverlay
     */
    _this.showLoadingOverlay = () => {
        _this.objects.$overlayLoading.removeClass('hide');
    };

    /**
     * @memberOf moduleSettingsTeleconsults
     * @function hideLoadingOverlay
     */
    _this.hideLoadingOverlay = () => {
        _this.objects.$overlayLoading.addClass('hide');
    };

    /**
     * @memberOf moduleSettingsTeleconsults
     * @function renderFormChatAvailability
     * @param data
     */
    _this.renderFormChatAvailability = (data) => {
        let html = swig.render(_this.templates.formChatAvailability, {
            locals: data
        });
        _this.objects.$formChatAvailability.html(html);
    };

    /**
     * @memberOf moduleSettingsTeleconsults
     * @function renderFormChatFeeSettings
     * @param data
     */
    _this.renderFormChatFeeSettings = (data) => {
        let html = swig.render(_this.templates.formChatFeeSettings, {
            locals: data
        });
        _this.objects.$formChatFeeSettings.html(html);
    };

    /**
     * @memberOf moduleSettingsTeleconsults
     * @function renderFormVideoAvailability
     * @param data
     */
    _this.renderFormVideoAvailability = (data) => {
        let html = swig.render(_this.templates.formVideoAvailability, {
            locals: data
        });
        _this.objects.$formVideoAvailability.html(html);
    };

    /**
     * @memberOf moduleSettingsTeleconsults
     * @function renderFormVideoFeeSettings
     * @param data
     */
    _this.renderFormVideoFeeSettings = (data) => {
        console.log('data', data);
        let html = swig.render(_this.templates.formVideoFeeSettings, {
            locals: data
        });
        _this.objects.$formVideoFeeSettings.html(html);
    };

    /**
     * @memberOf moduleSettingsTeleconsults
     * @function render
     */
    _this.render = () => {
        _this.showLoadingOverlay();
        sandbox.emit('service/teleconsultSettings/fetchDoctorInfo', {
            doneCallback: (data) => {
                let formChatAvailabilityHtml = swig.render(_this.templates.formChatAvailability, {
                    locals: data,
                }),
                    formChatFeeSettingsHtml = swig.render(_this.templates.formChatFeeSettings, {
                        locals: data.chatFee,
                    }),
                    formVideoAvailabilityHtml = swig.render(_this.templates.formVideoAvailability, {
                        locals: data,
                    }),
                    formVideoFeeSettingsHtml = swig.render(_this.templates.formVideoFeeSettings, {
                        locals: data.videoFee,
                    });

                console.log(data);
                _this.objects.$formChatAvailability.append(formChatAvailabilityHtml);
                _this.objects.$formChatFeeSettings.append(formChatFeeSettingsHtml);
                _this.objects.$formVideoAvailability.append(formVideoAvailabilityHtml);
                _this.objects.$formVideoFeeSettings.append(formVideoFeeSettingsHtml);
                _this.hideLoadingOverlay();
            },
            failCallback: (e, data) => {
                _this.renderMessage({
                    message: 'Cannot load your fee settings for tele-consults. Please try again later.',
                    level: 'warning'
                });
                _this.hideLoadingOverlay();
            }
        });
    };

    _this.renderMessage = ({ message, level }) => {
        let html = swig.render(_this.templates.message, {
            locals: { message, level }
        });
        _this.objects.$message.html(html);
    };

    /**
     * @memberOf moduleSettingsTeleconsults
     * @function bindEvents
     */
    _this.bindEvents = () => {
        _this.objects.$formChatAvailability
            .on('change', '[name=available_chat]', (event) => {
                let isChecked = $(event.currentTarget).prop('checked');

                _this.showLoadingOverlay();

                if (isChecked) {
                    _this.activateChat({
                        doneCallback: (data) => {
                            _this.renderFormChatAvailability(data);
                            sandbox.emit('window/notify/show', {
                                icon: 'fa fa-check',
                                message: 'Updated chat availability successfully',
                                type: 'success'
                            });
                            _this.hideLoadingOverlay();
                        },
                        failCallback: (e, data) => {
                            let message = '';

                            if (e
                                && e.responseJSON
                                && e.responseJSON.message
                                && e.responseJSON.message.length) {
                                message = e.responseJSON.message;
                            } else {
                                message = 'Cannot update chat availability. Please try again later.';
                            }

                            sandbox.emit('window/notify/show', {
                                icon: 'fa fa-warning-sign',
                                message,
                                type: 'warning'
                            });
                            _this.hideLoadingOverlay();
                        }
                    });
                } else {
                    _this.deactivateChat({
                        doneCallback: (data) => {
                            _this.renderFormChatAvailability(data);
                            sandbox.emit('window/notify/show', {
                                icon: 'fa fa-check',
                                message: 'Updated chat availability successfully',
                                type: 'success'
                            });
                            _this.hideLoadingOverlay();
                        },
                        failCallback: (e, data) => {
                            let message = '';

                            if (e
                                && e.responseJSON
                                && e.responseJSON.message
                                && e.responseJSON.message.length) {
                                message = e.responseJSON.message;
                            } else {
                                message = 'Cannot update chat availability. Please try again later.';
                            }

                            sandbox.emit('window/notify/show', {
                                icon: 'fa fa-warning-sign',
                                message,
                                type: 'warning'
                            });
                            _this.hideLoadingOverlay();
                        }
                    });
                }
            })
            ;

        _this.bindFormChatFeeSettingsEvents();

        _this.objects.$formVideoAvailability
            .on('change', '[name=available_video]', (event) => {
                let isChecked = $(event.currentTarget).prop('checked');

                _this.showLoadingOverlay();

                if (isChecked) {
                    _this.activateVideo({
                        doneCallback: (data) => {
                            _this.renderFormVideoAvailability(data);
                            sandbox.emit('window/notify/show', {
                                icon: 'fa fa-check',
                                message: 'Updated video availability successfully',
                                type: 'success'
                            });
                            _this.hideLoadingOverlay();
                        },
                        failCallback: (e, data) => {
                            let message = '';

                            if (e
                                && e.responseJSON
                                && e.responseJSON.message
                                && e.responseJSON.message.length) {
                                message = e.responseJSON.message;
                            } else {
                                message = 'Cannot update video availability. Please try again later.';
                            }

                            sandbox.emit('window/notify/show', {
                                icon: 'fa fa-warning-sign',
                                message: e.message,
                                type: 'warning'
                            });
                            _this.hideLoadingOverlay();
                        }
                    });
                } else {
                    _this.deactivateVideo({
                        doneCallback: (data) => {
                            _this.renderFormVideoAvailability(data);
                            sandbox.emit('window/notify/show', {
                                icon: 'fa fa-check',
                                message: 'Updated video availability successfully',
                                type: 'success'
                            });
                            _this.hideLoadingOverlay();
                        },
                        failCallback: (e, data) => {
                            let message = '';

                            if (e
                                && e.responseJSON
                                && e.responseJSON.message
                                && e.responseJSON.message.length) {
                                message = e.responseJSON.message;
                            } else {
                                message = 'Cannot update video availability. Please try again later.';
                            }

                            sandbox.emit('window/notify/show', {
                                icon: 'fa fa-warning-sign',
                                message,
                                type: 'warning'
                            });
                            _this.hideLoadingOverlay();
                        }
                    });
                }
            })
            ;

        _this.bindFormVideoFeeSettingsEvents();
    };

    /**
     * @memberOf moduleSettingsTeleconsults
     * @function bindFormChatFeeSettingsEvents
     */
    _this.bindFormChatFeeSettingsEvents = () => {
        _this.objects.$formChatFeeSettings.validate({
            rules: {
                initial_message_fee: {
                    required: true,
                    number: true,
                },
                subsequent_message_fee: {
                    required: true,
                    number: true,
                },
                summary_fee: {
                    required: true,
                    number: true,
                },
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

                let $form = _this.objects.$formChatFeeSettings;

                let isSubmitting = parseInt($form.data('is-submitting'));

                if (isSubmitting) {
                    return;
                }

                let formData = $form.serialize();
                $form.data('is-submitting', 1);
                _this.showLoadingOverlay();

                sandbox.emit('service/teleconsultSettings/updateChatFeeSettings', {
                    data: formData,
                    doneCallback: (data) => {
                        _this.renderFormChatFeeSettings(data);
                        _this.bindFormChatFeeSettingsEvents();
                        $form.data('is-submitting', 0);
                        sandbox.emit('window/notify/show', {
                            icon: 'fa fa-check',
                            message: 'Updated chat fee settings successfully',
                            type: 'success'
                        });
                        _this.hideLoadingOverlay();
                    },
                    failCallback: (e, data) => {
                        let message = '';

                        if (e
                            && e.responseJSON
                            && e.responseJSON.message
                            && e.responseJSON.message.length) {
                            message = e.responseJSON.message;
                        } else {
                            message = 'Cannot update chat fee settings. Please try again later.';
                        }

                        sandbox.emit('window/notify/show', {
                            icon: 'fa fa-warning-sign',
                            message,
                            type: 'warning'
                        });

                        $form.data('is-submitting', 0);
                        _this.hideLoadingOverlay();
                    }
                })
            }
        });
    }

    /**
     * @memberOf moduleSettingsTeleconsults
     * @function bindFormVideoFeeSettingsEvents
     */
    _this.bindFormVideoFeeSettingsEvents = () => {
        _this.objects.$formVideoFeeSettings.validate({
            rules: {
                initial_minute_fee: {
                    required: true,
                    number: true,
                },
                subsequent_minute_fee: {
                    required: true,
                    number: true,
                },
                summary_fee: {
                    required: true,
                    number: true,
                },
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

                let $form = _this.objects.$formVideoFeeSettings;

                let isSubmitting = parseInt($form.data('is-submitting'));

                if (isSubmitting) {
                    return;
                }

                let formData = $form.serialize();
                $form.data('is-submitting', 1);
                _this.showLoadingOverlay();

                sandbox.emit('service/teleconsultSettings/updateVideoFeeSettings', {
                    data: formData,
                    doneCallback: (data) => {
                        _this.renderFormVideoFeeSettings(data);
                        _this.bindFormVideoFeeSettingsEvents();
                        $form.data('is-submitting', 0);
                        sandbox.emit('window/notify/show', {
                            icon: 'fa fa-check',
                            message: 'Updated video fee settings successfully',
                            type: 'success'
                        });
                        _this.hideLoadingOverlay();
                    },
                    failCallback: (e, data) => {
                        let message = '';

                        if (e
                            && e.responseJSON
                            && e.responseJSON.message
                            && e.responseJSON.message.length) {
                            message = e.responseJSON.message;
                        } else {
                            message = 'Cannot update video fee settings. Please try again later.';
                        }

                        sandbox.emit('window/notify/show', {
                            icon: 'fa fa-warning-sign',
                            message,
                            type: 'warning'
                        });
                        $form.data('is-submitting', 0);
                        _this.hideLoadingOverlay();
                    }
                })
            }
        });
    }

    /**
     * @memberOf moduleSettingsTeleconsults
     * @function init
     * @param data
     */
    _this.init = ({ data }) => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$container = $('#box_teleconsult_settings');
        _this.objects.$overlayLoading = _this.objects.$container.children('.overlay');
        _this.objects.$body = _this.objects.$container.children('.box-body');
        _this.objects.$formChatAvailability = _this.objects.$body.children('#form_chat_availability');
        _this.objects.$formChatFeeSettings = _this.objects.$body.children('#form_chat_fee_settings');
        _this.objects.$formVideoAvailability = _this.objects.$body.children('#form_video_availability');
        _this.objects.$formVideoFeeSettings = _this.objects.$body.children('#form_video_fee_settings');
        _this.objects.$message = _this.objects.$body.children('#message');

        _this.templates = {};
        _this.templates.formChatAvailability = multiline(() => {/*!@preserve
        <h4 class="text-uppercase">
            <div class="checkbox">
                <label>
                  <input type="checkbox" name="available_chat" {% if availableChat %}checked="checked"{% endif %}> Chat
                </label>
            </div>
        </h4>
        */console.log
        });
        _this.templates.formChatFeeSettings = multiline(() => {/*!@preserve
        <div class="form-group">
            <label class="col-xs-3 control-label">First 5 messages</label>
            <div class="col-xs-9">
                <input class="form-control" name="initial_message_fee" value="{{initialMessageFee}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">Subsequent message</label>
            <div class="col-xs-9">
                <input class="form-control" name="subsequent_message_fee" value="{{subsequentMessageFee}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">Consult summary</label>
            <div class="col-xs-9">
                <input class="form-control" name="summary_fee" value="{{summaryFee}}"/>
            </div>
        </div>
       <input type="hidden" name="currency" value="{{currency}}"/>
        <div class="form-group">
            <label class="col-xs-3 control-label">Currency</label>
            <div class="col-xs-9">
                <p class="form-control-static">{{currency}}</p>
                
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-9 col-xs-push-3">
                <button class="btn btn-primary" type="submit">Submit</button>
                <button class="btn btn-default" type="reset">Reset</button>
            </div>
        </div>
        */console.log
        });
        _this.templates.formVideoAvailability = multiline(() => {/*!@preserve
        <h4 class="text-uppercase">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="available_video" {% if availableVideo %}checked="checked"{% endif %}> Video
                </label>
            </div>
        </h4>
        */console.log
        });
        _this.templates.formVideoFeeSettings = multiline(() => {/*!@preserve
        <div class="form-group">
            <label class="col-xs-3 control-label">First 3 minutes</label>
            <div class="col-xs-9">
                <input class="form-control" name="video_initial_block" value="{{initialMinuteFee}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">Subsequent minute</label>
            <div class="col-xs-9">
                <input class="form-control" name="video_sub_minute" value="{{subsequentMinuteFee}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">Consult summary</label>
            <div class="col-xs-9">
                <input class="form-control" name="video_consult_summary" value="{{summaryFee}}"/>
            </div>
        </div>
        <input type="hidden" name="currency" value="{{currency}}"/>
        <div class="form-group">
            <label class="col-xs-3 control-label">Currency</label>
            <div class="col-xs-9">
                <p class="form-control-static">{{currency}}</p>
                
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-9 col-xs-push-3">
                <button class="btn btn-primary" type="submit">Submit</button>
                <button class="btn btn-default" type="reset">Reset</button>
            </div>
        </div>
        */console.log
        });
        _this.templates.message = multiline(() => {/*!@preserve
        <div class="alert alert-dismissable alert-{{level}}" role="alert">
            {{message}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        */console.log
        });

        _this.render();
        _this.bindEvents();
    };

    /**
     * @memberOf moduleSettingsTeleconsults
     * @function destroy
     */
    _this.destroy = () => { };

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
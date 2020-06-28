/**
 * @module moduleProfileAvatar
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    _this.bindEvents = () => {
        _this.objects.$container
            .on('click', '[data-action=changePassword]', (event) => {
                event.preventDefault();

                var message = swig.render(_this.templates.formChangePassword, {
                    locals: {
                        doctorId: _this.data.doctorId
                    }
                });

                var $modal = bootbox.dialog({
                    title: 'Change password',
                    className: 'modal-change-password',
                    backdrop: true,
                    onEscape: true,
                    message: message,
                    buttons: {
                        submit: {
                            label: 'Submit',
                            className: 'btn btn-danger',
                            callback: function () {
                                var $form = $(this).find('form');

                                $form.submit();

                                return false;
                            }
                        }
                    }
                });

                $modal
                    .on('shown.bs.modal', function(){
                        var $form = $modal.find('form');

                        $form.validate({
                            rules: {
                                new_password: {
                                    required: true,
                                    minlength: 6,
                                    maxlength: 30
                                },
                                new_password_retype: {
                                    required: true,
                                    minlength: 6,
                                    maxlength: 30
                                }
                            },

                            errorElement: "p",
                            errorClass: "help-block",

                            errorPlacement: function(error, element) {
                                element.closest('div').append(error);
                            },

                            highlight: function(element) {
                                $(element).closest('div').addClass('has-error');
                            },

                            unhighlight: function (element) {
                                $(element).closest('div').removeClass('has-error');
                            },

                            submitHandler: function(form, event){
                                event.preventDefault();

                                var isSubmitting = parseInt($form.data('is-submitting'));

                                if(isSubmitting){
                                    return;
                                }

                                var formData = $(form).serialize();

                                sandbox.emit('window/loading/show');
                                $form.data('is-submitting', 1);
                                $modal.find(':input').prop('disabled', true);

                                var request = $.ajax({
                                    url: laroute.route('profile.changePasswordSubmit'),
                                    method: "POST",
                                    data: formData,
                                    dataType: "json"
                                });

                                request
                                    .done(function(response) {
                                        var message = '';
                                        if(response
                                            && response.name){
                                            message = 'Password of doctor <b>' + response.name + '</b> has been updated.'
                                        } else {
                                            message = 'Request has been processed successfully.';
                                        }
                                        bootbox.alert(message, function(){
                                            $modal.modal('hide');
                                            sandbox.emit('window/loading/hide');
//                                              window.location.reload();
                                        });
                                    })
                                    .fail(function(e, data) {
                                        var message = '';
                                        if(e
                                            && e.responseJSON
                                            && e.responseJSON.message
                                            && e.responseJSON.message.length){
                                            message = e.responseJSON.message;
                                        } else {
                                            message = 'The request cannot be processed';
                                        }
                                        bootbox.alert(message, function(){
                                            $form.data('is-submitting', 0);
                                            $modal.find(':input').prop('disabled', false);
                                            sandbox.emit('window/loading/hide');
                                        });
                                    })
                                    .always(function(){

                                    })
                            }
                        })
                    })
                ;
            })
        ;
    }

    _this.init = (data) => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$container = $('#box_security');

        _this.templates = {};
        _this.templates.formChangePassword = multiline(function(){/*!@preserve
        <form class="form" data-is-submitting="0">
            <input type="hidden" name="doctor_id" value="{{doctorId}}"/>
            <div class="form-group">
                <label for="newPassword">New password</label>
                <input class="form-control" name="new_password" type="password" value=""/>
            </div>
            <div class="form-group">
                <label for="newPasswordRetype">New password retype</label>
                <input class="form-control" name="new_password_retype" type="password" value=""/>
            </div>
        </form>
        */console.log});

        _this.data.doctorId = _this.objects.$container.find('[data-action=changePassword]').data('doctor-id');

        _this.bindEvents();
    }

    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
const _get = require('lodash/get');
const assetsBaseUrl = 'https://appointmentmanadr.blob.core.windows.net/images';

/**
 * @namespace pageAdminBroadcastEdit
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @memberOf pageAdminBroadcastEdit
     * @function render
     */
    _this.render = () => {
        _this.objects.$textAreaFullContent.wysihtml5();
    };

    _this.bindEvents = () => {
        _this.objects.$groupAuthorIcon
            .dropzone({
                acceptedFiles: '.jpg, .jpeg, .png',
                paramName: 'file',
                previewsContainer: false,
                clickable: '#form_edit_article__group_author_icon__button',
                previewTemplate: `<img data-dz-thumbnail/>`,
                url: laroute.route('admin.file.store'),
                autoProcessQueue: true,
                params: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                processing: () => {
                    _this.objects.$groupAuthorIcon_loadingOverlay.removeClass('hide');
                },
                success: (file, response) => {
                    let uploadedPreviewUrl = _get(response, 'file.preview_url');

                    _this.objects.$authorIcon.attr('src', uploadedPreviewUrl);
                    _this.objects.$inputAuthorIcon.val(uploadedPreviewUrl);
                    _this.objects.$groupAuthorIcon_loadingOverlay.addClass('hide');
                }
            })
        ;

        _this.objects.$groupBanner
            .dropzone({
                acceptedFiles: '.jpg, .jpeg, .png',
                paramName: 'file',
                previewsContainer: false,
                clickable: '#form_edit_article__group_banner__button',
                previewTemplate: `<img data-dz-thumbnail/>`,
                url: laroute.route('admin.file.store'),
                autoProcessQueue: true,
                params: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                processing: () => {
                    _this.objects.$groupBanner_loadingOverlay.removeClass('hide');
                },
                success: (file, response) => {
                    let uploadedPreviewUrl = _get(response, 'file.preview_url');

                    _this.objects.$banner.attr('src', uploadedPreviewUrl);
                    _this.objects.$inputBanner.val(uploadedPreviewUrl);
                    _this.objects.$groupBanner_loadingOverlay.addClass('hide');
                }
            })
        ;

        _this.objects.$groupMediaThumbnail
            .dropzone({
                acceptedFiles: '.jpg, .jpeg, .png',
                paramName: 'file',
                previewsContainer: false,
                clickable: '#form_edit_article__group_media_thumbnail__button',
                previewTemplate: `<img data-dz-thumbnail/>`,
                url: laroute.route('admin.file.store'),
                autoProcessQueue: true,
                params: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                processing: () => {
                    _this.objects.$groupMediaThumbnail_loadingOverlay.removeClass('hide');
                },
                success: (file, response) => {
                    let uploadedPreviewUrl = _get(response, 'file.preview_url');

                    _this.objects.$mediaThumbnail.attr('src', uploadedPreviewUrl);
                    _this.objects.$inputMediaThumbnail.val(uploadedPreviewUrl);
                    _this.objects.$groupMediaThumbnail_loadingOverlay.addClass('hide');
                }
            })
        ;

        _this.objects.$selectMediaType
            .on('change', event => {
                let $this = $(event.currentTarget),
                    selectedMediaType = _this.objects.$form.find('[name="media[type]"]:checked').val()
                ;
                console.log('selectedMediaType', selectedMediaType);
                switch(selectedMediaType){
                    case 'youtube':
                        _this.objects.$groupMediaThumbnail.addClass('hide');
                        _this.objects.$groupMediaVideo.removeClass('hide');
                        break;
                    case 'image':
                        _this.objects.$groupMediaThumbnail.removeClass('hide');
                        _this.objects.$groupMediaVideo.addClass('hide');
                        break;
                }
            })
            .trigger('change')
        ;

        _this.objects.$form
            .on('reset', (event) => {
                _this.objects.$authorIcon.attr('src', _this.data.initialAuthorIconUrl);
                _this.objects.$banner.attr('src', _this.data.initialBannerUrl);
            })
        ;

        _this.objects.$form.validate({
            title: {
                required: true,
            },
            short_content: {
                required: true,
            },
            full_content: {
                required: true,
            },
            author_name: {
                required: true,
            },
            author_icon_url: {
                required: true,
            },
            banner_url: {
                required: true,
            },
            ignore: ":hidden:not(select)",
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
                let $form = $(form),
                    id = $form.data('id'),
                    isSubmitting = parseInt($form.data('is-submitting'))
                ;

                if(isSubmitting){
                    return;
                }
                let formData = $form.serialize();
                sandbox.emit('window/loading/show');
                $form.data('is-submitting', 1);
                $form.find(':input').prop('disabled', true);

                let request = $.ajax({
                    url: laroute.route('admin.broadcast.update', {id}),
                    method: 'PUT',
                    data: formData,
                    dataType: 'json',
                });

                request
                    .done((response) => {
                        let message = `Article has been updated successfully.`;
                        bootbox.alert(message, () => {
                            let url = laroute.route('admin.broadcast.show', {id});
                            window.location.href = url;
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
                            $form.find(':input').prop('disabled', false);
                            $form.data('is-submitting', 0);
                            sandbox.emit('window/loading/hide');
                        });
                    })
                ;
            }
        })
    };

    _this.init = ({data}) => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$form = $('#form_edit_article');
        _this.objects.$textAreaFullContent = $('[name=full_content]');

        _this.objects.$groupBanner = $('#form_edit_article__group_banner');
        _this.objects.$groupBanner_loadingOverlay = _this.objects.$groupBanner.find('.overlay');
        _this.objects.$banner = $('#form_edit_article__group_banner__preview img');
        _this.objects.$inputBanner = $('[name=banner_url]');

        _this.objects.$groupAuthorIcon = $('#form_edit_article__group_author_icon');
        _this.objects.$groupAuthorIcon_loadingOverlay = _this.objects.$groupAuthorIcon.find('.overlay');
        _this.objects.$authorIcon = $('#form_edit_article__group_author_icon__preview img');
        _this.objects.$inputAuthorIcon = $('[name=author_icon_url]');

        _this.objects.$selectMediaType = $('[name="media[type]"]');
        _this.objects.$groupMediaVideo = $('#form_edit_article__group_media_video');
        _this.objects.$groupMediaThumbnail = $('#form_edit_article__group_media_thumbnail');
        _this.objects.$groupMediaThumbnail_loadingOverlay = _this.objects.$groupMediaThumbnail.find('.overlay');
        _this.objects.$mediaThumbnail = $('#form_edit_article__group_media_thumbnail__preview img');
        _this.objects.$inputMediaThumbnail = $('[name="media[thumb_url]"]');

        _this.data.initialAuthorIconUrl = _this.objects.$inputAuthorIcon.val();
        _this.data.initialBannerUrl = _this.objects.$inputBanner.val();

        _this.render();
        _this.bindEvents();
    };

    _this.destroy = () => {};

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
}
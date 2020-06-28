/**
 * @module moduleProfileAvatar
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    _this.handleUploader = () => {
        _this.objects.$avatarImage
            .dropzone({
                acceptedFiles: '.jpg, .jpeg, .png',
                paramName: 'avatar',
                previewsContainer: false,
                // clickable: '#box_avatar__button_change',
                url: laroute.route('profile.avatarUpload'),
                autoProcessQueue: true,
                params: {
                _token: $('meta[name="csrf-token"]').attr('content')
                },
                processing: function(){
                    _this.objects.$avatarOverlay.removeClass('hide');
                },
                success: function(file, response){
                    _this.objects.$avatarImage.attr('src', response.newAvatarUrl);
                    _this.objects.$avatarOverlay.addClass('hide');
                    $.notify({message: 'Profile image changed successfully'},{ type: 'success'});
                }
            })
        ;
    }

    _this.handleFormToggle = () => {
        _this.objects.$container
            .on('click', '[data-action=edit]', (event) => {
                event.preventDefault();

                _this.objects.$form.toggleClass('editing');
                _this.objects.$form.trigger('reset');

                if(_this.objects.$form.hasClass('editing')){
                    _this.handleUploader();
                } else {
                    if(_this.objects.$avatarImage[0].dropzone){
                        _this.objects.$avatarImage[0].dropzone.destroy();
                    }
                }
            })
        ;
    }

    _this.handleFormReset = () => {
        _this.objects.$form
            .on('reset', (event) => {
                setTimeout(()=>{
                    _this.objects.$formSelectLanguages.trigger('chosen:updated');
                },0);
            })
        ;
    }

    _this.handleDatepicker = () => {
        _this.objects.$formDatepicker
            .datepicker({
                format: 'dd/mm/yyyy',
                weekStart: 1,
                minViewMode: "month",
                maxViewMode: "years",
                orientation: "bottom",
                disableTouchKeyboard: true,
                autoclose: true,
                defaultViewDate: {
                    year: 1980,
                    month: 0,
                    day: 1
                },
                startView: "years",
                startDate: "01/01/1930",
                clearBtn: true
            })
        ;
    }

    _this.handleSelectLanguages = () => {
        _this.objects.$formSelectLanguages
            .chosen({
                width: '100%'
            })
        ;
    }

    _this.handleTableEditProfessionalIds = () => {
        let nextRowIndex = _this.objects.$formTableEditProfessionalIds.find('tbody tr').length;
        _this.objects.$formTableEditProfessionalIds
            .on('click', ".btn-remove-profession", function (e) {
                e.preventDefault();

                var $this = $(this);

                bootbox.confirm("Are you sure?", function(result) {
                    if (result) {
                        $this.closest('tr').remove();
                    }
                });
            })
            .on('click', ".btn-add-profession", function (e) {
                e.preventDefault();

                var template = multiline(()=> {/*!@preserve
                <tr>
                    <td>
                        <input type="text" class="form-control input-sm" name="professions[{{ index }}][name]" placeholder="Name"/>
                    </td>

                    <td>
                        <input type="text" class="form-control input-sm" name="professions[{{ index }}][license]" placeholder="License"/>
                    </td>

                    <td class="v-middle text-center">
                        <a href="#" class="btn btn-sm btn-danger btn-remove-profession">
                            Remove
                        </a>
                    </td>
                </tr>
                */console.log});

                var rendered = swig.render(template, {
                    locals: {
                        index: nextRowIndex
                    }
                });

                _this.objects.$formTableEditProfessionalIds.find('tbody').append(rendered);

                nextRowIndex ++;
            })
        ;
    }
    
    _this.handleForm = () => {
        _this.handleDatepicker();
        _this.handleTableEditProfessionalIds();
        _this.handleSelectLanguages();

        _this.handleFormToggle();
        _this.handleFormReset();
    }

    _this.init = (data) => {
        _this.objects = {};
        _this.objects.$container = $('#box_basic_information');
        _this.objects.$avatarImage = $('#box_basic_information__image');
        _this.objects.$avatarOverlay = $('#box_basic_information__image_overlay');
        _this.objects.$form = $('#form_basic_information');
        _this.objects.$formDatepicker = _this.objects.$form.find('.datepicker');
        _this.objects.$formTableEditProfessionalIds = _this.objects.$form.find('#table_edit_professional_ids');
        _this.objects.$formSelectLanguages = $('#form_basic_information__select_languages');

        _this.handleForm();
    }

    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
/**
 * @module moduleSpecialities
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    _this.handleFormToggle = () => {
        _this.objects.$container
            .on('click', '[data-action=edit]', (event) => {
                event.preventDefault();

                _this.objects.$form.toggleClass('editing');
                _this.objects.$form.trigger('reset');
            })
        ;
    }

    _this.handleFormReset = () => {
        _this.objects.$form
            .on('reset', (event) => {
                setTimeout(()=>{
                    _this.objects.$formSelectSpecialities.trigger('chosen:updated');
                },0);
            })
        ;
    }

    _this.handleSelectSpecialities = () => {
        // _this.objects.$formSelectSpecialities
        //     .chosen({
        //         width: '100%'
        //     })
        // ;
        _this.objects.$formSelectSpecialities
            .selectize({
                delimiter:',',
                persist: false,
                create: function(input) {
                    return {
                        value: "0:" + input,
                        text: input
                    }
                }
            })
        ;
    }

    _this.handleForm = () => {
        _this.handleSelectSpecialities();

        _this.handleFormToggle();
        _this.handleFormReset();
    }

    _this.init = (data) => {
        _this.objects = {};
        _this.objects.$container = $('#box_specialities');
        _this.objects.$form = $('#form_specialities');
        _this.objects.$formSelectSpecialities = $('#form_specialities__select_specialities');

        _this.handleForm();
    }

    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
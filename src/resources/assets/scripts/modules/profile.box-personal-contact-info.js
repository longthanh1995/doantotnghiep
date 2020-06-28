/**
 * @module modulePersonalContactInfo
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
            })
        ;
    }

    _this.handleForm = () => {
        _this.handleFormToggle();
    }

    _this.init = (data) => {
        _this.objects = {};
        _this.objects.$container = $('#box_personal_contact_info');
        _this.objects.$form = $('#form_personal_contact_info');

        _this.handleForm();
    }

    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
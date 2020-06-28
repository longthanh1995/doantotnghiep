'use strict';

/**
 * @namespace pagePatientsDetails
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @memberOf pagePatientsDetails
     * @function bindEvents
     */
    _this.bindEvents = () => {
        _this.objects.$body
            .on('click', '[data-action=verify]', (event) => {
                event.preventDefault();

                let $this = $(event.currentTarget),
                    patientId = $this.data('id')
                ;

                sandbox.emit('modalVerifyPatient/show', {
                    patientId,
                    doneCallback: (response) => {
                        window.location.reload();
                    }
                });
            })
    }

    /**
     * @memberOf pagePatientsDetails
     * @function init
     * @param data {Object}
     */
    _this.init = (data) => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$body = $('body');

        _this.templates = {};

        _this.bindEvents();
    }

    /**
     * @memberOf pagePatientsDetails
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
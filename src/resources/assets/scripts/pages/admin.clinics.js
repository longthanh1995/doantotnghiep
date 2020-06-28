'use strict';

/**
 * @module pageAdminClinicDetails
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    _this.init = (data) => {

        sandbox.sub.register("modalMapPicker", require('../modules/admin.clinics.modal-map-picker.js'));
        sandbox.sub.start();
    }
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
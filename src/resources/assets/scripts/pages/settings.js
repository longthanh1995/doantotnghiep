/**
 * @module pageSettings
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function (sandbox) {
    var _this = this;

    _this.init = (data) => {
        if($('#box_appointment_types').length){
            sandbox.sub.register("boxAppointmentTypes", require("../modules/settings.box-appointment-types"));
        }
        if($('#box_time').length){
            sandbox.sub.register("boxTime", require("../modules/settings.box-time"));
        }

        if($('#box_teleconsult_settings').length){
            sandbox.sub.register("boxTeleconsults", require('../modules/settings.box-teleconsult-settings'));
        }

        sandbox.sub.start();
    }

    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
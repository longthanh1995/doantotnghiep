'use strict';

const _get = require('lodash/get');

/**
 * @namespace pageAppointmentDetails
 */
module.exports = function(sandbox){
    let _this = this;

    _this.render = () => {};
    _this.bindEvents = () => {

    };

    /**
     * @memberOf pageAppointmentDetails
     * @function init
     * @param data
     */
    _this.init = (data) => {
        _this.data = data || {};

        if($('#box_profile').length){
            sandbox.sub.register('boxProfile', require('../modules/appointment.details.box-profile'), _get(data, 'appointment'));
        }

        if($('#box_consult_summary').length){
            sandbox.sub.register('boxConsultSummary', require('../modules/appointment.details.box-consult-summary'), _get(data, 'appointment.healthSummary'));
        }

        if($('#patient_info').length){
            sandbox.sub.register('boxInfo', require('../modules/appointment.details.box-info'), _get(data, 'appointment'));
        }

        if($('#box_messages').length){
            sandbox.sub.register('boxMessages', require('../modules/appointment.details.box-messages'), _get(data, 'appointment'));
        }

        sandbox.sub.start();
    };

    /**
     * @memberOf pageAppointmentDetails
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
'use strict';

const _get = require('lodash/get');

/**
 * @namespace boxInfo
 * @param sandbox
 */
module.exports = function(sandbox){
    let _this = this;

    _this.render = () => {}

    _this.bindEvents = () => {
        _this.objects.$self
            .on('click', '[data-action=updateBookingReason]', (event) => {
                event.preventDefault();

                sandbox.emit('modalUpdateBookingReason/show', {
                    appointmentId: _get(_this.data, 'id'),
                    content: {
                        bookingReason: _get(_this.data, 'bookingReason')
                    },
                    doneCallback: () => {
                        window.location.reload();
                    }
                });
            })
    };

    _this.init = (data) => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$self = $('#patient_info');

        _this.render();
        _this.bindEvents();
    }

    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
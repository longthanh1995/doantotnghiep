'use strict';

const _get = require('lodash/get');

/**
 * @namespace boxMessage
 * @param sandbox
 */
module.exports = function(sandbox){
    let _this = this;

    _this.render = () => {}

    _this.bindEvents = () => {
        _this.objects.$self
            .on('click', '[data-action=sendMessage]', (event) => {
                event.preventDefault();

                let appointmentId = _get(_this.data,'id');

                sandbox.emit('modalSendAppointmentMessage/show', {
                    appointmentId,
                    doneCallback: (response) => {
                        window.location.reload();
                    }
                })
            })
    };

    _this.init = (data) => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$self = $('#box_messages');

        _this.render();
        _this.bindEvents();
    }

    _this.destroy = () => {}
}
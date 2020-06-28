'use strict';

/**
 * @namespace boxHealthSummary
 * @memberOf pageAppointmentDetails
 */
module.exports = function(sandbox){
    let _this = this;

    _this.render = () => {}

    /**
     * @memberOf boxHealthSummary
     * @function bindEvents
     */
    _this.bindEvents = () => {
        _this.objects.$self
            .on('click', '[data-action=add]', (event) => {
                sandbox.emit('modalHealthSummary/showAdd', {
                    appointmentId: _this.objects.$self.data('appointment-id'),
                    doneCallback: () => {
                        window.location.reload();
                    }
                });
            })
            .on('click', '[data-action=update]', (event) => {
                sandbox.emit('modalHealthSummary/showUpdate', {
                    appointmentId: _this.objects.$self.data('appointment-id'),
                    content: {
                        title: _this.data.title,
                        summary: _this.data.summary,
                        plan: _this.data.plan,
                        visitDoctorIf: _this.data.visitDoctorIf
                    },
                    doneCallback: () => {
                        window.location.reload();
                    }
                });
            })
    }

    /**
     * @memberOf boxHealthSummary
     * @function init
     * @param data
     */
    _this.init = (data) => {
        _this.data = data || {};

        _this.objects = {};
        _this.objects.$self = $('#box_consult_summary');

        _this.bindEvents();
    }

    /**
     * @memberOf boxHealthSummary
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
/**
 * @module serviceAdminAppointments
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function (sandbox) {
    let _this = this;

    /**
     * @module serviceAdminAppointments
     * @function list
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.cancel = ({appointmentId, data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.appointment.cancel', {
                appointment: appointmentId
            }),
            method: 'POST',
            data,
            dataType: 'json',
        });

        request
            .done((response) => {
                if ('function' === typeof doneCallback) {
                    doneCallback(humps.camelizeKeys(response));
                }
            })
            .fail((e, data) => {
                if ('function' === typeof failCallback) {
                    failCallback(e, data);
                }
            })
        ;
    };

    sandbox.on('service/admin/appointments/cancel', ({appointmentId, data = {}, doneCallback = null, failCallback = null}) => _this.cancel({
        appointmentId,
        data,
        doneCallback,
        failCallback
    }));

    /**
     * @module serviceAdminAppointments
     * @function init
     * @param data
     */
    _this.init = (data) => {
    };

    /**
     * @module serviceAdminAppointments
     * @function destroy
     */
    _this.destroy = () => {
    };

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
}
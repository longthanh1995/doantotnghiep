/**
 * @module serviceDoctorAppointments
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function (sandbox) {
    let _this = this;

    /**
     * @module serviceDoctorAppointments
     * @function list
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.create = ({data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('appointment.store'),
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

    sandbox.on('service/doctor/appointments/create', ({data = {}, doneCallback = null, failCallback = null}) => _this.create({
        data,
        doneCallback,
        failCallback
    }));

    /**
     * @module serviceDoctorAppointments
     * @function init
     * @param data
     */
    _this.init = (data) => {
    };

    /**
     * @module serviceDoctorAppointments
     * @function destroy
     */
    _this.destroy = () => {
    };

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
}
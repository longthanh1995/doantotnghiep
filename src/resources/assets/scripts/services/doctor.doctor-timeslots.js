/**
 * @module serviceDoctorTimeslots
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function (sandbox) {
    let _this = this;

    /**
     * @module serviceDoctorTimeslots
     * @function list
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.list = ({data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('workingCalendar.fetchAvailableTimeslots'),
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

    sandbox.on('service/doctor/doctorTimeslots/list', ({data = {}, doneCallback = null, failCallback = null}) => _this.list({
        data,
        doneCallback,
        failCallback
    }));

    /**
     * @module serviceDoctorTimeslots
     * @function init
     * @param data
     */
    _this.init = (data) => {
    };

    /**
     * @module serviceDoctorTimeslots
     * @function destroy
     */
    _this.destroy = () => {
    };

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
}
/**
 * @module serviceClinics
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function (sandbox) {
    let _this = this;

    /**
     * @module serviceClinics
     * @function list
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.list = ({data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('api.doctor.clinics.index'),
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

    sandbox.on('service/doctor/clinics/list', ({data = {}, doneCallback = null, failCallback = null}) => _this.list({
        data,
        doneCallback,
        failCallback
    }));

    /**
     * @module serviceClinics
     * @function init
     * @param data
     */
    _this.init = (data) => {
    };

    /**
     * @module serviceClinics
     * @function destroy
     */
    _this.destroy = () => {
    };

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
}
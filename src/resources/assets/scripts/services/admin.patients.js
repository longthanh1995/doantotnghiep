/**
 * @module serviceAdminPatients
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function(sandbox) {
    let _this = this;

    /**
     * @module serviceAdminPatients
     * @function getByIDNumber
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.getByIDNumber = ({ data, doneCallback, failCallback }) => {
        let request = $.ajax({
            url: laroute.route('admin.patient.getByIdNumber'),
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

    sandbox.on('service/admin/patients/getByIdNumber', ({ data = {}, doneCallback = null, failCallback = null}) => _this.getByIDNumber({
        data,
        doneCallback,
        failCallback,
    }));

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
};
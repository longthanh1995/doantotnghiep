/**
 * @module serviceAdminSuperClinicData
 * @param sandbox
 * @returns {{init: *, destroy: *}}
 */
module.exports = function (sandbox) {
    let _this = this;

    /**
     * @module serviceAdminSuperClinicData
     * @function fetch
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.fetch = ({id, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.superClinicData.fetch', {superClinicData: id}),
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

    sandbox.on('service/superClinicData/fetch', ({id, doneCallback = null, failCallback = null}) => {
        _this.fetch({id, doneCallback, failCallback});
    });

    /**
     * @module serviceAdminSuperClinicData
     * @function init
     * @param data
     */
    _this.init = data => {
    };

    /**
     * @module serviceAdminSuperClinicData
     * @function destroy
     */
    _this.destroy = () => {
    };

    return {
        init: _this.init,
        destroy: _this.destroy
    }
};
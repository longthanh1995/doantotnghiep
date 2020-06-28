/**
 * @module serviceAdminDoctor
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @module serviceAdminDoctor
     * @function list
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.list = ({data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.doctor.search'),
            method: 'POST',
            data,
            dataType: 'json'
        });

        request
            .done((response) => {
                if('function' === typeof doneCallback){
                    doneCallback(humps.camelizeKeys(response));
                }
            })
            .fail((e, data) => {
                if('function' === typeof failCallback){
                    failCallback(e, data);
                }
            })
        ;
    };

    sandbox.on('service/adminDoctor/list', ({data, doneCallback = null, failCallback = null}) => {
        _this.list({data, doneCallback, failCallback});
    });

    /**
     * @module serviceAdminDoctor
     * @function init
     * @param data
     */
    _this.init = (data) => {};

    /**
     * @module serviceAdminDoctor
     * @function destroy
     */
    _this.destroy = () => {};

    return {
        init: _this.init,
        destroy: _this.destroy
    }
};
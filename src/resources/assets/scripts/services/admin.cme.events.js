/**
 * @module serviceAdminCME
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @module serviceAdminCME
     * @function approve
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.approve = ({id, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.cme.events.approve', {
                id,
            }),
            method: 'POST',
            data: {
                status: 1,
                comment: 'This CME Event has been approved.',
            },
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

    /**
     * @module serviceAdminCME
     * @function reject
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.reject = ({id, data: {comment}, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.cme.events.reject', {
                id,
            }),
            method: 'POST',
            data: {
                status: 0,
                comment,
            },
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

    sandbox.on('service/admin/cme/events/approve', ({id, doneCallback = null, failCallback = null}) => {
        _this.approve({id, doneCallback, failCallback})
    });
    sandbox.on('service/admin/cme/events/reject', ({id, data = {}, doneCallback = null, failCallback = null}) => {
        _this.reject({id, data, doneCallback, failCallback})
    });

    /**
     * @module serviceAdminCME
     * @function init
     * @param data
     */
    _this.init = (data) => {};

    /**
     * @module serviceAdminCME
     * @function destroy
     */
    _this.destroy = () => {};
};
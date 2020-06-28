/**
 * @module serviceAdminCMEOrganizers
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @module serviceAdminCMEOrganizers
     * @function register
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.register = ({data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.cme.organizers.register'),
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

    /**
     * @module serviceAdminCMEOrganizers
     * @function fetch
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.fetch = ({ id, doneCallback, failCallback }) => {
        let request = $.ajax({
            url: laroute.route('admin.cme.organizers.fetch', { organizer: id }),
            method: 'GET',
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
     * @module serviceAdminCMEOrganizers
     * @function update
     * @param id
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.update = ({id, data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.cme.organizers.update', {
                organizer: id,
            }),
            method: 'PATCH',
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

    sandbox.on('service/admin/cme/organizers/register', ({data = {}, doneCallback = null, failCallback = null}) => {
        _this.register({data, doneCallback, failCallback});
    });

    sandbox.on('service/admin/cme/organizers/fetch', ({ id, doneCallback = null, failCallback = null}) => {
        _this.fetch({id, doneCallback, failCallback});
    });

    sandbox.on('service/admin/cme/organizers/update', ({ id, data, doneCallback = null, failCallback = null}) => {
        _this.update({id, data, doneCallback, failCallback});
    });

    /**
     * @module serviceAdminCMEOrganizers
     * @function init
     * @param data
     */
    _this.init = (data) => {};

    /**
     * @module serviceAdminCMEOrganizers
     * @function destroy
     */
    _this.destroy = () => {};
};
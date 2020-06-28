/**
 * @module serviceConsultReason
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @module serviceConsultReason
     * @function create
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.create = ({data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.consultReason.create'),
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
    }

    /**
     * @module serviceConsultReason
     * @function fetch
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.fetch = ({id, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.consultReason.fetch', {consultReason: id}),
            method: 'POST'
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
     * @module serviceConsultReason
     * @function fetchAll
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.fetchAll = ({doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.consultReason.fetchAll'),
            method: 'POST'
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
     * @module serviceConsultReason
     * @fetch update
     * @param id
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.update = ({id, data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.consultReason.update', {consultReason: id}),
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
    }

    /**
     * @module serviceConsultReason
     * @fetch delete
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.delete = ({id, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.consultReason.delete', {consultReason: id}),
            method: 'DELETE'
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

    sandbox.on('service/consultReason/create', ({data = {}, doneCallback = null, failCallback = null}) => {
        _this.create({data, doneCallback, failCallback})
    });
    sandbox.on('service/consultReason/fetch', ({id, doneCallback = null, failCallback = null}) => {
        _this.fetch({id, doneCallback, failCallback});
    });
    sandbox.on('service/consultReason/fetchAll', ({id, doneCallback = null, failCallback = null}) => {
        _this.fetchAll({id, doneCallback, failCallback});
    });
    sandbox.on('service/consultReason/update', ({id, data, doneCallback = null, failCallback = null}) => {
        _this.update({id, data, doneCallback, failCallback})
    });
    sandbox.on('service/consultReason/delete', ({id, doneCallback = null, failCallback = null}) => {
        _this.delete({id, doneCallback, failCallback})
    });

    /**
     * @module serviceConsultReason
     * @function init
     * @param data
     */
    _this.init = (data) => {}

    /**
     * @module serviceConsultReason
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
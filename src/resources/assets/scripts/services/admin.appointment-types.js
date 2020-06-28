/**
 * @module serviceAppointmentType
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @module serviceAppointmentType
     * @function create
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.create = ({data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.appointmentType.create'),
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
     * @module serviceAppointmentType
     * @function fetch
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.fetch = ({id, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.appointmentType.fetch', {appointmentType: id}),
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
     * @module serviceAppointmentType
     * @function fetchAll
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.fetchAll = ({doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.appointmentType.fetchAll'),
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
     * @module serviceAppointmentType
     * @fetch update
     * @param id
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.update = ({id, data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.appointmentType.update', {appointmentType: id}),
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
     * @module serviceAppointmentType
     * @fetch delete
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.delete = ({id, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.appointmentType.delete', {appointmentType: id}),
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

    sandbox.on('service/appointmentType/create', ({data = {}, doneCallback = null, failCallback = null}) => {
            _this.delete({data, doneCallback, failCallback})
        });
    sandbox.on('service/appointmentType/fetch', ({id, doneCallback = null, failCallback = null}) => {
        _this.fetch({id, doneCallback, failCallback});
    });
    sandbox.on('service/appointmentType/fetchAll', ({id, doneCallback = null, failCallback = null}) => {
        _this.fetchAll({id, doneCallback, failCallback});
    });
    sandbox.on('service/appointmentType/update', ({id, data, doneCallback = null, failCallback = null}) => {
            _this.update({id, data, doneCallback, failCallback})
        });
    sandbox.on('service/appointmentType/delete', ({id, doneCallback = null, failCallback = null}) => {
            _this.delete({id, doneCallback, failCallback})
        });

    /**
     * @module serviceAppointmentType
     * @function init
     * @param data
     */
    _this.init = (data) => {};

    /**
     * @module serviceAppointmentType
     * @function destroy
     */
    _this.destroy = () => {};

    return {
        init: _this.init,
        destroy: _this.destroy
    }
};
/**
 * @module serviceHouseCallReason
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @module serviceHouseCallReason
     * @function create
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.create = ({data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.houseCallReason.create'),
            method: 'POST',
            data: data,
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
     * @module serviceHouseCallReason
     * @function fetch
     * @param id
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.fetch = ({id, data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.houseCallReason.fetch', {houseCallReason: id}),
            method: 'GET',
            data
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
     * @module serviceHouseCallReason
     * @function list
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.list = ({data = {}, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.houseCallReason.index'),
            method: 'GET',
            data: humps.decamelizeKeys(data)
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
     * @module serviceHouseCallReason
     * @fetch update
     * @param id
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.update = ({id, data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.houseCallReason.update', {houseCallReason: id}),
            method: 'PUT',
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
     * @module serviceHouseCallReason
     * @fetch delete
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.delete = ({id, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.houseCallReason.delete', {houseCallReason: id}),
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

    _this.fetchDoctors = ({id, data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.houseCallReason.fetchDoctors', {houseCallReason: id}),
            method: 'POST',
            data
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

    _this.assignDoctors = ({id, clinicId, doctorIds, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.houseCallReason.assignDoctors', {houseCallReason: id}),
            method: 'POST',
            data: {
                clinic_id: clinicId,
                doctor_ids: doctorIds,
            }
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

    _this.removeDoctor = ({id, clinicId, doctorId, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.houseCallReason.removeDoctor', {houseCallReason: id}),
            method: 'POST',
            data: {
                doctor_id: doctorId,
                clinic_id: clinicId,
            }
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

    sandbox.on('service/houseCallReason/create', ({data = {}, doneCallback = null, failCallback = null}) => {
        _this.create({data, doneCallback, failCallback})
    });
    sandbox.on('service/houseCallReason/fetch', ({id, data, doneCallback = null, failCallback = null}) => {
        _this.fetch({id, data, doneCallback, failCallback});
    });
    sandbox.on('service/houseCallReason/list', ({data = {}, doneCallback = null, failCallback = null}) => {
        _this.list({data, doneCallback, failCallback});
    });
    sandbox.on('service/houseCallReason/update', ({id, data, doneCallback = null, failCallback = null}) => {
        _this.update({id, data, doneCallback, failCallback})
    });
    sandbox.on('service/houseCallReason/delete', ({id, doneCallback = null, failCallback = null}) => {
        _this.delete({id, doneCallback, failCallback})
    });
    sandbox.on('service/houseCallReason/fetchDoctors', ({id, data, doneCallback = null, failCallback = null}) => {
        _this.fetchDoctors({id, data, doneCallback, failCallback});
    });
    sandbox.on('service/houseCallReason/assignDoctors', ({id, clinicId, doctorIds, doneCallback = null, failCallback = null}) => {
        _this.assignDoctors({id, clinicId, doctorIds, doneCallback, failCallback});
    });
    sandbox.on('service/houseCallReason/removeDoctor', ({id, clinicId, doctorId, doneCallback = null, failCallback = null}) => {
        _this.removeDoctor({id, clinicId, doctorId, doneCallback, failCallback});
    });

    /**
     * @module serviceHouseCallReason
     * @function init
     * @param data
     */
    _this.init = (data) => {}

    /**
     * @module serviceHouseCallReason
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
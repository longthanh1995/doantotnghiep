/**
 * @module serviceDoctorBookingFeeSurchargeSettings
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @module serviceDoctorBookingFeeSurchargeSettings
     * @function create
     * @param doctorBookingFeeId
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.create = ({doctorBookingFeeId, data = {}, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.doctorBookingFee.surchargeSetting.create', {
                doctorBookingFee: doctorBookingFeeId,
            }),
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
     * @module serviceDoctorBookingFeeSurchargeSettings
     * @function fetch
     * @param id
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.fetch = ({id, data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.doctorBookingFee.surchargeSetting.fetch', {surchargeSetting: id}),
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
     * @module serviceDoctorBookingFeeSurchargeSettings
     * @function list
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.list = ({doctorBookingFeeId, data = {}, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.doctorBookingFee.surchargeSetting.index', {
                doctorBookingFee: doctorBookingFeeId,
            }),
            method: 'GET',
            data: humps.decamelizeKeys(data),
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
     * @module serviceDoctorBookingFeeSurchargeSettings
     * @fetch update
     * @param id
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.update = ({id, data, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.doctorBookingFee.surchargeSetting.update', {surchargeSetting: id}),
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
     * @module serviceDoctorBookingFeeSurchargeSettings
     * @fetch delete
     * @param id
     * @param doneCallback
     * @param failCallback
     */
    _this.delete = ({id, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.doctorBookingFee.surchargeSetting.delete', {surchargeSetting: id}),
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

    sandbox.on('service/doctorBookingFee/surchargeSetting/create', ({doctorBookingFeeId, data = {}, doneCallback = null, failCallback = null}) => {
        _this.create({doctorBookingFeeId, data, doneCallback, failCallback})
    });
    sandbox.on('service/doctorBookingFee/surchargeSetting/fetch', ({id, data, doneCallback = null, failCallback = null}) => {
        _this.fetch({id, data, doneCallback, failCallback});
    });
    sandbox.on('service/doctorBookingFee/surchargeSetting/list', ({doctorBookingFeeId, data = {}, doneCallback = null, failCallback = null}) => {
        _this.list({doctorBookingFeeId, data, doneCallback, failCallback});
    });
    sandbox.on('service/doctorBookingFee/surchargeSetting/update', ({id, data, doneCallback = null, failCallback = null}) => {
        _this.update({id, data, doneCallback, failCallback})
    });
    sandbox.on('service/doctorBookingFee/surchargeSetting/delete', ({id, doneCallback = null, failCallback = null}) => {
        _this.delete({id, doneCallback, failCallback})
    });

    /**
     * @module serviceDoctorBookingFeeSurchargeSettings
     * @function init
     * @param data
     */
    _this.init = (data) => {}

    /**
     * @module serviceDoctorBookingFeeSurchargeSettings
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
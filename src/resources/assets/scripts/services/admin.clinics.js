/**
 * @module serviceAdminClinic
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @module serviceAdminClinic
     * @function setClinicWorkingWeekDays
     * @param id
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.setClinicWorkingWeekDays = ({clinicId, data = {}, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.clinic.setWorkingWeekDays', {
                clinic: clinicId,
            }),
            method: 'POST',
            data,
            dataType: 'json',
        });

        request
            .done(response => {
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
     * @module serviceAdminClinic
     * @function createHoliday
     * @param id
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.createHoliday = ({clinicId, data = {}, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.clinic.holiday.create', {
                clinic: clinicId,
            }),
            method: 'POST',
            data: humps.decamelizeKeys(data),
            dataType: 'json',
        });

        console.log('data', data);

        request
            .done(response => {
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
     * @module serviceAdminClinic
     * @function deleteHoliday
     * @param id
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.deleteHoliday = ({ clinicId, id, doneCallback, failCallback}) => {
        let request = $.ajax({
            url: laroute.route('admin.clinic.holiday.delete', {
                clinic: clinicId,
                holiday: id,
            }),
            method: 'DELETE',
        });

        request
            .done(response => {
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
     * @module serviceAdminClinic
     * @function enableQueueFeature
     * @param clinicId
     * @param doneCallback
     * @param failCallback
     */
    _this.enableQueueFeature = ({ clinicId, doneCallback, failCallback }) => {
        let request = $.ajax({
            url: laroute.route('admin.clinic.queue.enable', {
                clinic: clinicId,
            }),
            method: 'POST',
        });

        request
            .done(response => {
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
     * @module serviceAdminClinic
     * @function disableQueueFeature
     * @param clinicId
     * @param doneCallback
     * @param failCallback
     */
    _this.disableQueueFeature = ({ clinicId, doneCallback, failCallback }) => {
        let request = $.ajax({
            url: laroute.route('admin.clinic.queue.disable', {
                clinic: clinicId,
            }),
            method: 'POST',
        });

        request
            .done(response => {
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

    sandbox.on('service/admin/clinic/setWorkingWeekDays', ({clinicId, data = {}, doneCallback, failCallback}) => {
        _this.setClinicWorkingWeekDays({clinicId, data, doneCallback, failCallback});
    });

    sandbox.on('service/admin/clinic/holiday/create', ({clinicId, data = {}, doneCallback, failCallback}) => {
        _this.createHoliday({clinicId, data, doneCallback, failCallback});
    });

    sandbox.on('service/admin/clinic/holiday/delete', ({clinicId, id, doneCallback, failCallback}) => {
        _this.deleteHoliday({clinicId, id, doneCallback, failCallback});
    });

    sandbox.on('service/admin/clinic/queue/enable', ({clinicId, doneCallback, failCallback}) => {
        _this.enableQueueFeature({clinicId, doneCallback, failCallback});
    });

    sandbox.on('service/admin/clinic/queue/disable', ({clinicId, doneCallback, failCallback}) => {
        _this.disableQueueFeature({clinicId, doneCallback, failCallback});
    });

    /**
     * @module serviceAdminClinic
     * @function init
     * @param data
     */
    _this.init = data => {};

    /**
     * @module serviceAdminClinic
     * @function destroy
     */
    _this.destroy = () => {};

    return {
        init: _this.init,
        destroy: _this.destroy,
    }
}
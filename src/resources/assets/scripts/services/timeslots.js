'use strict';

const _get = require('lodash/get');
const _map = require('lodash/map');

const dashboardType = _get(globalData, 'context.dashboardType', 'doctor');

/**
 * @module serviceTimeslot
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @module serviceTimeslot
     * @fetch block
     * @param id
     * @param data
     * @param doneCallback
     * @param failCallback
     */
    _this.block = ({ids, doctorId, data, doneCallback, failCallback}) => {
        let requestRoute;
        switch(dashboardType){
            case 'admin':
                requestRoute = 'admin.doctor.workingCalendar.timeslot.block';
                break;
            case 'doctor':
            default:
                requestRoute = 'working-calendar.block';
                break;
        }

        let errorMessages = []
        ;

        //@TODO: Refactor to a single batch request
        let requests = _map(ids, (id) => {
            let request = $.ajax({
                url: laroute.route(requestRoute, {doctorTimetable: id, doctor: doctorId}),
                method: 'POST',
                data,
                dataType: 'json'
            });

            request
                .fail((e, data) => {
                    errorMessages.push(e.responseJSON.message);
                })
            ;

            return request;
        });

        $.when
            .apply(undefined, requests)
            .always(() => {
                if(errorMessages.length){
                    if('function' === typeof failCallback){
                        failCallback(errorMessages);
                    }
                } else {
                    if('function' === typeof doneCallback){
                        doneCallback();
                    }
                }
            })
        ;
    }

    sandbox.on('service/timeslot/block', ({ids, doctorId, data, doneCallback = null, failCallback = null}) => {
        _this.block({ids, doctorId, data, doneCallback, failCallback})
    });

    /**
     * @module serviceTimeslot
     * @function init
     * @param data
     */
    _this.init = (data) => {}

    /**
     * @module serviceTimeslot
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
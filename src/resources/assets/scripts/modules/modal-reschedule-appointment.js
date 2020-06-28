const _map = require('lodash/map');
const _get = require('lodash/get');
const _groupBy = require('lodash/groupBy');
const dashboardType = _get(globalData, 'context.dashboardType', 'doctor');

/**
 * @module modalRescheduleAppointment
 * @param sandbox
 * @returns {{init: ((function(*))|*), destroy: ((function())|*)}}
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @module modalRescheduleAppointment
     * @function showModalReschedule
     * @param appointmentTypeId
     * @param appointmentTypeName
     * @param appointmentTypeCategory
     * @param appointmentId
     */
    _this.showModalReschedule = ({appointmentTypeId, appointmentTypeName, appointmentTypeCategory, appointmentId, doctorId}) => {
        if(_this.data.isActive){
            return;
        }

        _this.data.isActive = true;

        if(!appointmentTypeId || !appointmentId){
            return;
        }

        let $modal = bootbox.dialog({
            title: 'Reschedule Appointment',
            message: swig.render(_this.templates.modalMessage, {
                locals: {}
            }),
            size: 'large',
            className: 'modal-reschedule-appointment'
        });

        $modal
            .on('shown.bs.modal', (event) => {
                let $formFindTimeSlots = $modal.find('#form_find_timeslots'),
                    $formFindTimeSlotsInputDate = $formFindTimeSlots.find('#form_find_timeslots__input_date'),
                    $listAvailableTimeslots = $modal.find('#list_available_timeslots'),
                    $overlayLoading = $modal.find('#overlay_loading')
                ;

                $formFindTimeSlotsInputDate.datepicker({
                    maxViewMode: "month",
                    weekStart: 1,
                    todayHighlight: true,
                    startDate: moment().format('DD/MM/YYYY'),
                    format: 'dd/mm/yyyy',
                    disableTouchKeyboard: true,
                    clearBtn: true
                });

                $listAvailableTimeslots
                    .on('click', '[data-id]', function(event) {
                        event.preventDefault();

                        let $this = $(this),
                            doctorTimetableId = $this.data('id')
                        ;

                        bootbox.confirm(`Are you sure to reschedule selected appointment to <b>${$this.data('appointment-type-name')}</b> timeslot at <b>${$this.data('date')} ${$this.text()}</b>?`, (result) => {
                            if(result){

                                $overlayLoading.removeClass('hide');

                                let requestRoute;
                                switch(dashboardType){
                                    case 'admin':
                                        requestRoute = 'admin.appointment.reschedule';
                                        break;
                                    case 'doctor':
                                    default:
                                        requestRoute = 'appointment.reschedule.submit';
                                        break;
                                }

                                $
                                    .ajax({
                                        url: laroute.route(requestRoute, {appointment: appointmentId}),
                                        method: "POST",
                                        dataType:'json',
                                        data: {
                                            appointmentId,
                                            doctorTimetableId
                                        }
                                    })
                                    .done((response) => {
                                        if(!response.success){
                                            bootbox.alert('Error occured. The appointment hasn\'t been reschedule yet!');
                                        }

                                        bootbox.alert('The appointment has been rescheduled successfully!', () => {
                                            // $modal.modal('hide');
                                            window.location.reload();
                                        });
                                    })
                                    .fail((error) => {
                                        bootbox.alert('Error occured. The appointment hasn\'t been reschedule yet!');
                                    })
                                    .always(()=>{
                                        $overlayLoading.addClass('hide');
                                    })
                                ;
                            }
                        });
                    })
                ;

                //@TODO: There might can be still issues in different timezones
                $formFindTimeSlots
                    .on('submit', (event) => {
                        event.preventDefault();
                        let inputDateValue = $formFindTimeSlotsInputDate.val(),
                            selectedDate = moment(inputDateValue, 'DD/MM/YYYY');

                        if(!selectedDate.isValid()){
                            return false;
                        }

                        $formFindTimeSlots.addClass('submitting');

                        $listAvailableTimeslots.html('');

                        let requestRoute;
                        switch(dashboardType){
                            case 'admin':
                                requestRoute = 'admin.doctor.workingCalendar.timeslot.index';
                                break;
                            case 'doctor':
                            default:
                                requestRoute = 'working-calendar.feed';
                                break;
                        }

                        let routeOptions = {
                            filters: JSON.stringify({
                                condition: [/*appointmentTypeId*/],
                                label:['available'],
                                clinic: [],
                                appointmentTypeCategory: [appointmentTypeCategory]

                            }),
                            from: selectedDate.unix() * 1000,
                            to: selectedDate.add(1, 'day').unix() * 1000,
                            utc_offset_from: (new Date()).getTimezoneOffset(),
                            utc_offset_to: (new Date()).getTimezoneOffset(),
                        }

                        if(doctorId){
                            routeOptions.doctor = doctorId
                        }

                        $
                            .ajax({
                                url: laroute.route(requestRoute, routeOptions),
                                dataType: 'json',
                                type: 'GET',
                                async: false
                            })
                            .done((response) => {
                                if(!response.success){
                                    console.log('error');
                                }

                                let timeslotsGroup = undefined;

                                if(response.result){
                                    let timeslots = _map(response.result, (timeslot) => {
                                            return {
                                                id: timeslot.id,
                                                appointmentType: (timeslot.appointmentType?timeslot.appointmentType.name:''),
                                                startAt: moment(timeslot.start).utcOffset(timeslot.timezone).tz(timeslot.timezone).format('HH:mm'),
                                                endAt: moment(timeslot.end).utcOffset(timeslot.timezone).tz(timeslot.timezone).format('HH:mm')
                                            };
                                        })
                                    ;

                                    timeslotsGroup = _groupBy(timeslots, (timeslot) => {
                                        return timeslot.appointmentType;
                                    })
                                }

                                let html = swig.render(_this.templates.listAvailableTimeslots, {
                                    locals: {
                                        selectedDate: inputDateValue,
                                        timeslotsGroup
                                    }
                                });

                                $listAvailableTimeslots.html(html);
                            })
                            .always(()=>{
                                $formFindTimeSlots.removeClass('submitting');
                            })
                    })
                ;

                // http://192.168.33.10/calendar/feed?
                //      filters={%22condition%22:[],%22label%22:[],%22clinic%22:[]}
                //     &from=1477933200000
                //     &to=1480525200000
                //     &utc_offset_from=-420
                //     &utc_offset_to=-420
            })
            .on('hidden.bs.modal', (event) => {
                _this.data.isActive = false;
            })
        ;
    }

    sandbox.on('modal/rescheduleAppointment/show', ({appointmentTypeId, appointmentTypeName, appointmentTypeCategory, appointmentId, doctorId}) => {
        _this.showModalReschedule({appointmentTypeId, appointmentTypeName, appointmentTypeCategory, appointmentId, doctorId});
    });

    _this.init = (data) => {
        _this.data = data || {};
        _this.data.isActive = false;

        _this.templates = {};
        _this.templates.modalMessage = multiline(()=>{/*!@preserve
            <form class="form" id="form_find_timeslots">
                <div class="form-group text-center">
                    Please choose the date you want to move the schedule & click search.
                </div>
                <div class="form-group clearfix">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="input-group">
                            <input class="form-control" id="form_find_timeslots__input_date" type="text"/>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary btn-flat">
                                    <i class="fa fa-spin fa-refresh"></i>
                                    Search
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </form>

            <div id="list_available_timeslots"></div>
            <div id="overlay_loading" class="hide"><i class="fa fa-spin fa-refresh"></i></div>
        */console.log});

        _this.templates.listAvailableTimeslots = multiline(()=>{/*!@preserve
        {% if Object.keys(timeslotsGroup).length > 0 %}
            {% for appointmentTypeName, timeslots in timeslotsGroup %}
                <p>There {% if timeslots.length == 1 %}is{%else%}are{%endif%} <b>{{timeslots.length}}</b> available <b>{{appointmentTypeName}}</b> {% if timeslots.length == 1 %}timeslot{%else%}timeslots{%endif%} in {{selectedDate}}:</p>
                <h4>
                {% for timeslot in timeslots %}
                    <a class="label label-default" data-date={{selectedDate}} data-id="{{timeslot.id}}" data-appointment-type-name="{{appoinmentTypeName}}">{{timeslot.startAt}} - {{timeslot.endAt}}</a>
                {% endfor %}
                </h4>
            {% endfor %}
        {% else %}
            <p>There is no available timeslots in {{selectedDate}}</p>
        {% endif %}
        */console.log});
    }
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
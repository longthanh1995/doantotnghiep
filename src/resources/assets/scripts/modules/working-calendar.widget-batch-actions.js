'use strict';

const _each = require('lodash/each');
const _get = require('lodash/get');

/**
 * @namespace widgetBatchActions
 * @memberOf pageWorkingCalendar
 */
module.exports = function(sandbox){
    let _this = this;
    
    _this.watch = () => {
        setInterval(() => {
            let $widgetBatchActions = $(_this.DOMSelectors.self),
                selectedEventsStats = _this.getSelectedEventsStats();

            if(selectedEventsStats.availableActions.block){
                $widgetBatchActions.attr('data-can-block', 1);
            } else {
                $widgetBatchActions.attr('data-can-block', 0);
            }

            if(selectedEventsStats.availableActions.unblock){
                $widgetBatchActions.attr('data-can-unblock', 1);
            } else {
                $widgetBatchActions.attr('data-can-unblock', 0);
            }

            if(selectedEventsStats.availableActions.delete){
                $widgetBatchActions.attr('data-can-delete', 1);
            } else {
                $widgetBatchActions.attr('data-can-delete', 0);
            }

            if(Object.keys(selectedEventsStats.events).length){
                $widgetBatchActions
                    .fadeIn(300)
                ;
            } else {
                $widgetBatchActions
                    .hide();
            }
        }, 100);
    }

    _this.getSelectedEventsStats = () => {
        let selectedEventsStats = {
            availableActions: {},
            events: {}
        };

        _this.objects.$calendar.find(_this.DOMSelectors.eventCheckedCheckboxes).each(function(){
            var $this = $(this),
                eventId = $this.attr('data-event-id'),
                eventTypes = $this.attr('data-action-types').split(','),
                isHidden = $this.closest('#cal-slide-box').css('display');

            //use switch/case for scalabiliy later
            switch(isHidden){
                case 'block':
                    _.each(eventTypes, function(eventType){
                        if(!selectedEventsStats.availableActions[eventType]){
                            selectedEventsStats.availableActions[eventType] = [];
                        }

                        if(eventId){
                            selectedEventsStats.events[eventId] = eventType;
                            selectedEventsStats.availableActions[eventType].push(eventId);
                        }
                    });
                    break;
                default:
                    return;
                    break;
            }
        });
        return selectedEventsStats;
    }

    _this.render = () => {}

    _this.bindEvents = () => {

        _this.objects.$calendar
            .on('click', '#widget_batch_actions [data-action-type]', (event) => {
                event.preventDefault();
                event.stopPropagation();

                var $this = $(event.currentTarget),
                    actionType = $this.attr('data-action-type'),
                    selectedEventsStats = _this.getSelectedEventsStats(),
                    confirmMessage = ' ';
                ;

                switch(actionType){
                    case 'selectAll':
                        $('#calendar').find('input[type=checkbox][data-event-id]').prop('checked', true);
                        break;
                    case 'deselectAll':
                        $('#calendar').find('input[type=checkbox][data-event-id]').prop('checked', false);
                        break;
                    case 'block':
                        if(!actionType
                            || !actionType.length
                            || !selectedEventsStats.availableActions[actionType].length){
                            manaDrApplication.emit('window/loading/hide');
                            return;
                        }

                        let ids = selectedEventsStats.availableActions[actionType],
                            doctorId = _get(_this.data, 'doctor.id')
                        ;

                        manaDrApplication.emit('modalBlockTimeslots/show', {
                            ids,
                            doctorId,
                            doneCallback: (response) => {
                                $.notify({
                                    message: 'Timeslot blocked successfully!'
                                }, {
                                    type: 'success',
                                    z_index: 1030
                                });

                                _this.objects.calendar.view();
                            },
                            failCallback: (e, data) => {}
                        });

                        break;
                    default:
                        if(!actionType
                        || !actionType.length
                        || !selectedEventsStats.availableActions[actionType].length){
                            manaDrApplication.emit('window/loading/hide');
                            return;
                        }

                        switch(actionType) {
                            case 'delete':
                                confirmMessage = '<p class="text-center">Are you sure to delete these timetables?<br/>(Note: Only timetables with no appointment will be deleted)</p>';
                                break;
                            case 'block':
                                confirmMessage = '<p class="text-center">Are you sure to block these timetables?</p>';
                                break;
                            case 'unblock':
                                confirmMessage = '<p class="text-center">Are you sure to unblock these timetables?</p>';
                                break;
                        }

                        if(selectedEventsStats.availableActions[actionType].length){
                            bootbox.confirm(confirmMessage, function(result){
                                if(result){
                                    //should add loading overlay
                                    manaDrApplication.emit('window/loading/show');

                                    //generate ajax calls
                                    var ajaxCalls = [],
                                        errorMessages = []
                                        ;

                                    _each(selectedEventsStats.availableActions[actionType], function(id){
                                        var request;

                                        switch(actionType){
                                            case 'delete':
                                                request = $.ajax({
                                                    url: laroute.route(_get(_this.data, 'routes.destroyTimeslot'), {doctor: _get(_this.data, 'doctor.id'), doctorTimetable: id}),
                                                    method: "DELETE",
                                                    dataType: "json"
                                                });
                                                break;
                                            case 'block':
                                                request = $.ajax({
                                                    url: laroute.route(_get(_this.data, 'routes.blockTimeslot'), {doctor: _get(_this.data, 'doctor.id'), doctorTimetable: id}),
                                                    method: "POST",
                                                    dataType: "json"
                                                });
                                                break;
                                            case 'unblock':
                                                request = $.ajax({
                                                    url: laroute.route(_get(_this.data, 'routes.unblockTimeslot'), {doctor: _get(_this.data, 'doctor.id'), doctorTimetable: id}),
                                                    method: "POST",
                                                    dataType: "json"
                                                });
                                                break;
                                        }


                                        request.fail(function(e, data) {
                                            errorMessages.push(e.responseJSON.message);
                                        });

                                        ajaxCalls.push(request);
                                    })

                                    $.when
                                        .apply(undefined, ajaxCalls)
                                        .always(function(){
                                            _this.objects.calendar.view();
                                            manaDrApplication.emit('window/loading/hide');
                                            if(errorMessages.length){
                                                bootbox.alert("Error happened while process your requests. Please check again.");
                                            } else {
                                                bootbox.alert("Your request was processed successfully.")
                                            }
                                        })
                                    ;
                                }
                            });
                        }
                        break;
                }
            })

        _this.watch();
    }

    _this.init = ({data, objects}) => {
        _this.data = data || {};

        _this.DOMSelectors = {};
        _this.DOMSelectors.self = '#widget_batch_actions';
        _this.DOMSelectors.eventCheckboxes = 'input[type=checkbox][data-event-id]';
        _this.DOMSelectors.eventCheckedCheckboxes = 'input[type=checkbox][data-event-id]:checked';

        _this.objects = objects || {};

        _this.render();
        _this.bindEvents();
    }

    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
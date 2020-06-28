'use strict';

const GoogleMapsLoader = require('google-maps');
GoogleMapsLoader.KEY = 'AIzaSyAb6zQRkXnjua7WNqFXzciULhd_R5lHSOo';

const _uniqueId = require('lodash/uniqueId');
const _assign = require('lodash/assign');
const _get = require('lodash/get');
const _isNumber = require('lodash/isNumber');

/**
 * @namespace moduleModalMapPicker
 * @param sandbox
 */
module.exports = function(sandbox){
    let _this = this;

    /**
     * @memberOf moduleModalMapPicker
     * @function render
     */
    _this.render = () => {}

    /**
     * @memberOf moduleModalMapPicker
     * @function bindEvents
     */
    _this.bindEvents = () => {}

    /**
     * @memberOf moduleModalMapPicker
     * @function updateCurrentPosition
     * @param {Object} position
     */
    _this.updateCurrentPosition = (position) => {
        if (position
            && position.lat && !_isNumber(position.lat)
            && position.lng && !_isNumber(position.lng)
        ) {
            _this.data.currentPosition.lat = position.lat;
            _this.data.currentPosition.lng = position.lng;
        }

        // _this.renderCurrentPosition();
    }

    /**
     * @memberOf moduleModalMapPicker
     * @function renderCurrentPosition
     */
    _this.renderCurrentPosition = () => {
        let html = swig.render(_this.templates.segmentSelectedPosition, {
            locals: {
                position: _this.data.currentPosition
            }
        });
        $(_this.DOMSelectors.segmentSelectedPosition).html(html);
    }

    /**
     * @memberOf moduleModalMapPicker
     * @function showModal
     */
    _this.showModal = ({address, doneCallback}) => {
        let containerId = _uniqueId('map_container_'),
            $modal = bootbox.dialog({
                title: 'Location Picker',
                className: 'modal-location-picker',
                message: swig.render(_this.templates.modal, {
                    locals: {
                        address,
                        containerId
                    }
                }),
                buttons: {
                    submit: {
                        label: 'Submit',
                        className: 'btn btn-primary',
                        callback: function(){
                            if('function' === typeof doneCallback){
                                let $form = $(this).find('form');

                                doneCallback({
                                    address: $form.find('[name=address]').val(),
                                    position: {
                                        lat: _get(_this.data,'currentPosition.lat'),
                                        lng: _get(_this.data,'currentPosition.lng')
                                    }
                                });
                            }

                        }
                    }
                }
            });

        $modal
            .on('shown.bs.modal', (event) => {
                let $form = $modal.find('form');

                GoogleMapsLoader.load((google) => {
                    let map = new google.maps.Map(document.getElementById(containerId), {
                        center: _get(_this.data, 'currentPosition'),
                        zoom: _get(_this.data, 'currentZoom')
                    });

                    let marker = new google.maps.Marker({
                        position: _get(_this.data, 'currentPosition'),
                        map: map,
                        draggable: true
                    });

                    google.maps.event.addListener(marker, 'dragend', (event) => {
                        console.log('dragend');
                    });

                    let geocoder = new google.maps.Geocoder();

                    $form
                        .on('submit', (event) => {
                            event.preventDefault();

                            let isSubmitting = parseInt($form.data('is-submitting'));
                            if(isSubmitting){
                                return;
                            }

                            $form.data('is-submitting', 1);
                            $modal.find(':input').prop('disabled', true);

                            let address = $form.find('input').val();

                            geocoder.geocode({address}, (results, status) => {
                                if(status == 'OK'){
                                    // if(status == 'OK'){
                                    //     map.setCenter(results[0].geometry.location);
                                    //     marker.setPosition(results[0].geometry.location);
                                    // }
                                    map.setCenter(results[0].geometry.location);
                                    marker.setPosition(results[0].geometry.location);

                                    _this.updateCurrentPosition({
                                        lat: results[0].geometry.location.lat(),
                                        lng: results[0].geometry.location.lng()
                                    })

                                }

                                $form.data('is-submitting', 0);
                                $modal.find(':input').prop('disabled', false);
                            })
                        })
                        .removeClass('hide')
                    ;

                    if(!!address){
                        $form.trigger('submit');
                    }
                });
            });
        ;
    }

    sandbox
        .on('modalLocationPicker/show', ({address, position, doneCallback}) => {
            _this.updateCurrentPosition(position);
            _this.showModal({address, doneCallback});
        })
    ;

    /**
     * @memberOf moduleModalMapPicker
     * @function init
     * @param {Object} data
     */
    _this.init = (data) => {
        _this.data = _assign(data, {
            currentPosition: {
                lat: 1.352083,
                lng: 103.81983600000001
            },
            currentZoom: 13
        });

        _this.templates = {};
        _this.templates.modal = multiline(() => {/*!@preserve
        <form class="form hide">
            <div class="form-group">
                <div class="input-group input-group-sm">
                    <input class="form-control" type="text" value="{{address}}" name="address" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </div>
        </form>
        <div id="{{containerId}}" style="height:300px;"></div>
        */console.log});

        _this.DOMSelectors = {};

        _this.objects = {};
    }

    /**
     * @memberOf moduleModalMapPicker
     * @function destroy
     */
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
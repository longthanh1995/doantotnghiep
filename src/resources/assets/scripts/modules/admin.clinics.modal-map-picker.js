'use strict';

var GoogleMapsLoader = require('google-maps');
GoogleMapsLoader.KEY = 'AIzaSyAb6zQRkXnjua7WNqFXzciULhd_R5lHSOo';

module.exports = function(sandbox){
    let _this = this;

    _this.render = () => {
        $('.modal-map-picker .modal-footer').prepend('<div id="segment_selected_position" class="pull-left"></div>');
    }

    _this.bindEvents = () => {
        GoogleMapsLoader.load((google) => {
            var map = new google.maps.Map(document.getElementById(_this.DOMSelectors.mapContainerId), {
                center: _this.data.currentPosition,
                zoom: _this.data.currentZoom
            });

            var marker = new google.maps.Marker({
                position: _this.data.currentPosition,
                map: map,
                draggable: true
            });

            // google.maps.event.addListener(map, 'dblclick', (event) => {
            //     var selectedPosition = event.latLng;
            //
            //     marker.setPosition(selectedPosition);
            //     map.panTo(selectedPosition);
            // })

            google.maps.event.addListener(marker, 'dragend', function(event) {
                _this.updateCurrentPosition({
                    lat: event.latLng.lat(),
                    lng: event.latLng.lng()
                });
            });
        })
    }

    _this.updateCurrentPosition = (position) => {
        if (position
            && position.lat && !isNaN(position.lat)
            && position.lng && !isNaN(position.lng)
        ) {
            _this.data.currentPosition.lat = position.lat;
            _this.data.currentPosition.lng = position.lng;
        }

        _this.renderCurrentPosition();
    }

    _this.renderCurrentPosition = () => {
        let html = swig.render(_this.templates.segmentSelectedPosition, {
            locals: {
                position: _this.data.currentPosition
            }
        });
        $(_this.DOMSelectors.segmentSelectedPosition).html(html);
    }

    sandbox.on('pageAdminClinicDetails/modalMapPicker/show', (position) => {
        _this.render();
        _this.updateCurrentPosition(position);
        _this.bindEvents();
    });

    _this.init = (data) => {
        _this.data = {
            currentPosition: {
                lat: 1.352083,
                lng: 103.81983600000001
            },
            currentZoom: 13
        };

        _this.DOMSelectors = {
            mapContainerId: 'segment_map_picker',
            segmentSelectedPosition: '#segment_selected_position'
        }

        _this.templates = {
            segmentSelectedPosition: multiline(()=>{/*!@preserve
                <b>Current Lat:</b> <span data-lat="{{position.lat}}">{{position.lat}}</span>, <b>Current Lng:</b> <span data-lng="{{position.lng}}">{{position.lng}}</span>
            */console.log})
        }

        _this.objects = {}
    }
    _this.destroy = () => {}

    return {
        init: _this.init,
        destroy: _this.destroy
    }
}
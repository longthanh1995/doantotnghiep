'use strict';

const _findIndex = require('lodash/findIndex');
const _indexOf = require('lodash/indexOf');

if (swig && swig.setFilter) {
    swig.setFilter('formatTimestamp1', function(input){
        return moment(input, 'YYYY-MM-DD HH:mm:ss').utcOffset(0).format('DD/MM/YYYY');
    });

    swig.setFilter('formatTimestamp2', function(input, timeZone, format){
        return moment(input).utcOffset(timeZone).tz(timeZone).format(format);
    });

    swig.setFilter('formatTimestamp3', function(input){
        return moment(input, 'YYYY-MM-DD').format('DD/MM/YYYY');
    });

    swig.setFilter('formatTimestamp4', function(input){
        return moment(input, 'YYYY-MM-DD HH:mm:ss').format('DD/MM/YYYY');
    });

    swig.setFilter('renderSelectedOption', (input, array, key) => {
        return(_findIndex(array, (item) => item[key] === input) > -1)?'selected="selected"':'';
    });

    swig.setFilter('checkIfIndexOf', (input, array) => {
        return(_indexOf(array, input) > -1)?'1':'0';
    });

    swig.setFilter('formatWithoutTimezone', (input, format) => {
        return moment.tz(input, 'Europe/London').format(format);
    });

    swig.setFilter('typeof', (input) => {
        return typeof input;
    });

    swig.setFilter('split', (input, delimiter) => {
        return input.split(delimiter);
    });
}
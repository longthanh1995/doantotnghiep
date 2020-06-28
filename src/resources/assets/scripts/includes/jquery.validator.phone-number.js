'use strict';

if (jQuery.validator) {
    jQuery.validator.addMethod("validatePhoneNumber", function (value) {
        return isValidPhoneNumber(value);
    });
}

function isValidPhoneNumber(phoneNumber) {
    if (phoneNumber.length) {
        var pattern = new RegExp(/^0(?:9(?=\d{8}$)|1(?=\d{9}$))/gi);
        return pattern.test(phoneNumber);
    }
    return true;
}
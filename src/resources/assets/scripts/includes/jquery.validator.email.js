'use strict';

if (jQuery.validator) {
    jQuery.validator.addMethod("validateEmail", function(value, element) {
        return this.optional(element) || isValidEmailAddress(value);
    });
}

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
    return pattern.test(emailAddress);
}
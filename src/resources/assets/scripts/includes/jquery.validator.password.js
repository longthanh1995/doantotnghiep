'use strict';

if (jQuery.validator) {
    jQuery.validator.addMethod("validatePassword", function (value, element) {
        var isValid = false;
        var isContainDigit = false;
        var isContainChar = false;
        for (var i = 0; i < value.length; i++) {
            if (/^[a-zA-Z]+$/.test(value[i])) {
                isContainChar = true;
            }
            if (/^[0-9]+$/.test(value[i])) {
                isContainDigit = true;
            }
        }
        if (isContainDigit && isContainChar)
            isValid = true;
        return isValid;
    });
}
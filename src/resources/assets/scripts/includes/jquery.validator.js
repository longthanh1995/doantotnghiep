if (jQuery.validator) {
    $.validator.addMethod(
        "dateFormatDMY",
        function(value, element) {
            return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
        },
        "Please enter a date in the format dd/mm/yyyy."
    );

    $.validator.addMethod("greaterThan", function(value, element, params) {
        if ($(params[0]).val() != '') {
            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > new Date($(params[0]).val());
            }
            return isNaN(value) && isNaN($(params[0]).val()) || (Number(value) > Number($(params[0]).val()));
        };
        return true;
    },'Must be greater than {1}.');
}
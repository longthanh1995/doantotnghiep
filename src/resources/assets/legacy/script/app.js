$.validator.addMethod(
    "dateFormatDMY",
    function(value, element) {
        // put your own logic here, this is just a (crappy) example
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

$.validator.addMethod("validateEmail", function(emailAddress) {
    var pattern = new RegExp(/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i);
    return pattern.test(emailAddress);
});

//swig's custom filter
if (swig && swig.setFilter) {
    //floor
    if('undefined' !== typeof moment){
        swig.setFilter('formatTimestamp1', function(input){
            return moment(input, 'YYYY-MM-DD HH:mm:ss').utcOffset(0).format('DD/MM/YYYY');
        })
    }
}

$(document).ready(function () {
    /*Menu-toggle*/
    $("#menu-toggle").click(function(e) {
        e.preventDefault();

        toggleMenu();
    });
});

var toggleMenu = function () {
    $("#wrapper").toggleClass("active");
};
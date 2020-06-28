(function () {

    var laroute = (function () {

        var routes = {

            absolute: false,
            rootUrl: 'http://localhost',
            routes : [{"host":null,"methods":["POST"],"uri":"file","name":"doctor.file.store","action":"App\Http\Controllers\Doctor\FileController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/patients\/searchByIcOrName","name":"api.patients.searchByIcOrName","action":"App\Http\Controllers\Doctor\Api\PatientController@searchByIcOrName"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/patients\/search","name":"api.patients.search","action":"App\Http\Controllers\Doctor\Api\PatientController@search"},{"host":null,"methods":["POST"],"uri":"api\/patients","name":"api.patients.store","action":"App\Http\Controllers\Doctor\Api\PatientController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"working-calendar","name":"working-calendar.index","action":"App\Http\Controllers\Doctor\CalendarController@index"},{"host":null,"methods":["POST"],"uri":"working-calendar\/create-timeslots","name":"working-calendar.createTimeslots","action":"App\Http\Controllers\Doctor\CalendarController@storeTimeslots"},{"host":null,"methods":["POST"],"uri":"working-calendar\/block\/{doctorTimetable}","name":"working-calendar.block","action":"App\Http\Controllers\Doctor\CalendarController@block"},{"host":null,"methods":["POST"],"uri":"working-calendar\/unblock\/{doctorTimetable}","name":"working-calendar.unblock","action":"App\Http\Controllers\Doctor\CalendarController@unblock"},{"host":null,"methods":["DELETE"],"uri":"working-calendar\/destroy\/{doctorTimetable}","name":"working-calendar.destroy","action":"App\Http\Controllers\Doctor\CalendarController@destroy"},{"host":null,"methods":["GET","HEAD","POST","PUT","PATCH","DELETE"],"uri":"working-calendar\/feed","name":"working-calendar.feed","action":"App\Http\Controllers\Doctor\CalendarController@feed"},{"host":null,"methods":["POST"],"uri":"working-calendar\/check-updates","name":"working-calendar.checkUpdates","action":"App\Http\Controllers\Doctor\CalendarController@checkUpdates"},{"host":null,"methods":["GET","HEAD"],"uri":"working-calendar\/fetch-available-timeslots","name":"workingCalendar.fetchAvailableTimeslots","action":"App\Http\Controllers\Doctor\CalendarController@fetchAvailableTimeslots"},{"host":null,"methods":["POST"],"uri":"appointment\/create","name":"appointment.store","action":"App\Http\Controllers\Doctor\AppointmentController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"appointment\/show\/{appointment}\/fetch","name":"appointment.fetch","action":"App\Http\Controllers\Doctor\AppointmentController@fetch"},{"host":null,"methods":["POST"],"uri":"appointment\/show\/{appointment}\/send-message","name":"appointment.sendMessage","action":"App\Http\Controllers\Doctor\AppointmentController@sendMessage"},{"host":null,"methods":["POST"],"uri":"appointment\/{appointment}\/create-health-summary","name":"appointment.createHealthSummary","action":"App\Http\Controllers\Doctor\AppointmentController@createHealthSummary"},{"host":null,"methods":["POST"],"uri":"appointment\/{appointment}\/update-health-summary","name":"appointment.updateHealthSummary","action":"App\Http\Controllers\Doctor\AppointmentController@updateHealthSummary"},{"host":null,"methods":["POST"],"uri":"appointment\/{appointment}\/update-booking-reason","name":"appointment.updateBookingReason","action":"App\Http\Controllers\Doctor\AppointmentController@updateBookingReason"},{"host":null,"methods":["POST"],"uri":"appointment\/reschedule","name":"appointment.reschedule.submit","action":"App\Http\Controllers\Doctor\AppointmentController@reschedule"},{"host":null,"methods":["GET","HEAD"],"uri":"appointment\/{appointment}\/markAsVisited","name":"appointment.markAsVisited","action":"App\Http\Controllers\Doctor\AppointmentController@markAsVisited"},{"host":null,"methods":["GET","HEAD"],"uri":"appointment\/{appointment}\/markAsNoShow","name":"appointment.markAsNoShow","action":"App\Http\Controllers\Doctor\AppointmentController@markAsNoShow"},{"host":null,"methods":["GET","HEAD"],"uri":"appointment\/{appointment}\/markAsLate","name":"appointment.markAsLate","action":"App\Http\Controllers\Doctor\AppointmentController@markAsLate"},{"host":null,"methods":["POST"],"uri":"profile\/avatar\/upload","name":"profile.avatarUpload","action":"App\Http\Controllers\Doctor\ProfileController@avatarUpload"},{"host":null,"methods":["POST"],"uri":"profile\/basic-information\/change-password","name":"profile.changePasswordSubmit","action":"App\Http\Controllers\Doctor\ProfileController@changePasswordSubmit"},{"host":null,"methods":["POST"],"uri":"profile\/qualifications\/college\/{id}","name":"profile.college.update","action":"App\Http\Controllers\Doctor\ProfileCollegeController@update"},{"host":null,"methods":["POST"],"uri":"profile\/qualifications\/{doctorQualification}","name":"profile.qualification.update","action":"App\Http\Controllers\Doctor\ProfileQualifcationController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"profile\/clinics","name":"profile.clinics","action":"App\Http\Controllers\Doctor\ProfileController@clinics"},{"host":null,"methods":["GET","HEAD"],"uri":"patients\/{patient}","name":"doctor.patient.details","action":"App\Http\Controllers\Doctor\PatientController@details"},{"host":null,"methods":["POST"],"uri":"patients\/search","name":"doctor.patient.search","action":"App\Http\Controllers\Doctor\PatientController@search"},{"host":null,"methods":["POST"],"uri":"patients\/{patient}\/fetch","name":"doctor.patient.fetch","action":"App\Http\Controllers\Doctor\PatientController@fetch"},{"host":null,"methods":["POST"],"uri":"patients\/{patient}\/update","name":"doctor.patient.update","action":"App\Http\Controllers\Doctor\PatientController@update"},{"host":null,"methods":["POST"],"uri":"patients\/{patient}\/set-guardianship\/{guardian}","name":"doctor.patient.setGuardianship","action":"App\Http\Controllers\Doctor\PatientController@setGuardianship"},{"host":null,"methods":["POST"],"uri":"patients\/{patient}\/revoke-guardianship\/{guardian}","name":"doctor.patient.revokeGuardianship","action":"App\Http\Controllers\Doctor\PatientController@revokeGuardianship"},{"host":null,"methods":["POST"],"uri":"patients\/get-by-id-number","name":"doctor.patient.getByIdNumber","action":"App\Http\Controllers\Doctor\PatientController@getByIDNumber"},{"host":null,"methods":["GET","HEAD"],"uri":"clinics","name":"api.doctor.clinics.index","action":"App\Http\Controllers\Doctor\ClinicController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"resources\/countries","name":"public.resource.country","action":"App\Http\Controllers\ResourceController@countries"}],
            prefix: '',

            route : function (name, parameters, route) {
                route = route || this.getByName(name);

                if ( ! route ) {
                    return undefined;
                }

                return this.toRoute(route, parameters);
            },

            url: function (url, parameters) {
                parameters = parameters || [];

                var uri = url + '/' + parameters.join('/');

                return this.getCorrectUrl(uri);
            },

            toRoute : function (route, parameters) {
                var uri = this.replaceNamedParameters(route.uri, parameters);
                var qs  = this.getRouteQueryString(parameters);

                return this.getCorrectUrl(uri + qs);
            },

            replaceNamedParameters : function (uri, parameters) {
                uri = uri.replace(/\{(.*?)\??\}/g, function(match, key) {
                    if (parameters.hasOwnProperty(key)) {
                        var value = parameters[key];
                        delete parameters[key];
                        return value;
                    } else {
                        return match;
                    }
                });

                // Strip out any optional parameters that were not given
                uri = uri.replace(/\/\{.*?\?\}/g, '');

                return uri;
            },

            getRouteQueryString : function (parameters) {
                var qs = [];
                for (var key in parameters) {
                    if (parameters.hasOwnProperty(key)) {
                        qs.push(key + '=' + parameters[key]);
                    }
                }

                if (qs.length < 1) {
                    return '';
                }

                return '?' + qs.join('&');
            },

            getByName : function (name) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
                        return this.routes[key];
                    }
                }
            },

            getByAction : function(action) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
                        return this.routes[key];
                    }
                }
            },

            getCorrectUrl: function (uri) {
                var url = this.prefix + '/' + uri.replace(/^\/?/, '');

                if(!this.absolute)
                    return url;

                return this.rootUrl.replace('/\/?$/', '') + url;
            }
        };

        var getLinkAttributes = function(attributes) {
            if ( ! attributes) {
                return '';
            }

            var attrs = [];
            for (var key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    attrs.push(key + '="' + attributes[key] + '"');
                }
            }

            return attrs.join(' ');
        };

        var getHtmlLink = function (url, title, attributes) {
            title      = title || url;
            attributes = getLinkAttributes(attributes);

            return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
        };

        return {
            // Generate a url for a given controller action.
            // laroute.action('HomeController@getIndex', [params = {}])
            action : function (name, parameters) {
                parameters = parameters || {};

                return routes.route(name, parameters, routes.getByAction(name));
            },

            // Generate a url for a given named route.
            // laroute.route('routeName', [params = {}])
            route : function (route, parameters) {
                parameters = parameters || {};

                return routes.route(route, parameters);
            },

            // Generate a fully qualified URL to the given path.
            // laroute.route('url', [params = {}])
            url : function (route, parameters) {
                parameters = parameters || {};

                return routes.url(route, parameters);
            },

            // Generate a html link to the given url.
            // laroute.link_to('foo/bar', [title = url], [attributes = {}])
            link_to : function (url, title, attributes) {
                url = this.url(url);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given route.
            // laroute.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
            link_to_route : function (route, title, parameters, attributes) {
                var url = this.route(route, parameters);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given controller action.
            // laroute.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
            link_to_action : function(action, title, parameters, attributes) {
                var url = this.action(action, parameters);

                return getHtmlLink(url, title, attributes);
            }

        };

    }).call(this);

    /**
     * Expose the class either via AMD, CommonJS or the global object
     */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return laroute;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = laroute;
    }
    else {
        window.laroute = laroute;
    }

}).call(this);


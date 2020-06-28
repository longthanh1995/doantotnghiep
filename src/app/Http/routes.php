<?php

/*
 * Doctor Routes
 */
Route::group(['middleware' => 'doctor.values', 'namespace' => 'Doctor'], function () {
    Route::get('/', ['uses' => 'IndexController@index', 'as' => 'home']);
    Route::group(['middleware' => 'doctor.guest'], function () {
        Route::get('/sign-in', ['uses' => 'AuthController@login', 'as' => 'doctor.signIn']);
        Route::post('/sign-in', ['uses' => 'AuthController@loginSubmit', 'as' => 'doctor.signInSubmit']);
        Route::get('/sign-up', ['uses' => 'AuthController@signUp', 'as' => 'doctor.signUp']);
        Route::post('/sign-up', ['uses' => 'AuthController@signUpSubmit', 'as' => 'doctor.signUpSubmit']);
        Route::post('/get-doctor-info', ['uses' => 'AuthController@getDoctorInfo', 'as' => 'doctor.getDoctorInfo']);
    });

    Route::group(['middleware' => 'doctor.auth'], function () {
        Route::get('/sign-out', ['uses' => 'AuthController@logout', 'as' => 'doctor.signOut']);
        Route::group(['prefix' => 'file'], function() {
            Route::post('/', ['uses' => 'FileController@store', 'as' => 'doctor.file.store', 'laroute' => true]);
        });

        /*
         * API section
         */
        Route::group(['prefix' => 'api'], function () {
            Route::get('/patients/searchByIcOrName', ['uses' => 'Api\PatientController@searchByIcOrName', 'as' => 'api.patients.searchByIcOrName', 'laroute' => true]);
            Route::get('/patients/search', ['uses' => 'Api\PatientController@search', 'as' => 'api.patients.search', 'laroute' => true]);
            Route::post('/patients', ['uses' => 'Api\PatientController@store', 'as' => 'api.patients.store', 'laroute' => true]);
        });

        /*
         * Dashboard section
         */
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', ['uses' => 'DashboardController@index', 'as' => 'doctor.dashboard']);
        });

        /*
         * Calendar section
         */
        Route::group(['prefix' => 'working-calendar'], function () {
            Route::get('/', ['uses' => 'CalendarController@index', 'as' => 'working-calendar.index', 'laroute' => true]);
            Route::post('/create-timeslots', ['uses' => 'CalendarController@storeTimeslots', 'as' => 'working-calendar.createTimeslots', 'laroute' => true]);
            Route::post('/block/{doctorTimetable}', ['uses' => 'CalendarController@block', 'as' => 'working-calendar.block', 'laroute' => true]);
            Route::post('/unblock/{doctorTimetable}', ['uses' => 'CalendarController@unblock', 'as' => 'working-calendar.unblock', 'laroute' => true]);
            Route::delete('/destroy/{doctorTimetable}', ['uses' => 'CalendarController@destroy', 'as' => 'working-calendar.destroy', 'laroute' => true]);
            Route::any('/feed', ['uses' => 'CalendarController@feed', 'as' => 'working-calendar.feed', 'laroute' => true]);
            Route::post('check-updates', ['uses' => 'CalendarController@checkUpdates', 'as' => 'working-calendar.checkUpdates', 'laroute' => true]);
            Route::get('/{typeView?}', ['uses' => 'CalendarController@index', 'as' => 'calendar.index'])
                ->where('typeView', 'day|month|week|year');
            Route::get('/fetch-available-timeslots', ['uses' => 'CalendarController@fetchAvailableTimeslots', 'as' => 'workingCalendar.fetchAvailableTimeslots', 'laroute' => true]);
        });

        /*
         * Appointment section
         */
        Route::group(['prefix' => 'appointment'], function () {
            Route::get('/', ['uses' => 'AppointmentController@index', 'as' => 'appointment.index']);

            Route::post('/create', ['uses' => 'AppointmentController@store', 'as' => 'appointment.store', 'laroute' => true]);
            Route::get('/show/{appointment}', ['uses' => 'AppointmentController@show', 'as' => 'appointment.show']);

            Route::get('/show/{appointment}/fetch', ['uses' => 'AppointmentController@fetch', 'as' => 'appointment.fetch', 'laroute' => true]);
            Route::post('/show/{appointment}/send-message', ['uses' => 'AppointmentController@sendMessage', 'as' => 'appointment.sendMessage', 'laroute' => true]);

            Route::post('/show/{appointment}/visit', ['uses' => 'AppointmentController@visitSubmit', 'as' => 'appointment.visitSubmit']);
            Route::post('/show/{appointment}/cancel', ['uses' => 'AppointmentController@cancelSubmit', 'as' => 'appointment.cancelSubmit']);
            Route::post('/show/{appointment}/mark-as-no-show', ['uses' => 'AppointmentController@markAsNoShowSubmit', 'as' => 'appointment.markAsNoShowSubmit']);
            Route::post('/show/{appointment}/mark-as-late', ['uses' => 'AppointmentController@markAsLateSubmit', 'as' => 'appointment.markAsLateSubmit']);

            Route::post('{appointment}/create-health-summary', ['uses' => 'AppointmentController@createHealthSummary', 'as' => 'appointment.createHealthSummary', 'laroute' => true]);
            Route::post('{appointment}/update-health-summary', ['uses' => 'AppointmentController@updateHealthSummary', 'as' => 'appointment.updateHealthSummary', 'laroute' => true]);
            Route::post('{appointment}/update-booking-reason', ['uses' => 'AppointmentController@updateBookingReason', 'as' => 'appointment.updateBookingReason', 'laroute' => true]);

            Route::post('/reschedule', ['uses' => 'AppointmentController@reschedule', 'as' => 'appointment.reschedule.submit', 'laroute' => true]);

            Route::get('/confirmed-booking', ['uses' => 'AppointmentController@confirmedBooking', 'as' => 'appointment.confirmedBooking']);
            Route::get('/visited-booking', ['uses' => 'AppointmentController@visitedBooking', 'as' => 'appointment.visitedBooking']);
            Route::get('/cancelled-booking', ['uses' => 'AppointmentController@cancelledBooking', 'as' => 'appointment.cancelledBooking']);
            Route::get('/not-showing-up-booking', ['uses' => 'AppointmentController@notShowingUpBooking', 'as' => 'appointment.notShowingUpBooking']);
            Route::get('/late-booking', ['uses' => 'AppointmentController@lateBooking', 'as' => 'appointment.lateBooking']);

            Route::get('{appointment}/markAsVisited', ['uses' => 'AppointmentController@markAsVisited', 'as' => 'appointment.markAsVisited', 'laroute' => true]);
            Route::get('{appointment}/markAsNoShow', ['uses' => 'AppointmentController@markAsNoShow', 'as' => 'appointment.markAsNoShow', 'laroute' => true]);
            Route::get('{appointment}/markAsLate', ['uses' => 'AppointmentController@markAsLate', 'as' => 'appointment.markAsLate', 'laroute' => true]);

            Route::get('/export/xls', ['uses' => 'AppointmentController@exportXls', 'as' => 'appointment.export.xls']);
            Route::get('/export/pdf', ['uses' => 'AppointmentController@exportPdf', 'as' => 'appointment.export.pdf']);
        });

        /*
         * Setting section
         */
        Route::group(['prefix' => 'setting'], function () {
            Route::get('/', ['uses' => 'SettingController@index', 'as' => 'setting.index']);
            Route::post('/appointment-type', ['uses' => 'SettingController@appointmentTypeSubmit', 'as' => 'setting.appointmentTypeSubmit']);
            Route::get('/time', ['uses' => 'SettingController@time', 'as' => 'setting.time']);
            Route::post('/time', ['uses' => 'SettingController@timeSubmit', 'as' => 'setting.timeSubmit']);
        });

        /*
         * Profile section
         */
        Route::group(['prefix' => 'profile'], function () {
            Route::get('/', ['uses' => 'ProfileController@index', 'as' => 'profile.index']);

            Route::get('/avatar', ['uses' => 'ProfileController@avatar', 'as' => 'profile.avatar']);
            Route::post('/avatar', ['uses' => 'ProfileController@avatarSubmit', 'as' => 'profile.avatarSubmit']);
            Route::post('/avatar/upload', ['uses' => 'ProfileController@avatarUpload', 'as' => 'profile.avatarUpload', 'laroute' => true]);

            Route::get('/basic-information', ['uses' => 'ProfileController@basicInformation', 'as' => 'profile.basicInformation']);
            Route::post('/basic-information', ['uses' => 'ProfileController@basicInformationSubmit', 'as' => 'profile.basicInformationSubmit']);
            Route::post('/basic-information/personal-contact', ['uses' => 'ProfileController@personalContactSubmit', 'as' => 'profile.personalContactSubmit']);
            Route::post('/basic-information/change-password', ['uses' => 'ProfileController@changePasswordSubmit', 'as' => 'profile.changePasswordSubmit', 'laroute' => true]);

            Route::get('/qualifications', ['uses' => 'ProfileController@qualifications', 'as' => 'profile.qualifications']);

            Route::post('/qualifications/college', ['uses' => 'ProfileCollegeController@store', 'as' => 'profile.college.store']);
            Route::post('/qualifications/college/{id}', ['uses' => 'ProfileCollegeController@update', 'as' => 'profile.college.update', 'laroute' => true]);
            Route::delete('/qualifications/college/{id}', ['uses' => 'ProfileCollegeController@destroy', 'as' => 'profile.college.destroy']);

            Route::post('/qualifications', ['uses' => 'ProfileQualifcationController@store', 'as' => 'profile.qualification.store']);
            Route::post('/qualifications/{doctorQualification}', ['uses' => 'ProfileQualifcationController@update', 'as' => 'profile.qualification.update', 'laroute' => true]);
            Route::delete('/qualifications/{doctorQualification}', ['uses' => 'ProfileQualifcationController@destroy', 'as' => 'profile.qualification.destroy']);

            Route::get('/professional-working', ['uses' => 'ProfileController@professionalWorking', 'as' => 'profile.professionalWorking']);
            Route::post('/professional-working/speciality', ['uses' => 'ProfileController@specialitySubmit', 'as' => 'profile.specialitySubmit']);

            Route::get('/clinics', ['uses' => 'ProfileController@clinics', 'as' => 'profile.clinics', 'laroute' => true]);
        });
        Route::group(['prefix' => 'patients'], function(){
            Route::get('/', ['uses' => 'PatientController@index', 'as' => 'doctor.patient.index']);
            Route::get('/{patient}', ['uses' => 'PatientController@details', 'as' => 'doctor.patient.details', 'laroute'=> true]);
            Route::post('/search', ['uses' => 'PatientController@search', 'as' => 'doctor.patient.search', 'laroute'=> true]);
            Route::post('/{patient}/fetch', ['uses' => 'PatientController@fetch', 'as' => 'doctor.patient.fetch', 'laroute'=> true]);
            Route::post('/{patient}/update', ['uses' => 'PatientController@update', 'as' => 'doctor.patient.update', 'laroute'=> true]);
            Route::post('/{patient}/set-guardianship/{guardian}', ['uses' => 'PatientController@setGuardianship', 'as' => 'doctor.patient.setGuardianship', 'laroute'=> true]);
            Route::post('/{patient}/revoke-guardianship/{guardian}', ['uses' => 'PatientController@revokeGuardianship', 'as' => 'doctor.patient.revokeGuardianship', 'laroute'=> true]);
            Route::post('/get-by-id-number', ['uses' => 'PatientController@getByIDNumber', 'as' => 'doctor.patient.getByIdNumber', 'laroute' => true]);
        });
        Route::group(['prefix' => 'clinics'], function(){
            Route::get('/', ['uses' => 'ClinicController@index', 'as' => 'api.doctor.clinics.index', 'laroute' => true]);
        });
    });
});

Route::group(['prefix' => 'resources'], function(){
    Route::get('/countries', ['uses' => 'ResourceController@countries', 'as' => 'public.resource.country', 'laroute' => true]);
});
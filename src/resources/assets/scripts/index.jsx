'use strict';

require("file?name=vendors.js?hash=[hash]!./vendors.js");

require("../styles/style.less");

require('./includes/jquery.ajax');
require('./includes/jquery.validator');
require('./includes/jquery.validator.email');
require('./includes/jquery.validator.password');
require('./includes/jquery.validator.phone-number');
require('./includes/swig.custom-filters');

var _get = require('lodash/get');

// alert(1);
window.manaDrApplication = require('./core/application');

manaDrApplication.register('window', require('./modules/window'));
manaDrApplication.register('modalRescheduleAppointment', require('./modules/modal-reschedule-appointment'));
manaDrApplication.register('modalConsultSummary', require('./modules/modal-consult-summary'));
manaDrApplication.register('modalUpdateBookingReason', require('./modules/modal-update-booking-reason'));
manaDrApplication.register('modalLocationPicker', require('./modules/modal-location-picker'));
manaDrApplication.register('modalSendAppointmentMessage', require('./modules/modal-send-appointment-message'));
manaDrApplication.register('modalVerifyPatient', require('./modules/modal-verify-patient'));
manaDrApplication.register('modalBlockTimeslots', require('./modules/modal-block-timeslots'));
manaDrApplication.register('modalCreateAppointment', require('./modules/modal-create-appointment'));
manaDrApplication.register('modalCreatePatient', require('./modules/modal-create-patient'));
manaDrApplication.register('modalManageHouseCallReasons', require('./modules/modal-manage-house-call-reasons'));
manaDrApplication.register('modalCreateHouseCallReason', require('./modules/modal-create-house-call-reason'));
manaDrApplication.register('modalUpdateHouseCallReason', require('./modules/modal-update-house-call-reason'));
manaDrApplication.register('modalManageHouseCallReasonDoctors', require('./modules/modal-manage-house-call-reasons-doctors'));
manaDrApplication.register('modalClinicDoctorsPicker', require('./modules/modal-clinic-doctors-picker'));
manaDrApplication.register('modalManageSurchargeSettings', require('./modules/modal-manage-surcharge-settings'));
manaDrApplication.register('modalCreateSurchargeSetting', require('./modules/modal-create-surcharge-setting'));
manaDrApplication.register('modalUpdateSurchargeSetting', require('./modules/modal-update-surcharge-setting'));
manaDrApplication.register('modalCancelAppointment', require('./modules/modal-cancel-appointment'));

//register services
manaDrApplication.register('serviceAppointmentType', require('./services/admin.appointment-types'));
manaDrApplication.register('serviceConsultReason', require('./services/admin.consult-reasons'));
manaDrApplication.register('serviceHouseCallReason', require('./services/admin.house-call-reasons'));
manaDrApplication.register('serviceTimeslot', require('./services/timeslots'));
manaDrApplication.register('serviceDoctorTeleconsultSettings', require('./services/doctor.teleconsult-settings'));
manaDrApplication.register('serviceClinics', require('./services/clinics'));
manaDrApplication.register('serviceDoctorTimeslots', require('./services/doctor.doctor-timeslots'));
manaDrApplication.register('serviceDoctorAppointments', require('./services/doctor.appointments'));
manaDrApplication.register('serviceCountries', require('./services/countries'));
manaDrApplication.register('serviceAdminDoctors', require('./services/admin.doctors'));
manaDrApplication.register('serviceAdminClinics', require('./services/admin.clinics'));
manaDrApplication.register('serviceDoctorBookingFeeSurchargeSettings', require('./services/admin.doctor-booking-fees.surcharge-settings'));
manaDrApplication.register('serviceAdminCMEEvents', require('./services/admin.cme.events'));
manaDrApplication.register('serviceAdminCMEOrganizers', require('./services/admin.cme.organizers'));
manaDrApplication.register('serviceAdminSuperClinicData', require('./services/admin.super-clinic-data'));
manaDrApplication.register('servicePatients', require('./services/doctor.patients'));
manaDrApplication.register('serviceAdminPatients', require('./services/admin.patients'));
manaDrApplication.register('serviceAdminAppointments', require('./services/admin.appointments'));

if($('.page-profile').length){
    manaDrApplication.register('pageProfile', require('./pages/profile'));
}

if($('.page-working-calendar.new').length){
    manaDrApplication.register('pageWorkingCalendar', require('./pages/working-calendar'), humps.camelizeKeys(_get(globalData,'context.pageWorkingCalendar')));
}

if($('.page-settings').length){
    manaDrApplication.register('pageSettings', require('./pages/settings'));
}

if($('.page-admin.page-clinics').length){
    manaDrApplication.register('pageAdminClinic', require('./pages/admin.clinics'));
}

if($('.page-appointments-details').length){
    manaDrApplication.register('pageAppointmentDetails', require('./pages/appointment.details'), humps.camelizeKeys(_get(globalData,'context.pageAppointmentDetails')));
}

if($('.page-patients-details').length){
    manaDrApplication.register('pagePatientsDetails', require('./pages/patients.details'));
}

if($('.page-admin.page-doctors-details').length){
    manaDrApplication.register('pageAdminDoctorDetails', require('./pages/admin.doctor.details'), {
        data: humps.camelizeKeys(_get(globalData,'context.pageAdminDoctorDetails'))
    });
}

if($('.page-admin.page-work-companies').length){
    manaDrApplication.register('pageAdminWorkCompanies', require('./pages/admin.work-companies'));
}

if($('.page-admin.page-insurance-companies').length){
    manaDrApplication.register('pageAdminInsuranceCompanies', require('./pages/admin.insurance-companies'));
}

if($('.page-admin.page-consult-reasons').length){
    manaDrApplication.register('pageAdminConsultReasons', require('./pages/admin.consult-reasons'));
}

if($('.page-admin.page-clinics.page-clinics-details').length){
    manaDrApplication.register('pageAdminClinicsDetails', require('./pages/admin.clinic.details'));
}

if($('.page-admin.page-broadcast.page-broadcast-edit').length){
    manaDrApplication.register('pageAdminBroadcastEdit', require('./pages/admin.broadcast.edit'));
}

if($('.page-admin.page-broadcast.page-broadcast-create').length){
    manaDrApplication.register('pageAdminBroadcastCreate', require('./pages/admin.broadcast.create'));
}

if($('.page-admin.page-broadcast.page-broadcast-index').length){
    manaDrApplication.register('pageAdminBroadcastIndex', require('./pages/admin.broadcast.index'));
}

if($('.page-admin.page-cme-events.page-cme-events-index').length){
    manaDrApplication.register('pageAdminCMEEventsIndex', require('./pages/admin.cme.events.index'));
}

if($('.page-admin.page-cme-organizers.page-cme-organizers-index').length){
    manaDrApplication.register('pageAdminCMEOrganizersIndex', require('./pages/admin.cme.organizers.index'));
}

if($('.page-admin.page-super-clinic.page-super-clinic-index').length){
    manaDrApplication.register('pageAdminSuperClinic', require('./pages/admin.super-clinic.index'));
}

$(function () {
    manaDrApplication.start();
});
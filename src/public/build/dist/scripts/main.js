!function(e){var t={};function n(a){if(t[a])return t[a].exports;var o=t[a]={exports:{},id:a,loaded:!1};return e[a].call(o.exports,o,o.exports,n),o.loaded=!0,o.exports}n.m=e,n.c=t,n.p="/build/dist/",n(0)}([function(e,t,n){"use strict";n(1),n(2),n(3),n(4),n(5),n(6),n(7),n(8);var a=n(15);window.manaDrApplication=n(25),manaDrApplication.register("window",n(27)),manaDrApplication.register("modalRescheduleAppointment",n(28)),manaDrApplication.register("modalConsultSummary",n(51)),manaDrApplication.register("modalUpdateBookingReason",n(52)),manaDrApplication.register("modalLocationPicker",n(53)),manaDrApplication.register("modalSendAppointmentMessage",n(70)),manaDrApplication.register("modalVerifyPatient",n(71)),manaDrApplication.register("modalBlockTimeslots",n(72)),manaDrApplication.register("modalCreateAppointment",n(73)),manaDrApplication.register("modalCreatePatient",n(79)),manaDrApplication.register("modalManageHouseCallReasons",n(80)),manaDrApplication.register("modalCreateHouseCallReason",n(81)),manaDrApplication.register("modalUpdateHouseCallReason",n(82)),manaDrApplication.register("modalManageHouseCallReasonDoctors",n(83)),manaDrApplication.register("modalClinicDoctorsPicker",n(84)),manaDrApplication.register("modalManageSurchargeSettings",n(85)),manaDrApplication.register("modalCreateSurchargeSetting",n(86)),manaDrApplication.register("modalUpdateSurchargeSetting",n(109)),manaDrApplication.register("modalCancelAppointment",n(110)),manaDrApplication.register("serviceAppointmentType",n(111)),manaDrApplication.register("serviceConsultReason",n(112)),manaDrApplication.register("serviceHouseCallReason",n(113)),manaDrApplication.register("serviceTimeslot",n(114)),manaDrApplication.register("serviceDoctorTeleconsultSettings",n(115)),manaDrApplication.register("serviceClinics",n(116)),manaDrApplication.register("serviceDoctorTimeslots",n(117)),manaDrApplication.register("serviceDoctorAppointments",n(118)),manaDrApplication.register("serviceCountries",n(119)),manaDrApplication.register("serviceAdminDoctors",n(120)),manaDrApplication.register("serviceAdminClinics",n(121)),manaDrApplication.register("serviceDoctorBookingFeeSurchargeSettings",n(122)),manaDrApplication.register("serviceAdminCMEEvents",n(123)),manaDrApplication.register("serviceAdminCMEOrganizers",n(124)),manaDrApplication.register("serviceAdminSuperClinicData",n(125)),manaDrApplication.register("servicePatients",n(126)),manaDrApplication.register("serviceAdminPatients",n(127)),manaDrApplication.register("serviceAdminAppointments",n(128)),$(".page-profile").length&&manaDrApplication.register("pageProfile",n(129)),$(".page-working-calendar.new").length&&manaDrApplication.register("pageWorkingCalendar",n(136),humps.camelizeKeys(a(globalData,"context.pageWorkingCalendar"))),$(".page-settings").length&&manaDrApplication.register("pageSettings",n(144)),$(".page-admin.page-clinics").length&&manaDrApplication.register("pageAdminClinic",n(148)),$(".page-appointments-details").length&&manaDrApplication.register("pageAppointmentDetails",n(150),humps.camelizeKeys(a(globalData,"context.pageAppointmentDetails"))),$(".page-patients-details").length&&manaDrApplication.register("pagePatientsDetails",n(155)),$(".page-admin.page-doctors-details").length&&manaDrApplication.register("pageAdminDoctorDetails",n(156),{data:humps.camelizeKeys(a(globalData,"context.pageAdminDoctorDetails"))}),$(".page-admin.page-work-companies").length&&manaDrApplication.register("pageAdminWorkCompanies",n(157)),$(".page-admin.page-insurance-companies").length&&manaDrApplication.register("pageAdminInsuranceCompanies",n(158)),$(".page-admin.page-consult-reasons").length&&manaDrApplication.register("pageAdminConsultReasons",n(159)),$(".page-admin.page-clinics.page-clinics-details").length&&manaDrApplication.register("pageAdminClinicsDetails",n(160)),$(".page-admin.page-broadcast.page-broadcast-edit").length&&manaDrApplication.register("pageAdminBroadcastEdit",n(162)),$(".page-admin.page-broadcast.page-broadcast-create").length&&manaDrApplication.register("pageAdminBroadcastCreate",n(163)),$(".page-admin.page-broadcast.page-broadcast-index").length&&manaDrApplication.register("pageAdminBroadcastIndex",n(164)),$(".page-admin.page-cme-events.page-cme-events-index").length&&manaDrApplication.register("pageAdminCMEEventsIndex",n(165)),$(".page-admin.page-cme-organizers.page-cme-organizers-index").length&&manaDrApplication.register("pageAdminCMEOrganizersIndex",n(166)),$(".page-admin.page-super-clinic.page-super-clinic-index").length&&manaDrApplication.register("pageAdminSuperClinic",n(167)),$(function(){manaDrApplication.start()})},function(e,t,n){e.exports=n.p+"vendors.js?hash=ff56e624e7b56da6cef1f05cc807c799"},function(e,t){},function(e,t){"use strict";jQuery.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}})},function(e,t){"use strict";jQuery.validator&&($.validator.addMethod("dateFormatDMY",function(e,t){return e.match(/^\d\d?\/\d\d?\/\d\d\d\d$/)},"Please enter a date in the format dd/mm/yyyy."),$.validator.addMethod("greaterThan",function(e,t,n){return""==$(n[0]).val()||(/Invalid|NaN/.test(new Date(e))?isNaN(e)&&isNaN($(n[0]).val())||Number(e)>Number($(n[0]).val()):new Date(e)>new Date($(n[0]).val()))},"Must be greater than {1}."))},function(e,t){"use strict";jQuery.validator&&jQuery.validator.addMethod("validateEmail",function(e,t){return this.optional(t)||function(e){return new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/).test(e)}(e)})},function(e,t){"use strict";jQuery.validator&&jQuery.validator.addMethod("validatePassword",function(e,t){for(var n=!1,a=!1,o=!1,i=0;i<e.length;i++)/^[a-zA-Z]+$/.test(e[i])&&(o=!0),/^[0-9]+$/.test(e[i])&&(a=!0);return a&&o&&(n=!0),n})},function(e,t){"use strict";jQuery.validator&&jQuery.validator.addMethod("validatePhoneNumber",function(e){return function(e){if(e.length){var t=new RegExp(/^0(?:9(?=\d{8}$)|1(?=\d{9}$))/gi);return t.test(e)}return!0}(e)})},function(e,t,n){"use strict";var a="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},o=n(9),i=n(13);swig&&swig.setFilter&&(swig.setFilter("formatTimestamp1",function(e){return moment(e,"YYYY-MM-DD HH:mm:ss").utcOffset(0).format("DD/MM/YYYY")}),swig.setFilter("formatTimestamp2",function(e,t,n){return moment(e).utcOffset(t).tz(t).format(n)}),swig.setFilter("formatTimestamp3",function(e){return moment(e,"YYYY-MM-DD").format("DD/MM/YYYY")}),swig.setFilter("formatTimestamp4",function(e){return moment(e,"YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY")}),swig.setFilter("renderSelectedOption",function(e,t,n){return o(t,function(t){return t[n]===e})>-1?'selected="selected"':""}),swig.setFilter("checkIfIndexOf",function(e,t){return i(t,e)>-1?"1":"0"}),swig.setFilter("formatWithoutTimezone",function(e,t){return moment.tz(e,"Europe/London").format(t)}),swig.setFilter("typeof",function(e){return void 0===e?"undefined":a(e)}),swig.setFilter("split",function(e,t){return e.split(t)}))},function(e,t,n){var a=n(10),o=n(11),i=n(12),l=Math.max;e.exports=function(e,t,n){var r=null==e?0:e.length;if(!r)return-1;var s=null==n?0:i(n);return s<0&&(s=l(r+s,0)),a(e,o(t,3),s)}},function(e,t){e.exports=function(e,t,n,a){for(var o=e.length,i=n+(a?1:-1);a?i--:++i<o;)if(t(e[i],i,e))return i;return-1}},function(e,t){e.exports=function(e){return e}},function(e,t){e.exports=function(e){return e}},function(e,t,n){var a=n(14),o=n(12),i=Math.max;e.exports=function(e,t,n){var l=null==e?0:e.length;if(!l)return-1;var r=null==n?0:o(n);return r<0&&(r=i(l+r,0)),a(e,t,r)}},function(e,t){e.exports=function(e,t,n){for(var a=n-1,o=e.length;++a<o;)if(e[a]===t)return a;return-1}},function(e,t,n){var a=n(16);e.exports=function(e,t,n){var o=null==e?undefined:a(e,t);return o===undefined?n:o}},function(e,t,n){var a=n(17),o=n(24);e.exports=function(e,t){for(var n=0,i=(t=a(t,e)).length;null!=e&&n<i;)e=e[o(t[n++])];return n&&n==i?e:undefined}},function(e,t,n){var a=n(18),o=n(19),i=n(21),l=n(23);e.exports=function(e,t){return a(e)?e:o(e,t)?[e]:i(l(e))}},function(e,t){var n=Array.isArray;e.exports=n},function(e,t,n){var a=n(18),o=n(20),i=/\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/,l=/^\w*$/;e.exports=function(e,t){if(a(e))return!1;var n=typeof e;return!("number"!=n&&"symbol"!=n&&"boolean"!=n&&null!=e&&!o(e))||l.test(e)||!i.test(e)||null!=t&&e in Object(t)}},function(e,t){e.exports=function(){return!1}},function(e,t,n){var a=/[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g,o=/\\(\\)?/g,i=n(22)(function(e){var t=[];return 46===e.charCodeAt(0)&&t.push(""),e.replace(a,function(e,n,a,i){t.push(a?i.replace(o,"$1"):n||e)}),t});e.exports=i},function(e,t){e.exports=function(e){return e}},function(e,t){e.exports=function(e){return e}},function(e,t){e.exports=function(e){return e}},function(e,t,n){"use strict";var a=n(26),o=new scaleApp.Core(a);o.use(scaleApp.plugins.ls),o.use(scaleApp.plugins.util),o.use(scaleApp.plugins.submodule,{inherit:!0,use:["ls","submodule","util"],useGlobalMediator:!0}),o.userAgent=new UAParser,e.exports=o},function(e,t){"use strict";e.exports=function(e,t,n,a){return this.namespace="manadr",e._mediator.installTo(this),this.myEmit=function(n,a){e.emit(n+"/"+t,a)},this.id=t,this.options=n,this.userAgent=new UAParser,this}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.showNotify=function(e){var t=e.icon,n=e.message,a=e.type,o=e.allowDismiss,i=o===undefined||o,l=e.delay,r=l===undefined?500:l;$.notify({icon:t,message:n},{type:a,z_index:1030,delay:r,allow_dismiss:i,placement:{from:"top",align:"right"}})},e.on("window/reload",function(){window.location.reload()}),e.on("window/loading/show",function(){t.objects.$loading.removeClass("hide")}),e.on("window/loading/hide",function(){t.objects.$loading.addClass("hide")}),e.on("window/notify/show",function(e){var n=e.icon,a=e.message,o=e.type,i=e.allowDismiss,l=e.delay;t.showNotify({icon:n,message:a,type:o,allowDismiss:i,delay:l})}),t.init=function(e){t.objects={},t.objects.$loading=$("#overlay_loading")},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=n(29),o=n(15),i=n(44),l=o(globalData,"context.dashboardType","doctor");e.exports=function(e){var t=this;return t.showModalReschedule=function(e){var n=e.appointmentTypeId,o=(e.appointmentTypeName,e.appointmentTypeCategory),r=e.appointmentId,s=e.doctorId;if(!t.data.isActive&&(t.data.isActive=!0,n&&r)){var c=bootbox.dialog({title:"Reschedule Appointment",message:swig.render(t.templates.modalMessage,{locals:{}}),size:"large",className:"modal-reschedule-appointment"});c.on("shown.bs.modal",function(e){var n=c.find("#form_find_timeslots"),d=n.find("#form_find_timeslots__input_date"),u=c.find("#list_available_timeslots"),f=c.find("#overlay_loading");d.datepicker({maxViewMode:"month",weekStart:1,todayHighlight:!0,startDate:moment().format("DD/MM/YYYY"),format:"dd/mm/yyyy",disableTouchKeyboard:!0,clearBtn:!0}),u.on("click","[data-id]",function(e){e.preventDefault();var t=$(this),n=t.data("id");bootbox.confirm("Are you sure to reschedule selected appointment to <b>"+t.data("appointment-type-name")+"</b> timeslot at <b>"+t.data("date")+" "+t.text()+"</b>?",function(e){if(e){f.removeClass("hide");var t=void 0;switch(l){case"admin":t="admin.appointment.reschedule";break;case"doctor":default:t="appointment.reschedule.submit"}$.ajax({url:laroute.route(t,{appointment:r}),method:"POST",dataType:"json",data:{appointmentId:r,doctorTimetableId:n}}).done(function(e){e.success||bootbox.alert("Error occured. The appointment hasn't been reschedule yet!"),bootbox.alert("The appointment has been rescheduled successfully!",function(){window.location.reload()})}).fail(function(e){bootbox.alert("Error occured. The appointment hasn't been reschedule yet!")}).always(function(){f.addClass("hide")})}})}),n.on("submit",function(e){e.preventDefault();var r=d.val(),c=moment(r,"DD/MM/YYYY");if(!c.isValid())return!1;n.addClass("submitting"),u.html("");var f=void 0;switch(l){case"admin":f="admin.doctor.workingCalendar.timeslot.index";break;case"doctor":default:f="working-calendar.feed"}var m={filters:JSON.stringify({condition:[],label:["available"],clinic:[],appointmentTypeCategory:[o]}),from:1e3*c.unix(),to:1e3*c.add(1,"day").unix(),utc_offset_from:(new Date).getTimezoneOffset(),utc_offset_to:(new Date).getTimezoneOffset()};s&&(m.doctor=s),$.ajax({url:laroute.route(f,m),dataType:"json",type:"GET",async:!1}).done(function(e){e.success||console.log("error");var n=undefined;if(e.result){var o=a(e.result,function(e){return{id:e.id,appointmentType:e.appointmentType?e.appointmentType.name:"",startAt:moment(e.start).utcOffset(e.timezone).tz(e.timezone).format("HH:mm"),endAt:moment(e.end).utcOffset(e.timezone).tz(e.timezone).format("HH:mm")}});n=i(o,function(e){return e.appointmentType})}var l=swig.render(t.templates.listAvailableTimeslots,{locals:{selectedDate:r,timeslotsGroup:n}});u.html(l)}).always(function(){n.removeClass("submitting")})})}).on("hidden.bs.modal",function(e){t.data.isActive=!1})}},e.on("modal/rescheduleAppointment/show",function(e){var n=e.appointmentTypeId,a=e.appointmentTypeName,o=e.appointmentTypeCategory,i=e.appointmentId,l=e.doctorId;t.showModalReschedule({appointmentTypeId:n,appointmentTypeName:a,appointmentTypeCategory:o,appointmentId:i,doctorId:l})}),t.init=function(e){t.data=e||{},t.data.isActive=!1,t.templates={},t.templates.modalMessage=multiline(function(){
/*!@preserve
	            <form class="form" id="form_find_timeslots">
	            <div class="form-group text-center">
	            Please choose the date you want to move the schedule & click search.
	            </div>
	            <div class="form-group clearfix">
	            <div class="col-md-8 col-md-offset-2">
	            <div class="input-group">
	            <input class="form-control" id="form_find_timeslots__input_date" type="text"/>
	            <span class="input-group-btn">
	            <button type="submit" class="btn btn-primary btn-flat">
	            <i class="fa fa-spin fa-refresh"></i>
	            Search
	            </button>
	            </span>
	            </div>
	            </div>
	            </div>
	            </form>
	            <div id="list_available_timeslots"></div>
	            <div id="overlay_loading" class="hide"><i class="fa fa-spin fa-refresh"></i></div>
	            */
console.log}),t.templates.listAvailableTimeslots=multiline(function(){
/*!@preserve
	            {% if Object.keys(timeslotsGroup).length > 0 %}
	            {% for appointmentTypeName, timeslots in timeslotsGroup %}
	            <p>There {% if timeslots.length == 1 %}is{%else%}are{%endif%} <b>{{timeslots.length}}</b> available <b>{{appointmentTypeName}}</b> {% if timeslots.length == 1 %}timeslot{%else%}timeslots{%endif%} in {{selectedDate}}:</p>
	            <h4>
	            {% for timeslot in timeslots %}
	            <a class="label label-default" data-date={{selectedDate}} data-id="{{timeslot.id}}" data-appointment-type-name="{{appoinmentTypeName}}">{{timeslot.startAt}} - {{timeslot.endAt}}</a>
	            {% endfor %}
	            </h4>
	            {% endfor %}
	            {% else %}
	            <p>There is no available timeslots in {{selectedDate}}</p>
	            {% endif %}
	            */
console.log})},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){var a=n(30),o=n(11),i=n(31),l=n(18);e.exports=function(e,t){return(l(e)?a:i)(e,o(t,3))}},function(e,t){e.exports=function(e,t){for(var n=-1,a=null==e?0:e.length,o=Array(a);++n<a;)o[n]=t(e[n],n,e);return o}},function(e,t,n){var a=n(32),o=n(39);e.exports=function(e,t){var n=-1,i=o(e)?Array(e.length):[];return a(e,function(e,a,o){i[++n]=t(e,a,o)}),i}},function(e,t,n){var a=n(33),o=n(38)(a);e.exports=o},function(e,t,n){var a=n(34),o=n(36);e.exports=function(e,t){return e&&a(e,t,o)}},function(e,t,n){var a=n(35)();e.exports=a},function(e,t){e.exports=function(e){return function(t,n,a){for(var o=-1,i=Object(t),l=a(t),r=l.length;r--;){var s=l[e?r:++o];if(!1===n(i[s],s,i))break}return t}}},function(e,t,n){var a=n(37)(Object.keys,Object);e.exports=a},function(e,t){e.exports=function(e,t){return function(n){return e(t(n))}}},function(e,t,n){var a=n(39);e.exports=function(e,t){return function(n,o){if(null==n)return n;if(!a(n))return e(n,o);for(var i=n.length,l=t?i:-1,r=Object(n);(t?l--:++l<i)&&!1!==o(r[l],l,r););return n}}},function(e,t,n){var a=n(40),o=n(43);e.exports=function(e){return null!=e&&o(e.length)&&!a(e)}},function(e,t,n){var a=n(41),o=n(42),i="[object AsyncFunction]",l="[object Function]",r="[object GeneratorFunction]",s="[object Proxy]";e.exports=function(e){if(!o(e))return!1;var t=a(e);return t==l||t==r||t==i||t==s}},function(e,t){var n=Object.prototype.toString;e.exports=function(e){return n.call(e)}},function(e,t){e.exports=function(e){var t=typeof e;return null!=e&&("object"==t||"function"==t)}},function(e,t){var n=9007199254740991;e.exports=function(e){return"number"==typeof e&&e>-1&&e%1==0&&e<=n}},function(e,t,n){var a=n(45),o=n(48),i=Object.prototype.hasOwnProperty,l=o(function(e,t,n){i.call(e,n)?e[n].push(t):a(e,n,[t])});e.exports=l},function(e,t,n){var a=n(46);e.exports=function(e,t,n){"__proto__"==t&&a?a(e,t,{configurable:!0,enumerable:!0,value:n,writable:!0}):e[t]=n}},function(e,t,n){var a=n(47),o=function(){try{var e=a(Object,"defineProperty");return e({},"",{}),e}catch(t){}}();e.exports=o},function(e,t){e.exports=function(e,t){return null==e?undefined:e[t]}},function(e,t,n){var a=n(49),o=n(50),i=n(11),l=n(18);e.exports=function(e,t){return function(n,r){var s=l(n)?a:o,c=t?t():{};return s(n,e,i(r,2),c)}}},function(e,t){e.exports=function(e,t,n,a){for(var o=-1,i=null==e?0:e.length;++o<i;){var l=e[o];t(a,l,n(l),e)}return a}},function(e,t,n){var a=n(32);e.exports=function(e,t,n,o){return a(e,function(e,a,i){t(o,e,n(e),i)}),o}},function(e,t,n){"use strict";var a=n(15)(globalData,"context.dashboardType","doctor");e.exports=function(e){var t=this;return t.showModalAddHealthSummary=function(e){var n=e.appointmentId,o=e.doneCallback,i=e.failCallback,l=n,r=bootbox.dialog({title:"Add Consult Summary",message:swig.render(t.templates.modal,{locals:{appointmentId:l}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}},skip:{label:"Skip for now",className:"btn btn-warning",callback:function(e){bootbox.alert("You've marked this appointment as visited without a health summary. Please note that you can always add this later in appointment details page.",function(){"function"==typeof o&&o()})}}}});r.on("shown.bs.modal",function(e){var t=r.find("form");t.validate({rules:{summary:{require_from_group:[1,"textarea"]},plan:{require_from_group:[1,"textarea"]},visit_doctor_if:{require_from_group:[1,"textarea"]}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(e,n){if(n.preventDefault(),!parseInt(t.data("is-submitting"))){var s=t.serialize();manaDrApplication.emit("window/loading/show"),t.data("is-submitting",1),r.find(":input").prop("disabled",!0);var c=void 0;switch(a){case"admin":c="admin.appointment.createHealthSummary";break;case"doctor":default:c="appointment.createHealthSummary"}$.ajax({url:laroute.route(c,{appointment:l}),method:"POST",data:s,dataType:"json"}).done(function(e){bootbox.alert("Health summary has been added",function(){r.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o()})}).fail(function(e,n){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){t.data("is-submitting",0),r.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof i&&i()})})}}})})},t.showModalUpdateHealthSummary=function(e){var n=e.appointmentId,a=e.content,o=e.doneCallback,i=e.failCallback,l=n,r=bootbox.dialog({title:"Update Consult Summary",message:swig.render(t.templates.modal,{locals:{appointmentId:l,title:a.title,summary:a.summary,plan:a.plan,visitDoctorIf:a.visitDoctorIf}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Update",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});r.on("shown.bs.modal",function(e){var t=r.find("form");t.validate({rules:{summary:{require_from_group:[1,"textarea"]},plan:{require_from_group:[1,"textarea"]},visit_doctor_if:{require_from_group:[1,"textarea"]}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(e,n){if(n.preventDefault(),!parseInt(t.data("is-submitting"))){var a=t.serialize();manaDrApplication.emit("window/loading/show"),t.data("is-submitting",1),r.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("appointment.updateHealthSummary",{appointment:l}),method:"POST",data:a,dataType:"json"}).done(function(e){bootbox.alert("Health summary has been updated",function(){r.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o()})}).fail(function(e,n){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){t.data("is-submitting",0),r.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof i&&i()})})}}})})},e.on("modalHealthSummary/showAdd",function(e){var n=e.appointmentId,a=e.doneCallback,o=e.failCallback;t.showModalAddHealthSummary({appointmentId:n,doneCallback:a,failCallback:o})}),e.on("modalHealthSummary/showUpdate",function(e){var n=e.appointmentId,a=e.content,o=e.doneCallback,i=e.failCallback;t.showModalUpdateHealthSummary({appointmentId:n,content:a,doneCallback:o,failCallback:i})}),t.init=function(e){t.data=e||{},t.templates={},t.templates.modal=multiline(function(){
/*!@preserve
	            <form class="form">
	            <input type="hidden" name="appointment_id" value="{{appointmentId}}"/>
	            <div class="form-group">
	            <label for="form__input_title" class="control-label">Title:</label>
	            <input class="form-control" name="title" value="{{title}}"/>
	            </div>
	            <div class="form-group">
	            <label for="form__textarea_summary" class="control-label">Summary:</label>
	            <textarea class="form-control" name="summary">{{summary}}</textarea>
	            </div>
	            <div class="form-group">
	            <label for="form__textarea_plan" class="control-label">Plan:</label>
	            <textarea class="form-control" name="plan">{{plan}}</textarea>
	            </div>
	            <div class="form-group">
	            <label for="form__textarea_visit_doctor_if" class="control-label">Visit doctor if:</label>
	            <textarea class="form-control" name="visit_doctor_if">{{visitDoctorIf}}</textarea>
	            </div>
	            </form>
	            */
console.log})},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.showModal=function(e){var n=e.appointmentId,a=e.content,o=e.doneCallback,i=e.failCallback,l=bootbox.dialog({title:"Update Booking Reason",message:swig.render(t.templates.modal,{locals:{appointmentId:n,content:a}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});l.on("shown.bs.modal",function(e){var t=l.find("form");t.validate({rules:{},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(e,a){if(a.preventDefault(),!parseInt(t.data("is-submitting"))){var r=t.serialize();manaDrApplication.emit("window/loading/show"),t.data("is-submitting",1),l.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("appointment.updateBookingReason",{appointment:n}),method:"POST",data:r,dataType:"json"}).done(function(e){bootbox.alert("Booking reason has been updated",function(){l.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o()})}).fail(function(e,n){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){t.data("is-submitting",0),l.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof i&&i()})})}}})})},t.init=function(e){t.data=e||{},t.templates={},t.templates.modal=multiline(function(){
/*!@preserve
	            <form class="form">
	            <input type="hidden" name="appointment_id" value="{{appointmentId}}"/>
	            <div class="form-group">
	            <label for="form__input_title" class="control-label">Booking Reason:</label>
	            <textarea class="form-control" name="booking_reason">{{content.bookingReason}}</textarea>
	            </div>
	            </form>
	            */
console.log})},e.on("modalUpdateBookingReason/show",function(e){var n=e.appointmentId,a=e.content,o=e.doneCallback,i=e.failCallback;t.showModal({appointmentId:n,content:a,doneCallback:o,failCallback:i})}),t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=n(54);a.KEY="AIzaSyAb6zQRkXnjua7WNqFXzciULhd_R5lHSOo";var o=n(55),i=n(56),l=n(15),r=n(68);e.exports=function(e){var t=this;return t.render=function(){},t.bindEvents=function(){},t.updateCurrentPosition=function(e){e&&e.lat&&!r(e.lat)&&e.lng&&!r(e.lng)&&(t.data.currentPosition.lat=e.lat,t.data.currentPosition.lng=e.lng)},t.renderCurrentPosition=function(){var e=swig.render(t.templates.segmentSelectedPosition,{locals:{position:t.data.currentPosition}});$(t.DOMSelectors.segmentSelectedPosition).html(e)},t.showModal=function(e){var n=e.address,i=e.doneCallback,r=o("map_container_"),s=bootbox.dialog({title:"Location Picker",className:"modal-location-picker",message:swig.render(t.templates.modal,{locals:{address:n,containerId:r}}),buttons:{submit:{label:"Submit",className:"btn btn-primary",callback:function(){if("function"==typeof i){var e=$(this).find("form");i({address:e.find("[name=address]").val(),position:{lat:l(t.data,"currentPosition.lat"),lng:l(t.data,"currentPosition.lng")}})}}}}});s.on("shown.bs.modal",function(e){var o=s.find("form");a.load(function(e){var a=new e.maps.Map(document.getElementById(r),{center:l(t.data,"currentPosition"),zoom:l(t.data,"currentZoom")}),i=new e.maps.Marker({position:l(t.data,"currentPosition"),map:a,draggable:!0});e.maps.event.addListener(i,"dragend",function(e){console.log("dragend")});var c=new e.maps.Geocoder;o.on("submit",function(e){if(e.preventDefault(),!parseInt(o.data("is-submitting"))){o.data("is-submitting",1),s.find(":input").prop("disabled",!0);var n=o.find("input").val();c.geocode({address:n},function(e,n){"OK"==n&&(a.setCenter(e[0].geometry.location),i.setPosition(e[0].geometry.location),t.updateCurrentPosition({lat:e[0].geometry.location.lat(),lng:e[0].geometry.location.lng()})),o.data("is-submitting",0),s.find(":input").prop("disabled",!1)})}}).removeClass("hide"),n&&o.trigger("submit")})})},e.on("modalLocationPicker/show",function(e){var n=e.address,a=e.position,o=e.doneCallback;t.updateCurrentPosition(a),t.showModal({address:n,doneCallback:o})}),t.init=function(e){t.data=i(e,{currentPosition:{lat:1.352083,lng:103.81983600000001},currentZoom:13}),t.templates={},t.templates.modal=multiline(function(){
/*!@preserve
	            <form class="form hide">
	            <div class="form-group">
	            <div class="input-group input-group-sm">
	            <input class="form-control" type="text" value="{{address}}" name="address" />
	            <span class="input-group-btn">
	            <button type="submit" class="btn btn-info">
	            <i class="fa fa-search"></i>
	            </button>
	            </span>
	            </div>
	            </div>
	            </form>
	            <div id="{{containerId}}" style="height:300px;"></div>
	            */
console.log}),t.DOMSelectors={},t.objects={}},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){var a,o;!function(i,l){if(null===i)throw new Error("Google-maps package can be used only in browser");(o="function"==typeof(a=l)?a.call(t,n,t,e):a)===undefined||(e.exports=o)}("undefined"!=typeof window?window:null,function(){"use strict";var e=null,t=null,n=!1,a=[],o=[],i=null,l={URL:"https://maps.googleapis.com/maps/api/js",KEY:null,LIBRARIES:[],CLIENT:null,CHANNEL:null,LANGUAGE:null,REGION:null,VERSION:"3.31",WINDOW_CALLBACK_NAME:"__google_maps_api_provider_initializator__",_googleMockApiObject:{},load:function(e){null===t?!0===n?e&&a.push(e):(n=!0,window[l.WINDOW_CALLBACK_NAME]=function(){r(e)},l.createLoader()):e&&e(t)},createLoader:function(){(e=document.createElement("script")).type="text/javascript",e.src=l.createUrl(),document.body.appendChild(e)},isLoaded:function(){return null!==t},createUrl:function(){var e=l.URL;return e+="?callback="+l.WINDOW_CALLBACK_NAME,l.KEY&&(e+="&key="+l.KEY),l.LIBRARIES.length>0&&(e+="&libraries="+l.LIBRARIES.join(",")),l.CLIENT&&(e+="&client="+l.CLIENT),l.CHANNEL&&(e+="&channel="+l.CHANNEL),l.LANGUAGE&&(e+="&language="+l.LANGUAGE),l.REGION&&(e+="&region="+l.REGION),l.VERSION&&(e+="&v="+l.VERSION),e},release:function(r){var s=function(){l.KEY=null,l.LIBRARIES=[],l.CLIENT=null,l.CHANNEL=null,l.LANGUAGE=null,l.REGION=null,l.VERSION="3.31",t=null,n=!1,a=[],o=[],"undefined"!=typeof window.google&&delete window.google,"undefined"!=typeof window[l.WINDOW_CALLBACK_NAME]&&delete window[l.WINDOW_CALLBACK_NAME],null!==i&&(l.createLoader=i,i=null),null!==e&&(e.parentElement.removeChild(e),e=null),r&&r()};n?l.load(function(){s()}):s()},onLoad:function(e){o.push(e)},makeMock:function(){i=l.createLoader,l.createLoader=function(){window.google=l._googleMockApiObject,window[l.WINDOW_CALLBACK_NAME]()}}},r=function(e){var i;for(n=!1,null===t&&(t=window.google),i=0;i<o.length;i++)o[i](t);for(e&&e(t),i=0;i<a.length;i++)a[i](t);a=[]};return l})},function(e,t,n){var a=n(23),o=0;e.exports=function(e){var t=++o;return a(e)+t}},function(e,t,n){var a=n(57),o=n(59),i=n(60),l=n(39),r=n(67),s=n(36),c=Object.prototype.hasOwnProperty,d=i(function(e,t){if(r(t)||l(t))o(t,s(t),e);else for(var n in t)c.call(t,n)&&a(e,n,t[n])});e.exports=d},function(e,t,n){var a=n(45),o=n(58),i=Object.prototype.hasOwnProperty;e.exports=function(e,t,n){var l=e[t];i.call(e,t)&&o(l,n)&&(n!==undefined||t in e)||a(e,t,n)}},function(e,t){e.exports=function(e,t){return e===t||e!=e&&t!=t}},function(e,t,n){var a=n(57),o=n(45);e.exports=function(e,t,n,i){var l=!n;n||(n={});for(var r=-1,s=t.length;++r<s;){var c=t[r],d=i?i(n[c],e[c],c,n,e):undefined;d===undefined&&(d=e[c]),l?o(n,c,d):a(n,c,d)}return n}},function(e,t,n){var a=n(61),o=n(66);e.exports=function(e){return a(function(t,n){var a=-1,i=n.length,l=i>1?n[i-1]:undefined,r=i>2?n[2]:undefined;for(l=e.length>3&&"function"==typeof l?(i--,l):undefined,r&&o(n[0],n[1],r)&&(l=i<3?undefined:l,i=1),t=Object(t);++a<i;){var s=n[a];s&&e(t,s,a,l)}return t})}},function(e,t,n){var a=n(62),o=n(63),i=n(65);e.exports=function(e,t){return i(o(e,t,a),e+"")}},function(e,t){e.exports=function(e){return e}},function(e,t,n){var a=n(64),o=Math.max;e.exports=function(e,t,n){return t=o(t===undefined?e.length-1:t,0),function(){for(var i=arguments,l=-1,r=o(i.length-t,0),s=Array(r);++l<r;)s[l]=i[t+l];l=-1;for(var c=Array(t+1);++l<t;)c[l]=i[l];return c[t]=n(s),a(e,this,c)}}},function(e,t){e.exports=function(e,t,n){switch(n.length){case 0:return e.call(t);case 1:return e.call(t,n[0]);case 2:return e.call(t,n[0],n[1]);case 3:return e.call(t,n[0],n[1],n[2])}return e.apply(t,n)}},function(e,t){e.exports=function(e){return e}},function(e,t){e.exports=function(){return!1}},function(e,t){e.exports=function(){return!1}},function(e,t,n){var a=n(41),o=n(69),i="[object Number]";e.exports=function(e){return"number"==typeof e||o(e)&&a(e)==i}},function(e,t){e.exports=function(e){return null!=e&&"object"==typeof e}},function(e,t,n){"use strict";var a=n(15),o=a(globalData,"context.dashboardType","doctor");e.exports=function(e){var t=this;t.fetchAppointment=function(e){var t=e.appointmentId,n=e.doneCallback,a=e.failCallback;manaDrApplication.emit("window/loading/show");var i=void 0;switch(o){case"admin":i="admin.appointment.fetch";break;case"doctor":default:i="appointment.fetch"}$.ajax({url:laroute.route(i,{appointment:t}),method:"GET"}).done(function(e){"function"==typeof n&&n(e)}).fail(function(e,t){"function"==typeof a&&a(e,t)}).always(function(){manaDrApplication.emit("window/loading/hide")})},t.showModal=function(e){var n=e.appointment,i=e.doneCallback,l=e.failCallback,r=n.id,s=a(n,"booker.firstName",""),c=a(n,"booker.lastName",""),d=s.length||c.length?s+" "+c:"booker",u=bootbox.dialog({title:"Send appointment message",message:swig.render(t.templates.modal,{locals:n}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});u.on("shown.bs.modal",function(e){var t=u.find("form");t.validate({rules:{message:{required:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(e,n){if(n.preventDefault(),!parseInt(t.data("is-submitting"))){var a=t.serialize();manaDrApplication.emit("window/loading/show"),t.data("is-submitting",1),u.find(":input").prop("disabled",!0);var s=void 0;switch(o){case"admin":s="admin.appointment.sendMessage";break;case"doctor":default:s="appointment.sendMessage"}$.ajax({url:laroute.route(s,{appointment:r}),method:"POST",data:a,dataType:"json"}).done(function(e){var t="The message has been sent to "+d+"'s device.";bootbox.alert(t,function(){u.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof i&&i()})}).fail(function(e,n){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){t.data("is-submitting",0),u.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof l&&l(e,n)})})}}})})},e.on("modalSendAppointmentMessage/show",function(e){var n=e.appointmentId,a=e.doneCallback,o=e.failCallback;t.fetchAppointment({appointmentId:n,doneCallback:function(e){var n=humps.camelizeKeys(e);t.showModal({appointment:n,doneCallback:a,failCallback:o})},failCallback:function(e,t){"function"==typeof o&&o(e,t)}})}),t.init=function(e){t.data=e||{},t.templates={},t.templates.modal=multiline(function(){
/*!@preserve
	            <form class="form" data-is-submitting="0">
	            <div class="form-group">
	            <label for="message">Message:</label>
	            <textarea class="form-control" name="message" maxlength="250"></textarea>
	            </div>
	            </form>
	            */
console.log})}}},function(e,t,n){"use strict";var a=n(15)(globalData,"context.dashboardType","doctor");e.exports=function(e){var t=this;return t.fetchPatientInformation=function(e){var t=e.patientId,n=e.doneCallback,o=e.failCallback;manaDrApplication.emit("window/loading/show");var i=void 0;switch(a){case"admin":i="admin.patient.fetch";break;case"doctor":default:i="doctor.patient.fetch"}$.ajax({url:laroute.route(i,{patient:t}),method:"POST"}).done(function(e){manaDrApplication.emit("window/loading/hide"),"function"==typeof n&&n(e)}).fail(function(e,t){manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o(e,t)})},t.fetchCountries=function(e){var t=e.doneCallback,n=e.failCallback;manaDrApplication.emit("window/loading/show"),$.ajax({url:laroute.route("public.resource.country"),method:"GET"}).done(function(e){manaDrApplication.emit("window/loading/hide"),"function"==typeof t&&t(e)}).fail(function(e,t){manaDrApplication.emit("window/loading/hide"),"function"==typeof n&&n(e,t)})},t.showModal=function(e){var n=e.patientData,o=e.countriesData,i=e.doneCallback,l=e.failCallback,r=n.id,s=bootbox.dialog({title:"Verify Patient Information",message:swig.render(t.templates.modal,{locals:{patient:n,countries:o}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Verify & Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});s.on("shown.bs.modal",function(e){var t=s.find("form");t.find("input").first().focus(),t.find('[name="date_of_birth"]').datepicker({format:"dd/mm/yyyy",weekStart:1,minViewMode:"month",maxViewMode:"years",orientation:"bottom",disableTouchKeyboard:!0,autoclose:!0,defaultViewDate:{year:1980,month:0,day:1},startView:"years"}),t.validate({rules:{first_name:{required:!0,minlength:1,maxlength:255},last_name:{required:!0,minlength:1,maxlength:255},date_of_birth:{required:!0,dateFormatDMY:!0},gender:{required:!0},email:{required:{depends:function(){return $(this).val().length}},validateEmail:""},phone_number:{number:!0},id_number:{},address_zip:{number:!0}},messages:{email:{required:"",validateEmail:"Invalid email format."}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(e,n){if(n.preventDefault(),!parseInt(t.data("is-submitting"))){var o=$(e).serialize();manaDrApplication.emit("window/loading/show"),t.data("is-submitting",1),s.find(":input").prop("disabled",!0);var c=void 0;switch(a){case"admin":c="admin.patient.update";break;case"doctor":default:c="doctor.patient.update"}$.ajax({url:laroute.route(c,{patient:r}),method:"POST",data:o,dataType:"json"}).done(function(e){var t="";t=e&&e.id?"Patient info has been verified!":"Request has been processed successfully",bootbox.alert(t,function(){s.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof i&&i(e)})}).fail(function(e,n){var a="",o=multiline(function(){
/*!@preserve
	                            <p>{{message}}</p>
	                            {% if error|typeof === 'object' %}
	                            <ul>
	                            {% for key,value in error %}
	                            <li>{{value}}</li>
	                            {% endfor %}
	                            </ul>
	                            {% endif %}
	                            */
console.log});a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?swig.render(o,{locals:e.responseJSON}):"The request cannot be processed",bootbox.alert(a,function(){t.data("is-submitting",0),s.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof l&&l(e,n)})})}}})})},e.on("modalVerifyPatient/show",function(e){var n=e.patientId,a=e.doneCallback,o=e.failCallback;t.fetchPatientInformation({patientId:n,doneCallback:function(e){var n=humps.camelizeKeys(e);t.fetchCountries({doneCallback:function(e){var i=humps.camelizeKeys(e);t.showModal({patientData:n,countriesData:i,doneCallback:function(e){"function"==typeof a&&a(e)},failCallback:function(e,t){"function"==typeof o&&o(e,t)}})},failCallback:function(e,t){"function"==typeof o&&o(e,t)}})},failCallback:function(e,t){"function"==typeof o&&o(e,t)}})}),t.init=function(e){t.data=e||{},t.templates={},t.templates.modal=multiline(function(){
/*!@preserve
	            <form class="form" data-is-submitting="0">
	            <input type="hidden" name="verified" id="verified" value="1"/>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label for="first_name">First Name (*):</label>
	            <input type="text" name="first_name" id="modal_edit_patient__form__input_first_name" class="form-control" value="{{patient.firstName}}"/>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label for="last_name">Last Name (*):</label>
	            <input type="text" name="last_name" id="modal_edit_patient__form__input_last_name" class="form-control" value="{{patient.lastName}}"/>
	            </div>
	            </div>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label for="gender">Gender (*):</label>
	            <p>
	            <label class="radio-inline">
	            <input type="radio" name="gender" id="gender_male" value="Male" {% if patient.gender|lower === 'male' %}checked{% endif %}/>
	            Male
	            </label>
	            <label class="radio-inline">
	            <input type="radio" name="gender" id="gender_male" value="Female" {% if patient.gender|lower === 'female' %}checked{% endif %}/>
	            Female
	            </label>
	            <label class="radio-inline">
	            <input type="radio" name="gender" id="gender_male" value="Other" {% if patient.gender|lower === 'other' %}checked{% endif %}/>
	            Other
	            </label>
	            </p>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label for="date_of_birth">Date of Birth (*):</label>
	            <input class="form-control" name="date_of_birth" id="form_edit_patient__input_date_of_birth" value="{{patient.dateOfBirth|date('d/m/Y')}}"/>
	            </div>
	            </div>
	            </div>
	            <div class="form-group">
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label for="email">Email:</label>
	            <input type="text" name="email" id="modal_edit_patient__form__input_email" class="form-control" value="{{patient.email}}"/>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label for="race">Race:</label>
	            <input type="text" name="race" id="modal_edit_patient__form__input_race" class="form-control" value="{{patient.race}}"/>
	            </div>
	            </div>
	            </div>
	            </div>
	            <label for="phone_number">Phone Number:</label>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <select class="form-control" name="phone_country_code" id="phone_country_code">
	            <option value="">(Undetermined)</option>
	            {% for country in countries %}
	            <option value="{{country.phoneCountryCode }}" {% if country.phoneCountryCode == patient.phoneCountryCode %}selected{% endif %}>{{country.niceName}} ({{ country.phoneCountryCode }})</option>
	            {% endfor %}
	            </select>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <input type="text" name="phone_number" id="modal_edit_patient__form__input_phone_number" class="form-control" value="{{patient.phoneNumber }}"/>
	            </div>
	            </div>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label for="address_street">Street:</label>
	            <input type="text" name="address_street" id="modal_edit_patient__form__input_address_street" class="form-control" value="{{patient.addressStreet }}"/>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label for="address_zip">Zip Code:</label>
	            <input type="text" name="address_zip" id="modal_edit_patient__form__input_address_zip" class="form-control" value="{{patient.addressZip }}"/>
	            </div>
	            </div>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label for="address_city">City:</label>
	            <input type="text" name="address_city" id="modal_edit_patient__form__input_address_city" class="form-control" value="{{patient.addressCity}}"/>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label for="resident_country_id">Residence Country:</label>
	            <select class="form-control" name="resident_country_id">
	            <option value="">(Undetermined)</option>
	            {% for country in countries %}
	            <option value="{{ country.id }}" {% if country.id == patient.residentCountryId %}selected{% endif %}>{{country.niceName}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            </div>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label for="id_number">National ID Number (*):</label>
	            <input type="text" name="id_number" id="modal_edit_patient__form__input_id_number" class="form-control" value="{{patient.idNumber}}"/>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label for="issue_country_id">National ID Issuing Country (*):</label>
	            <select class="form-control" name="issue_country_id">
	            <option value="">(Undetermined)</option>
	            {% for country in countries %}
	            <option value="{{ country.id }}" {% if country.id == patient.issueCountryId %}selected{% endif %}>{{country.niceName}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            </div>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Medical Condition</label>
	            <textarea class="form-control vertical" name="medical_condition">{{patient.medicalCondition}}</textarea>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Drug Allergy</label>
	            <textarea class="form-control vertical" name="drug_allergy">{{patient.drugAllergy}}</textarea>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="checkbox-inline">
	            <input type="checkbox" name="deceased" id="deceased" value="1" {% if patient.deceased %}checked{% endif %}/>
	            Mark as deceased
	            </label>
	            </div>
	            </div>
	            </div>
	            </form>
	            */
console.log})},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";n(15)(globalData,"context.dashboardType","doctor");e.exports=function(e){var t=this;return t.showModal=function(n){var a=n.ids,o=n.doctorId,i=n.doneCallback,l=n.failCallback,r=bootbox.dialog({title:"Block timeslot",message:swig.render(t.templates.modal,{locals:{}}),buttons:{submit:{label:"Submit",className:"btn btn-warning",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}},cancel:{label:"Cancel",className:"btn"}}});r.on("shown.bs.modal",function(t){var n=r.find("form");n.validate({rules:{block_reason:{required:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(t,s){if(s.preventDefault(),!parseInt(n.data("is-submitting"))){var c=n.serialize();manaDrApplication.emit("window/loading/show"),n.data("is-submitting",1),r.find(":input").prop("disabled",!0),e.emit("service/timeslot/block",{ids:a,doctorId:o,data:c,doneCallback:function(){var e="Selected "+(a.length>1?"timeslots":"timeslot")+" has been blocked!";bootbox.alert(e,function(){r.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof i&&i()})},failCallback:function(e){bootbox.alert("The request cannot be processed",function(){n.data("is-submitting",0),r.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof l&&l(e)})}})}}})})},e.on("modalBlockTimeslots/show",function(e){var n=e.ids,a=e.doctorId,o=e.doneCallback,i=e.failCallback;t.showModal({ids:n,doctorId:a,doneCallback:o,failCallback:i})}),t.init=function(e){t.data=e||{},t.templates={},t.templates.modal=multiline(function(){
/*!@preserve
	            <form class="form" data-is-submitting="0">
	            <div class="form-group">
	            <p class="form-control-static">Are you sure you want to block this timeslot?</p>
	            </div>
	            <div class="form-group">
	            <label for="message">Reason:</label>
	            <textarea class="form-control" name="block_reason"></textarea>
	            </div>
	            </form>
	            */
console.log})},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=n(74),o=n(15),i=n(29),l=n(76);e.exports=function(e){var t=this;return t.render=function(n){var r=n.data;n.doneCallback,n.failCallback;e.emit("window/loading/show"),e.emit("service/doctor/clinics/list",{doneCallback:function(n){e.emit("window/loading/hide"),t.data.clinics=n;var s=o(globalData,"doctor.title",""),c=o(globalData,"doctor.name",""),d=bootbox.dialog({title:'Add new appointment <span class="text-primary">(book from '+s+" "+c+")</span>",message:swig.render(t.templates.modalContent,{locals:{clinics:n}}),className:"modal-create-appointment",buttons:{back:{label:"Back",className:"btn hide back",callback:function(e){$(e.delegateTarget).find("form");return t.objects.$wizard.wizard("backward"),!1}},next:{label:"Next",className:"btn btn-primary next",callback:function(e){return t.objects.$wizard.wizard("forward"),!1}},submit:{label:"Submit",className:"btn btn-primary hide submit",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});d.on("shown.bs.modal",function(n){var s=d.find(".modal-footer .btn.next"),c=d.find(".modal-footer .btn.back"),u=d.find(".modal-footer .btn.submit"),f=d.find("form"),m=f.find("#form_create_appointment__group_select_doctor"),p=f.find("#form_create_appointment__group_select_appointment_type"),b=d.find("[name=clinic_id]"),g=d.find("[name=date]"),h=d.find(".step-2"),v=function(e){var n=swig.render(t.templates.groupSelectDoctorContent,{locals:{clinic:e}});m.html(n),m.find("select.chosen").chosen(),f.find("[name=doctor_id]").on("change",function(e){var n=$(e.currentTarget),o=parseInt(n.data("clinic-id")),i=parseInt(n.val());if(!i)return!1;var l=a(t.data.clinics,function(e){return e.id===o});!function(e,n){var a=swig.render(t.templates.groupSelectAppointmentTypeContent,{locals:{doctor:e,clinic:n}});p.html(a),p.find("select.chosen").chosen()}(a(l.doctors,function(e){return e.id===i}),l)}).trigger("change")},y=function(n){var a=n.clinic,i=n.doctor,l=n.appointmentType,s=n.date,c=n.doctorTimeslots,u=swig.render(t.templates.step2Content,{locals:{clinic:a,doctor:i,appointmentType:l,date:s,doctorTimeslots:c,patient:o(r,"patient",undefined)}});h.html(u);var m=f.find("#form_create_appointment__input_search_patient"),p=f.find("#form_create_appointment__select_patient_id"),b=f.find("#form_create_appointment__group_attachments");p.select2({dropdownParent:d,placeholder:"Search by Name/ID Number",ajax:{url:laroute.route("api.patients.search"),dataType:"json",delay:250,data:function(e){return{text:$.trim(e.term),page:e.page}},transport:function(e,t,n){new $.ajax(e.url,e).done(function(e){t(e)}).fail(function(){n()})},processResults:function(e,t){return t.page=t.page||1,{results:e.data,pagination:{more:30*t.page<e.total_count}}},cache:!0},escapeMarkup:function(e){return e},minimumInputLength:1,minimumResultsForSearch:Infinity,templateResult:function(e){if(e.loading)return e.text;var t=multiline(function(){
/*!@preserve
	                                    <div class='select2-result-patient clearfix'>
	                                    <div class='select2-result-patient__avatar pull-left'>
	                                    <img src='{{patient.profile_image_url}}' width='48' height='48'/>
	                                    </div>
	                                    <div class='select2-result-patient__meta pull-left' style='padding-left: 10px;'>
	                                    <div class='select2-result-patient__title'>{{ patient.full_name }} (<b>#{{ patient.id }}</b>)</div>
	                                    <div class='select2-result-patient__statistics'>
	                                    {% if (patient.date_of_birth && patient.date_of_birth.length) %}
	                                    <div class='select2-result-patient__forks'>Date of Birth: {{ patient.date_of_birth }}</div>
	                                    {% endif %}
	                                    {% if (patient.id_number && patient.id_number.length) %}
	                                    <div class='select2-result-patient__forks'>National ID: {{ patient.id_number }}</div>
	                                    {% endif %}
	                                    {% if (patient.country_name && patient.country_name.length) %}
	                                    <div class='select2-result-patient__stargazers'>Country: {{ patient.country_name }}</div>
	                                    {% endif %}
	                                    {% if (patient.imported_name && patient.imported_name.length) %}
	                                    <div class='select2-result-patient__stargazers text-red'><i>Imported Name: {{ patient.imported_name }}</i></div>
	                                    {% endif %}
	                                    {% if (patient.imported_email && patient.imported_email.length) %}
	                                    <div class='select2-result-patient__stargazers text-red'><i>Imported Email: {{ patient.imported_email }}</i></div>
	                                    {% endif %}
	                                    {% if (patient.phone && patient.phone.length) %}
	                                    <div class='select2-result-patient__stargazers text-red'><i>Imported Phone: {{ patient.phone }}</i></div>
	                                    {% endif %}
	                                    </div>
	                                    </div>
	                                    </div>
	                                    */
console.log});return swig.render(t,{locals:{patient:e}})},templateSelection:function(e){return e.text}}),o(r,"patient.id",undefined)&&p.append('<option selected value="'+r.patient.id+'">'+r.patient.text+"</option>"),h.find("[name=appointment-time-slot]").chosen({disable_search_threshold:5}),b.dropzone({acceptedFiles:".jpg, .jpeg, .png",paramName:"file",previewsContainer:"#form_create_appointment__group_attachments__previews",clickable:"#form_create_appointment__group_attachments__button_upload",previewTemplate:'<div class="item">\n                                            <div class="thumbnail">\n                                                <img data-dz-thumbnail />\n                                                <div class="xxs progress">\n                                                    <div class="dz-upload progress-bar progress-bar-green" data-dz-uploadprogress></div>\n                                                </div>\n                                                <div class="overlay loading">\n                                                    <i class="fa fa-refresh fa-spin"></i>\n                                                </div>\n                                            </div>\n                                            <div class="content">\n                                                <div class="title">\n                                                    <span data-dz-name></span>\n                                                    <div class="pull-right">\n                                                        <a data-dz-remove href="#" data-toggle="tooltip" data-title="Remove">\n                                                            <i class="fa fa-times"></i>\n                                                        </a>\n                                                    </div>\n                                                </div>\n                                                <div class="description">\n                                                    <textarea class="form-control" placeholder="Description"></textarea>\n                                                </div>\n                                                <div class="text error">\n                                                    <span data-dz-errormessage></span>\n                                                </div>\n                                            </div>\n                                        </div>',url:laroute.route("doctor.file.store"),autoProcessQueue:!0,params:{_token:$('meta[name="csrf-token"]').attr("content")},processing:function(){},success:function(e,t){var n=$(e.previewElement),a=o(t,"file.id");a&&n.find("textarea").attr("name","files["+a+"][description]")}}),h.on("click","[data-action=addNewPatient]",function(t){t.preventDefault(),e.emit("modal/createPatient/show",{doneCallback:function(e){var t=o(e,"data.id",0),n=o(e,"data.text");p.append('<option selected value="'+t+'">'+n+"</option>")},failCallback:function(e,t){}})}).on("click","[data-action=searchPatients]",function(e){e.preventDefault(),function(e){var t=p.data("select2"),n=t.dropdown.$search||t.selection.$search;t.results.clear(),t.trigger("open"),n.val(e),n.trigger("keyup")}(m.val())})};f.find("select.chosen").chosen(),g.datepicker({maxViewMode:"month",weekStart:1,startDate:moment().format("DD/MM/YYYY"),format:"dd/mm/yyyy",disableTouchKeyboard:!0,clearBtn:!0}),f.validate({rules:{clinic_id:{required:!0},doctor_id:{required:!0},"appointment-type":{required:!0},date:{required:!0},patient_id:{required:!0},"appointment-time-slot":{required:!0},patient_address:{required:function(){return parseInt($("[name=appointment-type] :selected").attr("is-house-call-appointment-type"))}},patient_location_lat:{required:function(){return parseInt($("[name=appointment-type] :selected").attr("is-house-call-appointment-type"))}},patient_location_lng:{required:function(){return parseInt($("[name=appointment-type] :selected").attr("is-house-call-appointment-type"))}}},ignore:":hidden:not(select)",errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(n,a){if(a.preventDefault(),!parseInt(f.data("is-submitting"))){var i=f.serialize();e.emit("window/loading/show"),f.data("is-submitting",1),d.find(":input").prop("disabled",!0),e.emit("service/doctor/appointments/create",{data:i,doneCallback:function(t){e.emit("window/loading/hide");var n=o(t,"appointmentType.name",""),a=o(t,"patient.firstName",""),i=o(t,"patient.lastName",""),l=o(t,"doctor.title.title",""),r=o(t,"doctor.name"),s=o(t,"clinic.timeZone","UTC"),c=moment.tz(o(t,"startAt",""),"YYYY-MM-DD HH:mm:ss","UTC").utcOffset(s).tz(s);bootbox.alert("<i>"+n+"</i> appointment for patient <b>"+a+" "+i+"</b> has been booked to "+l+" <b>"+r+"</b> at "+c.format("DD/MM/YYYY HH:mm")+" ("+c.format("[GMT]Z")+").",function(){d.modal("hide")})},failCallback:function(n,a){var i=swig.render(t.templates.modalErrorsContent,{locals:o(n,"responseJSON",{message:"The request cannot be processed"})});bootbox.alert(i),f.data("is-submitting",0),d.find(":input").prop("disabled",!1),e.emit("window/loading/hide")}})}}}),t.objects.$wizard=$(t.DOMSelectors.wizard).wizard({afterSelect:function(e,n){n.isLastStep&&!s.hasClass("hide")?(s.addClass("hide"),u.removeClass("hide")):(s.removeClass("hide"),u.addClass("hide")),n.isFirstStep&&c.hasClass("hide")?c.addClass("hide"):c.removeClass("hide"),d.find(t.DOMSelectors.stepIndex).text(n.stepIndex+1)},beforeForward:function(e,t){return f.valid()},beforeBackward:function(e,n){var a=swig.render(t.templates.step2EmptyContent);h.html(a)},afterForward:function(n,a){switch(a.stepIndex){case 1:var r=f.serialize();e.emit("window/loading/show"),e.emit("service/doctor/doctorTimeslots/list",{data:r,doneCallback:function(n){var a=function(){var e=arguments.length>0&&arguments[0]!==undefined?arguments[0]:[],t=i(e,function(e){var t=moment(e.start).utcOffset(0).format("YYYY-MM-DD HH:mm:ss"),n=moment(e.end).utcOffset(0).format("YYYY-MM-DD HH:mm:ss"),a=e.timezone;return{id:e.id,currentTimezone:a,startAt:moment(1e3*moment.utc(t).unix()).utcOffset(a).tz(a),endAt:moment(1e3*moment.utc(n).unix()).utcOffset(a).tz(a),appointments:e.appointments,available:e.available,isBlocked:e.isBlocked}});return l(t,function(e){return e.startAt.diff(moment())>0&&!e.appointments.length&&e.available&&!e.isBlocked})}(o(n,"result",[]));a.length?y({clinic:{name:f.find("[name=clinic_id] :selected").text()},doctor:{name:f.find("[name=doctor_id] :selected").text()},appointmentType:{name:f.find("[name=appointment-type] :selected").text()},date:f.find("[name=date]").val(),doctorTimeslots:a}):bootbox.alert("There's no available timeslot for given criterias. Please check again.",function(){t.objects.$wizard.wizard("backward")}),e.emit("window/loading/hide")},failCallback:function(n,a){var i=swig.render(t.templates.modalErrorsContent,{locals:o(n,"responseJSON",{message:"The request cannot be processed"})});bootbox.alert(i),e.emit("window/loading/hide")}});break;default:return!0}}}),b.on("change",function(e){var n=$(e.currentTarget),o=parseInt(n.val()),i=a(t.data.clinics,function(e){return e.id===o});v(i)}).trigger("change"),f.on("reset",function(e){setTimeout(function(){f.find("select.chosen").trigger("chosen:updated")},0)})})},failCallback:function(n,a){var i=swig.render(t.templates.modalErrorsContent,{locals:o(n,"responseJSON",{message:"The request cannot be processed"})});bootbox.alert(i),e.emit("window/loading/hide")}})},e.on("modalCreateAppointment/show",function(e){var n=e.data,a=e.doneCallback,o=e.failCallback;t.render({data:n,doneCallback:a,failCallback:o})}),t.init=function(e){t.data=e||{},t.DOMSelectors={},t.DOMSelectors.wizard="#wizard_create_appointment",t.DOMSelectors.stepIndex=".step-index",t.objects={},t.templates={},t.templates.modalContent=multiline(function(){
/*!@preserve
	            <div class="wizard" id="wizard_create_appointment">
	            <p class="text-muted">Step <span class="step-index">1</span> of 2</p>
	            <form class="form" id="form_create_appointment">
	            <div class="step step-1">
	            <div class="form-group">
	            <label class="control-label">Clinic</label>
	            <select class="form-control chosen" name="clinic_id" data-placeholder="Please choose a clinic">
	            <option></option>
	            {% for clinic in clinics %}
	            <option value="{{clinic.id}}">{{clinic.name}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            <div class="form-group" id="form_create_appointment__group_select_doctor"></div>
	            <div class="form-group" id="form_create_appointment__group_select_appointment_type"></div>
	            <div class="form-group">
	            <label class="control-label">Date</label>
	            <input type="text" class="form-control" name="date" placeholder="Click to pick a date" readonly="readonly"/>
	            </div>
	            </div>
	            <div class="step step-2">
	            <i class="fa fa-spin fa-refresh"></i>
	            Loading...
	            </div>
	            </form>
	            </div>
	            */
console.log}),t.templates.groupSelectDoctorContent=multiline(function(){
/*!@preserve
	            <label class="control-label">Doctor</label>
	            <select class="form-control chosen" name="doctor_id" data-clinic-id="{{clinic.id}}" data-placeholder="{% if clinic.id %}Please choose a doctor{% else %}Please choose a clinic first{% endif %}">
	            <option></option>
	            {% for doctor in clinic.doctors %}
	            <option value="{{doctor.id}}" data-clinic-id="doctor.clinicId">{{doctor.name}}</option>
	            {% endfor %}
	            </select>
	            */
console.log}),t.templates.groupSelectAppointmentTypeContent=multiline(function(){
/*!@preserve
	            <label class="control-label">Appointment Type</label>
	            <select class="form-control chosen" name="appointment-type" data-placeholder="{% if clinic.id %}Please choose an appointment type{% else %}Please choose a doctor first{% endif %}">
	            <option></option>
	            {% for appointmentType in doctor.timetableConfigs %}
	            <option value="{{appointmentType.id}}" data-doctor-id="doctor.id">{{appointmentType.name}}</option>
	            {% endfor %}
	            </select>
	            */
console.log}),t.templates.step2Content=multiline(function(){
/*!@preserve
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label">Clinic</label>
	            <div class="form-control-static">{{clinic.name}}</div>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label">Doctor</label>
	            <div class="form-control-static">{{doctor.name}}</div>
	            </div>
	            </div>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label">Appointment type</label>
	            <div class="form-control-static">{{appointmentType.name}}</div>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label">Date</label>
	            <div class="form-control-static">{{date}}</div>
	            </div>
	            </div>
	            </div>
	            <div class="form-group">
	            <label>National ID - Name - Country - DoB - #ID</label>
	            {% if patient.id && patient.text %}
	            <div class="form-control-static">
	            <input type="hidden" name="patient_id" id="form_create_appointment__input_search_patient" value="{{patient.id}}"/>
	            {{patient.text}}
	            </div>
	            {% else %}
	            <div class="input-group">
	            <select id="form_create_appointment__select_patient_id" class="form-control" name="patient_id" autocomplete="off"></select>
	            <span class="input-group-btn">
	            <a href="#" class="btn btn-primary" data-action="addNewPatient" data-toggle="tooltip" data-title="Create new patient record">
	            <i class="fa fa-plus"></i>
	            </a>
	            </span>
	            </div>
	            {% endif %}
	            </div>
	            <div class="form-group">
	            <label class="control-label">Timeslot</label>
	            <select class="form-control" name="appointment-time-slot">
	            {% for timeslot in doctorTimeslots %}
	            <option value="{{timeslot.id}}">
	            {{timeslot.startAt|formatTimestamp2(timeslot.currentTimezone, 'HH:mm')}} to {{timeslot.endAt|formatTimestamp2(timeslot.currentTimezone, 'HH:mm')}}
	            </option>
	            {% endfor %}
	            </select>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Reason</label>
	            <textarea class="form-control" name="booking_reason"></textarea>
	            </div>
	            <div class="form-group" id="form_create_appointment__group_attachments">
	            <label>Attachments <i id="form_create_appointment__group_attachments__button_upload" class="fa fa-upload" data-toggle="tooltip" data-title="Click here to upload"></i></label>
	            <div id="form_create_appointment__group_attachments__previews"></div>
	            </div>
	            <div class="form-group">
	            <label>Note</label>
	            <textarea class="form-control" name="note" placeholder="Referrer, additional information,..."></textarea>
	            </div>
	            */
console.log}),t.templates.step2EmptyContent=multiline(function(){
/*!@preserve
	            <i class="fa fa-spin fa-refresh"></i>
	            Loading...
	            */
console.log}),t.templates.modalErrorsContent=multiline(function(){
/*!@preserve
	            <p>{{message}}</p>
	            {% if errors|typeof === 'object' %}
	            <ul>
	            {% for field,message in errors %}
	            <li data-field="{{field}}">{{message}}</li>
	            {% endfor %}
	            </ul>
	            {% endif %}
	            */
console.log})},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){var a=n(75)(n(9));e.exports=a},function(e,t,n){var a=n(11),o=n(39),i=n(36);e.exports=function(e){return function(t,n,l){var r=Object(t);if(!o(t)){var s=a(n,3);t=i(t),n=function(e){return s(r[e],e,r)}}var c=e(t,n,l);return c>-1?r[s?t[c]:c]:undefined}}},function(e,t,n){var a=n(77),o=n(78),i=n(11),l=n(18);e.exports=function(e,t){return(l(e)?a:o)(e,i(t,3))}},function(e,t){e.exports=function(e,t){for(var n=-1,a=null==e?0:e.length,o=0,i=[];++n<a;){var l=e[n];t(l,n,e)&&(i[o++]=l)}return i}},function(e,t,n){var a=n(32);e.exports=function(e,t){var n=[];return a(e,function(e,a,o){t(e,a,o)&&n.push(e)}),n}},function(e,t,n){"use strict";var a=n(15),o=a(globalData,"context.dashboardType","doctor");e.exports=function(e){var t=this;return t.listClinics=function(e){var t=e.data,n=e.doneCallback,a=e.failCallback;return $.ajax({url:laroute.route("profile.clinics"),data:t,dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.render=function(n){var i=n.doneCallback,l=n.failCallback;e.emit("window/loading/show"),e.emit("service/countries/list",{doneCallback:function(n){t.listClinics({doneCallback:function(r){e.emit("window/loading/hide");var s=bootbox.dialog({title:"Add new patient 2",message:swig.render(t.templates.modalContent,{locals:{countries:n,clinics:r}}),size:"large",className:"modal-create-patient",buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}}),c=s.find("form");c.find("[name=date_of_birth]").datepicker({format:"dd/mm/yyyy",weekStart:1,minViewMode:"month",maxViewMode:"years",orientation:"bottom",disableTouchKeyboard:!0,autoclose:!0,defaultViewDate:{year:1980,month:0,day:1},startView:"years",clearBtn:!0}),c.find("select.chosen").chosen({width:"100%",search_contains:!0}),c.validate({ignore:":hidden:not(select)",rules:{first_name:{required:!0,minlength:1,maxlength:255},last_name:{required:!0,minlength:1,maxlength:255},date_of_birth:{required:!0,dateFormatDMY:!0},gender:{required:!0},email:{required:{depends:function(){return $(this).val().length}},validateEmail:""},phone_number:{number:!0},issue_country_id:{required:!0},id_number:{required:!0},zip_code:{number:!0}},messages:{email:{required:"",validateEmail:"Invalid email format."}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(e,t){if(t.preventDefault(),!parseInt(c.data("is-submitting"))){var n=$(e).serialize();manaDrApplication.emit("window/loading/show"),c.data("is-submitting",1),s.find(":input").prop("disabled",!0);var r=void 0;switch(o){case"admin":r="admin.patients.store";break;case"doctor":default:r="api.patients.store"}console.log("dashboardType",o,r),$.ajax({url:laroute.route(r),method:"POST",data:n,dataType:"json"}).done(function(e){a(e,"data.id",0);var t="Patient <b>"+a(e,"data.full_name","")+"</b> has been created successfully!";bootbox.alert(t,function(){"function"==typeof i&&i(e),s.modal("hide"),manaDrApplication.emit("window/loading/hide")})}).fail(function(e,t){"function"==typeof l&&l(e,t),c.data("is-submitting",0),s.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide")})}}}),c.on("reset",function(e){setTimeout(function(){c.find("select.chosen").trigger("chosen:updated")},0)})},failCallback:function(t,n){e.emit("window/loading/hide"),"function"==typeof l&&l(t,n)}})},failCallback:function(t,n){e.emit("window/loading/hide"),"function"==typeof l&&l(t,n)}})},e.on("modal/createPatient/show",function(e){var n=e.doneCallback,a=e.failCallback;t.render({doneCallback:n,failCallback:a})}),t.init=function(e){t.data=e||{},t.templates={},t.templates.modalContent=multiline(function(){
/*!@preserve
	            <form class="form" id="form_create_patient">
	            <div class="row">
	            <div class="col-sm-8">
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label for="form_create_patient__input_first_name" class="control-label">First Name (*)</label>
	            <input type="text" class="form-control" name="first_name" id="form_create_patient__input_first_name"/>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label for="form_create_patient__input_last_name" class="control-label">Last Name (*)</label>
	            <input type="text" class="form-control" name="last_name" id="form_create_patient__input_last_name"/>
	            </div>
	            </div>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label">Gender (*)</label>
	            <p>
	            <label class="radio-inline">
	            <input name="gender" id="form_create_patient__select_gender_male" value="Male" aria-required="true" type="radio">
	            Male
	            </label>
	            <label class="radio-inline">
	            <input name="gender" id="form_create_patient__select_gender_female" value="Female" type="radio">
	            Female
	            </label>
	            <label class="radio-inline">
	            <input name="gender" id="form_create_patient__select_gender_other" value="Other" type="radio">
	            Other
	            </label>
	            </p>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_create_patient__input_date_of_birth">Date of Birth (*)</label>
	            <input type="text" class="form-control" name="date_of_birth" id="form_create_patient__input_date_of_birth" readonly="readonly"/>
	            </div>
	            </div>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_create_patient__select_issue_country">National ID Issuing Country (*)</label>
	            <select type="text" class="form-control chosen" name="issue_country_id" id="form_create_patient__select_issue_country">
	            <option value="">Undetermined</option>
	            {% for country in countries %}
	            <option value="{{country.id}}">{{country.niceName}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_create_patient__input_id_number">National ID (*)</label>
	            <input type="text" class="form-control" name="id_number" id="form_create_patient__input_id_number"/>
	            </div>
	            </div>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_create_patient__input_phone_number">Phone Number</label>
	            <div class="row">
	            <div class="col-xs-6">
	            <select class="form-control chosen" name="phone_country_code">
	            <option value="">Undetermined</option>
	            {% for code, name in phoneCountryCodes %}
	            <option value="{{code}}">{{code}}</option>
	            {% endfor %}
	            {% for country in countries %}
	            <option value="{{country.phoneCountryCode}}">{{country.niceName}} ({{country.phoneCountryCode}})</option>
	            {% endfor %}
	            </select>
	            </div>
	            <div class="col-xs-6">
	            <input type="text" class="form-control" name="phone_number" id="form_create_patient__input_phone_number"/>
	            </div>
	            </div>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_create_patient__input_email">Email</label>
	            <input type="text" class="form-control" name="email" id="form_create_patient__input_email"/>
	            </div>
	            </div>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_create_patient__input_street">Street</label>
	            <input type="text" class="form-control" name="address_street" id="form_create_patient__input_street"/>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_create_patient__input_zip_code">Zip Code</label>
	            <input type="text" class="form-control" name="address_zip" id="form_create_patient__input_zip_code"/>
	            </div>
	            </div>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_create_patient__input_city">City</label>
	            <input type="text" class="form-control" name="address_city" id="form_create_patient__input_city"/>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_create_patient__select_residence_country">Residence Country</label>
	            <select type="text" class="form-control chosen" name="resident_country_id" id="form_create_patient__select_residence_country">
	            <option value="">Undetermined</option>
	            {% for country in countries %}
	            <option value="{{country.id}}">{{country.niceName}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            </div>
	            </div>
	            </div>
	            <div class="col-sm-4">
	            <div class="row">
	            <div class="col-xs-6 col-sm-12">
	            <div class="form-group">
	            <label for="form_create_patient__select_clinic" class="control-label">Clinic</label>
	            <select id="form_create_patient__select_clinic" class="form-control chosen" name="clinic_id">
	            {% for clinic in clinics %}
	            <option value="{{clinic.id}}">{{clinic.name}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            </div>
	            <div class="col-xs-6 col-sm-12">
	            <div class="form-group">
	            <label class="control-label" id="form_create_patient__input_race">Race</label>
	            <input type="text" class="form-control" name="race" id="form_create_patient__input_race"/>
	            </div>
	            </div>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Medical Condition</label>
	            <textarea class="form-control vertical" name="medical_condition" style="height:108px"></textarea>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Drug Allergy</label>
	            <textarea class="form-control vertical" name="drug_allergy" style="height:108px"></textarea>
	            </div>
	            </div>
	            </div>
	            </form>
	            */
console.log})},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.fetchHouseCallReasons=function(t){var n=t.appointmentTypeId,a=t.clinicId,o=t.doneCallback,i=t.failCallback;e.emit("window/loading/show"),e.emit("service/houseCallReason/list",{data:{appointmentTypeId:n,clinicId:a},doneCallback:function(t){e.emit("window/loading/hide"),"function"==typeof o&&o(t)},failCallback:function(t,n){e.emit("window/loading/hide"),"function"==typeof i&&i(t,n)}})},t.showModal=function(n){var a=n.appointmentTypeId,o=n.appointmentTypeName,i=n.clinicId,l=n.reasons,r=(n.doneCallback,n.failCallback,bootbox.dialog({title:"Manage reasons for "+o,message:swig.render(t.templates.modalContent,{locals:{reasons:l}})}));r.on("shown.bs.modal",function(n){var l=r.find("#table_house_call_reasons"),s=l.find("tbody");l.on("click","[data-action=add]",function(n){n.preventDefault(),e.emit("modal/createHouseCallReason/show",{appointmentTypeId:a,appointmentTypeName:o,clinicId:i,doneCallback:function(e){var n=e,a=swig.render(t.templates.row,{locals:{reason:n}});s.append(a)},failCallback:function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n)}})}).on("click","[data-action=edit]",function(n){n.preventDefault();var a=$(n.currentTarget).closest("tr[data-id]"),o=a.data("id");e.emit("modal/updateHouseCallReason/show",{id:o,doneCallback:function(e){var n=e,o=swig.render(t.templates.row,{locals:{reason:n}});a.replaceWith(o)},failCallback:function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n)}})}).on("click","[data-action=delete]",function(t){t.preventDefault();var n=$(t.currentTarget).closest("tr[data-id]"),a=n.data("id"),o=n.data("reason");bootbox.confirm("Are you sure to delete <b>"+o+"</b>?",function(t){t&&(e.emit("window/loading/show"),e.emit("service/houseCallReason/delete",{id:a,doneCallback:function(t){var a="<b>"+o+"</b> has been deleted successfully!";bootbox.alert(a,function(){n.remove(),e.emit("window/loading/hide")})},failCallback:function(t,n){var a="";a=t&&t.responseJSON&&t.responseJSON.message&&t.responseJSON.message.length?t.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){e.emit("window/loading/hide")})}}))})}).on("click","[data-action=manageDoctors]",function(n){n.preventDefault();var a=$(n.currentTarget).closest("tr[data-id]"),o=a.data("id");e.emit("modal/manageHouseCallReasonDoctors/show",{id:o,clinicId:i,doneCallback:function(e){var n=a.find("[data-action=manageDoctors]"),o=swig.render(t.templates.manageDoctorsButton,{locals:{doctorAmount:e}});n.replaceWith(o)},failCallback:function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n)}})})})},e.on("modal/manageHouseCallReasons/show",function(e){var n=e.appointmentTypeId,a=e.appointmentTypeName,o=e.clinicId,i=e.doneCallback,l=e.failCallback;t.fetchHouseCallReasons({appointmentTypeId:n,clinicId:o,doneCallback:function(e){t.showModal({appointmentTypeId:n,appointmentTypeName:a,clinicId:o,reasons:e,doneCallback:function(e){"function"==typeof i&&i(e)},failCallback:function(e,t){"function"==typeof l&&l(e,t)}})},failCallback:function(e,t){"function"==typeof l&&l(e,t)}})}),t.init=function(e){t.data=e||{},t.templates={},t.templates.modalContent=multiline(function(){
/*!@preserve
	            <table class="table table-hover table-striped" id="table_house_call_reasons">
	            <thead>
	            <tr>
	            <th>Reason</th>
	            <th></th>
	            <th>
	            <a class="btn btn-xs btn-primary" data-action="add">
	            <i class="fa fa-plus" />
	            Add
	            </a>
	            </th>
	            </tr>
	            </thead>
	            <tbody>
	            {% for reason in reasons %}
	            <tr data-id="{{reason.id}}" data-reason="{{reason.reason}}">
	            <td>{{reason.reason}}</td>
	            <td class="text-right">
	            <a class="btn btn-xs btn-default" data-id="{{ reason.id }}" data-action="manageDoctors">
	            <i class="fa fa-user-md" />
	            {% if reason.doctors.length == 1 %}
	            1 doctor
	            {% elseif (reason.doctors.length > 1) %}
	            {{ reason.doctors.length }} doctors
	            {% else %}
	            Manage doctors
	            {% endif %}
	            </a>
	            </td>
	            <td>
	            <a href="#" class="btn btn-xs btn-warning" data-action="edit">
	            <i class="fa fa-pencil" /> Edit
	            </a>
	            <a href="#" class="btn btn-xs btn-danger" data-action="delete">
	            <i class="fa fa-trash" /> Delete
	            </a>
	            </td>
	            </tr>
	            {% endfor %}
	            </tbody>
	            </table>
	            */
console.log}),t.templates.row=multiline(function(){
/*!@preserve
	            <tr data-id="{{reason.id}}" data-reason="{{reason.reason}}">
	            <td>{{reason.reason}}</td>
	            <td class="text-right">
	            <a class="btn btn-xs btn-default" data-id="{{ reason.id }}" data-action="manageDoctors">
	            <i class="fa fa-user-md" />
	            {% if reason.doctors.length == 1 %}
	            1 doctor
	            {% elseif (reason.doctors.length > 1) %}
	            {{ reason.doctors.length }} doctors
	            {% else %}
	            Manage doctors
	            {% endif %}
	            </a>
	            </td>
	            <td>
	            <a href="#" class="btn btn-xs btn-warning" data-action="edit">
	            <i class="fa fa-pencil" /> Edit
	            </a>
	            <a href="#" class="btn btn-xs btn-danger" data-action="delete">
	            <i class="fa fa-trash" /> Delete
	            </a>
	            </td>
	            </tr>
	            */
console.log}),t.templates.manageDoctorsButton=multiline(function(){
/*!@preserve
	            <a class="btn btn-xs btn-default" data-action="manageDoctors">
	            <i class="fa fa-user-md" />
	            {% if doctorAmount == 1 %}
	            1 doctor
	            {% elseif (doctorAmount > 1) %}
	            {{ doctorAmount }} doctors
	            {% else %}
	            Manage doctors
	            {% endif %}
	            </a>
	            */
console.log})},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.showModal=function(n){var a=n.appointmentTypeId,o=n.appointmentTypeName,i=n.clinicId,l=n.doneCallback,r=n.failCallback,s=bootbox.dialog({title:"Add reason for <b>"+o+"</b>",message:swig.render(t.templates.modalContent,{locals:{clinicId:i,appointmentTypeId:a,appointmentTypeName:o}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});s.on("shown.bs.modal",function(t){var n=s.find("form");n.validate({ignore:":hidden:not(select)",rules:{reason:{required:!0,minlength:1}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(t,a){if(a.preventDefault(),!parseInt(n.data("is-submitting"))){var o=$(t).serialize();e.emit("window/loading/show"),n.data("is-submitting",1),s.find(":input").prop("disabled",!0),e.emit("service/houseCallReason/create",{data:o,doneCallback:function(t){var n="House call reason <b>"+t.reason+"</b> has been created successfully!";bootbox.alert(n,function(){"function"==typeof l&&l(t),s.modal("hide"),e.emit("window/loading/hide")})},failCallback:function(t,a){"function"==typeof r&&r(t,a),n.data("is-submitting",0),s.find(":input").prop("disabled",!1),e.emit("window/loading/hide")}})}}}),n.on("reset",function(e){setTimeout(function(){n.find("select.chosen").trigger("chosen:updated")},0)})})},e.on("modal/createHouseCallReason/show",function(e){var n=e.appointmentTypeId,a=e.appointmentTypeName,o=e.clinicId,i=e.doneCallback,l=e.failCallback;t.showModal({appointmentTypeId:n,appointmentTypeName:a,clinicId:o,doneCallback:i,failCallback:l})}),t.init=function(e){t.data=e||{},t.templates={},t.templates.modalContent=multiline(function(){
/*!@preserve
	            <form class="form" id="form_create_house_call_reasons">
	            <input type="hidden" name="clinic_id" value="{{clinicId}}" />
	            <input type="hidden" name="appointment_type_id" value="{{appointmentTypeId}}" />
	            <div class="form-group">
	            <label class="control-label" for="form_create_house_call_reasons__input_reason">Reason</label>
	            <input type="text" class="form-control" id="form_create_house_call_reasons__input_reason" name="reason" />
	            </div>
	            </form>
	            */
console.log})},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.showModal=function(n){var a=n.reason,o=n.doneCallback,i=n.failCallback,l=bootbox.dialog({title:"Update reason <b>"+a.reason+"</b>",message:swig.render(t.templates.modalContent,{locals:{reason:a}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});l.on("shown.bs.modal",function(t){var n=l.find("form");n.validate({ignore:":hidden:not(select)",rules:{reason:{required:!0,minlength:1}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(t,r){if(r.preventDefault(),!parseInt(n.data("is-submitting"))){var s=$(t).serialize();e.emit("window/loading/show"),n.data("is-submitting",1),l.find(":input").prop("disabled",!0),e.emit("service/houseCallReason/update",{id:a.id,data:s,doneCallback:function(t){bootbox.alert("House call reason has been updated successfully!",function(){"function"==typeof o&&o(t),l.modal("hide"),e.emit("window/loading/hide")})},failCallback:function(t,a){"function"==typeof i&&i(t,a),n.data("is-submitting",0),l.find(":input").prop("disabled",!1),e.emit("window/loading/hide")}})}}}),n.on("reset",function(e){setTimeout(function(){n.find("select.chosen").trigger("chosen:updated")},0)})})},e.on("modal/updateHouseCallReason/show",function(n){var a=n.id,o=n.doneCallback,i=n.failCallback;e.emit("window/loading/show"),e.emit("service/houseCallReason/fetch",{id:a,doneCallback:function(n){var a=n;t.showModal({reason:a,doneCallback:o,failCallback:i}),e.emit("window/loading/hide")},failCallback:function(t,n){var a="";a=t&&t.responseJSON&&t.responseJSON.message&&t.responseJSON.message.length?t.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){e.emit("window/loading/hide"),"function"==typeof i&&i(t,n)})}})}),t.init=function(e){t.data=e||{},t.templates={},t.templates.modalContent=multiline(function(){
/*!@preserve
	            <form class="form" id="form_update_house_call_reasons">
	            <input type="hidden" name="clinic_id" value="{{reason.clinicId}}" />
	            <input type="hidden" name="appointment_type_id" value="{{reason.appointmentTypeId}}" />
	            <div class="form-group">
	            <label class="control-label" for="form_update_house_call_reasons__input_reason">Reason</label>
	            <input type="text" class="form-control" id="form_update_house_call_reasons__input_reason" name="reason" value="{{reason.reason}}" />
	            </div>
	            </form>
	            */
console.log})},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=function(e){return e&&e.__esModule?e:{"default":e}}(n(29));e.exports=function(e){var t=this;return t.fetchHouseCallReason=function(t){var n=t.id,a=t.clinicId,o=t.doneCallback,i=t.failCallback;e.emit("window/loading/show"),e.emit("service/houseCallReason/fetch",{id:n,data:{clinic_id:a},doneCallback:function(t){e.emit("window/loading/hide"),"function"==typeof o&&o(t)},failCallback:function(t,n){e.emit("window/loading/hide"),"function"==typeof i&&i(t,n)}})},t.showModal=function(n){var o=n.reason,i=n.clinicId,l=n.doneCallback,r=n.failCallback,s=bootbox.dialog({title:"Manage doctors for house call reason <b>"+o.reason+"</b>",message:swig.render(t.templates.modalContent,{locals:{doctors:o.doctors}})});s.on("shown.bs.modal",function(n){var l=s.find("#table_house_call_reason_doctors"),c=l.find("tbody");l.on("click","[data-action=add]",function(n){n.preventDefault();var l=[];c.children("tr").each(function(){var e=$(this);l.push(e.data("id"))}),e.emit("modal/clinicDoctorsPicker/show",{clinicId:i,excludeIds:l,doneCallback:function(n){var l=(0,a["default"])(n,function(e){return e.id});e.emit("service/houseCallReason/assignDoctors",{id:o.id,clinicId:i,doctorIds:l,doneCallback:function(e){var a=swig.render(t.templates.rows,{locals:{doctors:n}});c.append(a)},failCallback:function(e,t){"function"==typeof r&&r(e,t)}})},failCallback:function(e,t){console.log("error",e,t)}})}).on("click","[data-action=remove]",function(t){t.preventDefault();var n=$(t.currentTarget).closest("tr[data-id]"),a=n.data("id"),l=n.data("name");bootbox.confirm("Are you sure to remove <b>"+l+"</b> from this house call reason?",function(t){t&&(e.emit("window/loading/show"),e.emit("service/houseCallReason/removeDoctor",{id:o.id,clinicId:i,doctorId:a,doneCallback:function(t){var a="<b>"+l+"</b> has been removed from this house call reason successfully!";bootbox.alert(a,function(){n.remove(),e.emit("window/loading/hide")})},failCallback:function(t,n){var a="";a=t&&t.responseJSON&&t.responseJSON.message&&t.responseJSON.message.length?t.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){e.emit("window/loading/hide")})}}))})})}).on("hidden.bs.modal",function(e){var t=s.find("#table_house_call_reason_doctors").find("tbody").children().length;"function"==typeof l&&l(t)})},e.on("modal/manageHouseCallReasonDoctors/show",function(e){var n=e.id,a=e.clinicId,o=e.doneCallback,i=e.failCallback;t.fetchHouseCallReason({id:n,clinicId:a,doneCallback:function(e){var n=e;t.showModal({reason:n,clinicId:a,doneCallback:function(e){"function"==typeof o&&o(e)},failCallback:function(e,t){"function"==typeof i&&i(e,t)}})},failCallback:function(e,t){"function"==typeof i&&i(e,t)}})}),t.init=function(e){t.data=e||{},t.templates={},t.templates.modalContent=multiline(function(){
/*!@preserve
	            <table class="table table-hover table-striped" id="table_house_call_reason_doctors">
	            <thead>
	            <tr>
	            <th>Doctor</th>
	            <th>
	            <a class="btn btn-xs btn-primary" data-action="add">
	            <i class="fa fa-plus" />
	            Add
	            </a>
	            </th>
	            </tr>
	            </thead>
	            <tbody>
	            {% for doctor in doctors %}
	            <tr data-id="{{doctor.id}}" data-name="{{doctor.name}}">
	            <td>{{doctor.name}}</td>
	            <td>
	            <a href="#" class="btn btn-xs btn-danger" data-action="remove">
	            <i class="fa fa-times" /> Remove
	            </a>
	            </td>
	            </tr>
	            {% endfor %}
	            </tbody>
	            </table>
	            */
console.log}),t.templates.row=multiline(function(){
/*!@preserve
	            <tr data-id="{{doctor.id}}" data-name="{{doctor.name}}">
	            <td>{{doctor.name}}</td>
	            <td>
	            <a href="#" class="btn btn-xs btn-danger" data-action="remove">
	            <i class="fa fa-times" /> Remove
	            </a>
	            </td>
	            </tr>
	            */
console.log}),t.templates.rows=multiline(function(){
/*!@preserve
	            {% for doctor in doctors %}
	            <tr data-id="{{doctor.id}}" data-name="{{doctor.name}}">
	            <td>{{doctor.name}}</td>
	            <td>
	            <a href="#" class="btn btn-xs btn-danger" data-action="remove">
	            <i class="fa fa-times" /> Remove
	            </a>
	            </td>
	            </tr>
	            {% endfor %}
	            */
console.log})},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.fetchDoctors=function(t){var n=t.clinicId,a=t.excludeIds,o=t.doneCallback,i=t.failCallback;e.emit("window/loading/show"),e.emit("service/adminDoctor/list",{data:{clinic_id:n,exclude_ids:a},doneCallback:function(t){e.emit("window/loading/hide"),"function"==typeof o&&o(t)},failCallback:function(t,n){e.emit("window/loading/hide"),"function"==typeof i&&i(t,n)}})},t.showModal=function(e){var n=e.doctors,a=e.doneCallback;e.failCallback;bootbox.dialog({title:"Add doctors",message:swig.render(t.templates.modalContent,{locals:{doctors:n}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),!1}},submit:{label:"Add",className:"btn btn-primary",callback:function(e){var t=[];$(e.delegateTarget).find("form").find("[type=checkbox]:checked").closest("tr").each(function(){var e=$(this);t.push({id:e.data("id"),name:e.data("name")})}),"function"==typeof a&&a(t)}}}}).on("shown.bs.modal",function(e){})},e.on("modal/clinicDoctorsPicker/show",function(e){var n=e.clinicId,a=e.excludeIds,o=e.doneCallback,i=e.failCallback;t.fetchDoctors({clinicId:n,excludeIds:a,doneCallback:function(e){t.showModal({doctors:e,doneCallback:function(e){"function"==typeof o&&o(e)},failCallback:function(e,t){"function"==typeof i&&i(e,t)}})},failCallback:function(e,t){"function"==typeof i&&i(e,t)}})}),t.init=function(e){t.data=e||{},t.templates={},t.templates.modalContent=multiline(function(){
/*!@preserve
	            <form class="form" id="form_clinic_doctors">
	            <table class="table table-hover table-striped" id="table_clinic_doctors">
	            <thead>
	            <tr>
	            <th width="30"></th>
	            <th>Name</th>
	            </tr>
	            </thead>
	            <tbody>
	            {% if doctors.length %}
	            {% for doctor in doctors %}
	            <tr data-id="{{doctor.id}}" data-name="{{doctor.name}}">
	            <td>
	            <input type="checkbox" name="doctor_ids[]" value="{{doctor.id}}"/>
	            </td>
	            <td>{{doctor.name}}</td>
	            </tr>
	            {% endfor %}
	            {% else %}
	            <tr>
	            <td colspan="2" class="text-center">No available doctors.</td>
	            </tr>
	            {% endif %}
	            </tbody>
	            </table>
	            </form>
	            */
console.log})},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";var n=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var a in n)Object.prototype.hasOwnProperty.call(n,a)&&(e[a]=n[a])}return e};e.exports=function(e){var t=this;return t.fetchSurchargeSettings=function(t){var n=t.doctorBookingFeeId,a=t.doneCallback,o=t.failCallback;e.emit("window/loading/show"),e.emit("service/doctorBookingFee/surchargeSetting/list",{doctorBookingFeeId:n,doneCallback:function(t){e.emit("window/loading/hide"),"function"==typeof a&&a(t)},failCallback:function(t,n){e.emit("window/loading/hide"),"function"==typeof o&&o(t,n)}})},t.showModal=function(a){var o=a.data,i=a.doneCallback,l=a.failCallback,r=o,s=bootbox.dialog({title:"Manage Surcharge Settings for "+r.doctor.name,message:swig.render(t.templates.modalContent,{locals:n({},r,{weekDays:t.data.weekDays})})});s.on("shown.bs.modal",function(n){s.on("click","[data-action=add]",function(n){n.preventDefault();var a=r.id;e.emit("modal/createSurchargeSetting/show",{doctorBookingFeeId:a,doneCallback:function(e){var n=e,a=s.find(t.DOMSelectors.listSurchargeSettings),o=swig.render(t.templates.surchargeSettingItem,{locals:{surchargeSetting:n,doctorBookingFee:r,weekDays:t.data.weekDays}});a.append(o),"function"==typeof i&&i(e)},failCallback:function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(e,t){"function"==typeof l&&l(e,t)})}})}).on("click","[data-action=edit]",function(n){n.preventDefault();var a=$(n.currentTarget).closest("li"),o=a.data("id");e.emit("modal/updateSurchargeSetting/show",{id:o,doneCallback:function(e){var n=e,o=swig.render(t.templates.surchargeSettingItem,{locals:{surchargeSetting:n,doctorBookingFee:r,weekDays:t.data.weekDays}});a.replaceWith(o),"function"==typeof i&&i(e)},failCallback:function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){"function"==typeof l&&l(e,t)})}})}).on("click","[data-action=delete]",function(t){t.preventDefault();var n=$(t.currentTarget).closest("li"),a=n.data("id"),o=n.data("name");bootbox.confirm("Are you sure to delete surcharge setting <b>"+o+"</b>?",function(t){t&&(e.emit("window/loading/show"),e.emit("service/doctorBookingFee/surchargeSetting/delete",{id:a,doneCallback:function(t){var a="Surcharge setting <b>"+o+"</b> has been deleted successfully!";bootbox.alert(a,function(){n.remove(),e.emit("window/loading/hide"),"function"==typeof i&&i(t)})},failCallback:function(t,n){var a="";a=t&&t.responseJSON&&t.responseJSON.message&&t.responseJSON.message.length?t.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){e.emit("window/loading/hide"),"function"==typeof l&&l(t,n)})}}))})})})},e.on("modal/manageSurchageSettings/show",function(e){var n=e.doctorBookingFeeId,a=e.doneCallback,o=e.failCallback;t.fetchSurchargeSettings({doctorBookingFeeId:n,doneCallback:function(e){t.showModal({data:e,doneCallback:function(e){"function"==typeof a&&a(e)},failCallback:function(e,t){"function"==typeof o&&o(e,t)}})},failCallback:function(e,t){"function"==typeof o&&o(e,t)}})}),t.init=function(e){t.data=e||{},t.data.weekDays=[{symbol:"MON",label:"Monday"},{symbol:"TUE",label:"Tuesday"},{symbol:"WED",label:"Wednesday"},{symbol:"THU",label:"Thursday"},{symbol:"FRI",label:"Friday"},{symbol:"SAT",label:"Saturday"},{symbol:"SUN",label:"Sunday"}],t.DOMSelectors={listSurchargeSettings:"#list_surcharge_settings"},t.templates={},t.templates.modalContent=multiline(function(){
/*!@preserve
	            <p>
	            Normal price for <span class="text-primary">{{appointmentType.name}}</span> is <span class="text-bold">{{parseFloat(feeAmount)}} {{feeCurrency}}</span>.
	            </p>
	            <p>
	            <a href="#" data-action="add">
	            <i class="fa fa-plus"></i> Add Surcharge
	            </a>
	            </p>
	            <ul class="list-unstyled" id="list_surcharge_settings">
	            {% for surchargeSetting in surchargeSettings %}
	            <li data-id="{{surchargeSetting.id}}" data-name="{{surchargeSetting.name}}">
	            <div class="pull-right">
	            <a href="#" data-action="edit" style="margin-right:10px;">
	            Edit
	            </a>
	            <a href="#" data-action="delete">
	            Delete
	            </a>
	            </div>
	            <b>{{surchargeSetting.name}}</b><br/>
	            From {{moment(surchargeSetting.startHour, "HH:mm:ss").format("HH:mm")}} to {{moment(surchargeSetting.endHour, "HH:mm:ss").format("HH:mm")}}<br/>
	            <ul class="list-inline">
	            {% for weekDay in weekDays %}
	            <li>
	            <i style="vertical-align:middle;" class="fa
	            {% if weekDay.symbol|checkIfIndexOf(surchargeSetting.weekDays) == 1 %}
	            fa-check-square-o
	            {% else %}
	            fa-square-o
	            {% endif %}
	            "/>
	            {{ weekDay.label }}
	            </li>
	            {% endfor %}
	            </ul>
	            Price: {{parseFloat(feeAmount)}} + {{parseFloat(surchargeSetting.amount)}} = {{parseFloat(feeAmount) + parseFloat(surchargeSetting.amount)}} {{feeCurrency}}
	            </p>
	            </li>
	            {% endfor %}
	            </ul>
	            */
console.log}),t.templates.surchargeSettingItem=multiline(function(){
/*!@preserve
	            <li data-id="{{surchargeSetting.id}}" data-name="{{surchargeSetting.name}}">
	            <div class="pull-right">
	            <a href="#" data-action="edit" style="margin-right:10px;">
	            Edit
	            </a>
	            <a href="#" data-action="delete">
	            Delete
	            </a>
	            </div>
	            <b>{{surchargeSetting.name}}</b><br/>
	            From {{moment(surchargeSetting.startHour, "HH:mm:ss").format("HH:mm")}} to {{moment(surchargeSetting.endHour, "HH:mm:ss").format("HH:mm")}}<br/>
	            <ul class="list-inline">
	            {% for weekDay in weekDays %}
	            <li>
	            <i style="vertical-align:middle;" class="fa
	            {% if weekDay.symbol|checkIfIndexOf(surchargeSetting.weekDays) == 1 %}
	            fa-check-square-o
	            {% else %}
	            fa-square-o
	            {% endif %}
	            "/>
	            {{ weekDay.label }}
	            </li>
	            {% endfor %}
	            </ul>
	            Price: {{parseFloat(doctorBookingFee.feeAmount)}} + {{parseFloat(surchargeSetting.amount)}} = {{parseFloat(doctorBookingFee.feeAmount) + parseFloat(surchargeSetting.amount)}} {{doctorBookingFee.feeCurrency}}
	            </p>
	            </li>
	            */
console.log})},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=n(87),o=n(91),i=n(94),l=n(108);e.exports=function(e){var t=this;return t.generateTimeOptions=function(){var e=arguments.length>0&&arguments[0]!==undefined?arguments[0]:0,t=arguments.length>1&&arguments[1]!==undefined?arguments[1]:24,n=arguments.length>2&&arguments[2]!==undefined?arguments[2]:5,l=[];return o(a(e,t),function(e){e=i(String(e),2,"0"),o(a(0,60,n),function(t){t=i(String(t),2,"0"),l.push({value:e+":"+t+":00",title:e+":"+t})})}),l},t.fetchSurchargeSettings=function(t){var n=t.doctorBookingFeeId,a=t.doneCallback,o=t.failCallback;e.emit("window/loading/show"),manaDrApplication.emit("service/doctorBookingFee/surchargeSetting/list",{doctorBookingFeeId:n,doneCallback:function(t){e.emit("window/loading/hide"),"function"==typeof a&&a(t)},failCallback:function(t,n){e.emit("window/loading/hide"),"function"==typeof o&&o(t,n)}})},t.showModal=function(n){var a=n.doctorBookingFeeId,o=n.data,i=n.doneCallback,r=n.failCallback,s=bootbox.dialog({title:"Add Surcharge Setting",message:swig.render(t.templates.modalContent,{locals:{data:o,weekDays:t.data.weekDays,timeOptions:t.generateTimeOptions()}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});s.on("shown.bs.modal",function(n){var c=s.find("form"),d=s.find(t.DOMSelectors.totalAmount);c.find("select").chosen(),c.validate({ignore:":hidden:not(select)",rules:{doctor_booking_fee_id:{required:!0},name:{required:!0,minlength:1},start_hour:{required:!0},end_hour:{required:!0},"week_days[]":{required:!0},amount:{required:!0,number:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(t,n){if(n.preventDefault(),!parseInt(c.data("is-submitting"))){var o=$(t).serialize();e.emit("window/loading/show"),c.data("is-submitting",1),s.find(":input").prop("disabled",!0),e.emit("service/doctorBookingFee/surchargeSetting/create",{doctorBookingFeeId:a,data:o,doneCallback:function(t){bootbox.alert("New surcharge setting has been created successfully!",function(){"function"==typeof i&&i(t),s.modal("hide"),e.emit("window/loading/hide")})},failCallback:function(t,n){"function"==typeof r&&r(t,n),c.data("is-submitting",0),s.find(":input").prop("disabled",!1),e.emit("window/loading/hide")}})}}}),c.on("reset",function(e){setTimeout(function(){c.find("select.chosen").trigger("chosen:updated")},0)}).on("change","[name=amount]",function(e){var t=$(e.currentTarget),n=l(t.val());"number"!=typeof n||isNaN(n)?d.html(""):d.html("= "+(n+parseFloat(o.feeAmount)))})})},e.on("modal/createSurchargeSetting/show",function(e){var n=e.doctorBookingFeeId,a=e.doneCallback,o=e.failCallback;t.fetchSurchargeSettings({doctorBookingFeeId:n,doneCallback:function(e){t.showModal({doctorBookingFeeId:n,data:e,doneCallback:function(e){"function"==typeof a&&a(e)},failCallback:function(e,t){"function"==typeof o&&o(e,t)}})},failCallback:function(e,t){"function"==typeof o&&o(e,t)}})}),t.init=function(e){t.data=e||{},t.data.weekDays=[{symbol:"MON",label:"Monday"},{symbol:"TUE",label:"Tuesday"},{symbol:"WED",label:"Wednesday"},{symbol:"THU",label:"Thursday"},{symbol:"FRI",label:"Friday"},{symbol:"SAT",label:"Saturday"},{symbol:"SUN",label:"Sunday"}],t.DOMSelectors={totalAmount:".total-amount"},t.templates={},t.templates.modalContent=multiline(function(){
/*!@preserve
	            <form class="form" id="form_create_surcharge_setting">
	            <input type="hidden" name="doctor_booking_fee_id" value="{{data.id}}" />
	            <div class="form-group">
	            <label class="control-label">Name</label>
	            <div class="radio">
	            <label>
	            <input type="radio" name="name" value="After Office Hour" />
	            After Office Hour
	            </label>
	            </div>
	            <div class="radio">
	            <label>
	            <input type="radio" name="name" value="After Midnight" />
	            After Midnight
	            </label>
	            </div>
	            <div class="radio">
	            <label>
	            <input type="radio" name="name" value="Weekend" />
	            Weekend
	            </label>
	            </div>
	            </div>
	            <div class="form-group">
	            From
	            <select class="form-control" name="start_hour" style="width:100px;display:inline-block;">
	            {% for timeOption in timeOptions %}
	            <option value="{{timeOption.value}}">{{timeOption.title}}</option>
	            {% endfor %}
	            </select>
	            to
	            <select class="form-control" name="end_hour" style="width:100px;display:inline-block;">
	            {% for timeOption in timeOptions %}
	            <option value="{{timeOption.value}}">{{timeOption.title}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            <div class="form-group">
	            {% for weekDay in weekDays %}
	            <label class="checkbox-inline">
	            <input type="checkbox" name="week_days[]" value="{{weekDay.symbol}}"> {{weekDay.label}}
	            </label>
	            {% endfor %}
	            </div>
	            <div class="form-group">
	            Surcharge Price = Normal Price + <input class="form-control" name="amount" style="width:80px;display:inline-block" /> <span class="total-amount"></span> {{data.feeCurrency}}
	            </div>
	            </form>
	            */
console.log})},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){var a=n(88)();e.exports=a},function(e,t,n){var a=n(89),o=n(66),i=n(90);e.exports=function(e){return function(t,n,l){return l&&"number"!=typeof l&&o(t,n,l)&&(n=l=undefined),t=i(t),n===undefined?(n=t,t=0):n=i(n),l=l===undefined?t<n?1:-1:i(l),a(t,n,l,e)}}},function(e,t){var n=Math.ceil,a=Math.max;e.exports=function(e,t,o,i){for(var l=-1,r=a(n((t-e)/(o||1)),0),s=Array(r);r--;)s[i?r:++l]=e,e+=o;return s}},function(e,t){e.exports=function(e){return e}},function(e,t,n){var a=n(92),o=n(32),i=n(93),l=n(18);e.exports=function(e,t){return(l(e)?a:o)(e,i(t))}},function(e,t){e.exports=function(e,t){for(var n=-1,a=null==e?0:e.length;++n<a&&!1!==t(e[n],n,e););return e}},function(e,t){e.exports=function(e){return e}},function(e,t,n){var a=n(95),o=n(101),i=n(12),l=n(23);e.exports=function(e,t,n){e=l(e);var r=(t=i(t))?o(e):0;return t&&r<t?a(t-r,n)+e:e}},function(e,t,n){var a=n(96),o=n(97),i=n(98),l=n(100),r=n(101),s=n(105),c=Math.ceil;e.exports=function(e,t){var n=(t=t===undefined?" ":o(t)).length;if(n<2)return n?a(t,e):t;var d=a(t,c(e/r(t)));return l(t)?i(s(d),0,e).join(""):d.slice(0,e)}},function(e,t){var n=9007199254740991,a=Math.floor;e.exports=function(e,t){var o="";if(!e||t<1||t>n)return o;do{t%2&&(o+=e),(t=a(t/2))&&(e+=e)}while(t);return o}},function(e,t){e.exports=function(e){return e}},function(e,t,n){var a=n(99);e.exports=function(e,t,n){var o=e.length;return n=n===undefined?o:n,!t&&n>=o?e:a(e,t,n)}},function(e,t){e.exports=function(e,t,n){var a=-1,o=e.length;t<0&&(t=-t>o?0:o+t),(n=n>o?o:n)<0&&(n+=o),o=t>n?0:n-t>>>0,t>>>=0;for(var i=Array(o);++a<o;)i[a]=e[a+t];return i}},function(e,t){e.exports=function(){return!1}},function(e,t,n){var a=n(102),o=n(100),i=n(104);e.exports=function(e){return o(e)?i(e):a(e)}},function(e,t,n){var a=n(103)("length");e.exports=a},function(e,t){e.exports=function(e){return function(t){return null==t?undefined:t[e]}}},function(e,t,n){var a=n(103)("length");e.exports=a},function(e,t,n){var a=n(106),o=n(100),i=n(107);e.exports=function(e){return o(e)?i(e):a(e)}},function(e,t){e.exports=function(e){return e.split("")}},function(e,t){e.exports=function(e){return e.split("")}},function(e,t,n){var a=n(42),o=n(20),i=NaN,l=/^\s+|\s+$/g,r=/^[-+]0x[0-9a-f]+$/i,s=/^0b[01]+$/i,c=/^0o[0-7]+$/i,d=parseInt;e.exports=function(e){if("number"==typeof e)return e;if(o(e))return i;if(a(e)){var t="function"==typeof e.valueOf?e.valueOf():e;e=a(t)?t+"":t}if("string"!=typeof e)return 0===e?e:+e;e=e.replace(l,"");var n=s.test(e);return n||c.test(e)?d(e.slice(2),n?2:8):r.test(e)?i:+e}},function(e,t,n){"use strict";var a=n(87),o=n(91),i=n(94),l=n(108);e.exports=function(e){var t=this;return t.generateTimeOptions=function(){var e=arguments.length>0&&arguments[0]!==undefined?arguments[0]:0,t=arguments.length>1&&arguments[1]!==undefined?arguments[1]:24,n=arguments.length>2&&arguments[2]!==undefined?arguments[2]:5,l=[];return o(a(e,t),function(e){e=i(String(e),2,"0"),o(a(0,60,n),function(t){t=i(String(t),2,"0"),l.push({value:e+":"+t+":00",title:e+":"+t})})}),l},t.showModal=function(n){var a=n.surchargeSetting,o=n.doneCallback,i=n.failCallback,r=bootbox.dialog({title:"Update surcharge setting <b>"+a.name+"</b>",message:swig.render(t.templates.modalContent,{locals:{surchargeSetting:a,weekDays:t.data.weekDays,timeOptions:t.generateTimeOptions()}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});r.on("shown.bs.modal",function(n){var s=r.find("form"),c=r.find(t.DOMSelectors.totalAmount);s.find("select").chosen(),s.validate({ignore:":hidden:not(select)",rules:{doctor_booking_fee_id:{required:!0},name:{required:!0,minlength:1},start_hour:{required:!0},end_hour:{required:!0},"week_days[]":{},amount:{required:!0,number:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(t,n){if(n.preventDefault(),!parseInt(s.data("is-submitting"))){var l=$(t).serialize();e.emit("window/loading/show"),s.data("is-submitting",1),r.find(":input").prop("disabled",!0),e.emit("service/doctorBookingFee/surchargeSetting/update",{id:a.id,data:l,doneCallback:function(t){var n="Surcharge setting <b>"+a.name+"</b> has been updated successfully!";bootbox.alert(n,function(){"function"==typeof o&&o(t),r.modal("hide"),e.emit("window/loading/hide")})},failCallback:function(t,n){"function"==typeof i&&i(t,n),s.data("is-submitting",0),r.find(":input").prop("disabled",!1),e.emit("window/loading/hide")}})}}}),s.on("reset",function(e){setTimeout(function(){s.find("select.chosen").trigger("chosen:updated")},0)}).on("change","[name=amount]",function(e){var t=$(e.currentTarget),n=l(t.val());"number"!=typeof n||isNaN(n)?c.html(""):c.html("= "+(n+parseFloat(a.doctorBookingFee.feeAmount)))})})},e.on("modal/updateSurchargeSetting/show",function(n){var a=n.id,o=n.doneCallback,i=n.failCallback;e.emit("window/loading/show"),e.emit("service/doctorBookingFee/surchargeSetting/fetch",{id:a,doneCallback:function(n){var a=n;t.showModal({surchargeSetting:a,doneCallback:o,failCallback:i}),e.emit("window/loading/hide")},failCallback:function(t,n){var a="";a=t&&t.responseJSON&&t.responseJSON.message&&t.responseJSON.message.length?t.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){e.emit("window/loading/hide"),"function"==typeof i&&i(t,n)})}})}),t.init=function(e){t.data=e||{},t.data.weekDays=[{symbol:"MON",label:"Monday"},{symbol:"TUE",label:"Tuesday"},{symbol:"WED",label:"Wednesday"},{symbol:"THU",label:"Thursday"},{symbol:"FRI",label:"Friday"},{symbol:"SAT",label:"Saturday"},{symbol:"SUN",label:"Sunday"}],t.DOMSelectors={totalAmount:".total-amount"},t.templates={},t.templates.modalContent=multiline(function(){
/*!@preserve
	            <form class="form" id="form_update_surcharge_setting">
	            <input type="hidden" name="doctor_booking_fee_id" value="{{surchargeSetting.doctorBookingFee.id}}" />
	            <div class="form-group">
	            <label class="control-label">Name</label>
	            <div class="radio">
	            <label>
	            <input type="radio" name="name" value="After Office Hour"
	            {% if surchargeSetting.name == "After Office Hour" %}
	            checked
	            {% endif %}
	            />
	            After Office Hour
	            </label>
	            </div>
	            <div class="radio">
	            <label>
	            <input type="radio" name="name" value="After Midnight"
	            {% if surchargeSetting.name == "After Midnight" %}
	            checked
	            {% endif %}
	            />
	            After Midnight
	            </label>
	            </div>
	            <div class="radio">
	            <label>
	            <input type="radio" name="name" value="Weekend"
	            {% if surchargeSetting.name == "Weekend" %}
	            checked
	            {% endif %}
	            />
	            Weekend
	            </label>
	            </div>
	            </div>
	            <div class="form-group">
	            From
	            <select class="form-control" name="start_hour" style="width:100px;display:inline-block;">
	            {% for timeOption in timeOptions %}
	            <option value="{{timeOption.value}}"
	            {% if timeOption.value == surchargeSetting.startHour %}
	            selected
	            {% endif %}
	            >{{timeOption.title}}</option>
	            {% endfor %}
	            </select>
	            to
	            <select class="form-control" name="end_hour" style="width:100px;display:inline-block;">
	            {% for timeOption in timeOptions %}
	            <option value="{{timeOption.value}}"
	            {% if timeOption.value == surchargeSetting.endHour %}
	            selected
	            {% endif %}
	            >{{timeOption.title}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            <div class="form-group">
	            {% for weekDay in weekDays %}
	            <label class="checkbox-inline">
	            <input type="checkbox" name="week_days[]" value="{{weekDay.symbol}}"
	            {% if weekDay.symbol|checkIfIndexOf(surchargeSetting.weekDays) == 1 %}
	            checked
	            {% endif %}
	            > {{weekDay.label}}
	            </label>
	            {% endfor %}
	            </div>
	            <div class="form-group">
	            Surcharge Price = Normal Price + <input class="form-control" name="amount" style="width:80px;display:inline-block" value="{{parseFloat(surchargeSetting.amount)}}" /> <span class="total-amount">= {{parseFloat(surchargeSetting.amount) + parseFloat(surchargeSetting.doctorBookingFee.feeAmount)}}</span> {{surchargeSetting.doctorBookingFee.feeCurrency}}
	            </div>
	            </form>
	            */
console.log})},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=n(15)(globalData,"context.dashboardType","doctor");e.exports=function(e){var t=this;return t.render=function(n){var o=n.appointmentId,i=n.doneCallback,l=n.failCallback,r=bootbox.dialog({title:"Cancel appointment",message:swig.render(t.templates.modalContent,{locals:{appointmentId:o}}),className:"modal-cancel-appointment",buttons:{submit:{label:"Yes, I'm sure",className:"btn btn-danger",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}},cancel:{label:"No, I'm not sure",className:"btn btn-default"}}});r.on("shown.bs.modal",function(t){var n=r.find("form");n.on("submit",function(t){if(t.preventDefault(),!parseInt(n.data("is-loading"))){var s=n.serialize();e.emit("window/loading/show"),n.data("is-submitting",1),r.find(":input").prop("disabled",!0);var c="admin"===a?"service/admin/appointments/cancel":"service/doctor/appointments/cancel";e.emit(c,{appointmentId:o,data:s,doneCallback:function(e){var t="";t=e&&e.id?"This appointment has been cancelled!":"Request has been processed successfully",bootbox.alert(t,function(){r.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof i&&i(e)})},failCallback:function(e,t){var a="",o=multiline(function(){
/*!@preserve
	                            <p>{{message}}</p>
	                            {% if error|typeof === 'object' %}
	                            <ul>
	                            {% for key,value in error %}
	                            <li>{{value}}</li>
	                            {% endfor %}
	                            </ul>
	                            {% endif %}
	                            */
console.log});a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?swig.render(o,{locals:e.responseJSON}):"The request cannot be processed",bootbox.alert(a,function(){n.data("is-submitting",0),r.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof l&&l(e,t)})}})}})})},t.init=function(e){t.templates={},t.templates.modalContent=multiline(function(){
/*!@preserve
	                <form class="form" id="form_cancel_appointment">
	                <div class="form-group">
	                <p class="form-control-static">Are you sure to cancel this appointment? This action cannot be undone.</p>
	                </div>
	                <div class="form-group">
	                <label for="form_cancel_appointment__textarea_cancel_reason" class="control-label">Cancel reason</label>
	                <textarea class="form-control" id="form_cancel_appointment__textarea_cancel_reason" name="cancel_reason"></textarea>
	                </div>
	                </form>
	                */
console.log})},t.destroy=function(){},e.on("modalCancelAppointment/show",function(e){var n=e.appointmentId,a=e.doneCallback,o=e.failCallback;t.render({appointmentId:n,doneCallback:a,failCallback:o})}),{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.create=function(e){var t=e.data,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.appointmentType.create"),method:"POST",data:t,dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.fetch=function(e){var t=e.id,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.appointmentType.fetch",{appointmentType:t}),method:"POST"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.fetchAll=function(e){var t=e.doneCallback,n=e.failCallback;$.ajax({url:laroute.route("admin.appointmentType.fetchAll"),method:"POST"}).done(function(e){"function"==typeof t&&t(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof n&&n(e,t)})},t.update=function(e){var t=e.id,n=e.data,a=e.doneCallback,o=e.failCallback;$.ajax({url:laroute.route("admin.appointmentType.update",{appointmentType:t}),method:"PATCH",data:n,dataType:"json"}).done(function(e){"function"==typeof a&&a(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof o&&o(e,t)})},t["delete"]=function(e){var t=e.id,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.appointmentType.delete",{appointmentType:t}),method:"DELETE"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},e.on("service/appointmentType/create",function(e){var n=e.data,a=n===undefined?{}:n,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;t["delete"]({data:a,doneCallback:i,failCallback:r})}),e.on("service/appointmentType/fetch",function(e){var n=e.id,a=e.doneCallback,o=a===undefined?null:a,i=e.failCallback,l=i===undefined?null:i;t.fetch({id:n,doneCallback:o,failCallback:l})}),e.on("service/appointmentType/fetchAll",function(e){var n=e.id,a=e.doneCallback,o=a===undefined?null:a,i=e.failCallback,l=i===undefined?null:i;t.fetchAll({id:n,doneCallback:o,failCallback:l})}),e.on("service/appointmentType/update",function(e){var n=e.id,a=e.data,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;t.update({id:n,data:a,doneCallback:i,failCallback:r})}),e.on("service/appointmentType/delete",function(e){var n=e.id,a=e.doneCallback,o=a===undefined?null:a,i=e.failCallback,l=i===undefined?null:i;t["delete"]({id:n,doneCallback:o,failCallback:l})}),t.init=function(e){},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.create=function(e){var t=e.data,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.consultReason.create"),method:"POST",data:t,dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.fetch=function(e){var t=e.id,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.consultReason.fetch",{consultReason:t}),method:"POST"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.fetchAll=function(e){var t=e.doneCallback,n=e.failCallback;$.ajax({url:laroute.route("admin.consultReason.fetchAll"),method:"POST"}).done(function(e){"function"==typeof t&&t(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof n&&n(e,t)})},t.update=function(e){var t=e.id,n=e.data,a=e.doneCallback,o=e.failCallback;$.ajax({url:laroute.route("admin.consultReason.update",{consultReason:t}),method:"PATCH",data:n,dataType:"json"}).done(function(e){"function"==typeof a&&a(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof o&&o(e,t)})},t["delete"]=function(e){var t=e.id,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.consultReason.delete",{consultReason:t}),method:"DELETE"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},e.on("service/consultReason/create",function(e){var n=e.data,a=n===undefined?{}:n,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;t.create({data:a,doneCallback:i,failCallback:r})}),e.on("service/consultReason/fetch",function(e){var n=e.id,a=e.doneCallback,o=a===undefined?null:a,i=e.failCallback,l=i===undefined?null:i;t.fetch({id:n,doneCallback:o,failCallback:l})}),e.on("service/consultReason/fetchAll",function(e){var n=e.id,a=e.doneCallback,o=a===undefined?null:a,i=e.failCallback,l=i===undefined?null:i;t.fetchAll({id:n,doneCallback:o,failCallback:l})}),e.on("service/consultReason/update",function(e){var n=e.id,a=e.data,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;t.update({id:n,data:a,doneCallback:i,failCallback:r})}),e.on("service/consultReason/delete",function(e){var n=e.id,a=e.doneCallback,o=a===undefined?null:a,i=e.failCallback,l=i===undefined?null:i;t["delete"]({id:n,doneCallback:o,failCallback:l})}),t.init=function(e){},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.create=function(e){var t=e.data,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.houseCallReason.create"),method:"POST",data:t,dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.fetch=function(e){var t=e.id,n=e.data,a=e.doneCallback,o=e.failCallback;$.ajax({url:laroute.route("admin.houseCallReason.fetch",{houseCallReason:t}),method:"GET",data:n}).done(function(e){"function"==typeof a&&a(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof o&&o(e,t)})},t.list=function(e){var t=e.data,n=t===undefined?{}:t,a=e.doneCallback,o=e.failCallback;$.ajax({url:laroute.route("admin.houseCallReason.index"),method:"GET",data:humps.decamelizeKeys(n)}).done(function(e){"function"==typeof a&&a(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof o&&o(e,t)})},t.update=function(e){var t=e.id,n=e.data,a=e.doneCallback,o=e.failCallback;$.ajax({url:laroute.route("admin.houseCallReason.update",{houseCallReason:t}),method:"PUT",data:n,dataType:"json"}).done(function(e){"function"==typeof a&&a(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof o&&o(e,t)})},t["delete"]=function(e){var t=e.id,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.houseCallReason.delete",{houseCallReason:t}),method:"DELETE"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.fetchDoctors=function(e){var t=e.id,n=e.data,a=e.doneCallback,o=e.failCallback;$.ajax({url:laroute.route("admin.houseCallReason.fetchDoctors",{houseCallReason:t}),method:"POST",data:n}).done(function(e){"function"==typeof a&&a(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof o&&o(e,t)})},t.assignDoctors=function(e){var t=e.id,n=e.clinicId,a=e.doctorIds,o=e.doneCallback,i=e.failCallback;$.ajax({url:laroute.route("admin.houseCallReason.assignDoctors",{houseCallReason:t}),method:"POST",data:{clinic_id:n,doctor_ids:a}}).done(function(e){"function"==typeof o&&o(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof i&&i(e,t)})},t.removeDoctor=function(e){var t=e.id,n=e.clinicId,a=e.doctorId,o=e.doneCallback,i=e.failCallback;$.ajax({url:laroute.route("admin.houseCallReason.removeDoctor",{houseCallReason:t}),method:"POST",data:{doctor_id:a,clinic_id:n}}).done(function(e){"function"==typeof o&&o(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof i&&i(e,t)})},e.on("service/houseCallReason/create",function(e){var n=e.data,a=n===undefined?{}:n,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;t.create({data:a,doneCallback:i,failCallback:r})}),e.on("service/houseCallReason/fetch",function(e){var n=e.id,a=e.data,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;t.fetch({id:n,data:a,doneCallback:i,failCallback:r})}),e.on("service/houseCallReason/list",function(e){var n=e.data,a=n===undefined?{}:n,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;t.list({data:a,doneCallback:i,failCallback:r})}),e.on("service/houseCallReason/update",function(e){var n=e.id,a=e.data,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;t.update({id:n,data:a,doneCallback:i,failCallback:r})}),e.on("service/houseCallReason/delete",function(e){var n=e.id,a=e.doneCallback,o=a===undefined?null:a,i=e.failCallback,l=i===undefined?null:i;t["delete"]({id:n,doneCallback:o,failCallback:l})}),e.on("service/houseCallReason/fetchDoctors",function(e){var n=e.id,a=e.data,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;t.fetchDoctors({id:n,data:a,doneCallback:i,failCallback:r})}),e.on("service/houseCallReason/assignDoctors",function(e){var n=e.id,a=e.clinicId,o=e.doctorIds,i=e.doneCallback,l=i===undefined?null:i,r=e.failCallback,s=r===undefined?null:r;t.assignDoctors({id:n,clinicId:a,doctorIds:o,doneCallback:l,failCallback:s})}),e.on("service/houseCallReason/removeDoctor",function(e){var n=e.id,a=e.clinicId,o=e.doctorId,i=e.doneCallback,l=i===undefined?null:i,r=e.failCallback,s=r===undefined?null:r;t.removeDoctor({id:n,clinicId:a,doctorId:o,doneCallback:l,failCallback:s})}),t.init=function(e){},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=n(15),o=n(29),i=a(globalData,"context.dashboardType","doctor");e.exports=function(e){var t=this;return t.block=function(e){var t=e.ids,n=e.doctorId,a=e.data,l=e.doneCallback,r=e.failCallback,s=void 0;switch(i){case"admin":s="admin.doctor.workingCalendar.timeslot.block";break;case"doctor":default:s="working-calendar.block"}var c=[],d=o(t,function(e){var t=$.ajax({url:laroute.route(s,{doctorTimetable:e,doctor:n}),method:"POST",data:a,dataType:"json"});return t.fail(function(e,t){c.push(e.responseJSON.message)}),t});$.when.apply(undefined,d).always(function(){c.length?"function"==typeof r&&r(c):"function"==typeof l&&l()})},e.on("service/timeslot/block",function(e){var n=e.ids,a=e.doctorId,o=e.data,i=e.doneCallback,l=i===undefined?null:i,r=e.failCallback,s=r===undefined?null:r;t.block({ids:n,doctorId:a,data:o,doneCallback:l,failCallback:s})}),t.init=function(e){},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;t.fetchDoctorInfo=function(e){var t=e.doneCallback,n=e.failCallback;$.ajax({url:laroute.route("setting.fetchDoctorInfo"),method:"GET"}).done(function(e){"function"==typeof t&&t(humps.camelizeKeys(e.data))}).fail(function(e,t){"function"==typeof n&&n(e,t)})},t.updateChatAvailability=function(e){var t=e.availability,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("setting.updateChatAvailability"),method:"PUT",data:{availability:t},dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e.data))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.updateVideoAvailability=function(e){var t=e.availability,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("setting.updateVideoAvailability"),method:"PUT",data:{availability:t},dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e.data))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.getChatFeeSettings=function(e){var t=e.doneCallback,n=e.failCallback;$.ajax({url:laroute.route("setting.getChatFeeSettings"),method:"GET"}).done(function(e){"function"==typeof t&&t(humps.camelizeKeys(e.data))}).fail(function(e,t){"function"==typeof n&&n(e,t)})},t.getVideoFeeSettings=function(e){var t=e.doneCallback,n=e.failCallback;$.ajax({url:laroute.route("setting.getVideoFeeSettings"),method:"GET"}).done(function(e){"function"==typeof t&&t(humps.camelizeKeys(e.data))}).fail(function(e,t){"function"==typeof n&&n(e,t)})},t.updateChatFeeSettings=function(e){var t=e.data,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("setting.updateChatFeeSettings"),method:"PUT",data:t,dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e.data))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.updateVideoFeeSettings=function(e){var t=e.data,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("setting.updateVideoFeeSettings"),method:"PUT",data:t,dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e.data))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},e.on("service/teleconsultSettings/fetchDoctorInfo",function(e){var n=e.doneCallback,a=n===undefined?null:n,o=e.failCallback,i=o===undefined?null:o;t.fetchDoctorInfo({doneCallback:a,failCallback:i})}),e.on("service/teleconsultSettings/updateChatAvailability",function(e){var n=e.availability,a=e.doneCallback,o=a===undefined?null:a,i=e.failCallback,l=i===undefined?null:i;t.updateChatAvailability({availability:n,doneCallback:o,failCallback:l})}),e.on("service/teleconsultSettings/updateVideoAvailability",function(e){var n=e.availability,a=e.doneCallback,o=a===undefined?null:a,i=e.failCallback,l=i===undefined?null:i;t.updateVideoAvailability({availability:n,doneCallback:o,failCallback:l})}),e.on("service/teleconsultSettings/getChatFeeSettings",function(e){var n=e.doneCallback,a=n===undefined?null:n,o=e.failCallback,i=o===undefined?null:o;t.getChatFeeSettings({doneCallback:a,failCallback:i})}),e.on("service/teleconsultSettings/getVideoFeeSettings",function(e){var n=e.doneCallback,a=n===undefined?null:n,o=e.failCallback,i=o===undefined?null:o;t.getVideoFeeSettings({doneCallback:a,failCallback:i})}),e.on("service/teleconsultSettings/updateChatFeeSettings",function(e){var n=e.data,a=e.doneCallback,o=a===undefined?null:a,i=e.failCallback,l=i===undefined?null:i;t.updateChatFeeSettings({data:n,doneCallback:o,failCallback:l})}),e.on("service/teleconsultSettings/updateVideoFeeSettings",function(e){var n=e.data,a=e.doneCallback,o=a===undefined?null:a,i=e.failCallback,l=i===undefined?null:i;t.updateVideoFeeSettings({data:n,doneCallback:o,failCallback:l})})}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.list=function(e){var t=e.data,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("api.doctor.clinics.index"),data:t,dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},e.on("service/doctor/clinics/list",function(e){var n=e.data,a=n===undefined?{}:n,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;return t.list({data:a,doneCallback:i,failCallback:r})}),t.init=function(e){},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.list=function(e){var t=e.data,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("workingCalendar.fetchAvailableTimeslots"),data:t,dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},e.on("service/doctor/doctorTimeslots/list",function(e){var n=e.data,a=n===undefined?{}:n,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;return t.list({data:a,doneCallback:i,failCallback:r})}),t.init=function(e){},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.create=function(e){var t=e.data,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("appointment.store"),method:"POST",data:t,dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},e.on("service/doctor/appointments/create",function(e){var n=e.data,a=n===undefined?{}:n,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;return t.create({data:a,doneCallback:i,failCallback:r})}),t.init=function(e){},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.store=function(e){var t=e.data,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("api.countries.store"),method:"POST",data:t,dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.fetch=function(e){var t=e.id,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("api.countries.retrieve",{id:t}),headers:{accept:"application/json"}}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.list=function(e){var t=e.data,n=e.doneCallback,a=e.failCallback;return $.ajax({url:laroute.route("public.resource.country"),data:t,dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.update=function(e){var t=e.id,n=e.data,a=e.doneCallback,o=e.failCallback;$.ajax({url:laroute.route("api.countries.update",{id:t}),data:n,dataType:"json",method:"PUT"}).done(function(e){"function"==typeof a&&a(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof o&&o(e,t)})},t["delete"]=function(e){var t=e.id,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("api.countries.delete",{id:t}),method:"DELETE"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},e.on("service/countries/store",function(e){var n=e.data,a=n===undefined?{}:n,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;return t.store({data:a,doneCallback:i,failCallback:r})}),e.on("service/countries/fetch",function(e){var n=e.id,a=n===undefined?"":n,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;return t.fetch({id:a,doneCallback:i,failCallback:r})}),e.on("service/countries/list",function(e){var n=e.data,a=n===undefined?{}:n,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;return t.list({data:a,doneCallback:i,failCallback:r})}),e.on("service/countries/update",function(e){var n=e.id,a=n===undefined?"":n,o=e.data,i=o===undefined?{}:o,l=e.doneCallback,r=l===undefined?null:l,s=e.failCallback,c=s===undefined?null:s;return t.update({id:a,data:i,doneCallback:r,failCallback:c})}),e.on("service/countries/delete",function(e){var n=e.id,a=n===undefined?"":n,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;return t["delete"]({id:a,doneCallback:i,failCallback:r})}),t.init=function(e){},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.list=function(e){var t=e.data,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.doctor.search"),method:"POST",data:t,dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},e.on("service/adminDoctor/list",function(e){var n=e.data,a=e.doneCallback,o=a===undefined?null:a,i=e.failCallback,l=i===undefined?null:i;t.list({data:n,doneCallback:o,failCallback:l})}),t.init=function(e){},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.setClinicWorkingWeekDays=function(e){var t=e.clinicId,n=e.data,a=n===undefined?{}:n,o=e.doneCallback,i=e.failCallback;$.ajax({url:laroute.route("admin.clinic.setWorkingWeekDays",{clinic:t}),method:"POST",data:a,dataType:"json"}).done(function(e){"function"==typeof o&&o(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof i&&i(e,t)})},t.createHoliday=function(e){var t=e.clinicId,n=e.data,a=n===undefined?{}:n,o=e.doneCallback,i=e.failCallback,l=$.ajax({url:laroute.route("admin.clinic.holiday.create",{clinic:t}),method:"POST",data:humps.decamelizeKeys(a),dataType:"json"});console.log("data",a),l.done(function(e){"function"==typeof o&&o(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof i&&i(e,t)})},t.deleteHoliday=function(e){var t=e.clinicId,n=e.id,a=e.doneCallback,o=e.failCallback;$.ajax({url:laroute.route("admin.clinic.holiday.delete",{clinic:t,holiday:n}),method:"DELETE"}).done(function(e){"function"==typeof a&&a(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof o&&o(e,t)})},t.enableQueueFeature=function(e){var t=e.clinicId,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.clinic.queue.enable",{clinic:t}),method:"POST"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.disableQueueFeature=function(e){var t=e.clinicId,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.clinic.queue.disable",{clinic:t}),method:"POST"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},e.on("service/admin/clinic/setWorkingWeekDays",function(e){var n=e.clinicId,a=e.data,o=a===undefined?{}:a,i=e.doneCallback,l=e.failCallback;t.setClinicWorkingWeekDays({clinicId:n,data:o,doneCallback:i,failCallback:l})}),e.on("service/admin/clinic/holiday/create",function(e){var n=e.clinicId,a=e.data,o=a===undefined?{}:a,i=e.doneCallback,l=e.failCallback;t.createHoliday({clinicId:n,data:o,doneCallback:i,failCallback:l})}),e.on("service/admin/clinic/holiday/delete",function(e){var n=e.clinicId,a=e.id,o=e.doneCallback,i=e.failCallback;t.deleteHoliday({clinicId:n,id:a,doneCallback:o,failCallback:i})}),e.on("service/admin/clinic/queue/enable",function(e){var n=e.clinicId,a=e.doneCallback,o=e.failCallback;t.enableQueueFeature({clinicId:n,doneCallback:a,failCallback:o})}),e.on("service/admin/clinic/queue/disable",function(e){var n=e.clinicId,a=e.doneCallback,o=e.failCallback;t.disableQueueFeature({clinicId:n,doneCallback:a,failCallback:o})}),t.init=function(e){},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.create=function(e){var t=e.doctorBookingFeeId,n=e.data,a=n===undefined?{}:n,o=e.doneCallback,i=e.failCallback;$.ajax({url:laroute.route("admin.doctorBookingFee.surchargeSetting.create",{doctorBookingFee:t}),method:"POST",data:a,dataType:"json"}).done(function(e){"function"==typeof o&&o(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof i&&i(e,t)})},t.fetch=function(e){var t=e.id,n=e.data,a=e.doneCallback,o=e.failCallback;$.ajax({url:laroute.route("admin.doctorBookingFee.surchargeSetting.fetch",{surchargeSetting:t}),method:"GET",data:n}).done(function(e){"function"==typeof a&&a(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof o&&o(e,t)})},t.list=function(e){var t=e.doctorBookingFeeId,n=e.data,a=n===undefined?{}:n,o=e.doneCallback,i=e.failCallback;$.ajax({url:laroute.route("admin.doctorBookingFee.surchargeSetting.index",{doctorBookingFee:t}),method:"GET",data:humps.decamelizeKeys(a)}).done(function(e){"function"==typeof o&&o(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof i&&i(e,t)})},t.update=function(e){var t=e.id,n=e.data,a=e.doneCallback,o=e.failCallback;$.ajax({url:laroute.route("admin.doctorBookingFee.surchargeSetting.update",{surchargeSetting:t}),method:"PUT",data:n,dataType:"json"}).done(function(e){"function"==typeof a&&a(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof o&&o(e,t)})},t["delete"]=function(e){var t=e.id,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.doctorBookingFee.surchargeSetting.delete",{surchargeSetting:t}),method:"DELETE"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},e.on("service/doctorBookingFee/surchargeSetting/create",function(e){var n=e.doctorBookingFeeId,a=e.data,o=a===undefined?{}:a,i=e.doneCallback,l=i===undefined?null:i,r=e.failCallback,s=r===undefined?null:r;t.create({doctorBookingFeeId:n,data:o,doneCallback:l,failCallback:s})}),e.on("service/doctorBookingFee/surchargeSetting/fetch",function(e){var n=e.id,a=e.data,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;t.fetch({id:n,data:a,doneCallback:i,failCallback:r})}),e.on("service/doctorBookingFee/surchargeSetting/list",function(e){var n=e.doctorBookingFeeId,a=e.data,o=a===undefined?{}:a,i=e.doneCallback,l=i===undefined?null:i,r=e.failCallback,s=r===undefined?null:r;t.list({doctorBookingFeeId:n,data:o,doneCallback:l,failCallback:s})}),e.on("service/doctorBookingFee/surchargeSetting/update",function(e){var n=e.id,a=e.data,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;t.update({id:n,data:a,doneCallback:i,failCallback:r})}),e.on("service/doctorBookingFee/surchargeSetting/delete",function(e){var n=e.id,a=e.doneCallback,o=a===undefined?null:a,i=e.failCallback,l=i===undefined?null:i;t["delete"]({id:n,doneCallback:o,failCallback:l})}),t.init=function(e){},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;t.approve=function(e){var t=e.id,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.cme.events.approve",{id:t}),method:"POST",data:{status:1,comment:"This CME Event has been approved."},dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.reject=function(e){var t=e.id,n=e.data.comment,a=e.doneCallback,o=e.failCallback;$.ajax({url:laroute.route("admin.cme.events.reject",{id:t}),method:"POST",data:{status:0,comment:n},dataType:"json"}).done(function(e){"function"==typeof a&&a(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof o&&o(e,t)})},e.on("service/admin/cme/events/approve",function(e){var n=e.id,a=e.doneCallback,o=a===undefined?null:a,i=e.failCallback,l=i===undefined?null:i;t.approve({id:n,doneCallback:o,failCallback:l})}),e.on("service/admin/cme/events/reject",function(e){var n=e.id,a=e.data,o=a===undefined?{}:a,i=e.doneCallback,l=i===undefined?null:i,r=e.failCallback,s=r===undefined?null:r;t.reject({id:n,data:o,doneCallback:l,failCallback:s})}),t.init=function(e){},t.destroy=function(){}}},function(e,t){"use strict";e.exports=function(e){var t=this;t.register=function(e){var t=e.data,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.cme.organizers.register"),method:"POST",data:t,dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.fetch=function(e){var t=e.id,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.cme.organizers.fetch",{organizer:t}),method:"GET",dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},t.update=function(e){var t=e.id,n=e.data,a=e.doneCallback,o=e.failCallback;$.ajax({url:laroute.route("admin.cme.organizers.update",{organizer:t}),method:"PATCH",data:n,dataType:"json"}).done(function(e){"function"==typeof a&&a(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof o&&o(e,t)})},e.on("service/admin/cme/organizers/register",function(e){var n=e.data,a=n===undefined?{}:n,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;t.register({data:a,doneCallback:i,failCallback:r})}),e.on("service/admin/cme/organizers/fetch",function(e){var n=e.id,a=e.doneCallback,o=a===undefined?null:a,i=e.failCallback,l=i===undefined?null:i;t.fetch({id:n,doneCallback:o,failCallback:l})}),e.on("service/admin/cme/organizers/update",function(e){var n=e.id,a=e.data,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;t.update({id:n,data:a,doneCallback:i,failCallback:r})}),t.init=function(e){},t.destroy=function(){}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.fetch=function(e){var t=e.id,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.superClinicData.fetch",{superClinicData:t})}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},e.on("service/superClinicData/fetch",function(e){var n=e.id,a=e.doneCallback,o=a===undefined?null:a,i=e.failCallback,l=i===undefined?null:i;t.fetch({id:n,doneCallback:o,failCallback:l})}),t.init=function(e){},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.getByIDNumber=function(e){var t=e.data,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("doctor.patient.getByIdNumber"),method:"POST",data:t,dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},e.on("service/doctor/patients/getByIdNumber",function(e){var n=e.data,a=n===undefined?{}:n,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;return t.getByIDNumber({data:a,doneCallback:i,failCallback:r})}),{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.getByIDNumber=function(e){var t=e.data,n=e.doneCallback,a=e.failCallback;$.ajax({url:laroute.route("admin.patient.getByIdNumber"),method:"POST",data:t,dataType:"json"}).done(function(e){"function"==typeof n&&n(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof a&&a(e,t)})},e.on("service/admin/patients/getByIdNumber",function(e){var n=e.data,a=n===undefined?{}:n,o=e.doneCallback,i=o===undefined?null:o,l=e.failCallback,r=l===undefined?null:l;return t.getByIDNumber({data:a,doneCallback:i,failCallback:r})}),{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.cancel=function(e){var t=e.appointmentId,n=e.data,a=e.doneCallback,o=e.failCallback;$.ajax({url:laroute.route("admin.appointment.cancel",{appointment:t}),method:"POST",data:n,dataType:"json"}).done(function(e){"function"==typeof a&&a(humps.camelizeKeys(e))}).fail(function(e,t){"function"==typeof o&&o(e,t)})},e.on("service/admin/appointments/cancel",function(e){var n=e.appointmentId,a=e.data,o=a===undefined?{}:a,i=e.doneCallback,l=i===undefined?null:i,r=e.failCallback,s=r===undefined?null:r;return t.cancel({appointmentId:n,data:o,doneCallback:l,failCallback:s})}),t.init=function(e){},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";e.exports=function(e){return this.init=function(t){$("#box_basic_information").length&&e.sub.register("boxBasicInformation",n(130)),$("#box_personal_contact_info").length&&e.sub.register("boxPersonalContactInfo",n(131)),$("#box_security").length&&e.sub.register("boxSecurity",n(132)),$("#box_specialities").length&&e.sub.register("boxSecurity",n(133)),$("#box_colleges").length&&e.sub.register("boxColleges",n(134)),$("#box_qualifications").length&&e.sub.register("boxQualifications",n(135)),e.sub.start()},this.destroy=function(){},{init:this.init,destroy:this.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.handleUploader=function(){t.objects.$avatarImage.dropzone({acceptedFiles:".jpg, .jpeg, .png",paramName:"avatar",previewsContainer:!1,url:laroute.route("profile.avatarUpload"),autoProcessQueue:!0,params:{_token:$('meta[name="csrf-token"]').attr("content")},processing:function(){t.objects.$avatarOverlay.removeClass("hide")},success:function(e,n){t.objects.$avatarImage.attr("src",n.newAvatarUrl),t.objects.$avatarOverlay.addClass("hide"),$.notify({message:"Profile image changed successfully"},{type:"success"})}})},t.handleFormToggle=function(){t.objects.$container.on("click","[data-action=edit]",function(e){e.preventDefault(),t.objects.$form.toggleClass("editing"),t.objects.$form.trigger("reset"),t.objects.$form.hasClass("editing")?t.handleUploader():t.objects.$avatarImage[0].dropzone&&t.objects.$avatarImage[0].dropzone.destroy()})},t.handleFormReset=function(){t.objects.$form.on("reset",function(e){setTimeout(function(){t.objects.$formSelectLanguages.trigger("chosen:updated")},0)})},t.handleDatepicker=function(){t.objects.$formDatepicker.datepicker({format:"dd/mm/yyyy",weekStart:1,minViewMode:"month",maxViewMode:"years",orientation:"bottom",disableTouchKeyboard:!0,autoclose:!0,defaultViewDate:{year:1980,month:0,day:1},startView:"years",startDate:"01/01/1930",clearBtn:!0})},t.handleSelectLanguages=function(){t.objects.$formSelectLanguages.chosen({width:"100%"})},t.handleTableEditProfessionalIds=function(){var e=t.objects.$formTableEditProfessionalIds.find("tbody tr").length;t.objects.$formTableEditProfessionalIds.on("click",".btn-remove-profession",function(e){e.preventDefault();var t=$(this);bootbox.confirm("Are you sure?",function(e){e&&t.closest("tr").remove()})}).on("click",".btn-add-profession",function(n){n.preventDefault();var a=multiline(function(){
/*!@preserve
	                <tr>
	                <td>
	                <input type="text" class="form-control input-sm" name="professions[{{ index }}][name]" placeholder="Name"/>
	                </td>
	                <td>
	                <input type="text" class="form-control input-sm" name="professions[{{ index }}][license]" placeholder="License"/>
	                </td>
	                <td class="v-middle text-center">
	                <a href="#" class="btn btn-sm btn-danger btn-remove-profession">
	                Remove
	                </a>
	                </td>
	                </tr>
	                */
console.log}),o=swig.render(a,{locals:{index:e}});t.objects.$formTableEditProfessionalIds.find("tbody").append(o),e++})},t.handleForm=function(){t.handleDatepicker(),t.handleTableEditProfessionalIds(),t.handleSelectLanguages(),t.handleFormToggle(),t.handleFormReset()},t.init=function(e){t.objects={},t.objects.$container=$("#box_basic_information"),t.objects.$avatarImage=$("#box_basic_information__image"),t.objects.$avatarOverlay=$("#box_basic_information__image_overlay"),t.objects.$form=$("#form_basic_information"),t.objects.$formDatepicker=t.objects.$form.find(".datepicker"),t.objects.$formTableEditProfessionalIds=t.objects.$form.find("#table_edit_professional_ids"),t.objects.$formSelectLanguages=$("#form_basic_information__select_languages"),t.handleForm()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.handleFormToggle=function(){t.objects.$container.on("click","[data-action=edit]",function(e){e.preventDefault(),t.objects.$form.toggleClass("editing")})},t.handleForm=function(){t.handleFormToggle()},t.init=function(e){t.objects={},t.objects.$container=$("#box_personal_contact_info"),t.objects.$form=$("#form_personal_contact_info"),t.handleForm()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.bindEvents=function(){t.objects.$container.on("click","[data-action=changePassword]",function(n){n.preventDefault();var a=swig.render(t.templates.formChangePassword,{locals:{doctorId:t.data.doctorId}}),o=bootbox.dialog({title:"Change password",className:"modal-change-password",backdrop:!0,onEscape:!0,message:a,buttons:{submit:{label:"Submit",className:"btn btn-danger",callback:function(){return $(this).find("form").submit(),!1}}}});o.on("shown.bs.modal",function(){var t=o.find("form");t.validate({rules:{new_password:{required:!0,minlength:6,maxlength:30},new_password_retype:{required:!0,minlength:6,maxlength:30}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest("div").addClass("has-error")},unhighlight:function(e){$(e).closest("div").removeClass("has-error")},submitHandler:function(n,a){if(a.preventDefault(),!parseInt(t.data("is-submitting"))){var i=$(n).serialize();e.emit("window/loading/show"),t.data("is-submitting",1),o.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("profile.changePasswordSubmit"),method:"POST",data:i,dataType:"json"}).done(function(t){var n="";n=t&&t.name?"Password of doctor <b>"+t.name+"</b> has been updated.":"Request has been processed successfully.",bootbox.alert(n,function(){o.modal("hide"),e.emit("window/loading/hide")})}).fail(function(n,a){var i="";i=n&&n.responseJSON&&n.responseJSON.message&&n.responseJSON.message.length?n.responseJSON.message:"The request cannot be processed",bootbox.alert(i,function(){t.data("is-submitting",0),o.find(":input").prop("disabled",!1),e.emit("window/loading/hide")})}).always(function(){})}}})})})},t.init=function(e){t.data=e||{},t.objects={},t.objects.$container=$("#box_security"),t.templates={},t.templates.formChangePassword=multiline(function(){
/*!@preserve
	            <form class="form" data-is-submitting="0">
	            <input type="hidden" name="doctor_id" value="{{doctorId}}"/>
	            <div class="form-group">
	            <label for="newPassword">New password</label>
	            <input class="form-control" name="new_password" type="password" value=""/>
	            </div>
	            <div class="form-group">
	            <label for="newPasswordRetype">New password retype</label>
	            <input class="form-control" name="new_password_retype" type="password" value=""/>
	            </div>
	            </form>
	            */
console.log}),t.data.doctorId=t.objects.$container.find("[data-action=changePassword]").data("doctor-id"),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.handleFormToggle=function(){t.objects.$container.on("click","[data-action=edit]",function(e){e.preventDefault(),t.objects.$form.toggleClass("editing"),t.objects.$form.trigger("reset")})},t.handleFormReset=function(){t.objects.$form.on("reset",function(e){setTimeout(function(){t.objects.$formSelectSpecialities.trigger("chosen:updated")},0)})},t.handleSelectSpecialities=function(){t.objects.$formSelectSpecialities.selectize({delimiter:",",persist:!1,create:function(e){return{value:"0:"+e,text:e}}})},t.handleForm=function(){t.handleSelectSpecialities(),t.handleFormToggle(),t.handleFormReset()},t.init=function(e){t.objects={},t.objects.$container=$("#box_specialities"),t.objects.$form=$("#form_specialities"),t.objects.$formSelectSpecialities=$("#form_specialities__select_specialities"),t.handleForm()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.bindEvents=function(){t.objects.$container.on("click","[data-action=add]",function(e){e.preventDefault();var n=bootbox.dialog({title:"Add new College Record",message:swig.render(t.templates.modalAddCollegeMessage,{locals:{_token:$('[name="csrf-token"]').attr("content")}}),className:"modal-add-college"});n.on("shown.bs.modal",function(e){n.find("#form_add_college__input_date_of_graduation").datepicker(t.data.datePickerConfig)})}).on("click","[data-action=edit]",function(e){e.preventDefault();var n=$(this).closest("tr"),a=n.data("id"),o=n.data("name"),i=n.data("date-of-graduation"),l=bootbox.dialog({title:"Edit College Record",message:swig.render(t.templates.modalEditCollegeMessage,{locals:{_token:$('[name="csrf-token"]').attr("content"),id:a,name:o,dateOfGraduation:i}}),className:"modal-edit-college"});l.on("shown.bs.modal",function(e){l.find("#form_edit_college__input_date_of_graduation").datepicker(t.data.datePickerConfig)})}).on("click","[data-action=delete]",function(e){e.preventDefault();var t=$(this).closest("tr").find("form");bootbox.confirm("Are you sure to delete this record?",function(e){e&&t.submit()})})},t.init=function(e){t.data=e||{},t.data.datePickerConfig={format:"dd/mm/yyyy",weekStart:1,minViewMode:"month",maxViewMode:"years",orientation:"bottom",disableTouchKeyboard:!0,autoclose:!0,defaultViewDate:{year:2010,month:0,day:1},startView:"years",startDate:"01/01/1930",clearBtn:!0},t.objects={},t.objects.$container=$("#box_colleges"),t.templates={},t.templates.modalAddCollegeMessage=multiline(function(){
/*!@preserve
	            <form class="form-horizontal" id="form_add_college" action="/profile/qualifications/college" method="POST">
	            <input type="hidden" name="_token" value="{{_token}}"/>
	            <div class="form-group">
	            <label class="control-label col-sm-3" for="form_add_college__input_name">School Name</label>
	            <div class="col-md-9">
	            <input class="form-control" id="form_add_college__input_name" name="name"/>
	            </div>
	            </div>
	            <div class="form-group">
	            <label class="control-label col-sm-3" for="form_add_college__input_date_of_graduation">Date of Graduation</label>
	            <div class="col-md-9">
	            <input class="form-control" id="form_add_college__input_date_of_graduation" name="date_of_graduation" placeholder="Click to pick a date"/>
	            </div>
	            </div>
	            <div class="form-group">
	            <div class="col-md-9 col-md-offset-3">
	            <button type="submit" class="btn btn-primary">Submit</button>
	            </div>
	            </div>
	            </form>
	            */
console.log}),t.templates.modalEditCollegeMessage=multiline(function(){
/*!@preserve
	            <form class="form-horizontal" id="form_edit_college" action="/profile/qualifications/college/{{id}}" method="POST">
	            <input type="hidden" name="_token" value="{{_token}}"/>
	            <div class="form-group">
	            <label class="control-label col-sm-3" for="form_edit_college__input_name">School Name</label>
	            <div class="col-md-9">
	            <input class="form-control" id="form_edit_college__input_name" name="name" value="{{name}}"/>
	            </div>
	            </div>
	            <div class="form-group">
	            <label class="control-label col-sm-3" for="form_edit_college__input_date_of_graduation">Date of Graduation</label>
	            <div class="col-md-9">
	            <input class="form-control" id="form_edit_college__input_date_of_graduation" name="date_of_graduation" placeholder="Click to pick a date" value="{{dateOfGraduation}}"/>
	            </div>
	            </div>
	            <div class="form-group">
	            <div class="col-md-9 col-md-offset-3">
	            <button type="submit" class="btn btn-primary">Submit</button>
	            </div>
	            </div>
	            </form>
	            */
console.log}),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.bindEvents=function(){t.objects.$container.on("click","[data-action=add]",function(e){e.preventDefault();bootbox.dialog({title:"Add new Qualification Record",message:swig.render(t.templates.modalAddQualificationMessage,{locals:{_token:$('[name="csrf-token"]').attr("content")}}),className:"modal-add-qualification"})}).on("click","[data-action=edit]",function(e){e.preventDefault();var n=$(this).closest("tr"),a=n.data("id"),o=n.data("name"),i=n.data("issuer"),l=n.data("issued-time");bootbox.dialog({title:"Edit Qualification Record",message:swig.render(t.templates.modalEditQualificationMessage,{locals:{_token:$('[name="csrf-token"]').attr("content"),id:a,name:o,issuer:i,issuedTime:l}}),className:"modal-edit-qualification"})}).on("click","[data-action=delete]",function(e){e.preventDefault();var t=$(this).closest("tr").find("form");bootbox.confirm("Are you sure to delete this record?",function(e){e&&t.submit()})})},t.init=function(e){t.data=e||{},t.objects={},t.objects.$container=$("#box_qualifications"),t.templates={},t.templates.modalAddQualificationMessage=multiline(function(){
/*!@preserve
	            <form class="form-horizontal" id="form_add_qualification" action="/profile/qualifications" method="POST">
	            <input type="hidden" name="_token" value="{{_token}}"/>
	            <div class="form-group">
	            <label class="control-label col-sm-3" for="form_add_qualification__input_name">Name</label>
	            <div class="col-md-9">
	            <input class="form-control" id="form_add_qualification__input_name" name="name"/>
	            </div>
	            </div>
	            <div class="form-group">
	            <label class="control-label col-sm-3" for="form_add_qualification__input_issuer">Issuer</label>
	            <div class="col-md-9">
	            <input class="form-control" id="form_add_qualification__input_issuer" name="issuer"/>
	            </div>
	            </div>
	            <div class="form-group">
	            <label class="control-label col-sm-3" for="form_add_qualification__input_issued_time">Issued Year</label>
	            <div class="col-md-9">
	            <input class="form-control" type="number" id="form_add_qualification__input_issued_time" name="issued_time"/>
	            </div>
	            </div>
	            <div class="form-group">
	            <div class="col-md-9 col-md-offset-3">
	            <button type="submit" class="btn btn-primary">Submit</button>
	            </div>
	            </div>
	            </form>
	            */
console.log}),t.templates.modalEditQualificationMessage=multiline(function(){
/*!@preserve
	            <form class="form-horizontal" id="form_edit_qualification" action="/profile/qualifications/{{id}}" method="POST">
	            <input type="hidden" name="_token" value="{{_token}}"/>
	            <div class="form-group">
	            <label class="control-label col-sm-3" for="form_add_qualification__input_name">Name</label>
	            <div class="col-md-9">
	            <input class="form-control" id="form_add_qualification__input_name" name="name" value="{{name}}"/>
	            </div>
	            </div>
	            <div class="form-group">
	            <label class="control-label col-sm-3" for="form_add_qualification__input_issuer">Issuer</label>
	            <div class="col-md-9">
	            <input class="form-control" id="form_add_qualification__input_issuer" name="issuer" value="{{issuer}}"/>
	            </div>
	            </div>
	            <div class="form-group">
	            <label class="control-label col-sm-3" for="form_add_qualification__input_issued_time">Issued Time</label>
	            <div class="col-md-9">
	            <input class="form-control" type="number" id="form_add_qualification__input_issued_time" name="issued_time" value="{{issuedTime}}"/>
	            </div>
	            </div>
	            <div class="form-group">
	            <div class="col-md-9 col-md-offset-3">
	            <button type="submit" class="btn btn-primary">Submit</button>
	            </div>
	            </div>
	            </form>
	            */
console.log}),$("#form_add_qualification__input_issued_time").datepicker({minViewMode:2,format:"yyyy"}),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=n(56),o=n(15),i=n(29),l=n(76),r=n(137),s=n(13),c=o(globalData,"context.dashboardType","doctor");e.exports=function(e){var t=this;return t.render=function(){t.renderCalendar()},t.bindEvents=function(){t.objects.$buttonCreateTimeSlots.on("click",function(e){e.preventDefault(),t.showModalCreateTimeSlots()}),t.objects.$viewModeButtons.on("click",function(e){e.preventDefault();var n=$(e.currentTarget);t.data.currentView=n.data("calendar-view"),t.objects.calendar.view(t.data.currentView)}),t.objects.$nagivationButtons.on("click",function(e){e.preventDefault();var n=$(e.currentTarget);t.objects.calendar.navigate(n.data("calendar-nav")),t.data.currentDay=t.objects.calendar.options.day}),t.objects.$boxFilters.on("change","[data-filter-type]",function(e){e.preventDefault();var n=$(e.currentTarget),a=t.data.filters,o=n.data("filter-type"),i=n.data("filter-id");$(e.currentTarget).prop("checked")?-1==a[o].indexOf(i)&&a[o].push(i):-1!=a[o].indexOf(i)&&a[o].splice(a[o].indexOf(i),1),t.objects.calendar.view(t.data.currentView),t.updateUrl(t.data)}),t.objects.$boxCalendar.on("click",".btn-add-appointment-at-calendar",function(e){e.preventDefault(),e.stopPropagation();var n=$(e.currentTarget).data("appointment-date");if(!n)return!1;t.showModalAddNewAppointment({selectedDate:n,clinics:t.data.doctorClinics,conditions:t.data.conditions,timeslots:t.data.timeSlots[n]})}),t.objects.$body.on("click","[data-action=reloadCalendar]",function(e){e.preventDefault(),t.hideShouldUpdateNotification(),setTimeout(function(){t.objects.calendar.view()},1e3),t.scheduleCheckUpdates({doctorId:o(t.data,"doctor.id"),lastUpdatedTime:o(t.data,"lastUpdatedTime")})}).on("click","[data-action=sendMessage]",function(e){e.preventDefault();var n=$(e.currentTarget).data("appointment-id");t.showModalSendAppointmentMessage({appointmentId:n})}).on("click","[data-action=reschedule]",function(t){t.preventDefault();var n=$(t.currentTarget);n.data("appointment-id");e.emit("modal/rescheduleAppointment/show",{appointmentId:n.data("appointment-id"),appointmentTypeId:n.data("appointment-type-id"),appointmentTypeName:n.data("appointment-type-name"),appointmentTypeCategory:n.data("appointment-type-category"),doctorId:n.data("doctor-id")})}).on("click","[data-action=markAsVisited]",function(e){e.preventDefault();var n=$(e.currentTarget).data("appointment-id");t.showModalMarkAsVisited({appointmentId:n,doneCallback:function(e){t.objects.$modalTimeslotInfo.modal("hide"),$.notify({message:"Appointment marked as visited successfully!"},{type:"success",z_index:1030}),t.objects.calendar.view()}})}).on("click","[data-action=markAsNoShow]",function(e){e.preventDefault();var n=$(e.currentTarget),a=n.data("appointment-id"),o=n.data("appointment-time"),i=n.data("patient-name");t.showModalMarkAsNoShow({appointmentId:a,appointmentTime:o,patientName:i,doneCallback:function(e){t.objects.$modalTimeslotInfo.modal("hide"),$.notify({message:"Appointment has been marked as no-show successfully!"},{type:"success",z_index:1030}),t.objects.calendar.view()}})}).on("click","[data-action=markAsLate]",function(e){e.preventDefault();var n=$(e.currentTarget),a=n.data("appointment-id"),o=n.data("appointment-time"),i=n.data("patient-name");t.showModalMarkAsLate({appointmentId:a,appointmentTime:o,patientName:i,doneCallback:function(e){t.objects.$modalTimeslotInfo.modal("hide"),$.notify({message:"Appointment has been marked as late successfully!"},{type:"success",z_index:1030}),t.objects.calendar.view()}})}).on("click","[data-action=createAppointmentForOtherDoctor]",function(e){e.preventDefault(),t.showModalCreateAppointment()}).on("show.bs.modal",".modal-timeslot-info",function(e){$(".event-item").tooltip("hide")}).on("click",".modal-timeslot-info, .modal-add-new-appointment, .modal-add-new-patient",function(e){e.stopPropagation()}),t.bindModalTimeslotInfoEvents()},t.fetchAppointment=function(e){var t=e.appointmentId,n=e.doneCallback,a=e.failCallback;manaDrApplication.emit("window/loading/show");var o=void 0;switch(c){case"admin":o="admin.appointment.fetch";break;case"doctor":default:o="appointment.fetch"}$.ajax({url:laroute.route(o,{appointment:t}),method:"GET"}).done(function(e){"function"==typeof n&&n(e)}).fail(function(e,t){"function"==typeof a&&a(e,t)}).always(function(){manaDrApplication.emit("window/loading/hide")})},t.showModalSendAppointmentMessage=function(t){var n=t.appointmentId;e.emit("modalSendAppointmentMessage/show",{appointmentId:n})},t.showModalCreateAppointment=function(){e.emit("modalCreateAppointment/show",{})},t.bindModalTimeslotInfoEvents=function(){t.objects.$modalTimeslotInfo.on("click","[data-action=blockTimeslot]",function(e){e.preventDefault(),e.stopPropagation();var n=$(e.currentTarget).data("id"),a=o(t.data,"doctor.id");t.showmodalBlockTimeslots({ids:[n],doctorId:a,doneCallback:function(){t.objects.$modalTimeslotInfo.modal("hide"),$.notify({message:"Timeslot blocked successfully!"},{type:"success",z_index:1030}),t.objects.calendar.view()},failCallback:function(e){}})}).on("click","[data-action=deleteTimeslot]",function(e){e.preventDefault(),e.stopPropagation();var n=$(e.currentTarget).data("id");bootbox.confirm("Are you sure to delete this timeslot?<br /><b>Note: you are only able to delete a timing when it doesn't have any appointment yet</b>",function(e){e&&(manaDrApplication.emit("window/loading/show"),$.ajax({url:laroute.route(o(t.data,"routes.destroyTimeslot"),{doctor:o(t.data,"doctor.id"),doctorTimetable:n}),method:"DELETE",dataType:"json"}).done(function(e){t.objects.$modalTimeslotInfo.modal("hide"),$.notify({message:"Timeslot deleted successfully!"},{type:"success",z_index:1140}),t.objects.calendar.view()}).fail(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",$.notify({message:n},{type:"warning",z_index:1140})}).always(function(){t.objects.$modalTimeslotInfo.data("handled.bootstrapCalendar",!1),manaDrApplication.emit("window/loading/hide")}))})}).on("click","[data-action=unblockTimeslot]",function(e){e.preventDefault(),e.stopPropagation();var n=$(e.currentTarget).data("id");bootbox.confirm("Are you sure to unblock this timetable?",function(e){e&&(manaDrApplication.emit("window/loading/show"),$.ajax({url:laroute.route(o(t.data,"routes.unblockTimeslot"),{doctor:o(t.data,"doctor.id"),doctorTimetable:n}),method:"POST",dataType:"json"}).done(function(e){t.objects.$modalTimeslotInfo.modal("hide"),$.notify({message:"Timeslot unblocked successfully!"},{type:"success",z_index:1140}),t.objects.calendar.view()}).fail(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",$.notify({message:n},{type:"warning",z_index:1140})}).always(function(){manaDrApplication.emit("window/loading/hide")}))})}).on("click","[data-action=addAppointment]",function(e){e.preventDefault(),e.stopPropagation();var n=$(e.currentTarget),a=n.data("date"),o=n.data("clinic-id"),i=n.data("appointment-type-id"),l=n.data("timetable-id");t.showModalAddNewAppointment({clinics:t.data.doctorClinics,conditions:t.data.conditions,timeslots:t.data.timeSlots[a],selectedDate:a,selectedClinicId:o,selectedAppointmentTypeId:i,selectedTimeslotId:l})}).on("hide.bs.modal",function(e){$(e.currentTarget).data("handled.bootstrapCalendar",!1)})},t.showModalCreateTimeSlots=function(){var e=bootbox.dialog({title:"Create Timeslots",message:swig.render(t.templates.modalCreateTimeSlots,{locals:t.data}),className:"modal-create-timeslots",buttons:{submit:{label:'<i class="fa fa-fw fa-calendar-plus-o"></i> Confirm and submit',className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});e.on("shown.bs.modal",function(){var n=e.find("form"),i=n.find("#form_create_timeslots__select_appointment_type"),l=n.find("#form_create_timeslots__select_duration");$(".add-datepicker").datepicker({multidate:!0,maxViewMode:"month",weekStart:1,startDate:moment().format("DD/MM/YYYY"),format:"dd/mm/yyyy",disableTouchKeyboard:!0,clearBtn:!0}),l.chosen({width:"100%"}),i.on("change",function(e){var t=$(e.currentTarget).children(":selected").data("default-duration");l.children('option[value="'+t+'"]').length&&l.val(t).trigger("chosen:updated")}),n.validate({rules:{clinic:{required:!0},date:{required:!0},fromTime:{required:!0},endTime:{required:!0},appointmentType:{required:!0},duration:{required:!0},"weekly-cycle":{number:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(i,l){if(l.preventDefault(),!parseInt(n.data("is-submitting"))){var r=n.serialize();manaDrApplication.emit("window/loading/show"),n.data("is-submitting",1),e.find(":input").prop("disabled",!0),$.ajax({url:laroute.route(o(t.data,"routes.createTimeslots"),{doctor:o(t.data,"doctor.id")}),method:"POST",data:r,dataType:"json"}).done(function(n){var o=n.timezone;if(n.success){var i=swig.render(t.templates.modalCreateTimeSlotsResults,{locals:a({},n,{currentTimezone:o})});bootbox.dialog({title:"Results",message:i,className:"modal-add-timeslots modal-results"}).on("hidden.bs.modal",function(n){e.modal("hide"),manaDrApplication.emit("window/loading/hide"),t.objects.calendar.view()})}}).fail(function(t,a){var o="";o=t&&t.responseJSON&&t.responseJSON.message&&t.responseJSON.message.length?t.responseJSON.message:"The request cannot be processed",bootbox.alert(o,function(){n.data("is-submitting",0),e.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide")})})}}})})},t.showmodalBlockTimeslots=function(e){var t=e.ids,n=e.doctorId,a=e.doneCallback,o=e.failCallback;manaDrApplication.emit("modalBlockTimeslots/show",{ids:t,doctorId:n,doneCallback:a,failCallback:o})},t.showModalAddNewAppointment=function(e){var n=bootbox.dialog({title:"Add New Appointment",message:swig.render(t.templates.modalAddNewAppointment,{locals:e}),className:"modal-add-new-appointment",buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}}),a=e.selectedTimeslotId;n.on("shown.bs.modal",function(r){var s=n.find("form"),c=s.find("#form_add_new_appointment__select_clinic_id"),d=s.find("#form_add_new_appointment__select_appointment_type"),u=s.find("#form_add_new_appointment__input_search_patient"),f=s.find("#form_add_new_appointment__select_patient_id"),m=s.find("#form_add_new_appointment__group_attachments"),p=function(e){var n=function(e){var t=c.val(),n=d.val();if(!t||!n)return[];var a=o(e,"timeslots["+t+"]["+n+"]",[]),r=i(a,function(e){var t=o(e,"clinic.time_zone","");return{id:e.id,currentTimezone:t,startAt:moment(1e3*moment.utc(e.start_at).unix()).utcOffset(t).tz(t),endAt:moment(1e3*moment.utc(e.end_at).unix()).utcOffset(t).tz(t)}});return l(r,function(e){return{}})}(e),r=swig.render(t.templates.modalAddNewAppointment_SelectTimeslot,{locals:{timeslots:n,selectedTimeslotId:a}});$("#form_add_new_appointment__group_timeslot").html(r)};f.select2({dropdownParent:n,placeholder:"Search by Name/ID Number",ajax:{url:laroute.route(o(t.data,"routes.searchPatients")),dataType:"json",delay:250,data:function(e){return{text:$.trim(e.term),page:e.page||1}},transport:function(e,t,n){new $.ajax(e.url,e).done(function(e){t(e)}).fail(function(){n()})},processResults:function(e,t){return t.page=t.page||1,{results:e.data,pagination:{more:20*t.page<e.count}}},cache:!0},escapeMarkup:function(e){return e},minimumInputLength:3,minimumResultsForSearch:Infinity,templateResult:function(e){if(e.loading)return e.text;var t=multiline(function(){
/*!@preserve
	                        <div class='select2-result-patient clearfix'>
	                        <div class='select2-result-patient__avatar pull-left'>
	                        <img src='{{patient.profile_image_url}}' width='48' height='48'/>
	                        </div>
	                        <div class='select2-result-patient__meta pull-left' style='padding-left: 10px;'>
	                        <div class='select2-result-patient__title'>{{ patient.full_name }} (<b>#{{ patient.id }}</b>)</div>
	                        <div class='select2-result-patient__statistics'>
	                        {% if (patient.date_of_birth && patient.date_of_birth.length) %}
	                        <div class='select2-result-patient__forks'>Date of Birth: {{ patient.date_of_birth }}</div>
	                        {% endif %}
	                        {% if (patient.id_number && patient.id_number.length) %}
	                        <div class='select2-result-patient__forks'>National ID: {{ patient.id_number }}</div>
	                        {% endif %}
	                        {% if (patient.country_name && patient.country_name.length) %}
	                        <div class='select2-result-patient__stargazers'>Country: {{ patient.country_name }}</div>
	                        {% endif %}
	                        {% if (patient.imported_name && patient.imported_name.length) %}
	                        <div class='select2-result-patient__stargazers text-red'><i>Imported Name: {{ patient.imported_name }}</i></div>
	                        {% endif %}
	                        {% if (patient.imported_email && patient.imported_email.length) %}
	                        <div class='select2-result-patient__stargazers text-red'><i>Imported Email: {{ patient.imported_email }}</i></div>
	                        {% endif %}
	                        {% if (patient.phone && patient.phone.length) %}
	                        <div class='select2-result-patient__stargazers text-red'><i>Imported Phone: {{ patient.phone }}</i></div>
	                        {% endif %}
	                        </div>
	                        </div>
	                        </div>
	                        */
console.log});return swig.render(t,{locals:{patient:e}})},templateSelection:function(e){return e.text}}),u.on("focus",function(e){u.val("")}),m.dropzone({acceptedFiles:".jpg, .jpeg, .png",paramName:"file",previewsContainer:"#form_add_new_appointment__group_attachments__previews",clickable:"#form_add_new_appointment__group_attachments__button_upload",previewTemplate:'<div class="item">\n                            <div class="thumbnail">\n                                <img data-dz-thumbnail />\n                                <div class="xxs progress">\n                                    <div class="dz-upload progress-bar progress-bar-green" data-dz-uploadprogress></div>\n                                </div>\n                                <div class="overlay loading">\n                                    <i class="fa fa-refresh fa-spin"></i>\n                                </div>\n                            </div>\n                            <div class="content">\n                                <div class="title">\n                                    <span data-dz-name></span>\n                                    <div class="pull-right">\n                                        <a data-dz-remove href="#" data-toggle="tooltip" data-title="Remove">\n                                            <i class="fa fa-times"></i>\n                                        </a>\n                                    </div>\n                                </div>\n                                <div class="description">\n                                    <textarea class="form-control" placeholder="Description"></textarea>\n                                </div>\n                                <div class="text error">\n                                    <span data-dz-errormessage></span>\n                                </div>\n                            </div>\n                        </div>',url:laroute.route(o(t.data,"routes.uploadFile")),autoProcessQueue:!0,params:{_token:$('meta[name="csrf-token"]').attr("content")},processing:function(){},success:function(e,t){var n=$(e.previewElement),a=o(t,"file.id");a&&n.find("textarea").attr("name","files["+a+"][description]")}}),s.validate({rules:{patient_id:{required:!0},"appointment-type":{required:!0,min:1},clinic:{required:!0},appointment_date:{required:!0},"appointment-time-slot":{required:!0},patient_address:{required:function(){return parseInt($("[name=appointment-type] :selected").attr("is-house-call-appointment-type"))}},patient_location_lat:{required:function(){return parseInt($("[name=appointment-type] :selected").attr("is-house-call-appointment-type"))}},patient_location_lng:{required:function(){return parseInt($("[name=appointment-type] :selected").attr("is-house-call-appointment-type"))}}},messages:{"appointment-type":{min:"Please select an appointment type"}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(e,a){if(a.preventDefault(),!parseInt(s.data("is-submitting"))){var i=$(e).serialize(),l=$(e).find("[name=appointment-time-slot]").val();manaDrApplication.emit("window/loading/show"),s.data("is-submitting",1),n.find(":input").prop("disabled",!0),$.ajax({url:laroute.route(o(t.data,"routes.createAppointment"),{doctor:o(t.data,"doctor.id"),doctorTimetable:l}),method:"POST",data:i,dataType:"json"}).done(function(e){bootbox.alert("New appointment has been created",function(){bootbox.hideAll(),$(".modal-timeslot-info").modal("hide"),manaDrApplication.emit("window/loading/hide"),t.objects.calendar.view()})}).fail(function(e,t){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){s.data("is-submitting",0),n.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide")})})}}}),s.on("click","[data-action=addNewPatient]",function(e){e.preventDefault();$(e.currentTarget);t.showModalAddNewPatient({data:{clinics:t.data.doctorClinics,phoneCountryCodes:t.data.phoneCountryCodes,countries:t.data.countries},objects:{$selectPatient:f}})}).on("click","[data-action=searchPatients]",function(e){e.preventDefault(),function(e){var t=f.data("select2"),n=t.dropdown.$search||t.selection.$search;t.results.clear(),t.trigger("open"),n.val(e),n.trigger("keyup")}(u.val())}).on("click","[data-action=showLocationPicker]",function(e){e.preventDefault();var t=s.find("[name=patient_address]").val(),n={lat:parseInt(s.find("[name=patient_location_lat]").val()),lng:parseInt(s.find("[name=patient_location_lng]").val())};manaDrApplication.emit("modalLocationPicker/show",{address:t,position:n,doneCallback:function(e){var t=e.position,n=e.address;s.find("[name=patient_address]").val(n),s.find("[name=patient_location_lat]").val(t.lat),s.find("[name=patient_location_lng]").val(t.lng)}})}).on("change","#form_add_new_appointment__select_clinic_id",function(t){p(e)}).on("change","#form_add_new_appointment__select_appointment_type",function(t){!function(){var e=parseInt(d.find(":selected").attr("is-house-call-appointment-type")),t=$("#form_add_new_appointment__group_patient_address, #form_add_new_appointment__group_patient_location");e?t.removeClass("hide"):t.addClass("hide")}(),p(e)}).on("reset",function(t){f.html("").trigger("change"),p(e)}),c.trigger("change"),d.trigger("change")})},t.showModalAddNewPatient=function(n){var a=n.data,i=n.objects,l=bootbox.dialog({title:"Add New Patient",message:swig.render(t.templates.modalAddNewPatient,{locals:a}),size:"large",className:"modal-add-new-patient",buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});l.find("form").find("[name=date_of_birth]").datepicker({format:"dd/mm/yyyy",weekStart:1,minViewMode:"month",maxViewMode:"years",disableTouchKeyboard:!0,autoclose:!0,defaultViewDate:{year:1980,month:0,day:1},startView:"years",clearBtn:!0}),l.on("shown.bs.modal",function(n){var a=l.find("form"),r=a.find('[name="issue_country_id"]'),s=a.find("[name=id_number]"),d=s.closest(".form-group"),u=function(){var n=r.val(),a=s.val();if(a.length){r.prop("disabled",!0),s.prop("disabled",!0).data("value",a),d.data("is-loading",1);var u={issue_country_id:n,id_number:a},f=d.find(".help-block"),m="admin"===c?"service/admin/patients/getByIdNumber":"service/doctor/patients/getByIdNumber";e.emit(m,{data:u,doneCallback:function(e){var n=swig.render(t.templates.messageIDNumberExisted,{locals:e});d.addClass("has-error"),f.length?f.html(n).css("display",""):f=$('<p id="form_add_new_patient__input_id_number-error" class="help-block">'+n+"</p>").appendTo(d),r.prop("disabled",!1),s.prop("disabled",!1),d.data("is-loading",0),f.on("click","[data-action=selectPatient]",function(t){t.preventDefault();var n=o(e,"data.id",0),a=o(e,"data.text",n);n&&i.$selectPatient&&i.$selectPatient.append('<option selected value="'+n+'">'+a+"</option>"),l.modal("hide")})},failCallback:function(e,t){if(422===e.status){var n=d.find(".help-block"),a=o(e,"responseJSON.message","");d.addClass("has-error"),n.length?n.html(a).css("display",""):n=$('<p id="form_add_new_patient__input_id_number-error" class="help-block">'+a+"</p>").appendTo(d)}else d.removeClass("has-error");r.prop("disabled",!1),s.prop("disabled",!1),d.data("is-loading",0),f.remove()}})}};a.on("reset",function(e){setTimeout(function(){return s.data("value","")})}),a.validate({rules:{first_name:{required:!0,minlength:1,maxlength:255},last_name:{required:!0,minlength:1,maxlength:255},date_of_birth:{required:!0,dateFormatDMY:!0},gender:{required:!0},email:{required:{depends:function(){return $(this).val().length}},validateEmail:""},phone_number:{number:!0},issue_country_id:{required:!0},id_number:{required:!0},zip_code:{number:!0}},messages:{email:{required:"",validateEmail:"Invalid email format."}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(e,n){if(n.preventDefault(),!parseInt(a.data("is-submitting"))){var r=$(e).serialize();manaDrApplication.emit("window/loading/show"),a.data("is-submitting",1),l.find(":input").prop("disabled",!0),$.ajax({url:laroute.route(o(t.data,"routes.createPatient")),method:"POST",data:r,dataType:"json"}).done(function(e){var t=o(e,"data.id",0),n=o(e,"data.full_name",""),a=o(e,"data.text",t),r="Patient <b>"+n+"</b> created successfully!";bootbox.alert(r,function(){t&&i.$selectPatient&&i.$selectPatient.append('<option selected value="'+t+'">'+a+"</option>"),l.modal("hide"),manaDrApplication.emit("window/loading/hide")})}).fail(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){a.data("is-submitting",0),l.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide")})})}}}),r.on("change",function(e){e.preventDefault(),u()}),s.on("blur",function(e){e.preventDefault(),s.val()!==s.data("value")&&u()})})},t.showModalCreateHealthSummary=function(e){e.appointmentId,e.doneCallback,e.failCallback},t.markAppointmentAsVisited=function(e){var t=e.appointmentId,n=e.doneCallback,a=e.failCallback;manaDrApplication.emit("window/loading/show");var o=void 0;switch(c){case"admin":o="admin.appointment.markAsVisited";break;case"doctor":default:o="appointment.markAsVisited"}manaDrApplication.emit("window/loading/show"),$.ajax({url:laroute.route(o,{appointment:t}),method:"GET"}).done(function(e){"function"==typeof n&&n(e)}).fail(function(e,t){"function"==typeof a&&a(e,t)}).always(function(){manaDrApplication.emit("window/loading/hide")})},t.markAppointmentAsNoShow=function(e){var t=e.appointmentId,n=e.doneCallback,a=e.failCallback;manaDrApplication.emit("window/loading/show");var o=void 0;switch(c){case"admin":o="admin.appointment.markAsNoShow";break;case"doctor":default:o="appointment.markAsNoShow"}manaDrApplication.emit("window/loading/show"),$.ajax({url:laroute.route(o,{appointment:t}),method:"GET"}).done(function(e){"function"==typeof n&&n(e)}).fail(function(e,t){"function"==typeof a&&a(e,t)}).always(function(){manaDrApplication.emit("window/loading/hide")})},t.markAppointmentAsLate=function(e){var t=e.appointmentId,n=e.doneCallback,a=e.failCallback;manaDrApplication.emit("window/loading/show");var o=void 0;switch(c){case"admin":o="admin.appointment.markAsLate";break;case"doctor":default:o="appointment.markAsLate"}manaDrApplication.emit("window/loading/show"),$.ajax({url:laroute.route(o,{appointment:t}),method:"GET"}).done(function(e){"function"==typeof n&&n(e)}).fail(function(e,t){"function"==typeof a&&a(e,t)}).always(function(){manaDrApplication.emit("window/loading/hide")})},t.showModalMarkAsVisited=function(e){var n=e.appointmentId,a=e.doneCallback,o=e.failCallback;bootbox.confirm("Are you sure that the patient has already visited?",function(e){e&&t.fetchAppointment({appointmentId:n,doneCallback:function(e){humps.camelizeKeys(e).healthSummary?t.markAppointmentAsVisited({appointmentId:n,doneCallback:a,failCallback:o}):manaDrApplication.emit("modalHealthSummary/showAdd",{appointmentId:n,doneCallback:function(){t.markAppointmentAsVisited({appointmentId:n,doneCallback:a,failCallback:o})}})},failCallback:function(e,t){"function"==typeof o&&o(e,t)}})})},t.showModalMarkAsNoShow=function(e){var n=e.appointmentId,a=e.patientName,o=e.appointmentTime,i=e.doneCallback,l=e.failCallback;bootbox.dialog({title:"You are going to mark this appointment as <b>No Show</b>",message:swig.render(t.templates.modalMarkAsNoShowContent,{locals:{patientName:a,appointmentTime:o}}),buttons:{cancel:{label:"Cancel",className:"btn-default"},confirm:{label:"Confirm",className:"btn-primary",callback:function(e){t.markAppointmentAsNoShow({appointmentId:n,doneCallback:i,failCallback:l})}}}})},t.showModalMarkAsLate=function(e){var n=e.appointmentId,a=e.patientName,o=e.appointmentTime,i=e.doneCallback,l=e.failCallback;bootbox.dialog({title:"You are going to mark this appointment as <b>Late</b>",message:swig.render(t.templates.modalMarkAsLateContent,{locals:{patientName:a,appointmentTime:o}}),buttons:{cancel:{label:"Cancel",className:"btn-default"},confirm:{label:"Confirm",className:"btn-primary",callback:function(e){t.markAppointmentAsLate({appointmentId:n,doneCallback:i,failCallback:l})}}}})},t.renderBoxViewModes=function(e){$('#box_calendar_view_modes button[data-calendar-view="'+e+'"]').removeClass("btn-normal").addClass("btn-primary").siblings(".btn-primary").removeClass("btn-primary").addClass("btn-normal")},t.renderFilters=function(){},t.renderCalendar=function(){var e=t.data.currentView||"month",n=t.data.currentDay;if(!t.objects.$calendar.length)return console.log("Please check the DOM");t.objects.calendar=t.objects.$calendar.calendar({view:e,weekbox:!1,first_day:1,day:n,time_start:"07:00",time_end:"24:00",time_split:5,tmpl_path:laroute.url("partials/doctor-calendar-js/",[]),tmpl_cache:!1,modal:".modal-timeslot-info",modal_type:"template",modal_title:function(e){var t=e.timezone,n=moment(e.start).utcOffset(t).tz(t),a=moment(e.end).utcOffset(t).tz(t);return n.format("HH:mm")+" to "+a.format("HH:mm")+' <span data-timezone="'+t+'">('+n.format("Z")+")</span> | "+n.format("dddd DD/MM")+" <br/> "+e.clinic.name},events_source:function(e,n,a){var i=laroute.route(o(t.data,"routes.feedTimeslots"),{doctor:t.data.doctor.id,filters:JSON.stringify(t.data.filters)}),l=[],r=e,s=n,c={from:r.getTime(),to:s.getTime(),utc_offset_from:r.getTimezoneOffset(),utc_offset_to:s.getTimezoneOffset()};return a.length&&(c.browser_timezone=a),$.ajax({url:function(e,t){var n=e.indexOf("?")<0?"?":"&",a=e,o=void 0;for(o in t)a+=n+o+"="+encodeURIComponent(t[o]),n="&";return a}(i,c),dataType:"json",type:"GET",async:!1}).done(function(e){e.success||$.error(e.error),e.result&&(l=e.result)}),l},onAfterViewLoad:function(e){t.objects.$boxCalendarHeaderTitle.text(this.getTitle().toUpperCase()),t.data.currentView=e,t.renderBoxViewModes(e),$(".events-list").each(function(){var e=$(this),t={};e.children(".event").each(function(){var e=$(this).attr("data-event-class");"undefined"==typeof t[e]?t[e]=1:t[e]++});var n="";$.each(t,function(e,t){n+=t+' <span class="event bg-'+e+'"></span>'}),e.html(n)}).removeClass("hide"),t.updateUrl(t.data),t.data.isCheckUpdatesScheduled||t.scheduleCheckUpdates({doctorId:o(t.data,"doctor.id"),lastUpdatedTime:o(t.data,"lastUpdatedTime")})},onBeforeEventsLoad:function(e){t.objects.$boxCalendarOverlay.removeClass("hide"),t.objects.$boxCalendarHeaderTitle.html(""),t.objects.$boxCalendarHeaderSubtitle.html(""),e()},onAfterEventsLoad:function(e){var n=t.generateTimeSlotData(e),a=e.length;if(t.data.timeSlots=n,t.data.lastUpdatedTime=Date.now(),t.objects.$boxCalendarHeaderSubtitle.html(a+" timeslots"),t.objects.$boxCalendarOverlay.addClass("hide"),s(["day","week"],this.options.view)>=0){var o=_.first(_.sortBy(_.map(e,function(e){return moment(e.start).utcOffset(e.timezone).tz(e.timezone).format("HH:mm")})));o=o<"07:00"?o:"07:00",this.setOptions({time_start:o}),this._render()}var i=t.generateAppointmentTypesData(e);t.renderBoxAppointmentTypeLegends({appointmentTypes:i})},onBeforeViewLoad:function(e){console.log("this onBeforeViewLoad",e)}})},t.renderBoxAppointmentTypeLegends=function(e){var n=e.appointmentTypes,a=swig.render(t.templates.boxAppointmentTypeLegends_body,{locals:{appointmentTypes:n}});t.objects.$boxAppointmentTypeLegends_body.html(a)},t.generateTimeSlotData=function(e){var t={};return _.forEach(e,function(e,n,a){var o=moment(e.start).utcOffset(0).format("YYYY-MM-DD HH:mm:ss"),i=moment(e.end).utcOffset(0).format("YYYY-MM-DD HH:mm:ss"),l=moment(e.start).utcOffset(e.timezone).tz(e.timezone).format("YYYY-MM-DD"),r=e.clinic.id,s=0;e.appointmentType&&e.appointmentType.id&&(s=parseInt(e.appointmentType.id)||0),"undefined"==typeof t[l]&&(t[l]={}),"undefined"==typeof t[l][r]&&(t[l][r]={}),"undefined"==typeof t[l][r][s]&&(t[l][r][s]=[]),t[l][r][s].push({id:e.id,clinic:{time_zone:e.timezone},start_at:o,end_at:i})}),t},t.generateAppointmentTypesData=function(e){return r(e,function(e,t,n){var a=o(t,"appointmentType"),i=o(a,"id")+"",l=o(t,"class");a&&i&&!e[i]&&(e[i]=a,e[i]["class"]=l)},{})},t.updateUrl=function(e){var n=laroute.route(o(t.data,"routes.base"),{doctor:o(t.data,"doctor.id"),view:e.currentView,filters:JSON.stringify(e.filters),day:e.currentDay});window.history.pushState(null,null,n)},t.hideShouldUpdateNotification=function(){t.objects.$checkUpdatesNotification&&t.objects.$checkUpdatesNotification.close()},t.showShouldUpdateNotification=function(){t.hideShouldUpdateNotification(),setTimeout(function(){t.objects.$checkUpdatesNotification=$.notify({message:'<span data-action="reloadCalendar">Your calendar got some updates, please click here to keep it up-to-date</span>'},{type:"info",z_index:1030,delay:0,allow_dismiss:!1,placement:{from:"top",align:"right"}})},1e3)},t.scheduleCheckUpdates=function(e){var n=e.doctorId,a=e.lastUpdatedTime;setTimeout(function(){$.ajax({url:laroute.route(o(t.data,"routes.checkUpdates"),{doctor:n}),method:"POST",dataType:"json",data:{last_updated_time:a}}).done(function(e){e&&e.shouldUpdate?t.showShouldUpdateNotification():t.scheduleCheckUpdates({doctorId:n,lastUpdatedTime:a})}).fail(function(e,o){t.scheduleCheckUpdates({doctorId:n,lastUpdatedTime:a})}),t.data.isCheckUpdatesScheduled=!0},t.data.checkUpdatesInterval)},e.on("pageWorkingCalendar/checkUpdates/request",function(e){var n=e.doctorId,a=e.lastUpdatedTime;t.scheduleCheckUpdates({doctorId:n,lastUpdatedTime:a})}),t.init=function(a){t.data=a||{},t.data.checkUpdatesInterval=12e4,t.data.isCheckUpdatesScheduled=!1,t.objects={},t.objects.$body=$("body"),t.objects.$boxViewModes=$("#box_calendar_view_modes"),t.objects.$viewModeButtons=$("[data-calendar-view]"),t.objects.$nagivationButtons=$("[data-calendar-nav]"),t.objects.$buttonCreateTimeSlots=$('[data-action="createTimeSlots"]'),t.objects.$boxFilters=$("#box_calendar_filters"),t.objects.$boxCalendar=$("#box_calendar"),t.objects.$boxCalendarHeaderTitle=t.objects.$boxCalendar.find(">.box-header>.box-title>span"),t.objects.$boxCalendarHeaderSubtitle=t.objects.$boxCalendar.find(">.box-header>.box-title>small"),t.objects.$boxCalendarOverlay=t.objects.$boxCalendar.find(".overlay"),t.objects.$boxAppointmentTypeLegends=$("#box_appointment_type_legends"),t.objects.$boxAppointmentTypeLegends_body=t.objects.$boxAppointmentTypeLegends.children(".box-body"),t.objects.$calendar=$("#calendar"),t.objects.$modalTimeslotInfo=$(".modal-timeslot-info"),t.templates={},t.templates.modalCreateTimeSlots=multiline(function(){
/*!@preserve
	            <form class="form" id="form_create_timeslots">
	            <div class="form-group">
	            <label for="form_create_timeslots__select_clinic_id">Clinic:</label>
	            <select class="form-control" name="clinic">
	            {% for clinic in doctorClinics %}
	            <option value="{{clinic.id}}">
	            {{clinic.name}}
	            </option>
	            {% endfor %}
	            </select>
	            </div>
	            <div class="form-group">
	            <label for="form_create_timeslots__input_available_date">Available Date:</label>
	            <input type="text" class="form-control add-datepicker" id="form_create_timeslots__input_available_date" name="date" placeholder="Click to pick a date" readonly="readonly"/>
	            </div>
	            <div class="form-group">
	            <label for="form_create_timeslots__input_available_time">Available Time:</label>
	            <div class="list-available-time">
	            <div class="row add-available-time-row">
	            <div class="col-xs-5">
	            <select class="form-control" name="fromTime" id="form_create_timeslots__select_from_time">
	            {% for value, title in timeOptions %}
	            <option value="{{value}}" {% if title == '07:00' %}selected{% endif %}>{{title}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            <div class="col-xs-2 text-center add-available-time-row-to">to</div>
	            <div class="col-xs-5">
	            <select class="form-control" name="endTime" for="form_create_timeslots__select_end_time">
	            {% for value, title in timeOptions %}
	            <option value="{{value}}" {% if title == '07:00' %}selected{% endif %}>{{title}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            </div>
	            </div>
	            </div>
	            <div class="form-group">
	            <div class="row">
	            <div class="col-xs-5">
	            <label for="form_create_timeslots__select_appointment_type">Appointment Type</label>
	            <select name="appointmentType" class="form-control" id="form_create_timeslots__select_appointment_type">
	            <option value="0" disabled="disabled" selected="selected">Choose an appointment type</option>
	            {% for condition in conditions %}
	            <option
	            value="{{condition.id}}"
	            data-default-duration="{{condition.pivot.duration}}"
	            >{{condition.name}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            <div class="col-xs-2"></div>
	            <div class="col-xs-5">
	            <label for="form_create_timeslots__select_duration">Duration:</label>
	            <select name="duration" class="form-control" id="form_create_timeslots__select_duration">
	            {% for duration in Array(180) %}
	            <option value="{{loop.index}}">{{loop.index}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            </div>
	            </div>
	            <div class="form-group">
	            <label for="weekly-cycle">Repeat weekly in:</label>
	            <input type="text" class="form-control" name="weekly-cycle"/>
	            <p class="form-control-static">
	            <i>*Experimental feature.</i>
	            </p>
	            </div>
	            </form>
	            */
console.log}),t.templates.modalCreateTimeSlotsResults=multiline(function(){
/*!@preserve
	            {% if (timetables && timetables.length) %}
	            <p class="text-success">Succeed to add {{timetables.length}} timeslots:</p>
	            <ul>
	            {% for timeslot in timetables %}
	            <li>{{timeslot.startDateTime|formatTimestamp2(currentTimezone, 'HH:mm')}} to {{timeslot.endDateTime|formatTimestamp2(currentTimezone, 'HH:mm')}} in {{timeslot.startDateTime|formatTimestamp2(currentTimezone, 'DD/MM/YYYY')}}</li>
	            {% endfor %}
	            </ul>
	            {% endif %}
	            {% if (timetablesError && timetablesError.length) %}
	            <p class="text-danger">Failed to add {{timetablesError.length}} timeslots:</p>
	            <ul>
	            {% for timeslot in timetablesError %}
	            <li>{{timeslot.startDateTime|formatTimestamp2(currentTimezone, 'HH:mm')}} to {{timeslot.endDateTime|formatTimestamp2(currentTimezone, 'HH:mm')}} in {{timeslot.startDateTime|formatTimestamp2(currentTimezone, 'DD/MM/YYYY')}}</li>
	            {% endfor %}
	            </ul>
	            {% endif %}
	            */
console.log}),t.templates.modalBlockTimeslots=multiline(function(){
/*!@preserve
	            <form class="form" id="form_block_timeslot">
	            <div class="form-group">
	            <textarea></text
	            </div>
	            </form>
	            */
console.log}),t.templates.modalAddNewAppointment=multiline(function(){
/*!@preserve
	            <form class="form" id="form_add_new_appointment">
	            <div class="form-group">
	            <label for="form_add_new_appointment__input_date">Date</label>
	            <input type="text" name="appointment_date" id="form_add_new_appointment__input_date" class="form-control" disabled="disabled" value="{{selectedDate}}"/>
	            </div>
	            <div class="form-group">
	            <label for="form_add_new_appointment__select_patient_id">National ID - Name - Country - DoB - #ID</label>
	            <div class="input-group">
	            <select id="form_add_new_appointment__select_patient_id" class="form-control" name="patient_id" autocomplete="off"></select>
	            <span class="input-group-btn">
	            <a href="#" class="btn btn-primary" data-action="addNewPatient" data-toggle="tooltip" data-title="Create new patient record">
	            <i class="fa fa-plus"></i>
	            </a>
	            </span>
	            </div>
	            </div>
	            <div class="form-group">
	            <label for="form_add_new_appointment__select_clinic_id">Clinic</label>
	            <select class="form-control" name="clinic_id" id="form_add_new_appointment__select_clinic_id">
	            {% for clinic in clinics %}
	            <option
	            value="{{clinic.id}}"
	            {% if (selectedClinicId && clinic.id == selectedClinicId) %}
	            selected="selected"
	            {% endif %}
	            >
	            {{clinic.name}}
	            </option>
	            {% endfor %}
	            </select>
	            </div>
	            <div class="form-group">
	            <label for="form_add_new_appointment__select_appointment_type">Appointment Type</label>
	            <select class="form-control" name="appointment-type" id="form_add_new_appointment__select_appointment_type">
	            <option value="0">Choose an appointment type</option>
	            {% for condition in conditions %}
	            <option
	            value="{{condition.id}}"
	            {% if (selectedAppointmentTypeId && condition.id == selectedAppointmentTypeId) %}
	            selected="selected"
	            {% endif %}
	            is-house-call-appointment-type="{% if (condition.category == 'house_call') %}1{% else %}0{% endif %}"
	            >
	            {{condition.name}}
	            </option>
	            {% endfor %}
	            </select>
	            </div>
	            <div class="form-group hide" id="form_add_new_appointment__group_patient_address">
	            <label class="control-label">Patient Address:</label>
	            <input class="form-control" type="text" name="patient_address"/>
	            </div>
	            <div class="form-group hide" id="form_add_new_appointment__group_patient_location">
	            <label class="control-label">Patient Location:</label>
	            <div class="row">
	            <div class="col-xs-5">
	            <input class="form-control" name="patient_location_lat" type="text" placeholder="Lat" value="" readonly="readonly"/>
	            </div>
	            <div class="col-xs-5">
	            <input class="form-control" name="patient_location_lng" type="text" placeholder="Lng" value="" readonly="readonly"/>
	            </div>
	            <div class="col-xs-2">
	            <a class="btn btn-primary" href="#" data-action="showLocationPicker">
	            <i class="fa fa-map-marker"></i>
	            </a>
	            </div>
	            </div>
	            </div>
	            <div class="form-group" id="form_add_new_appointment__group_timeslot">
	            <label for="form_add_new_appointment__select_timeslot">Timeslot</label>
	            <p class="form-control-static text-danger">Please select clinic & appointment type</p>
	            </div>
	            <div class="form-group">
	            <label for="form_add_new_appointment__textarea_reason">Reason</label>
	            <textarea class="form-control" name="booking_reason" id="form_add_new_appointment__textarea_reason"></textarea>
	            </div>
	            <div class="form-group" id="form_add_new_appointment__group_attachments">
	            <label>Attachments <i id="form_add_new_appointment__group_attachments__button_upload" class="fa fa-upload" data-toggle="tooltip" data-title="Click here to upload"></i></label>
	            <div id="form_add_new_appointment__group_attachments__previews"></div>
	            </div>
	            <div class="form-group">
	            <label for="form_add_new_appointment__textarea_note">Note</label>
	            <textarea class="form-control" name="note" id="form_add_new_appointment__textarea_note" placeholder="Referrer, additional information,..."></textarea>
	            </div>
	            </form>
	            */
console.log}),t.templates.modalAddNewAppointment_SelectTimeslot=multiline(function(){
/*!@preserve
	            <label for="form_add_new_appointment__select_timeslot">Timeslot</label>
	            {% if (timeslots.length > 0) %}
	            <select class="form-control" name="appointment-time-slot" id="form_add_new_appointment__select_timeslot">
	            {% for timeslot in timeslots %}
	            <option
	            value="{{timeslot.id}}"
	            {% if (selectedTimeslotId && timeslot.id == selectedTimeslotId) %}
	            selected="selected"
	            {% endif %}
	            >
	            {{timeslot.startAt|formatTimestamp2(timeslot.currentTimezone, 'HH:mm')}} to {{timeslot.endAt|formatTimestamp2(timeslot.currentTimezone, 'HH:mm')}}
	            </option>
	            {% endfor %}
	            </select>
	            {% else %}
	            <p class="form-control-static text-danger">Cannot find any available timeslots with selected clinic & appointment type</p>
	            {% endif %}
	            */
console.log}),t.templates.modalAddNewPatient=multiline(function(){
/*!@preserve
	            <form class="form" id="form_add_new_patient">
	            <div class="row">
	            <div class="col-sm-8">
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label for="form_add_new_patient__input_first_name" class="control-label">First Name (*)</label>
	            <input type="text" class="form-control" name="first_name" id="form_add_new_patient__input_first_name" placeholder="E.g. Swee Hock Peter, Ibrahim, Ravi"/>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label for="form_add_new_patient__input_last_name" class="control-label">Last Name (*)</label>
	            <input type="text" class="form-control" name="last_name" id="form_add_new_patient__input_last_name" placeholder="E.g. Wong, bin Salman, Singh" />
	            </div>
	            </div>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_add_new_patient__select_issue_country">National ID Issuing Country (*):</label>
	            <select type="text" class="form-control" name="issue_country_id" id="form_add_new_patient__select_issue_country">
	            <option value="">Undetermined</option>
	            {% for id, name in countries %}
	            <option value="{{id}}">{{name}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_add_new_patient__input_id_number">National ID (*):</label>
	            <input type="text" class="form-control" name="id_number" id="form_add_new_patient__input_id_number" placeholder="E.g. S3073167J, G9318256K, T4604526U"/>
	            </div>
	            </div>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_add_new_patient__input_date_of_birth">Date of Birth (*)</label>
	            <input type="text" class="form-control" name="date_of_birth" id="form_add_new_patient__input_date_of_birth" placeholder="DD/MM/YYYY" />
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label">Gender (*)</label>
	            <p>
	            <label class="radio-inline">
	            <input name="gender" id="form_add_new_patient__select_gender_male" value="Male" aria-required="true" type="radio">
	            Male
	            </label>
	            <label class="radio-inline">
	            <input name="gender" id="form_add_new_patient__select_gender_female" value="Female" type="radio">
	            Female
	            </label>
	            <label class="radio-inline">
	            <input name="gender" id="form_add_new_patient__select_gender_other" value="Other" type="radio">
	            Other
	            </label>
	            </p>
	            </div>
	            </div>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_add_new_patient__input_phone_number">Phone Number</label>
	            <div class="row">
	            <div class="col-xs-6">
	            <select class="form-control" name="phone_country_code">
	            <option value="">Undetermined</option>
	            {% for code, name in phoneCountryCodes %}
	            <option value="{{code}}">{{code}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            <div class="col-xs-6">
	            <input type="text" class="form-control" name="phone_number" id="form_add_new_patient__input_phone_number"/>
	            </div>
	            </div>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_add_new_patient__input_email">Email</label>
	            <input type="text" class="form-control" name="email" id="form_add_new_patient__input_email" placeholder="E.g. david@gmail.com"/>
	            </div>
	            </div>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_add_new_patient__input_block">Block</label>
	            <input type="text" class="form-control" name="address_block" id="form_add_new_patient__input_block"/>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_add_new_patient__input_apartment_number">Apartment</label>
	            <input type="text" class="form-control" name="apartment_number" id="form_add_new_patient__input_apartment_number"/>
	            </div>
	            </div>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_add_new_patient__input_street">Street</label>
	            <input type="text" class="form-control" name="address_street" id="form_add_new_patient__input_street"/>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_add_new_patient__input_zip_code">Postal Code</label>
	            <input type="text" class="form-control" name="address_zip" id="form_add_new_patient__input_zip_code"/>
	            </div>
	            </div>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_add_new_patient__input_city">City</label>
	            <input type="text" class="form-control" name="address_city" id="form_add_new_patient__input_city"/>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label" id="form_add_new_patient__select_residence_country">Residence Country</label>
	            <select type="text" class="form-control" name="resident_country_id" id="form_add_new_patient__select_residence_country">
	            <option value="">Undetermined</option>
	            {% for id, name in countries %}
	            <option value="{{id}}">{{name}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            </div>
	            </div>
	            </div>
	            <div class="col-sm-4">
	            <div class="row">
	            <div class="col-xs-6 col-sm-12">
	            <div class="form-group">
	            <label for="form_add_new_patient__select_clinic" class="control-label">Clinic</label>
	            <select id="form_add_new_patient__select_clinic" class="form-control" name="clinic_id">
	            {% for clinic in clinics %}
	            <option value="{{clinic.id}}">{{clinic.name}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            </div>
	            <div class="col-xs-6 col-sm-12">
	            <div class="form-group">
	            <label class="control-label" id="form_add_new_patient__input_race">Race</label>
	            <input type="text" class="form-control" name="race" id="form_add_new_patient__input_race"/>
	            </div>
	            </div>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Medical Condition</label>
	            <textarea class="form-control vertical" name="medical_condition" style="height:108px"></textarea>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Drug Allergy</label>
	            <textarea class="form-control vertical" name="drug_allergy" style="height:108px"></textarea>
	            </div>
	            </div>
	            </div>
	            </form>
	            */
console.log}),t.templates.boxAppointmentTypeLegends_body=multiline(function(){
/*!@preserve
	            <div class="list">
	            {% for appointmentType in appointmentTypes %}
	            <div class="item">
	            <i class="fa fa-circle text-{{appointmentType.class}}"></i> {{appointmentType.name}}
	            </div>
	            {% endfor %}
	            </div>
	            */
console.log}),t.templates.modalMarkAsNoShowContent=multiline(function(){
/*!@preserve
	            Patient name: {{patientName}}<br/>
	            Appointment time: {{appointmentTime}}
	            */
console.log}),t.templates.modalMarkAsLateContent=multiline(function(){
/*!@preserve
	            Patient name: {{patientName}}<br/>
	            Appointment time: {{appointmentTime}}
	            */
console.log}),t.templates.messageIDNumberExisted=multiline(function(){
/*!@preserve
	            Sorry, this ID Number already exists in our system. <a href="#" data-action="selectPatient" data-id="{id}">Use this record instead</a>
	            */
console.log}),t.render(),t.bindEvents(),e.sub.register("widgetBatchActions",n(142),{data:a,objects:{calendar:t.objects.calendar,$calendar:t.objects.$calendar}}),e.sub.start()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){var a=n(92),o=n(138),i=n(33),l=n(11),r=n(139),s=n(18),c=n(140),d=n(40),u=n(42),f=n(141);e.exports=function(e,t,n){var m=s(e),p=m||c(e)||f(e);if(t=l(t,4),null==n){var b=e&&e.constructor;n=p?m?new b:[]:u(e)&&d(b)?o(r(e)):{}}return(p?a:i)(e,function(e,a,o){return t(n,e,a,o)}),n}},function(e,t,n){var a=n(42),o=Object.create,i=function(){function e(){}return function(t){if(!a(t))return{};if(o)return o(t);e.prototype=t;var n=new e;return e.prototype=undefined,n}}();e.exports=i},function(e,t,n){var a=n(37)(Object.getPrototypeOf,Object);e.exports=a},function(e,t){e.exports=function(){return!1}},function(e,t){e.exports=function(){return!1}},function(e,t,n){"use strict";var a=n(143),o=n(15);e.exports=function(e){var t=this;return t.watch=function(){setInterval(function(){var e=$(t.DOMSelectors.self),n=t.getSelectedEventsStats();n.availableActions.block?e.attr("data-can-block",1):e.attr("data-can-block",0),n.availableActions.unblock?e.attr("data-can-unblock",1):e.attr("data-can-unblock",0),n.availableActions["delete"]?e.attr("data-can-delete",1):e.attr("data-can-delete",0),Object.keys(n.events).length?e.fadeIn(300):e.hide()},100)},t.getSelectedEventsStats=function(){var e={availableActions:{},events:{}};return t.objects.$calendar.find(t.DOMSelectors.eventCheckedCheckboxes).each(function(){var t=$(this),n=t.attr("data-event-id"),a=t.attr("data-action-types").split(",");switch(t.closest("#cal-slide-box").css("display")){case"block":_.each(a,function(t){e.availableActions[t]||(e.availableActions[t]=[]),n&&(e.events[n]=t,e.availableActions[t].push(n))});break;default:return}}),e},t.render=function(){},t.bindEvents=function(){t.objects.$calendar.on("click","#widget_batch_actions [data-action-type]",function(e){e.preventDefault(),e.stopPropagation();var n=$(e.currentTarget).attr("data-action-type"),i=t.getSelectedEventsStats(),l=" ";switch(n){case"selectAll":$("#calendar").find("input[type=checkbox][data-event-id]").prop("checked",!0);break;case"deselectAll":$("#calendar").find("input[type=checkbox][data-event-id]").prop("checked",!1);break;case"block":if(!n||!n.length||!i.availableActions[n].length)return void manaDrApplication.emit("window/loading/hide");var r=i.availableActions[n],s=o(t.data,"doctor.id");manaDrApplication.emit("modalBlockTimeslots/show",{ids:r,doctorId:s,doneCallback:function(e){$.notify({message:"Timeslot blocked successfully!"},{type:"success",z_index:1030}),t.objects.calendar.view()},failCallback:function(e,t){}});break;default:if(!n||!n.length||!i.availableActions[n].length)return void manaDrApplication.emit("window/loading/hide");switch(n){case"delete":l='<p class="text-center">Are you sure to delete these timetables?<br/>(Note: Only timetables with no appointment will be deleted)</p>';break;case"block":l='<p class="text-center">Are you sure to block these timetables?</p>';break;case"unblock":l='<p class="text-center">Are you sure to unblock these timetables?</p>'}i.availableActions[n].length&&bootbox.confirm(l,function(e){if(e){manaDrApplication.emit("window/loading/show");var l=[],r=[];a(i.availableActions[n],function(e){var a;switch(n){case"delete":a=$.ajax({url:laroute.route(o(t.data,"routes.destroyTimeslot"),{doctor:o(t.data,"doctor.id"),doctorTimetable:e}),method:"DELETE",dataType:"json"});break;case"block":a=$.ajax({url:laroute.route(o(t.data,"routes.blockTimeslot"),{doctor:o(t.data,"doctor.id"),doctorTimetable:e}),method:"POST",dataType:"json"});break;case"unblock":a=$.ajax({url:laroute.route(o(t.data,"routes.unblockTimeslot"),{doctor:o(t.data,"doctor.id"),doctorTimetable:e}),method:"POST",dataType:"json"})}a.fail(function(e,t){r.push(e.responseJSON.message)}),l.push(a)}),$.when.apply(undefined,l).always(function(){t.objects.calendar.view(),manaDrApplication.emit("window/loading/hide"),r.length?bootbox.alert("Error happened while process your requests. Please check again."):bootbox.alert("Your request was processed successfully.")})}})}}),t.watch()},t.init=function(e){var n=e.data,a=e.objects;t.data=n||{},t.DOMSelectors={},t.DOMSelectors.self="#widget_batch_actions",t.DOMSelectors.eventCheckboxes="input[type=checkbox][data-event-id]",t.DOMSelectors.eventCheckedCheckboxes="input[type=checkbox][data-event-id]:checked",t.objects=a||{},t.render(),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){e.exports=n(91)},function(e,t,n){"use strict";e.exports=function(e){return this.init=function(t){$("#box_appointment_types").length&&e.sub.register("boxAppointmentTypes",n(145)),$("#box_time").length&&e.sub.register("boxTime",n(146)),$("#box_teleconsult_settings").length&&e.sub.register("boxTeleconsults",n(147)),e.sub.start()},this.destroy=function(){},{init:this.init,destroy:this.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.handleFormToggle=function(){t.objects.$container.on("click","[data-action=edit]",function(e){e.preventDefault(),t.objects.$form.toggleClass("editing"),t.objects.$form.trigger("reset")}).on("click","[data-action=add]",function(e){e.preventDefault();multiline(function(){
/*!@preserve
	                Hello
	                */
console.log})})},t.handleFormEvents=function(){t.objects.$form.on("click","[data-action=delete]",function(e){e.preventDefault();var t=$(this);bootbox.confirm("Are you sure?",function(e){console.log(e),e&&t.closest("tr").addClass("hide").find("select").val("0")})}).on("click","[data-action=add]",function(e){e.preventDefault();var n=t.objects.$formRowAddSelectAppointmentType.val(),a=t.objects.$formRowAddSelectAppointmentType.find(":selected").text(),o=t.objects.$formRowAddSelectDuration.val();if(!parseInt(n)||!parseInt(o))return!1;var i=t.objects.$formRowAddSelectDuration.html(),l=multiline(function(){
/*!@preserve
	                <tr data-id="{{appointmentType.id}}">
	                <td>
	                <input type="hidden" name="appointment_type_id[]" value="{{appointmentType.id}}"/>
	                <div class="text-right" style="padding-top:7px">
	                {{appointmentType.name}}
	                </div>
	                </td>
	                <td>
	                <div class="form-control-static">
	                {{appointmentType.duration}} minutes
	                </div>
	                <select class="form-control" name="appointment_type_duration[]" value="{{appointmentType.duration}}">
	                {{durationOptionsHtml|safe}}
	                </select>
	                </td>
	                <td>
	                <a class="btn btn-danger" data-action="delete">
	                <i class="fa fa-times"></i>
	                Delete
	                </a>
	                </td>
	                </tr>
	                */
console.log}),r=swig.render(l,{locals:{appointmentType:{id:n,name:a,duration:o},durationOptionsHtml:i}}),s=$(r);s.find('[name="appointment_type_duration[]"]').val(o),s.insertBefore(t.objects.$formRowAdd),t.objects.$formRowAddSelectAppointmentType.val("0").trigger("chosen:updated"),t.objects.$formRowAddSelectDuration.val("0").trigger("chosen:updated")})},t.renderRowAddNew=function(){t.objects.$formRowAddSelectAppointmentType.chosen({width:"100%"}),t.objects.$formRowAddSelectDuration.chosen({width:"100%"})},t.render=function(){t.renderRowAddNew()},t.bindEvents=function(){t.handleFormToggle(),t.handleFormEvents()},t.init=function(e){t.objects={},t.objects.$container=$("#box_appointment_types"),t.objects.$form=$("#form_appointment_types"),t.objects.$formRowAdd=$("#form_appointment_types__row_add"),t.objects.$formRowAddSelectAppointmentType=$("#form_appointment_types__row_add__select_appointment_type"),t.objects.$formRowAddSelectDuration=$("#form_appointment_types__row_add__select_duration"),t.render(),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.render=function(){t.objects.$selectTimezone.chosen({search_contains:!0})},t.init=function(e){var n=e.data;t.data=n||{},t.objects={},t.objects.$form=$("#form_time"),t.objects.$selectTimezone=t.objects.$form.find("[name=timezone]"),t.templates={},t.render()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.activateChat=function(t){var n=t.doneCallback,a=t.failCallback;e.emit("service/teleconsultSettings/updateChatAvailability",{availability:!0,doneCallback:n,failCallback:a})},t.deactivateChat=function(t){var n=t.doneCallback,a=t.failCallback;e.emit("service/teleconsultSettings/updateChatAvailability",{availability:!1,doneCallback:n,failCallback:a})},t.activateVideo=function(t){var n=t.doneCallback,a=t.failCallback;e.emit("service/teleconsultSettings/updateVideoAvailability",{availability:!0,doneCallback:n,failCallback:a})},t.deactivateVideo=function(t){var n=t.doneCallback,a=t.failCallback;e.emit("service/teleconsultSettings/updateVideoAvailability",{availability:!1,doneCallback:n,failCallback:a})},t.showLoadingOverlay=function(){t.objects.$overlayLoading.removeClass("hide")},t.hideLoadingOverlay=function(){t.objects.$overlayLoading.addClass("hide")},t.renderFormChatAvailability=function(e){var n=swig.render(t.templates.formChatAvailability,{locals:e});t.objects.$formChatAvailability.html(n)},t.renderFormChatFeeSettings=function(e){var n=swig.render(t.templates.formChatFeeSettings,{locals:e});t.objects.$formChatFeeSettings.html(n)},t.renderFormVideoAvailability=function(e){var n=swig.render(t.templates.formVideoAvailability,{locals:e});t.objects.$formVideoAvailability.html(n)},t.renderFormVideoFeeSettings=function(e){console.log("data",e);var n=swig.render(t.templates.formVideoFeeSettings,{locals:e});t.objects.$formVideoFeeSettings.html(n)},t.render=function(){t.showLoadingOverlay(),e.emit("service/teleconsultSettings/fetchDoctorInfo",{doneCallback:function(e){var n=swig.render(t.templates.formChatAvailability,{locals:e}),a=swig.render(t.templates.formChatFeeSettings,{locals:e.chatFee}),o=swig.render(t.templates.formVideoAvailability,{locals:e}),i=swig.render(t.templates.formVideoFeeSettings,{locals:e.videoFee});console.log(e),t.objects.$formChatAvailability.append(n),t.objects.$formChatFeeSettings.append(a),t.objects.$formVideoAvailability.append(o),t.objects.$formVideoFeeSettings.append(i),t.hideLoadingOverlay()},failCallback:function(e,n){t.renderMessage({message:"Cannot load your fee settings for tele-consults. Please try again later.",level:"warning"}),t.hideLoadingOverlay()}})},t.renderMessage=function(e){var n=e.message,a=e.level,o=swig.render(t.templates.message,{locals:{message:n,level:a}});t.objects.$message.html(o)},t.bindEvents=function(){t.objects.$formChatAvailability.on("change","[name=available_chat]",function(n){var a=$(n.currentTarget).prop("checked");t.showLoadingOverlay(),a?t.activateChat({doneCallback:function(n){t.renderFormChatAvailability(n),e.emit("window/notify/show",{icon:"fa fa-check",message:"Updated chat availability successfully",type:"success"}),t.hideLoadingOverlay()},failCallback:function(n,a){var o="";o=n&&n.responseJSON&&n.responseJSON.message&&n.responseJSON.message.length?n.responseJSON.message:"Cannot update chat availability. Please try again later.",e.emit("window/notify/show",{icon:"fa fa-warning-sign",message:o,type:"warning"}),t.hideLoadingOverlay()}}):t.deactivateChat({doneCallback:function(n){t.renderFormChatAvailability(n),e.emit("window/notify/show",{icon:"fa fa-check",message:"Updated chat availability successfully",type:"success"}),t.hideLoadingOverlay()},failCallback:function(n,a){var o="";o=n&&n.responseJSON&&n.responseJSON.message&&n.responseJSON.message.length?n.responseJSON.message:"Cannot update chat availability. Please try again later.",e.emit("window/notify/show",{icon:"fa fa-warning-sign",message:o,type:"warning"}),t.hideLoadingOverlay()}})}),t.bindFormChatFeeSettingsEvents(),t.objects.$formVideoAvailability.on("change","[name=available_video]",function(n){var a=$(n.currentTarget).prop("checked");t.showLoadingOverlay(),a?t.activateVideo({doneCallback:function(n){t.renderFormVideoAvailability(n),e.emit("window/notify/show",{icon:"fa fa-check",message:"Updated video availability successfully",type:"success"}),t.hideLoadingOverlay()},failCallback:function(n,a){n&&n.responseJSON&&n.responseJSON.message&&n.responseJSON.message.length&&n.responseJSON.message,e.emit("window/notify/show",{icon:"fa fa-warning-sign",message:n.message,type:"warning"}),t.hideLoadingOverlay()}}):t.deactivateVideo({doneCallback:function(n){t.renderFormVideoAvailability(n),e.emit("window/notify/show",{icon:"fa fa-check",message:"Updated video availability successfully",type:"success"}),t.hideLoadingOverlay()},failCallback:function(n,a){var o="";o=n&&n.responseJSON&&n.responseJSON.message&&n.responseJSON.message.length?n.responseJSON.message:"Cannot update video availability. Please try again later.",e.emit("window/notify/show",{icon:"fa fa-warning-sign",message:o,type:"warning"}),t.hideLoadingOverlay()}})}),t.bindFormVideoFeeSettingsEvents()},t.bindFormChatFeeSettingsEvents=function(){t.objects.$formChatFeeSettings.validate({rules:{initial_message_fee:{required:!0,number:!0},subsequent_message_fee:{required:!0,number:!0},summary_fee:{required:!0,number:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(n,a){a.preventDefault();var o=t.objects.$formChatFeeSettings;if(!parseInt(o.data("is-submitting"))){var i=o.serialize();o.data("is-submitting",1),t.showLoadingOverlay(),e.emit("service/teleconsultSettings/updateChatFeeSettings",{data:i,doneCallback:function(n){t.renderFormChatFeeSettings(n),t.bindFormChatFeeSettingsEvents(),o.data("is-submitting",0),e.emit("window/notify/show",{icon:"fa fa-check",message:"Updated chat fee settings successfully",type:"success"}),t.hideLoadingOverlay()},failCallback:function(n,a){var i="";i=n&&n.responseJSON&&n.responseJSON.message&&n.responseJSON.message.length?n.responseJSON.message:"Cannot update chat fee settings. Please try again later.",e.emit("window/notify/show",{icon:"fa fa-warning-sign",message:i,type:"warning"}),o.data("is-submitting",0),t.hideLoadingOverlay()}})}}})},t.bindFormVideoFeeSettingsEvents=function(){t.objects.$formVideoFeeSettings.validate({rules:{initial_minute_fee:{required:!0,number:!0},subsequent_minute_fee:{required:!0,number:!0},summary_fee:{required:!0,number:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(n,a){a.preventDefault();var o=t.objects.$formVideoFeeSettings;if(!parseInt(o.data("is-submitting"))){var i=o.serialize();o.data("is-submitting",1),t.showLoadingOverlay(),e.emit("service/teleconsultSettings/updateVideoFeeSettings",{data:i,doneCallback:function(n){t.renderFormVideoFeeSettings(n),t.bindFormVideoFeeSettingsEvents(),o.data("is-submitting",0),e.emit("window/notify/show",{icon:"fa fa-check",message:"Updated video fee settings successfully",type:"success"}),t.hideLoadingOverlay()},failCallback:function(n,a){var i="";i=n&&n.responseJSON&&n.responseJSON.message&&n.responseJSON.message.length?n.responseJSON.message:"Cannot update video fee settings. Please try again later.",e.emit("window/notify/show",{icon:"fa fa-warning-sign",message:i,type:"warning"}),o.data("is-submitting",0),t.hideLoadingOverlay()}})}}})},t.init=function(e){var n=e.data;t.data=n||{},t.objects={},t.objects.$container=$("#box_teleconsult_settings"),t.objects.$overlayLoading=t.objects.$container.children(".overlay"),t.objects.$body=t.objects.$container.children(".box-body"),t.objects.$formChatAvailability=t.objects.$body.children("#form_chat_availability"),t.objects.$formChatFeeSettings=t.objects.$body.children("#form_chat_fee_settings"),t.objects.$formVideoAvailability=t.objects.$body.children("#form_video_availability"),t.objects.$formVideoFeeSettings=t.objects.$body.children("#form_video_fee_settings"),t.objects.$message=t.objects.$body.children("#message"),t.templates={},t.templates.formChatAvailability=multiline(function(){
/*!@preserve
	            <h4 class="text-uppercase">
	            <div class="checkbox">
	            <label>
	            <input type="checkbox" name="available_chat" {% if availableChat %}checked="checked"{% endif %}> Chat
	            </label>
	            </div>
	            </h4>
	            */
console.log}),t.templates.formChatFeeSettings=multiline(function(){
/*!@preserve
	            <div class="form-group">
	            <label class="col-xs-3 control-label">First 5 messages</label>
	            <div class="col-xs-9">
	            <input class="form-control" name="initial_message_fee" value="{{initialMessageFee}}"/>
	            </div>
	            </div>
	            <div class="form-group">
	            <label class="col-xs-3 control-label">Subsequent message</label>
	            <div class="col-xs-9">
	            <input class="form-control" name="subsequent_message_fee" value="{{subsequentMessageFee}}"/>
	            </div>
	            </div>
	            <div class="form-group">
	            <label class="col-xs-3 control-label">Consult summary</label>
	            <div class="col-xs-9">
	            <input class="form-control" name="summary_fee" value="{{summaryFee}}"/>
	            </div>
	            </div>
	            <input type="hidden" name="currency" value="{{currency}}"/>
	            <div class="form-group">
	            <label class="col-xs-3 control-label">Currency</label>
	            <div class="col-xs-9">
	            <p class="form-control-static">{{currency}}</p>
	            </div>
	            </div>
	            <div class="form-group">
	            <div class="col-xs-9 col-xs-push-3">
	            <button class="btn btn-primary" type="submit">Submit</button>
	            <button class="btn btn-default" type="reset">Reset</button>
	            </div>
	            </div>
	            */
console.log}),t.templates.formVideoAvailability=multiline(function(){
/*!@preserve
	            <h4 class="text-uppercase">
	            <div class="checkbox">
	            <label>
	            <input type="checkbox" name="available_video" {% if availableVideo %}checked="checked"{% endif %}> Video
	            </label>
	            </div>
	            </h4>
	            */
console.log}),t.templates.formVideoFeeSettings=multiline(function(){
/*!@preserve
	            <div class="form-group">
	            <label class="col-xs-3 control-label">First 3 minutes</label>
	            <div class="col-xs-9">
	            <input class="form-control" name="video_initial_block" value="{{initialMinuteFee}}"/>
	            </div>
	            </div>
	            <div class="form-group">
	            <label class="col-xs-3 control-label">Subsequent minute</label>
	            <div class="col-xs-9">
	            <input class="form-control" name="video_sub_minute" value="{{subsequentMinuteFee}}"/>
	            </div>
	            </div>
	            <div class="form-group">
	            <label class="col-xs-3 control-label">Consult summary</label>
	            <div class="col-xs-9">
	            <input class="form-control" name="video_consult_summary" value="{{summaryFee}}"/>
	            </div>
	            </div>
	            <input type="hidden" name="currency" value="{{currency}}"/>
	            <div class="form-group">
	            <label class="col-xs-3 control-label">Currency</label>
	            <div class="col-xs-9">
	            <p class="form-control-static">{{currency}}</p>
	            </div>
	            </div>
	            <div class="form-group">
	            <div class="col-xs-9 col-xs-push-3">
	            <button class="btn btn-primary" type="submit">Submit</button>
	            <button class="btn btn-default" type="reset">Reset</button>
	            </div>
	            </div>
	            */
console.log}),t.templates.message=multiline(function(){
/*!@preserve
	            <div class="alert alert-dismissable alert-{{level}}" role="alert">
	            {{message}}
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	            </div>
	            */
console.log}),t.render(),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";e.exports=function(e){return this.init=function(t){e.sub.register("modalMapPicker",n(149)),e.sub.start()},this.destroy=function(){},{init:this.init,destroy:this.destroy}}},function(e,t,n){"use strict";var a=n(54);a.KEY="AIzaSyAb6zQRkXnjua7WNqFXzciULhd_R5lHSOo",e.exports=function(e){var t=this;return t.render=function(){$(".modal-map-picker .modal-footer").prepend('<div id="segment_selected_position" class="pull-left"></div>')},t.bindEvents=function(){a.load(function(e){var n=new e.maps.Map(document.getElementById(t.DOMSelectors.mapContainerId),{center:t.data.currentPosition,zoom:t.data.currentZoom}),a=new e.maps.Marker({position:t.data.currentPosition,map:n,draggable:!0});e.maps.event.addListener(a,"dragend",function(e){t.updateCurrentPosition({lat:e.latLng.lat(),lng:e.latLng.lng()})})})},t.updateCurrentPosition=function(e){e&&e.lat&&!isNaN(e.lat)&&e.lng&&!isNaN(e.lng)&&(t.data.currentPosition.lat=e.lat,t.data.currentPosition.lng=e.lng),t.renderCurrentPosition()},t.renderCurrentPosition=function(){var e=swig.render(t.templates.segmentSelectedPosition,{locals:{position:t.data.currentPosition}});$(t.DOMSelectors.segmentSelectedPosition).html(e)},e.on("pageAdminClinicDetails/modalMapPicker/show",function(e){t.render(),t.updateCurrentPosition(e),t.bindEvents()}),t.init=function(e){t.data={currentPosition:{lat:1.352083,lng:103.81983600000001},currentZoom:13},t.DOMSelectors={mapContainerId:"segment_map_picker",segmentSelectedPosition:"#segment_selected_position"},t.templates={segmentSelectedPosition:multiline(function(){
/*!@preserve
	                <b>Current Lat:</b> <span data-lat="{{position.lat}}">{{position.lat}}</span>, <b>Current Lng:</b> <span data-lng="{{position.lng}}">{{position.lng}}</span>
	                */
console.log})},t.objects={}},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=n(15);e.exports=function(e){var t=this;return t.render=function(){},t.bindEvents=function(){},t.init=function(o){t.data=o||{},$("#box_profile").length&&e.sub.register("boxProfile",n(151),a(o,"appointment")),$("#box_consult_summary").length&&e.sub.register("boxConsultSummary",n(152),a(o,"appointment.healthSummary")),$("#patient_info").length&&e.sub.register("boxInfo",n(153),a(o,"appointment")),$("#box_messages").length&&e.sub.register("boxMessages",n(154),a(o,"appointment")),e.sub.start()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.render=function(){},t.bindEvents=function(){t.objects.$self.on("click","[data-action=cancel]",function(t){t.preventDefault();var n=$(t.currentTarget).data("id");e.emit("modalCancelAppointment/show",{appointmentId:n,doneCallback:function(e){window.location.reload()}})})},t.init=function(e){t.data=e||{},t.objects={},t.objects.$self=$("#box_profile"),t.render(),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.render=function(){},t.bindEvents=function(){t.objects.$self.on("click","[data-action=add]",function(n){e.emit("modalHealthSummary/showAdd",{appointmentId:t.objects.$self.data("appointment-id"),doneCallback:function(){window.location.reload()}})}).on("click","[data-action=update]",function(n){e.emit("modalHealthSummary/showUpdate",{appointmentId:t.objects.$self.data("appointment-id"),content:{title:t.data.title,summary:t.data.summary,plan:t.data.plan,visitDoctorIf:t.data.visitDoctorIf},doneCallback:function(){window.location.reload()}})})},t.init=function(e){t.data=e||{},t.objects={},t.objects.$self=$("#box_consult_summary"),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=n(15);e.exports=function(e){var t=this;return t.render=function(){},t.bindEvents=function(){t.objects.$self.on("click","[data-action=updateBookingReason]",function(n){n.preventDefault(),e.emit("modalUpdateBookingReason/show",{appointmentId:a(t.data,"id"),content:{bookingReason:a(t.data,"bookingReason")},doneCallback:function(){window.location.reload()}})})},t.init=function(e){t.data=e||{},t.objects={},t.objects.$self=$("#patient_info"),t.render(),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=n(15);e.exports=function(e){var t=this;t.render=function(){},t.bindEvents=function(){t.objects.$self.on("click","[data-action=sendMessage]",function(n){n.preventDefault();var o=a(t.data,"id");e.emit("modalSendAppointmentMessage/show",{appointmentId:o,doneCallback:function(e){window.location.reload()}})})},t.init=function(e){t.data=e||{},t.objects={},t.objects.$self=$("#box_messages"),t.render(),t.bindEvents()},t.destroy=function(){}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.bindEvents=function(){t.objects.$body.on("click","[data-action=verify]",function(t){t.preventDefault();var n=$(t.currentTarget).data("id");e.emit("modalVerifyPatient/show",{patientId:n,doneCallback:function(e){window.location.reload()}})})},t.init=function(e){t.data=e||{},t.objects={},t.objects.$body=$("body"),t.templates={},t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=n(15),o={submit:{label:"Submit",className:"btn btn-danger",callback:function(){return $(this).find("form").submit(),!1}}},i={format:"dd/mm/yyyy",weekStart:1,minViewMode:"month",maxViewMode:"years",orientation:"bottom",disableTouchKeyboard:!0,autoclose:!0,defaultViewDate:{year:1980,month:0,day:1},startView:"years",startDate:"01/01/1930",clearBtn:!0};e.exports=function(e){var t=this;return t.showModalUpdateBasicInformation=function(){console.log("xxx",t.data);var e=bootbox.dialog({title:"Update Basic Information",message:swig.render(t.templates.modalUpdateBasicInformation,{locals:t.data}),className:"modal-update-basic-information",buttons:o});e.on("shown.bs.modal",function(n){var o=e.find("form"),l=o.find("[name=date_of_birth]"),r=o.find("#select_languages"),s=o.find("#table_profession_ids"),c=s.find("tbody");l.datepicker(i),r.chosen({width:"100%"});var d=c.children().length;s.on("click","[data-action=addProfession]",function(e){e.preventDefault();var n=swig.render(t.templates.modalUpdateBasicInformation__tableProfessionIds__row,{locals:{index:d++}});c.append(n)}).on("click","[data-action=removeProfession]",function(e){e.preventDefault(),$(e.currentTarget).closest("tr").remove()}),o.validate({rules:{title:{required:!0},name:{required:!0},gender:{required:!0},date_of_birth:{required:!0}},messages:{},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest("div").addClass("has-error")},unhighlight:function(e){$(e).closest("div").removeClass("has-error")},submitHandler:function(n,i){if(i.preventDefault(),!parseInt(o.data("is-submitting"))){var l=$(n).serialize();manaDrApplication.emit("window/loading/show"),o.data("is-submitting",1),e.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.doctor.updateBasicInformation",{doctor:a(t.data,"doctor.id")}),method:"POST",data:l,dataType:"json"}).done(function(e){var t="";t=e&&e.message&&e.message.length?e.message:"Request has been processed successfully",bootbox.alert(t,function(){window.location.reload()})}).fail(function(t,n){var a="";a=t&&t.responseJSON&&t.responseJSON.message&&t.responseJSON.message.length?t.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){o.data("is-submitting",0),e.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide")})}).always(function(){})}}})})},t.showModalUpdatePersonalContact=function(){var e=bootbox.dialog({title:"Update Personal Contact",message:swig.render(t.templates.modalUpdatePersonalContact,{locals:t.data}),className:"modal-update-personal-contact",buttons:o});e.on("shown.bs.modal",function(n){var o=e.find("form"),i=o.find("[name=phone_country_code]"),l=o.find("[name=country_id]");i.chosen(),l.chosen(),o.validate({rules:{phone_country_code:{required:!0},phone_number:{required:!0,number:!0,minlength:6,maxlength:15},email:{validateEmail:!0},website:{url:!0},address:{required:!0}},messages:{email:{validateEmail:"Please enter a valid email address"}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest("div").addClass("has-error")},unhighlight:function(e){$(e).closest("div").removeClass("has-error")},submitHandler:function(n,i){if(i.preventDefault(),!parseInt(o.data("is-submitting"))){var l=$(n).serialize();manaDrApplication.emit("window/loading/show"),o.data("is-submitting",1),e.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.doctor.updatePersonalContact",{doctor:a(t.data,"doctor.id")}),method:"POST",data:l,dataType:"json"}).done(function(e){var t="";t=e&&e.message&&e.message.length?e.message:"Request has been processed successfully",bootbox.alert(t,function(){window.location.reload()})}).fail(function(t,n){var a="";a=t&&t.responseJSON&&t.responseJSON.message&&t.responseJSON.message.length?t.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){o.data("is-submitting",0),e.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide")})}).always(function(){})}}})})},t.showModalUpdateMedicalSchools=function(){var e=bootbox.dialog({title:"Update Medical Schools",message:swig.render(t.templates.modalUpdateMedicalSchools,{locals:t.data}),className:"modal-update-medical-schools"});e.on("hidden.bs.modal",function(e){manaDrApplication.emit("window/loading/show"),window.location.reload()}).on("click","[data-action=addMedicalSchool]",function(n){n.preventDefault();var l=e.find("#table_medical_schools"),r=bootbox.dialog({title:"Add new Medical School",message:swig.render(t.templates.modalCreateMedicalSchool),className:"modal-create-medical-school",buttons:o});r.on("shown.bs.modal",function(e){var n=r.find("form");n.find("[name=date_of_graduation]").datepicker(i),n.validate({rules:{name:{required:!0},date_of_graduation:{required:!0}},messages:{},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest("div").addClass("has-error")},unhighlight:function(e){$(e).closest("div").removeClass("has-error")},submitHandler:function(e,o){if(o.preventDefault(),!parseInt(n.data("is-submitting"))){var i=$(e).serialize();manaDrApplication.emit("window/loading/show"),n.data("is-submitting",1),r.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.doctor.storeMedicalSchool",{doctor:a(t.data,"doctor.id")}),method:"POST",data:i,dataType:"json"}).done(function(e){var n="";n=e&&e.message&&e.message.length?e.message:"Request has been processed successfully",bootbox.alert(n,function(){if(e&&e.data){var n=humps.camelizeKeys(e.data),a=swig.render(t.templates.modalUpdateMedicalSchools__tableMedicalSchools__row,{locals:{medicalSchool:n}});l.find("tbody").append(a)}r.modal("hide"),manaDrApplication.emit("window/loading/hide")})}).fail(function(e,t){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){n.data("is-submitting",0),r.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide")})}).always(function(){})}}})})}).on("click","[data-action=updateMedicalSchool]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr"),l=n.attr("data-id"),r=n.attr("data-name"),s=n.attr("data-date-of-graduation"),c=bootbox.dialog({title:"Update Medical School",message:swig.render(t.templates.modalUpdateMedicalSchool,{locals:{medicalSchool:{name:r,pivot:{dateOfGraduation:s}}}}),className:"modal-update-medical-school",buttons:o});c.on("shown.bs.modal",function(e){var o=c.find("form");o.find("[name=date_of_graduation]").datepicker(i),o.validate({rules:{name:{required:!0},date_of_graduation:{required:!0}},messages:{},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest("div").addClass("has-error")},unhighlight:function(e){$(e).closest("div").removeClass("has-error")},submitHandler:function(e,i){if(i.preventDefault(),!parseInt(o.data("is-submitting"))){var r=$(e).serialize();manaDrApplication.emit("window/loading/show"),o.data("is-submitting",1),c.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.doctor.updateMedicalSchool",{doctor:a(t.data,"doctor.id"),medicalSchool:l}),method:"POST",data:r,dataType:"json"}).done(function(e){var a="";a=e&&e.message&&e.message.length?e.message:"Request has been processed successfully",bootbox.alert(a,function(){if(e&&e.data){var a=humps.camelizeKeys(e.data),o=swig.render(t.templates.modalUpdateMedicalSchools__tableMedicalSchools__row,{locals:{medicalSchool:a}});n.replaceWith(o)}c.modal("hide"),manaDrApplication.emit("window/loading/hide")})}).fail(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){o.data("is-submitting",0),c.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide")})}).always(function(){})}}})})}).on("click","[data-action=removeMedicalSchool]",function(n){n.preventDefault();var o=$(n.currentTarget).closest("tr"),i=o.data("id");i&&bootbox.confirm("Do you really want to remove this entry?",function(n){n&&$.ajax({url:laroute.route("admin.doctor.deleteMedicalSchool",{doctor:a(t.data,"doctor.id"),medicalSchool:i}),method:"DELETE",data:{},dataType:"json"}).done(function(e){var t="";t=e&&e.message&&e.message.length?e.message:"Request has been processed successfully",bootbox.alert(t,function(){o.remove()})}).fail(function(t,n){var a="";a=t&&t.responseJSON&&t.responseJSON.message&&t.responseJSON.message.length?t.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){$form.data("is-submitting",0),e.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide")})}).always(function(){})})})},t.showModalUpdateQualifications=function(){var e=bootbox.dialog({title:"Update Qualifications",message:swig.render(t.templates.modalUpdateQualifications,{locals:t.data}),className:"modal-update-qualifications"});e.on("hidden.bs.modal",function(e){manaDrApplication.emit("window/loading/show"),window.location.reload()}).on("click","[data-action=addQualification]",function(n){n.preventDefault();var i=e.find("#table_qualifications"),l=bootbox.dialog({title:"Add new Qualification",message:swig.render(t.templates.modalCreateQualification),className:"modal-create-qualification",buttons:o});l.on("shown.bs.modal",function(e){var n=l.find("form");n.validate({rules:{name:{required:!0},issuer:{required:!0},issued_time:{required:!0,digits:!0,minlength:4,maxlength:4}},messages:{},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest("div").addClass("has-error")},unhighlight:function(e){$(e).closest("div").removeClass("has-error")},submitHandler:function(e,o){if(o.preventDefault(),!parseInt(n.data("is-submitting"))){var r=$(e).serialize();manaDrApplication.emit("window/loading/show"),n.data("is-submitting",1),l.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.doctor.storeQualification",{doctor:a(t.data,"doctor.id")}),method:"POST",data:r,dataType:"json"}).done(function(e){var n="";n=e&&e.message&&e.message.length?e.message:"Request has been processed successfully",bootbox.alert(n,function(){if(e&&e.data){var n=humps.camelizeKeys(e.data),a=swig.render(t.templates.modalUpdateQualifications__tableQualifications__row,{locals:{qualification:n}});i.find("tbody").append(a)}l.modal("hide"),manaDrApplication.emit("window/loading/hide")})}).fail(function(e,t){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){n.data("is-submitting",0),l.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide")})}).always(function(){})}}})})}).on("click","[data-action=updateQualification]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr"),i=n.attr("data-id"),l=n.attr("data-name"),r=n.attr("data-issuer"),s=n.attr("data-issued-time"),c=bootbox.dialog({title:"Update Qualification",message:swig.render(t.templates.modalUpdateQualification,{locals:{qualification:{name:l,issuer:r,issuedTime:s}}}),className:"modal-update-qualification",buttons:o});c.on("shown.bs.modal",function(e){var o=c.find("form");o.validate({rules:{name:{required:!0},issuer:{required:!0},issued_time:{required:!0,digits:!0,minlength:4,maxlength:4}},messages:{},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest("div").addClass("has-error")},unhighlight:function(e){$(e).closest("div").removeClass("has-error")},submitHandler:function(e,l){if(l.preventDefault(),!parseInt(o.data("is-submitting"))){var r=$(e).serialize();manaDrApplication.emit("window/loading/show"),o.data("is-submitting",1),c.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.doctor.updateQualification",{doctor:a(t.data,"doctor.id"),qualification:i}),method:"POST",data:r,dataType:"json"}).done(function(e){var a="";a=e&&e.message&&e.message.length?e.message:"Request has been processed successfully",bootbox.alert(a,function(){if(e&&e.data){var a=humps.camelizeKeys(e.data),o=swig.render(t.templates.modalUpdateQualifications__tableQualifications__row,{locals:{qualification:a}});n.replaceWith(o)}c.modal("hide"),manaDrApplication.emit("window/loading/hide")})}).fail(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){o.data("is-submitting",0),c.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide")})}).always(function(){})}}})})}).on("click","[data-action=removeQualification]",function(n){n.preventDefault();var o=$(n.currentTarget).closest("tr"),i=o.data("id");i&&bootbox.confirm("Do you really want to remove this entry?",function(n){n&&$.ajax({url:laroute.route("admin.doctor.deleteQualification",{doctor:a(t.data,"doctor.id"),qualification:i}),method:"DELETE",data:{},dataType:"json"}).done(function(e){var t="";t=e&&e.message&&e.message.length?e.message:"Request has been processed successfully",bootbox.alert(t,function(){o.remove()})}).fail(function(t,n){var a="";a=t&&t.responseJSON&&t.responseJSON.message&&t.responseJSON.message.length?t.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){$form.data("is-submitting",0),e.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide")})}).always(function(){})})})},t.showModalChangePassword=function(){var e=bootbox.dialog({title:"Change password",message:swig.render(t.templates.modalChangePassword,{locals:t.data}),buttons:o});e.on("shown.bs.modal",function(){var n=e.find("form");n.validate({rules:{new_password:{required:!0,minlength:6,maxlength:30}},messages:{},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest("div").addClass("has-error")},unhighlight:function(e){$(e).closest("div").removeClass("has-error")},submitHandler:function(o,i){if(i.preventDefault(),!parseInt(n.data("is-submitting"))){var l=$(o).serialize();manaDrApplication.emit("window/loading/show"),n.data("is-submitting",1),e.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.doctor.changePassword",{doctor:a(t.data,"doctor.id")}),method:"POST",data:l,dataType:"json"}).done(function(e){var t="";t=e&&e.message&&e.message.length?e.message:"Request has been processed successfully",bootbox.alert(t,function(){window.location.reload()})}).fail(function(t,a){var o="";o=t&&t.responseJSON&&t.responseJSON.message&&t.responseJSON.message.length?t.responseJSON.message:"The request cannot be processed",bootbox.alert(o,function(){n.data("is-submitting",0),e.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide")})}).always(function(){})}}})})},t.showModalChangeAuthenticationPhoneNumber=function(){var e=bootbox.dialog({title:"Change authentication number",message:swig.render(t.templates.modalChangeAuthenticationPhoneNumber,{locals:t.data}),buttons:o});e.on("shown.bs.modal",function(){var n=e.find("form");n.validate({rules:{new_phone_country_code:{required:!0},new_phone_number:{required:!0,number:!0,minlength:6,maxlength:15}},messages:{},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest("div").addClass("has-error")},unhighlight:function(e){$(e).closest("div").removeClass("has-error")},submitHandler:function(o,i){if(i.preventDefault(),!parseInt(n.data("is-submitting"))){var l=$(o).serialize();manaDrApplication.emit("window/loading/show"),n.data("is-submitting",1),e.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.doctor.updateAuthenticationPhoneNumber",{doctor:a(t.data,"doctor.id")}),method:"POST",data:l,dataType:"json"}).done(function(e){var t="";t=e&&e.message&&e.message.length?e.message:"Request has been processed successfully",bootbox.alert(t,function(){window.location.reload()})}).fail(function(t,a){var o="";o=t&&t.responseJSON&&t.responseJSON.message&&t.responseJSON.message.length?t.responseJSON.message:"The request cannot be processed",bootbox.alert(o,function(){n.data("is-submitting",0),e.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide")})}).always(function(){})}}})})},t.render=function(){},t.bindEvents=function(){t.objects.$boxInfo.on("click","[data-action=showModalUpdateBasicInformation]",function(e){e.preventDefault(),t.showModalUpdateBasicInformation()}).on("click","[data-action=showModalUpdatePersonalContact]",function(e){e.preventDefault(),t.showModalUpdatePersonalContact()}).on("click","[data-action=showModalUpdateMedicalSchools]",function(e){e.preventDefault(),t.showModalUpdateMedicalSchools()}).on("click","[data-action=showModalUpdateQualifications]",function(e){t.showModalUpdateQualifications()}),t.objects.$boxOperations.on("click","[data-action=showModalChangeAuthenticationPhoneNumber]",function(e){e.preventDefault(),t.showModalChangeAuthenticationPhoneNumber()}).on("click","[data-action=showModalChangePassword]",function(e){e.preventDefault(),t.showModalChangePassword()})},t.init=function(e){var n=e.data;t.data=n||{},t.objects={},t.objects.$boxInfo=$("#box_info"),t.objects.$boxOperations=$("#box_operations"),t.templates={},t.templates.modalUpdateBasicInformation=multiline(function(){
/*!@preserve
	            <form class="form" data-is-submitting="0">
	            <div class="form-group">
	            <label class="control-label">Title</label>
	            <select class="form-control" name="title">
	            <option value="">Undefined</option>
	            {% for title in doctorTitles %}
	            <option
	            value="{{title.id}}"
	            {% if (title.id == doctor.doctorTitleId) %}
	            selected="selected"
	            {% endif %}
	            >{{title.title}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Fullname</label>
	            <input class="form-control" name="name" value="{{doctor.name}}"/>
	            </div>
	            <div class="row">
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label">Gender</label>
	            <p>
	            <label class="radio-inline">
	            <input type="radio" name="gender" value="male" {% if (doctor.gender == 'male') %}checked="checked"{% endif %}/>
	            Male
	            </label>
	            <label class="radio-inline">
	            <input type="radio" name="gender" value="female" {% if (doctor.gender == 'female') %}checked="checked"{% endif %}/>
	            Female
	            </label>
	            </p>
	            </div>
	            </div>
	            <div class="col-xs-6">
	            <div class="form-group">
	            <label class="control-label">Date of Birth</label>
	            <input class="form-control" name="date_of_birth" value="{{doctor.dateOfBirth|formatWithoutTimezone('DD/MM/YYYY')}}" readonly="readonly"/>
	            </div>
	            </div>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Languages</label>
	            <select class="form-control hide" name="languages[]" id="select_languages" multiple="multiple">
	            {% for language in languages %}
	            <option
	            value="{{language.id}}"
	            {{language.id|renderSelectedOption(doctor.languages, 'id')}}
	            >{{language.name}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Profession IDs</label>
	            <table class="table" id="table_profession_ids">
	            <thead>
	            <tr>
	            <th>Name</th>
	            <th>License</th>
	            <th class="text-center">
	            <a href="#" class="btn btn-sm btn-primary" data-action="addProfession">
	            <i class="fa fa-fw fa-plus"></i> Add
	            </a>
	            </th>
	            </tr>
	            </thead>
	            <tbody>
	            {% for profession in doctor.professions %}
	            <tr>
	            <td>
	            <input class="form-control input-sm" value="{{profession.name}}" name="professions[{{loop.index0}}][name]">
	            </td>
	            <td>
	            <input class="form-control input-sm" value="{{profession.licenseNo}}" name="professions[{{loop.index0}}][license]">
	            </td>
	            <td class="text-center">
	            <a href="#" class="btn btn-sm btn-danger" data-action="removeProfession">
	            <i class="fa fa-times"></i> Remove
	            </a>
	            </td>
	            </tr>
	            {% endfor %}
	            </tbody>
	            </table>
	            </div>
	            </form>
	            */
console.log}),t.templates.modalUpdateBasicInformation__tableProfessionIds__row=multiline(function(){
/*!@preserve
	            <tr>
	            <td>
	            <input class="form-control input-sm" value="" name="professions[{{index}}][name]">
	            </td>
	            <td>
	            <input class="form-control input-sm" value="" name="professions[{{index}}][license]">
	            </td>
	            <td class="text-center">
	            <a href="#" class="btn btn-sm btn-danger" data-action="removeProfession">
	            <i class="fa fa-times"></i> Remove
	            </a>
	            </td>
	            </tr>
	            */
console.log}),t.templates.modalUpdatePersonalContact=multiline(function(){
/*!@preserve
	            <form class="form" data-is-submitting="0">
	            <div class="form-group">
	            <label>Phone Number<sup class="text-danger">*</sup></label>
	            <div class="row">
	            <div class="col-xs-6">
	            <select class="form-control" name="phone_country_code">
	            <option value="">Undetermined</option>
	            {% for phoneCountryCode in phoneCountryCodes %}
	            <option
	            value="{{phoneCountryCode}}"
	            {% if (doctor.phoneCountryCode == phoneCountryCode) %}
	            selected="selected"
	            {% endif %}
	            >{{phoneCountryCode}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            <div class="col-xs-6">
	            <input class="form-control" name="phone_number" type="text" value="{{doctor.phoneNumber}}"/>
	            </div>
	            </div>
	            </div>
	            <div class="form-group">
	            <div class="row">
	            <div class="col-xs-6">
	            <label class="control-label">Email<sup class="text-danger">*</sup></label>
	            <input class="form-control" name="email" value="{% if (doctor.account) %}{{doctor.account.email}}{% else %}{{doctor.email}}{% endif %}"/>
	            </div>
	            <div class="col-xs-6">
	            <label class="control-label">Website</label>
	            <input class="form-control" name="website" value="{{doctor.website}}"/>
	            </div>
	            </div>
	            </div>
	            <div class="form-group">
	            <div class="row">
	            <div class="col-xs-6">
	            <label class="control-label">Address<sup class="text-danger">*</sup></label>
	            <input class="form-control" name="address" value="{{doctor.address}}"/>
	            </div>
	            <div class="col-xs-6">
	            <label class="control-label">Country</label>
	            <select class="form-control" name="country_id">
	            <option value="">Please select</option>
	            {% for countryId, countryName in countries %}
	            <option
	            value="{{countryId}}"
	            {% if (countryId == doctor.countryId) %}
	            selected="selected"
	            {% endif %}
	            >{{countryName}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            </div>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Office Hours</label>
	            <textarea class="form-control" name="office_hours">{{doctor.officeHours}}</textarea>
	            </div>
	            </form>
	            */
console.log}),t.templates.modalUpdateMedicalSchools=multiline(function(){
/*!@preserve
	            <table class="table table-bordered" id="table_medical_schools">
	            <thead>
	            <tr>
	            <th>Date of Graduation</th>
	            <th>School Name</th>
	            <th class="text-center">
	            <a href="#" class="btn btn-xs btn-primary" data-action="addMedicalSchool">
	            <i class="fa fa-fw fa-plus"></i> Add
	            </a>
	            </th>
	            </tr>
	            </thead>
	            <tbody>
	            {% for medicalSchool in doctor.medicalSchools %}
	            <tr data-id="{{medicalSchool.id}}" data-name="{{medicalSchool.name}}" data-date-of-graduation="{{medicalSchool.pivot.dateOfGraduation|formatTimestamp1}}">
	            <td>
	            {{medicalSchool.pivot.dateOfGraduation|formatTimestamp1}}
	            </td>
	            <td>
	            {{medicalSchool.name}}
	            </td>
	            <td class="text-center">
	            <a href="#" class="btn btn-xs btn-warning" data-action="updateMedicalSchool">
	            <i class="fa fa-pencil"></i> Edit
	            </a>
	            <a href="#" class="btn btn-xs btn-danger" data-action="removeMedicalSchool">
	            <i class="fa fa-times"></i> Remove
	            </a>
	            </td>
	            </tr>
	            {% endfor %}
	            </tbody>
	            </table>
	            */
console.log}),t.templates.modalCreateMedicalSchool=multiline(function(){
/*!@preserve
	            <form class="form">
	            <div class="form-group">
	            <label class="control-label">School Name:</label>
	            <input class="form-control" name="name"/>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Date of Graduation</label>
	            <input class="form-control" name="date_of_graduation" placeholder="Click to pick a date" readonly="readonly"/>
	            </div>
	            </form>
	            */
console.log}),t.templates.modalUpdateMedicalSchool=multiline(function(){
/*!@preserve
	            <form class="form">
	            <div class="form-group">
	            <label class="control-label">School Name:</label>
	            <input class="form-control" name="name" value="{{medicalSchool.name}}"/>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Date of Graduation</label>
	            <input class="form-control" name="date_of_graduation" placeholder="Click to pick a date" readonly="readonly" value="{{medicalSchool.pivot.dateOfGraduation}}"/>
	            </div>
	            </form>
	            */
console.log}),t.templates.modalUpdateMedicalSchools__tableMedicalSchools__row=multiline(function(){
/*!@preserve
	            <tr data-id="{{medicalSchool.id}}" data-name="{{medicalSchool.name}}" data-date-of-graduation="{{medicalSchool.pivot.dateOfGraduation|formatTimestamp1}}">
	            <td>
	            {{medicalSchool.pivot.dateOfGraduation|formatTimestamp1}}
	            </td>
	            <td>
	            {{medicalSchool.name}}
	            </td>
	            <td class="text-center">
	            <a href="#" class="btn btn-xs btn-warning" data-action="updateMedicalSchool">
	            <i class="fa fa-pencil"></i> Edit
	            </a>
	            <a href="#" class="btn btn-xs btn-danger" data-action="removeMedicalSchool">
	            <i class="fa fa-times"></i> Remove
	            </a>
	            </td>
	            </tr>
	            */
console.log}),t.templates.modalUpdateQualifications=multiline(function(){
/*!@preserve
	            <table class="table table-bordered" id="table_qualifications">
	            <thead>
	            <tr>
	            <th>Year</th>
	            <th>Issuer</th>
	            <th>Name</th>
	            <th class="text-center">
	            <a href="#" class="btn btn-xs btn-primary" data-action="addQualification">
	            <i class="fa fa-fw fa-plus"></i> Add
	            </a>
	            </th>
	            </tr>
	            </thead>
	            <tbody>
	            {% for qualification in doctor.qualifications %}
	            <tr data-id="{{qualification.id}}" data-name="{{qualification.name}}" data-issued-time="{{qualification.issuedTime}}" data-issuer="{{qualification.issuer}}">
	            <td>{{qualification.issuedTime|formatWithoutTimezone("YYYY")}}</td>
	            <td>{{qualification.issuer}}</td>
	            <td>{{qualification.name}}</td>
	            <td class="text-center">
	            <a href="#" class="btn btn-xs btn-warning" data-action="updateQualification">
	            <i class="fa fa-pencil"></i> Edit
	            </a>
	            <a href="#" class="btn btn-xs btn-danger" data-action="removeQualification">
	            <i class="fa fa-times"></i> Remove
	            </a>
	            </td>
	            </tr>
	            {% endfor %}
	            </tbody>
	            </table>
	            */
console.log}),t.templates.modalCreateQualification=multiline(function(){
/*!@preserve
	            <form class="form">
	            <div class="form-group">
	            <label class="control-label">Name:</label>
	            <input class="form-control" name="name"/>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Issuer</label>
	            <input class="form-control" name="issuer"/>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Year</label>
	            <input class="form-control" name="issued_time"/>
	            </div>
	            </form>
	            */
console.log}),t.templates.modalUpdateQualification=multiline(function(){
/*!@preserve
	            <form class="form">
	            <div class="form-group">
	            <label class="control-label">Name:</label>
	            <input class="form-control" name="name" value="{{qualification.name}}"/>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Issuer</label>
	            <input class="form-control" name="issuer" value="{{qualification.issuer}}"/>
	            </div>
	            <div class="form-group">
	            <label class="control-label">Year</label>
	            <input class="form-control" name="issued_time" value="{{qualification.issuedTime|formatWithoutTimezone("YYYY")}}"/>
	            </div>
	            </form>
	            */
console.log}),t.templates.modalUpdateQualifications__tableQualifications__row=multiline(function(){
/*!@preserve
	            <tr data-id="{{qualification.id}}" data-name="{{qualification.name}}" data-issued-time="{{qualification.issuedTime}}" data-issuer="{{qualification.issuer}}">
	            <td>{{qualification.issuedTime|formatWithoutTimezone("YYYY")}}</td>
	            <td>{{qualification.issuer}}</td>
	            <td>{{qualification.name}}</td>
	            <td class="text-center">
	            <a href="#" class="btn btn-xs btn-warning" data-action="updateQualification">
	            <i class="fa fa-pencil"></i> Edit
	            </a>
	            <a href="#" class="btn btn-xs btn-danger" data-action="removeQualification">
	            <i class="fa fa-times"></i> Remove
	            </a>
	            </td>
	            </tr>
	            */
console.log}),t.templates.modalChangeAuthenticationPhoneNumber=multiline(function(){
/*!@preserve
	            <form class="form" data-is-submitting="0">
	            <div class="form-group">
	            <label>New authentication phone number for this doctor</label>
	            <div class="row">
	            <div class="col-xs-6">
	            <select class="form-control" name="new_phone_country_code">
	            <option value="">Undetermined</option>
	            {% for phoneCountryCode in phoneCountryCodes %}
	            <option
	            value="{{phoneCountryCode}}"
	            {% if (doctor.account.phoneCountryCode == phoneCountryCode) %}
	            selected="selected"
	            {% endif %}
	            >{{phoneCountryCode}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            <div class="col-xs-6">
	            <input class="form-control" name="new_phone_number" type="text" value="{{doctor.account.phoneNumber}}"/>
	            </div>
	            </div>
	            </div>
	            </form>
	            */
console.log}),t.templates.modalChangePassword=multiline(function(){
/*!@preserve
	            <form class="form" data-is-submitting="0">
	            <div class="form-group">
	            <label>New password for this doctor</label>
	            <input class="form-control" name="new_password" type="text" value=""/>
	            </div>
	            </form>
	            */
console.log}),t.render(),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.showModalCreateWorkCompany=function(e){var n=e.doneCallback,a=e.failCallback,o=bootbox.dialog({title:"Create work company",message:swig.render(t.templates.modalCreateWorkCompany,{locals:{}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});o.on("shown.bs.modal",function(e){var t=o.find("form");t.validate({rules:{name:{required:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(e,i){if(i.preventDefault(),!parseInt(t.data("is-submitting"))){var l=t.serialize();manaDrApplication.emit("window/loading/show"),t.data("is-submitting",1),o.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.workCompany.store"),method:"POST",data:l,dataType:"json"}).done(function(e){var t="Work company <b>"+e.name+"</b> has been created!";bootbox.alert(t,function(){o.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof n&&n(e)})}).fail(function(e,n){var i="";i=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(i,function(){t.data("is-submitting",0),o.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof a&&a()})})}}})})},t.showModalUpdateWorkCompany=function(e){var n=e.id,a=e.name,o=e.doneCallback,i=e.failCallback,l=bootbox.dialog({title:"Update work company",message:swig.render(t.templates.modalUpdateWorkCompany,{locals:{id:n,name:a}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});l.on("shown.bs.modal",function(e){var t=l.find("form");t.validate({rules:{name:{required:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(e,r){if(r.preventDefault(),!parseInt(t.data("is-submitting"))){var s=t.serialize();manaDrApplication.emit("window/loading/show"),t.data("is-submitting",1),l.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.workCompany.update",{workCompany:n}),method:"PATCH",data:s,dataType:"json"}).done(function(e){var t="Work company <b>"+a+"</b> has been updated!";bootbox.alert(t,function(){l.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o(e)})}).fail(function(e,n){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){t.data("is-submitting",0),l.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof i&&i()})})}}})})},t.showModalDeactivateWorkCompany=function(e){var t=e.id,n=e.name,a=e.doneCallback,o=e.failCallback,i=bootbox.confirm("Do you really want to deactivate work company <b>"+n+"</b>",function(e){e&&(manaDrApplication.emit("window/loading/show"),$.ajax({url:laroute.route("admin.workCompany.destroy",{workCompany:t}),method:"DELETE"}).done(function(e){var t="Work company <b>"+n+"</b> has been deactivated!";bootbox.alert(t,function(){i.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof a&&a(e)})}).fail(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o()})}))})},t.showModalActivateWorkCompany=function(e){var t=e.id,n=e.name,a=e.doneCallback,o=e.failCallback,i=bootbox.confirm("Do you really want to activate work company <b>"+n+"</b>",function(e){e&&(manaDrApplication.emit("window/loading/show"),$.ajax({url:laroute.route("admin.workCompany.restore"),method:"POST",data:{id:t},dataType:"json"}).done(function(e){var t="Work company <b>"+n+"</b> has been activated!";bootbox.alert(t,function(){i.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof a&&a(e)})}).fail(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o()})}))})},t.bindEvents=function(){t.objects.$tableWorkCompanies.on("click","[data-action=add]",function(e){e.preventDefault(),t.showModalCreateWorkCompany({doneCallback:function(e){var n=swig.render(t.templates.rowTemplate,{locals:e});t.objects.$tableWorkCompanies_tbody.append(n)}})}).on("click","[data-action=edit]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr[data-id]"),a=n.data("id"),o=n.data("name");if(!a)return!1;t.showModalUpdateWorkCompany({id:a,name:o,doneCallback:function(e){var a=swig.render(t.templates.rowTemplate,{locals:e});n.replaceWith(a)}})}).on("click","[data-action=deactivate]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr[data-id]"),a=n.data("id"),o=n.data("name");if(!a)return!1;t.showModalDeactivateWorkCompany({id:a,name:o,doneCallback:function(e){var a=swig.render(t.templates.rowTemplate,{locals:e});n.replaceWith(a)}})}).on("click","[data-action=activate]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr[data-id]"),a=n.data("id"),o=n.data("name");if(!a)return!1;t.showModalActivateWorkCompany({id:a,name:o,doneCallback:function(e){var a=swig.render(t.templates.rowTemplate,{locals:e});n.replaceWith(a)}})})},t.init=function(e){t.data=e||{},t.objects={},t.objects.$tableWorkCompanies=$("#table_work_companies"),t.objects.$tableWorkCompanies_tbody=t.objects.$tableWorkCompanies.children("tbody"),t.templates={},t.templates.modalCreateWorkCompany=multiline(function(){
/*!@preserve
	            <form class="form" data-is-submitting="0">
	            <div class="form-group">
	            <label for="name">Name</label>
	            <input class="form-control" name="name" type="text"/>
	            </div>
	            </form>
	            */
console.log}),t.templates.modalUpdateWorkCompany=multiline(function(){
/*!@preserve
	            <form class="form" data-is-submitting="0">
	            <div class="form-group">
	            <label for="name">Name</label>
	            <input class="form-control" name="name" type="text" value="{{name}}"/>
	            </div>
	            </form>
	            */
console.log}),t.templates.rowTemplate=multiline(function(){
/*!@preserve
	            <tr data-id="{{id}}" data-name="{{name}}">
	            <td>{{name}}</td>
	            <td>
	            <a href="#" class="btn btn-xs btn-default" data-action="edit">
	            <i class="fa fa-pencil"></i>
	            Edit
	            </a>
	            {% if deleted_at %}
	            <a href="#" class="btn btn-xs btn-default" data-action="activate">
	            <i class="fa fa-check"></i>
	            Activate
	            </a>
	            {% else %}
	            <a href="#" class="btn btn-xs btn-default" data-action="deactivate">
	            <i class="fa fa-times"></i>
	            Deactivate
	            </a>
	            {% endif %}
	            </td>
	            </tr>
	            */
console.log}),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.showModalCreateInsuranceCompany=function(e){var n=e.doneCallback,a=e.failCallback,o=bootbox.dialog({title:"Create insurance company",message:swig.render(t.templates.modalCreateInsuranceCompany,{locals:{}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});o.on("shown.bs.modal",function(e){var t=o.find("form");t.validate({rules:{name:{required:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(e,i){if(i.preventDefault(),!parseInt(t.data("is-submitting"))){var l=t.serialize();manaDrApplication.emit("window/loading/show"),t.data("is-submitting",1),o.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.insuranceCompany.store"),method:"POST",data:l,dataType:"json"}).done(function(e){var t="Insurance company <b>"+e.name+"</b> has been created!";bootbox.alert(t,function(){o.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof n&&n(e)})}).fail(function(e,n){var i="";i=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(i,function(){t.data("is-submitting",0),o.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof a&&a()})})}}})})},t.showModalUpdateInsuranceCompany=function(e){var n=e.id,a=e.name,o=e.doneCallback,i=e.failCallback,l=bootbox.dialog({title:"Update insurance company",message:swig.render(t.templates.modalUpdateInsuranceCompany,{locals:{id:n,name:a}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});l.on("shown.bs.modal",function(e){var t=l.find("form");t.validate({rules:{name:{required:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(e,r){if(r.preventDefault(),!parseInt(t.data("is-submitting"))){var s=t.serialize();manaDrApplication.emit("window/loading/show"),t.data("is-submitting",1),l.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.insuranceCompany.update",{insuranceCompany:n}),method:"PATCH",data:s,dataType:"json"}).done(function(e){var t="Insurance company <b>"+a+"</b> has been updated!";bootbox.alert(t,function(){l.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o(e)})}).fail(function(e,n){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){t.data("is-submitting",0),l.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof i&&i()})})}}})})},t.showModalDeactivateInsuranceCompany=function(e){var t=e.id,n=e.name,a=e.doneCallback,o=e.failCallback,i=bootbox.confirm("Do you really want to deactivate insurance company <b>"+n+"</b>",function(e){e&&(manaDrApplication.emit("window/loading/show"),$.ajax({url:laroute.route("admin.insuranceCompany.destroy",{insuranceCompany:t}),method:"DELETE"}).done(function(e){var t="Insurance company <b>"+n+"</b> has been deactivated!";bootbox.alert(t,function(){i.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof a&&a(e)})}).fail(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o()})}))})},t.showModalActivateInsuranceCompany=function(e){var t=e.id,n=e.name,a=e.doneCallback,o=e.failCallback,i=bootbox.confirm("Do you really want to activate insurance company <b>"+n+"</b>",function(e){e&&(manaDrApplication.emit("window/loading/show"),$.ajax({url:laroute.route("admin.insuranceCompany.restore"),method:"POST",data:{id:t},dataType:"json"}).done(function(e){var t="Insurance company <b>"+n+"</b> has been activated!";bootbox.alert(t,function(){i.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof a&&a(e)})}).fail(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o()})}))})},t.bindEvents=function(){t.objects.$tableInsuranceCompanies.on("click","[data-action=add]",function(e){e.preventDefault(),t.showModalCreateInsuranceCompany({doneCallback:function(e){var n=swig.render(t.templates.rowTemplate,{locals:e});t.objects.$tableInsuranceCompanies_tbody.append(n)}})}).on("click","[data-action=edit]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr[data-id]"),a=n.data("id"),o=n.data("name");if(!a)return!1;t.showModalUpdateInsuranceCompany({id:a,name:o,doneCallback:function(e){var a=swig.render(t.templates.rowTemplate,{locals:e});n.replaceWith(a)}})}).on("click","[data-action=deactivate]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr[data-id]"),a=n.data("id"),o=n.data("name");if(!a)return!1;t.showModalDeactivateInsuranceCompany({id:a,name:o,doneCallback:function(e){var a=swig.render(t.templates.rowTemplate,{locals:e});n.replaceWith(a)}})}).on("click","[data-action=activate]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr[data-id]"),a=n.data("id"),o=n.data("name");if(!a)return!1;t.showModalActivateInsuranceCompany({id:a,name:o,doneCallback:function(e){var a=swig.render(t.templates.rowTemplate,{locals:e});n.replaceWith(a)}})})},t.init=function(e){t.data=e||{},t.objects={},t.objects.$tableInsuranceCompanies=$("#table_insurance_companies"),t.objects.$tableInsuranceCompanies_tbody=t.objects.$tableInsuranceCompanies.children("tbody"),t.templates={},t.templates.modalCreateInsuranceCompany=multiline(function(){
/*!@preserve
	            <form class="form" data-is-submitting="0">
	            <div class="form-group">
	            <label for="name">Name</label>
	            <input class="form-control" name="name" type="text"/>
	            </div>
	            </form>
	            */
console.log}),t.templates.modalUpdateInsuranceCompany=multiline(function(){
/*!@preserve
	            <form class="form" data-is-submitting="0">
	            <div class="form-group">
	            <label for="name">Name</label>
	            <input class="form-control" name="name" type="text" value="{{name}}"/>
	            </div>
	            </form>
	            */
console.log}),t.templates.rowTemplate=multiline(function(){
/*!@preserve
	            <tr data-id="{{id}}" data-name="{{name}}">
	            <td>{{name}}</td>
	            <td>
	            <a href="#" class="btn btn-xs btn-default" data-action="edit">
	            <i class="fa fa-pencil"></i>
	            Edit
	            </a>
	            {% if deleted_at %}
	            <a href="#" class="btn btn-xs btn-default" data-action="activate">
	            <i class="fa fa-check"></i>
	            Activate
	            </a>
	            {% else %}
	            <a href="#" class="btn btn-xs btn-default" data-action="deactivate">
	            <i class="fa fa-times"></i>
	            Deactivate
	            </a>
	            {% endif %}
	            </td>
	            </tr>
	            */
console.log}),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.showModalCreateConsultReason=function(n){var a=n.doneCallback,o=n.failCallback;manaDrApplication.emit("window/loading/show"),e.emit("service/appointmentType/fetchAll",{doneCallback:function(n){var i={appointmentTypes:n},l=bootbox.dialog({title:"Create consult reason",message:swig.render(t.templates.modalCreateConsultReason,{locals:i}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});l.on("shown.bs.modal",function(t){var n=l.find("form");n.find("[name=appointment_type_id]").chosen({search_contains:!0}),n.validate({rules:{name:{required:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(t,i){if(i.preventDefault(),!parseInt(n.data("is-submitting"))){var r=n.serialize();manaDrApplication.emit("window/loading/show"),n.data("is-submitting",1),l.find(":input").prop("disabled",!0),e.emit("service/consultReason/create",{data:r,doneCallback:function(e){var t="Consult reason <b>"+e.reason+"</b> has been created!";bootbox.alert(t,function(){l.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof a&&a(humps.camelizeKeys(e))})},failCallback:function(e,t){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){n.data("is-submitting",0),l.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o(e,t)})}})}}})}),manaDrApplication.emit("window/loading/hide")},failCallback:function(e,t){manaDrApplication.emit("window/loading/hide")}})},t.showModalUpdateConsultReason=function(n){var a=n.id,o=n.doneCallback,i=n.failCallback;manaDrApplication.emit("window/loading/show"),e.emit("service/appointmentType/fetchAll",{doneCallback:function(n){manaDrApplication.emit("window/loading/show"),e.emit("service/consultReason/fetch",{id:a,doneCallback:function(l){var r={appointmentTypes:n,consultReason:l},s=bootbox.dialog({title:"Update consult reason",message:swig.render(t.templates.modalUpdateConsultReason,{locals:r}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});s.on("shown.bs.modal",function(t){var n=s.find("form");n.find("[name=appointment_type_id]").chosen({search_contains:!0}),n.validate({rules:{name:{required:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(t,l){if(l.preventDefault(),!parseInt(n.data("is-submitting"))){var r=n.serialize();manaDrApplication.emit("window/loading/show"),n.data("is-submitting",1),s.find(":input").prop("disabled",!0),e.emit("service/consultReason/update",{id:a,data:r,doneCallback:function(e){var t="Consult reason <b>"+e.reason+"</b> has been updated!";bootbox.alert(t,function(){s.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o(humps.camelizeKeys(e))})},failCallback:function(e,t){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){n.data("is-submitting",0),s.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof i&&i(e,t)})}})}}})}),manaDrApplication.emit("window/loading/hide")},failCallback:function(e,t){manaDrApplication.emit("window/loading/hide")}})},failCallback:function(e,t){manaDrApplication.emit("window/loading/hide")}})},t.showModalDeleteConsultReason=function(t){var n=t.id,a=t.doneCallback,o=t.failCallback,i=bootbox.confirm("Do you really want to remove this consult reason?",function(t){t&&e.emit("service/consultReason/delete",{id:n,doneCallback:function(e){bootbox.alert("Consult reason has been deleted!",function(){i.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof a&&a(humps.camelizeKeys(e))})},failCallback:function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){$form.data("is-submitting",0),i.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o(e,t)})}})})},t.bindEvents=function(){t.objects.$tableConsultReasons.on("click","[data-action=add]",function(e){e.preventDefault(),t.showModalCreateConsultReason({doneCallback:function(e){var n=swig.render(t.templates.rowTemplate,{locals:e});t.objects.$tableConsultReasons_tbody.append(n)}})}).on("click","[data-action=edit]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr[data-id]"),a=n.data("id");a&&t.showModalUpdateConsultReason({id:a,doneCallback:function(e){var a=swig.render(t.templates.rowTemplate,{locals:e});n.replaceWith(a)}})}).on("click","[data-action=delete]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr[data-id]"),a=n.data("id");a&&t.showModalDeleteConsultReason({id:a,doneCallback:function(e){n.remove()}})})},t.init=function(e){t.data=e||{},t.objects={},t.objects.$tableConsultReasons=$("#table_consult_reasons"),t.objects.$tableConsultReasons_tbody=t.objects.$tableConsultReasons.children("tbody"),t.templates={},t.templates.modalCreateConsultReason=multiline(function(){
/*!@preserve
	            <form class="form" data-is-submitting="0">
	            <div class="form-group">
	            <label for="name">Name</label>
	            <input class="form-control" name="reason" type="text"/>
	            </div>
	            <div class="form-group">
	            <label for="name">Appointment Type</label>
	            <select class="form-control" name="appointment_type_id">
	            {% for appointmentType in appointmentTypes %}
	            <option value="{{appointmentType.id}}">{{appointmentType.name}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            </form>
	            */
console.log}),t.templates.modalUpdateConsultReason=multiline(function(){
/*!@preserve
	            <form class="form" data-is-submitting="0">
	            <div class="form-group">
	            <label for="name">Name</label>
	            <input class="form-control" name="reason" type="text" value="{{consultReason.reason}}"/>
	            </div>
	            <div class="form-group">
	            <label for="name">Appointment Type</label>
	            <select class="form-control" name="appointment_type_id">
	            {% for appointmentType in appointmentTypes %}
	            <option value="{{appointmentType.id}}"
	            {% if appointmentType.id == consultReason.appointmentTypeId %}
	            select="selected"
	            {% endif %}
	            >{{appointmentType.name}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            </form>
	            */
console.log}),t.templates.rowTemplate=multiline(function(){
/*!@preserve
	            <tr data-id="{{id}}" data-reason="{{reason}}" data-appointment-type-id="{{appointmentType.id}}">
	            <td>{{reason}}</td>
	            <td>{{appointmentType.name}}</td>
	            <td>
	            <a href="#" class="btn btn-xs btn-warning" data-action="edit">
	            <i class="fa fa-pencil"></i>
	            Edit
	            </a>
	            <a href="#" class="btn btn-xs btn-default" data-action="delete">
	            <i class="fa fa-times"></i>
	            Delete
	            </a>
	            </td>
	            </tr>
	            */
console.log}),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=n(15)(globalData,"context.pageAdminClinicDetails.clinic.id");e.exports=function(e){var t=this;return t.showModalCreateAppointmentType=function(e){var n=e.clinicId,a=e.doneCallback,o=e.failCallback,i=bootbox.dialog({title:"Create Appointment Type",message:swig.render(t.templates.modalAppointmentType,{locals:{clinicId:n}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});i.on("shown.bs.modal",function(e){var t=i.find("form");t.validate({rules:{name:{required:!0},clinic_id:{required:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(e,n){if(n.preventDefault(),!parseInt(t.data("is-submitting"))){var l=t.serialize();manaDrApplication.emit("window/loading/show"),t.data("is-submitting",1),i.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.appointmentType.store"),method:"POST",data:l,dataType:"json"}).done(function(e){var t="Appointment type <b>"+e.name+"</b> has been created for you clinic only!";bootbox.alert(t,function(){i.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof a&&a(humps.camelizeKeys(e))})}).fail(function(e,n){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){t.data("is-submitting",0),i.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o(e,n)})})}}})})},t.showModalUpdateAppointmentType=function(e){var n=e.clinicId,a=e.id,o=e.name,i=e.doneCallback,l=e.failCallback,r=bootbox.dialog({title:"Update Appointment Type",message:swig.render(t.templates.modalAppointmentType,{locals:{id:a,name:o,clinicId:n}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});r.on("shown.bs.modal",function(e){var t=r.find("form");t.validate({rules:{name:{required:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(e,n){if(n.preventDefault(),!parseInt(t.data("is-submitting"))){var o=t.serialize();manaDrApplication.emit("window/loading/show"),t.data("is-submitting",1),r.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.appointmentType.update",{appointmentType:a}),method:"PUT",data:o,dataType:"json"}).done(function(e){var t="Appointment type <b>"+e.name+"</b> has been updated!";bootbox.alert(t,function(){r.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof i&&i(humps.camelizeKeys(e))})}).fail(function(e,n){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){t.data("is-submitting",0),r.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof l&&l(e,n)})})}}})})},t.showModalDeactivateAppointmentType=function(e){var t=e.id,n=(e.name,e.doneCallback),a=e.failCallback;bootbox.confirm("Are you sure you want to deactivate this appointment type?<br/><i>The existed available timeslots will be booked from Dashboard only.</i>",function(e){e&&(manaDrApplication.emit("window/loading/show"),$.ajax({url:laroute.route("admin.appointmentType.deactivate",{appointmentType:t}),method:"POST"}).done(function(e){var t="Appointment type <b>"+e.name+"</b> has been deactivated!";bootbox.alert(t,function(){manaDrApplication.emit("window/loading/hide"),"function"==typeof n&&n(humps.camelizeKeys(e))})}).fail(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){manaDrApplication.emit("window/loading/hide"),"function"==typeof a&&a(e,t)})}))})},t.showModalActivateAppointmentType=function(e){var t=e.id,n=e.doneCallback,a=e.failCallback;bootbox.confirm("Are you sure you want to activate this appointment type?<br/><i>The existed available timeslots will be booked through apps also.</i>",function(e){e&&(manaDrApplication.emit("window/loading/show"),$.ajax({url:laroute.route("admin.appointmentType.activate",{appointmentType:t}),method:"POST"}).done(function(e){var t="Appointment type <b>"+e.name+"</b> has been activated!";bootbox.alert(t,function(){manaDrApplication.emit("window/loading/hide"),"function"==typeof n&&n(humps.camelizeKeys(e))})}).fail(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){manaDrApplication.emit("window/loading/hide"),"function"==typeof a&&a(e,t)})}))})},t.showModalManageHouseCallReasons=function(t){var n=t.data,a=n===undefined?{}:n,o=t.doneCallback,i=t.failCallback;e.emit("service/houseCallReason/list",{data:a,doneCallback:o,failCallback:i})},t.showModalSetWorkingWeekDays=function(n){var o=n.data.workingWeekDays,i=n.doneCallback,l=n.failCallback,r=bootbox.dialog({title:"Set working week days",message:swig.render(t.templates.modalEditWorkingWeekDaysContent,{locals:{workingWeekDays:o,weekDays:t.data.weekDays}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});r.on("shown.bs.modal",function(t){var n=r.find("form");n.validate({rules:{},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(t,o){if(o.preventDefault(),!parseInt(n.data("is-submitting"))){var s=n.serialize();manaDrApplication.emit("window/loading/show"),n.data("is-submitting",1),r.find(":input").prop("disabled",!0),e.emit("service/admin/clinic/setWorkingWeekDays",{clinicId:a,data:s,doneCallback:function(e){bootbox.alert("Working week days of this clinic have been updated!",function(){r.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof i&&i(humps.camelizeKeys(e))})},failCallback:function(e){function t(t,n){return e.apply(this,arguments)}return t.toString=function(){return e.toString()},t}(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){manaDrApplication.emit("window/loading/hide"),"function"==typeof l&&l(e,t)})})})}}})})},t.showModalRemoveHoliday=function(t){var n=t.holiday,o=n.id,i=n.date,l=t.doneCallback,r=t.failCallback;bootbox.confirm("Are you sure you want to remove <b>"+i+"</b> from holidays list?",function(t){t&&(manaDrApplication.emit("window/loading/show"),e.emit("service/admin/clinic/holiday/delete",{clinicId:a,id:o,doneCallback:function(e){bootbox.alert("This holiday has been deleted!",function(){manaDrApplication.emit("window/loading/hide"),"function"==typeof l&&l(humps.camelizeKeys(e))})},failCallback:function(e){function t(t,n){return e.apply(this,arguments)}return t.toString=function(){return e.toString()},t}(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){manaDrApplication.emit("window/loading/hide"),"function"==typeof r&&r(e,t)})})}))})},t.enableQueueFeature=function(t){t.id;var n=t.doneCallback,o=t.failCallback;e.emit("service/admin/clinic/queue/enable",{clinicId:a,doneCallback:function(e){"function"==typeof n&&n(humps.camelizeKeys(e))},failCallback:function(e){function t(t,n){return e.apply(this,arguments)}return t.toString=function(){return e.toString()},t}(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){"function"==typeof o&&o(e,t)})})})},t.disableQueueFeature=function(t){t.id;var n=t.doneCallback,o=t.failCallback;e.emit("service/admin/clinic/queue/disable",{clinicId:a,doneCallback:function(e){"function"==typeof n&&n(humps.camelizeKeys(e))},failCallback:function(e){function t(t,n){return e.apply(this,arguments)}return t.toString=function(){return e.toString()},t}(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){"function"==typeof o&&o(e,t)})})})},t.bindEvents=function(){t.objects.$tabAppointmentTypeSettings.on("click","[data-action=createAppointmentType]",function(e){e.preventDefault(),t.showModalCreateAppointmentType({clinicId:a,doneCallback:function(e){var n=swig.render(t.templates.appointmentTypeRowTemplate,{locals:e});t.objects.$tableClinicAppointmentTypes_tbody.append(n)}})}).on("click","[data-action=updateAppointmentType]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr[data-id]"),o=n.data("id"),i=n.data("name");t.showModalUpdateAppointmentType({clinicId:a,id:o,name:i,doneCallback:function(e){var a=swig.render(t.templates.appointmentTypeRowTemplate,{locals:e});n.replaceWith(a)}})}).on("click","[data-action=deactivateAppointmentType]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr[data-id]"),a=n.data("id"),o=n.data("name");t.showModalDeactivateAppointmentType({id:a,name:o,doneCallback:function(e){var a=swig.render(t.templates.appointmentTypeRowTemplate,{locals:e});n.replaceWith(a)}})}).on("click","[data-action=activateAppointmentType]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr[data-id]"),a=n.data("id"),o=n.data("name");t.showModalActivateAppointmentType({id:a,name:o,doneCallback:function(e){var a=swig.render(t.templates.appointmentTypeRowTemplate,{locals:e});n.replaceWith(a)}})}).on("click","[data-action=manageHouseCallReasons]",function(t){t.preventDefault();var n=$(t.currentTarget).closest("tr[data-id]"),o=n.data("id"),i=n.data("name");e.emit("modal/manageHouseCallReasons/show",{appointmentTypeId:o,appointmentTypeName:i,clinicId:a,doneCallback:function(){},failCallback:function(){}})}),t.objects.$tabWorkingDaysSettings.on("click","[data-action=editWorkingWeekDays]",function(e){e.preventDefault();var n=$(e.currentTarget),o=n.data("working-week-days");t.showModalSetWorkingWeekDays({clinicId:a,data:{workingWeekDays:o},doneCallback:function(e){var a=e.workingWeekDays,o=swig.render(t.templates.listWorkingWeekDays,{locals:{workingWeekDays:a,weekDays:t.data.weekDays}});console.log("workingWeekDays",a),console.log("_this.data.weekDays",t.data.weekDays),console.log("html",o),n.data("working-week-days",a),t.objects.$tabWorkingDaysSettings_listWorkingWeekDays.replaceWith(o)},failCallback:function(e,t){}})}).on("click","[data-action=removeHoliday]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("li[data-id]"),a=n.data("id"),o=n.data("date");t.showModalRemoveHoliday({holiday:{id:a,date:o},doneCallback:function(e){n.remove()},failCallback:function(e,t){}})}),t.objects.$tabWorkingDaysSettings_formAddHoliday.validate({rules:{date:{required:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest(".form-group").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(n,o){o.preventDefault();var i=t.objects.$tabWorkingDaysSettings_formAddHoliday;parseInt(i.data("is-submitting"))||(manaDrApplication.emit("window/loading/show"),i.data("is-submitting",1),i.find(":input").prop("disabled",!0),e.emit("service/admin/clinic/holiday/create",{clinicId:a,data:{clinicId:a,date:moment(t.objects.$tabWorkingDaysSettings_formAddHoliday_inputDate.val(),"DD/MM/YYYY").format("YYYY-MM-DD")},doneCallback:function(e){var n=e.date,a=swig.render(t.templates.messageHolidateCreatedSuccessfully,{locals:{date:n}}),o=swig.render(t.templates.holidaysListItem,{locals:e});t.objects.$tabWorkingDaysSettings_listHolidays.append(o),bootbox.alert(a,function(){i.data("is-submitting",0),i.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide")})},failCallback:function(e){function t(t,n){return e.apply(this,arguments)}return t.toString=function(){return e.toString()},t}(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){i.data("is-submitting",0),i.find(":input").prop("disabled",!1),manaDrApplication.emit("window/loading/hide"),"function"==typeof failCallback&&failCallback(e,t)})})}))}}),t.objects.$checkboxToggleQueueFeature.on("click",function(e){var n=$(e.currentTarget),o=$(e.currentTarget).prop("checked");n.prop("disabled",!0),o?t.enableQueueFeature({clinicId:a,doneCallback:function(e){bootbox.alert("Queue feature has been enabled!",function(){n.prop("disabled",!1)})},failCallback:function(){n.prop("disabled",!1)}}):t.disableQueueFeature({clinicId:a,doneCallback:function(e){bootbox.alert("Queue feature has been disabled!",function(){n.prop("disabled",!1)})},failCallback:function(){n.prop("disabled",!1)}})})},t.render=function(){t.objects.$tabWorkingDaysSettings_formAddHoliday_inputDate.datepicker({format:"dd/mm/yyyy",weekStart:1,maxViewMode:"years",orientation:"bottom",disableTouchKeyboard:!0,autoclose:!0,clearBtn:!0,todayHighlight:!0,showWeekDays:!0})},t.init=function(a){var o=a.data;t.data=o||{},t.data.weekDays=[{id:1,label:"Sunday"},{id:2,label:"Monday"},{id:3,label:"Tuesday"},{id:4,label:"Wednesday"},{id:5,label:"Thursday"},{id:6,label:"Friday"},{id:7,label:"Saturday"}],t.objects={},t.objects.$tabAppointmentTypeSettings=$("#tab_appointment_types_settings"),t.objects.$tabWorkingDaysSettings=$("#tab_working_days_settings"),t.objects.$tabWorkingDaysSettings_formAddHoliday=t.objects.$tabWorkingDaysSettings.find("#form_add_holiday"),t.objects.$tabWorkingDaysSettings_listHolidays=t.objects.$tabWorkingDaysSettings.find("#list_holidays"),t.objects.$tabWorkingDaysSettings_formAddHoliday_inputDate=t.objects.$tabWorkingDaysSettings_formAddHoliday.find("input[name=date]"),t.objects.$tabWorkingDaysSettings_listWorkingWeekDays=t.objects.$tabWorkingDaysSettings.find("#list_working_week_days"),t.objects.$tabOtherSettings=$("#tab_other_settings"),t.objects.$tableClinicAppointmentTypes=$("#table_clinic_appointment_types"),t.objects.$tableClinicAppointmentTypes_tbody=t.objects.$tableClinicAppointmentTypes.children("tbody"),t.objects.$checkboxToggleQueueFeature=t.objects.$tabOtherSettings.find('[data-action="toggleQueueFeature"]'),t.templates={modalAppointmentType:multiline(function(){
/*!@preserve
	                <form class="form">
	                <input type="hidden" name="clinic_id" value="{{clinicId}}"/>
	                <div class="form-group">
	                <label class="control-label">Name</label>
	                <input class="form-control" name="name" value="{{name}}" />
	                </div>
	                </form>
	                */
console.log}),appointmentTypeRowTemplate:multiline(function(){
/*!@preserve
	                <tr data-id="{{id}}" data-name="{{name}}" class="{% if !isActive %}text-muted{% endif %}">
	                <td>{{name}}</td>
	                <td class="text-right">
	                <a href="#" class="btn-box-tool" data-action="updateAppointmentType" data-toggle="tooltip" data-title="Edit">
	                <i class="fa fa-edit"></i>
	                </a>
	                {% if isActive %}
	                <a href="#" class="btn-box-tool" data-action="deactivateAppointmentType" data-toggle="tooltip" data-title="Deactivate">
	                <i class="fa fa-times"></i>
	                </a>
	                {% else %}
	                <a href="#" class="btn-box-tool" data-action="activateAppointmentType" data-toggle="tooltip" data-title="Activate">
	                <i class="fa fa-check"></i>
	                </a>
	                {% endif %}
	                </td>
	                </tr>
	                */
console.log}),modalManageHouseCallReasons:multiline(function(){
/*!@preserve
	                <table class="table table-hover table-striped">
	                <thead>
	                <tr>
	                <th>Reason</th>
	                <th></th>
	                <th>Actions</th>
	                </tr>
	                </thead>
	                <tbody>
	                {% for reason in reasons %}
	                <tr>
	                <td>{{reason.name}}</td>
	                <td class="text-right">
	                <a class="btn btn-xs btn-default" data-id="{{ reason.id }}" data-action="manageDoctors">
	                <i class="fa fa-user-md" />
	                {% if reason.doctors.length == 1 %}
	                1 doctor
	                {% elseif (reason.doctors.length > 1) %}
	                {{ reason.doctors.length }} doctors
	                {% else %}
	                Manage doctors
	                {% endif %}
	                </a>
	                </td>
	                <td>
	                <a class="btn btn-xs btn-warning">
	                <i class="fa fa-pencil" /> Edit
	                </a>
	                <a class="btn btn-xs btn-danger">
	                <i class="fa fa-trash" /> Delete
	                </a>
	                </td>
	                </tr>
	                {% endfor %}
	                </tbody>
	                </table>
	                */
console.log}),holidaysListItem:multiline(function(){
/*!@preserve
	                <li data-id="{{id}}" data-date="{{date|formatTimestamp3}}">
	                <h4>
	                <span class="label label-default">
	                {{date|formatTimestamp3}}
	                <a href="#" data-action="removeHoliday">
	                <i class="fa fa-times text-muted"></i>
	                </a>
	                </span>
	                </h4>
	                </li>
	                */
console.log}),messageHolidateCreatedSuccessfully:multiline(function(){
/*!@preserve
	                Holiday <b>{{date|formatTimestamp3}}</b> has been created for you clinic
	                */
console.log}),modalEditWorkingWeekDaysContent:multiline(function(){
/*!@preserve
	                <form class="form" id="form_set_working_week_days">
	                <div class="form-group">
	                {% for weekDay in weekDays %}
	                <label class="checkbox-inline">
	                <input type="checkbox" name="working_week_days[]" value="{{weekDay.id}}"
	                {% if weekDay.id|checkIfIndexOf(workingWeekDays) == 1 %}
	                checked
	                {% endif %}
	                > {{weekDay.label}}
	                </label>
	                {% endfor %}
	                </div>
	                </form>
	                */
console.log}),listWorkingWeekDays:multiline(function(){
/*!@preserve
	                <ul class="list-inline" id="list_working_week_days">
	                {% for weekDay in weekDays %}
	                <li>
	                <i style="vertical-align:middle;" class="fa
	                {% if weekDay.id|checkIfIndexOf(workingWeekDays) == 1 %}
	                fa-check-square-o
	                {% else %}
	                fa-square-o
	                {% endif %}
	                "/>
	                {{ weekDay.label }}
	                </li>
	                {% endfor %}
	                </ul>
	                */
console.log})},t.render(),t.bindEvents(),$("#form_booking_fee_settings").length&&e.sub.register("formBookingFeeSettings",n(161)),e.sub.start()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=n(15)(globalData,"context.pageAdminClinicDetails.clinic.id");e.exports=function(e){var t=this;return t.render=function(){t.objects.$self.find(".select2").select2({minimumResultsForSearch:Infinity})},t.bindEvents=function(){t.objects.$self.validate({errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(e,n){if(n.preventDefault(),!parseInt(t.objects.$self.data("is-submitting"))){var o=t.objects.$self.serialize();manaDrApplication.emit("window/loading/show"),t.objects.$self.data("is-submitting",1),$.ajax({url:laroute.route("admin.clinic.updateBookingFeeSettings",{clinic:a}),method:"POST",data:o,dataType:"json"}).done(function(e){bootbox.alert("Doctors' booking fee settings have been saved!",function(){t.objects.$self.data("is-submitting",0),window.location.reload()})}).fail(function(e,n){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){t.objects.$self.data("is-submitting",0),window.location.reload()})})}}}),t.objects.$self.find('input[name$="[amount]"]').each(function(e){$(e.currentTarget).rules("add",{number:!0})}),t.objects.$self.on("change",":checkbox",function(e){e.preventDefault();var t=$(e.currentTarget),n=t.closest(".cell").find(":input:not(:checkbox)"),a=t.prop("checked");n.prop("disabled",!a)}).on("click","[data-action=manageSurchargeSettings]",function(n){n.preventDefault();var a=$(n.currentTarget),o=a.closest(".cell").data("id");if(!o)return bootbox.alert("You need to set the appointment fee & click <b>Submit</b> first.");e.emit("modal/manageSurchageSettings/show",{doctorBookingFeeId:o,doneCallback:function(n){e.emit("service/doctorBookingFee/surchargeSetting/list",{doctorBookingFeeId:o,doneCallback:function(n){e.emit("window/loading/hide");var o=n.surchargeSettings,i=swig.render(t.templates.labelManageSurchargeSettings,{locals:{surchargeSettings:o}});a.replaceWith(i)},failCallback:function(t,n){e.emit("window/loading/hide")}})}})})},t.init=function(e){t.data=e||{},t.objects={},t.objects.$self=$("#form_booking_fee_settings"),t.objects.$cells=t.objects.$self.find(".cell"),t.templates={},t.templates.labelManageSurchargeSettings=multiline(function(){
/*!@preserve
	            <a href="#" data-action="manageSurchargeSettings">
	            <i class="fa fa-flash"></i> Surcharge settings
	            {% if surchargeSettings.length %}
	            ({{surchargeSettings.length}})
	            {% endif %}
	            </a>
	            */
console.log}),t.render(),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=n(15);e.exports=function(e){var t=this;return t.render=function(){t.objects.$textAreaFullContent.wysihtml5()},t.bindEvents=function(){t.objects.$groupAuthorIcon.dropzone({acceptedFiles:".jpg, .jpeg, .png",paramName:"file",previewsContainer:!1,clickable:"#form_edit_article__group_author_icon__button",previewTemplate:"<img data-dz-thumbnail/>",url:laroute.route("admin.file.store"),autoProcessQueue:!0,params:{_token:$('meta[name="csrf-token"]').attr("content")},processing:function(){t.objects.$groupAuthorIcon_loadingOverlay.removeClass("hide")},success:function(e,n){var o=a(n,"file.preview_url");t.objects.$authorIcon.attr("src",o),t.objects.$inputAuthorIcon.val(o),t.objects.$groupAuthorIcon_loadingOverlay.addClass("hide")}}),t.objects.$groupBanner.dropzone({acceptedFiles:".jpg, .jpeg, .png",paramName:"file",previewsContainer:!1,clickable:"#form_edit_article__group_banner__button",previewTemplate:"<img data-dz-thumbnail/>",url:laroute.route("admin.file.store"),autoProcessQueue:!0,params:{_token:$('meta[name="csrf-token"]').attr("content")},processing:function(){t.objects.$groupBanner_loadingOverlay.removeClass("hide")},success:function(e,n){var o=a(n,"file.preview_url");t.objects.$banner.attr("src",o),t.objects.$inputBanner.val(o),t.objects.$groupBanner_loadingOverlay.addClass("hide")}}),t.objects.$groupMediaThumbnail.dropzone({acceptedFiles:".jpg, .jpeg, .png",paramName:"file",previewsContainer:!1,clickable:"#form_edit_article__group_media_thumbnail__button",previewTemplate:"<img data-dz-thumbnail/>",url:laroute.route("admin.file.store"),autoProcessQueue:!0,params:{_token:$('meta[name="csrf-token"]').attr("content")},processing:function(){t.objects.$groupMediaThumbnail_loadingOverlay.removeClass("hide")},success:function(e,n){var o=a(n,"file.preview_url");t.objects.$mediaThumbnail.attr("src",o),t.objects.$inputMediaThumbnail.val(o),t.objects.$groupMediaThumbnail_loadingOverlay.addClass("hide")}}),t.objects.$selectMediaType.on("change",function(e){$(e.currentTarget);var n=t.objects.$form.find('[name="media[type]"]:checked').val();switch(console.log("selectedMediaType",n),n){case"youtube":t.objects.$groupMediaThumbnail.addClass("hide"),t.objects.$groupMediaVideo.removeClass("hide");break;case"image":t.objects.$groupMediaThumbnail.removeClass("hide"),t.objects.$groupMediaVideo.addClass("hide")}}).trigger("change"),t.objects.$form.on("reset",function(e){t.objects.$authorIcon.attr("src",t.data.initialAuthorIconUrl),t.objects.$banner.attr("src",t.data.initialBannerUrl)}),t.objects.$form.validate({title:{required:!0},short_content:{required:!0},full_content:{required:!0},author_name:{required:!0},author_icon_url:{required:!0},banner_url:{required:!0},ignore:":hidden:not(select)",errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(t,n){n.preventDefault();var a=$(t),o=a.data("id");if(!parseInt(a.data("is-submitting"))){var i=a.serialize();e.emit("window/loading/show"),a.data("is-submitting",1),a.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.broadcast.update",{id:o}),method:"PUT",data:i,dataType:"json"}).done(function(e){bootbox.alert("Article has been updated successfully.",function(){var e=laroute.route("admin.broadcast.show",{id:o});window.location.href=e})}).fail(function(t,n){var o="";o=t&&t.responseJSON&&t.responseJSON.message&&t.responseJSON.message.length?t.responseJSON.message:"The request cannot be processed",bootbox.alert(o,function(){a.find(":input").prop("disabled",!1),a.data("is-submitting",0),e.emit("window/loading/hide")})})}}})},t.init=function(e){var n=e.data;t.data=n||{},t.objects={},t.objects.$form=$("#form_edit_article"),t.objects.$textAreaFullContent=$("[name=full_content]"),t.objects.$groupBanner=$("#form_edit_article__group_banner"),t.objects.$groupBanner_loadingOverlay=t.objects.$groupBanner.find(".overlay"),t.objects.$banner=$("#form_edit_article__group_banner__preview img"),t.objects.$inputBanner=$("[name=banner_url]"),t.objects.$groupAuthorIcon=$("#form_edit_article__group_author_icon"),t.objects.$groupAuthorIcon_loadingOverlay=t.objects.$groupAuthorIcon.find(".overlay"),t.objects.$authorIcon=$("#form_edit_article__group_author_icon__preview img"),t.objects.$inputAuthorIcon=$("[name=author_icon_url]"),t.objects.$selectMediaType=$('[name="media[type]"]'),t.objects.$groupMediaVideo=$("#form_edit_article__group_media_video"),t.objects.$groupMediaThumbnail=$("#form_edit_article__group_media_thumbnail"),t.objects.$groupMediaThumbnail_loadingOverlay=t.objects.$groupMediaThumbnail.find(".overlay"),t.objects.$mediaThumbnail=$("#form_edit_article__group_media_thumbnail__preview img"),t.objects.$inputMediaThumbnail=$('[name="media[thumb_url]"]'),t.data.initialAuthorIconUrl=t.objects.$inputAuthorIcon.val(),t.data.initialBannerUrl=t.objects.$inputBanner.val(),t.render(),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=n(15);e.exports=function(e){var t=this;return t.render=function(){t.objects.$textAreaFullContent.wysihtml5(),t.objects.$selectCountry.chosen()},t.bindEvents=function(){t.objects.$groupAuthorIcon.dropzone({acceptedFiles:".jpg, .jpeg, .png",paramName:"file",previewsContainer:!1,clickable:"#form_create_article__group_author_icon__button",previewTemplate:"<img data-dz-thumbnail/>",url:laroute.route("admin.file.store"),autoProcessQueue:!0,params:{_token:$('meta[name="csrf-token"]').attr("content")},processing:function(){t.objects.$groupAuthorIcon_loadingOverlay.removeClass("hide")},success:function(e,n){var o=a(n,"file.preview_url");t.objects.$authorIcon.attr("src",o),t.objects.$inputAuthorIcon.val(o),t.objects.$groupAuthorIcon_loadingOverlay.addClass("hide")}}),t.objects.$groupBanner.dropzone({acceptedFiles:".jpg, .jpeg, .png",paramName:"file",previewsContainer:!1,clickable:"#form_create_article__group_banner__button",previewTemplate:"<img data-dz-thumbnail/>",url:laroute.route("admin.file.store"),autoProcessQueue:!0,params:{_token:$('meta[name="csrf-token"]').attr("content")},processing:function(){t.objects.$groupBanner_loadingOverlay.removeClass("hide")},success:function(e,n){var o=a(n,"file.preview_url");t.objects.$banner.attr("src",o),t.objects.$inputBanner.val(o),t.objects.$groupBanner_loadingOverlay.addClass("hide")}}),t.objects.$groupMediaThumbnail.dropzone({acceptedFiles:".jpg, .jpeg, .png",paramName:"file",previewsContainer:!1,clickable:"#form_create_article__group_media_thumbnail__button",previewTemplate:"<img data-dz-thumbnail/>",url:laroute.route("admin.file.store"),autoProcessQueue:!0,params:{_token:$('meta[name="csrf-token"]').attr("content")},processing:function(){t.objects.$groupMediaThumbnail_loadingOverlay.removeClass("hide")},success:function(e,n){var o=a(n,"file.preview_url");t.objects.$mediaThumbnail.attr("src",o),t.objects.$inputMediaThumbnail.val(o),t.objects.$groupMediaThumbnail_loadingOverlay.addClass("hide")}}),t.objects.$selectMediaType.on("change",function(e){$(e.currentTarget);var n=t.objects.$form.find('[name="media[type]"]:checked').val();switch(console.log("selectedMediaType",n),n){case"youtube":t.objects.$groupMediaThumbnail.addClass("hide"),t.objects.$groupMediaVideo.removeClass("hide");break;case"image":t.objects.$groupMediaThumbnail.removeClass("hide"),t.objects.$groupMediaVideo.addClass("hide")}}).trigger("change"),t.objects.$form.on("reset",function(e){t.objects.$authorIcon.attr("src",t.data.initialAuthorIconUrl),t.objects.$banner.attr("src",t.data.initialBannerUrl)}),t.objects.$form.validate({rules:{title:{required:!0},short_content:{required:!0},full_content:{required:!0},author_name:{required:!0},author_icon_url:{required:!0},banner_url:{required:!0},circle:{required:!0},country_id:{required:!0},"media[type]":{required:!0}},ignore:":hidden:not(select,input)",errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(t,n){n.preventDefault();var o=$(t);o.data("id");if(!parseInt(o.data("is-submitting"))){var i=o.serialize();e.emit("window/loading/show"),o.data("is-submitting",1),o.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.broadcast.store"),method:"POST",data:i,dataType:"json"}).done(function(e){var t=a(e,"id");bootbox.alert("Article has been created successfully.",function(){window.location.href=laroute.route("admin.broadcast.show",{id:t})})}).fail(function(t,n){var a="";a=t&&t.responseJSON&&t.responseJSON.message&&t.responseJSON.message.length?t.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){o.find(":input").prop("disabled",!1),o.data("is-submitting",0),e.emit("window/loading/hide")})})}}})},t.init=function(e){var n=e.data;t.data=n||{},t.objects={},t.objects.$form=$("#form_create_article"),t.objects.$textAreaFullContent=$("[name=full_content]"),t.objects.$groupBanner=$("#form_create_article__group_banner"),t.objects.$groupBanner_loadingOverlay=t.objects.$groupBanner.find(".overlay"),t.objects.$banner=$("#form_create_article__group_banner__preview img"),t.objects.$inputBanner=$("[name=banner_url]"),t.objects.$selectCountry=$("#form_create_article__group_country"),t.objects.$groupAuthorIcon=$("#form_create_article__group_author_icon"),t.objects.$groupAuthorIcon_loadingOverlay=t.objects.$groupAuthorIcon.find(".overlay"),t.objects.$authorIcon=$("#form_create_article__group_author_icon__preview img"),t.objects.$inputAuthorIcon=$("[name=author_icon_url]"),t.objects.$selectMediaType=$('[name="media[type]"]'),t.objects.$groupMediaVideo=$("#form_create_article__group_media_video"),t.objects.$groupMediaThumbnail=$("#form_create_article__group_media_thumbnail"),t.objects.$groupMediaThumbnail_loadingOverlay=t.objects.$groupMediaThumbnail.find(".overlay"),t.objects.$mediaThumbnail=$("#form_create_article__group_media_thumbnail__preview img"),t.objects.$inputMediaThumbnail=$('[name="media[thumb_url]"]'),t.data.initialAuthorIconUrl=t.objects.$inputAuthorIcon.val(),t.data.initialBannerUrl=t.objects.$inputBanner.val(),t.render(),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.render=function(){},t.bindEvents=function(){t.objects.$table.on("click","[data-action=delete]",function(e){e.preventDefault();var t=$(e.currentTarget).closest("tr").data("id");bootbox.confirm("Do you really want to delete this article?",function(e){e&&(manaDrApplication.emit("window/loading/show"),$.ajax({url:laroute.route("admin.broadcast.delete",{id:t}),method:"DELETE"}).done(function(e){bootbox.alert("Article has been deleted successfully.",function(){window.location.reload()})}).fail(function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){manaDrApplication.emit("window/loading/hide")})}))})})},t.init=function(e){var n=e.data;t.data=n||{},t.objects={},t.objects.$table=$("#table_broadcast_articles"),t.render(),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.showModalApprove=function(t){var n=t.id,a=t.doneCallback,o=t.failCallback,i=bootbox.confirm("Are you sure to approve this event?",function(t){t&&(manaDrApplication.emit("window/loading/show"),e.emit("service/admin/cme/events/approve",{id:n,doneCallback:function(e){bootbox.alert("This event has been approved!",function(){i.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof a&&a(humps.camelizeKeys(e))})},failCallback:function(e,t){var n="";n=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(n,function(){manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o(e,t)})}}))})},t.showModalReject=function(n){var a=n.id,o=n.doneCallback,i=n.failCallback,l=bootbox.dialog({message:swig.render(t.templates.modalRejectContent),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});l.on("shown.bs.modal",function(t){var n=l.find("form");n.validate({rules:{comment:{required:!0}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("div").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(t,r){if(r.preventDefault(),!parseInt(n.data("is-submitting"))){var s=n.serializeObject();manaDrApplication.emit("window/loading/show"),n.data("is-submitting",1),l.find(":input").prop("disabled",!0),e.emit("service/admin/cme/events/reject",{id:a,data:s,doneCallback:function(e){bootbox.alert("This event has been rejected",function(){l.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o(humps.camelizeKeys(e))})},failCallback:function(e,t){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){manaDrApplication.emit("window/loading/hide"),n.data("is-submitting",0),l.find(":input").prop("disabled",!1),"function"==typeof i&&i(e,t)})}})}}})})},t.bindEvents=function(){t.objects.$table.on("click","[data-action=approve]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr"),a=n.data("id");t.showModalApprove({id:a,doneCallback:function(e){return window.location.reload()},failCallback:function(e,t){console.log("errorApprove",e,t)}})}).on("click","[data-action=reject]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr").data("id");t.showModalReject({id:n,doneCallback:function(e){return window.location.reload()},failCallback:function(e,t){console.log("errorReject",e,t)}})})},t.init=function(e){t.data=e||{},t.objects={},t.objects.$table=$("#table_cme_events"),t.templates={modalRejectContent:multiline(function(){
/*!@preserve
	                <form class="form" id="form_reject_event">
	                <p class="form-control-static">Are you sure to reject this event?</p>
	                <div class="form-group">
	                <textarea class="form-control vertical" name="comment"></textarea>
	                </div>
	                </form>
	                */
console.log}),row:multiline(function(){
/*!@preserve
	                <tr data-id="{{id}}">
	                <td>
	                <img src="{{attachments.data[0].url_preview}}" width="80"/>
	                </td>
	                <td>
	                <a href="{{laroute.route('admin.cme.events.details', {'id': id})}}">
	                {{name}}
	                </a>
	                </td>
	                <td>
	                {% if status == 0 %}
	                <span class="label label-default">
	                Draft
	                </span>
	                {% elseif status == 1 %}
	                <span class="label label-warning">
	                Approval pending
	                </span>
	                {% elseif status == 2 %}
	                <span class="label label-primary">
	                Published
	                </span>
	                {% elseif status == 3 %}
	                <span class="label label-aqua">
	                Ongoing
	                </span>
	                {% elseif status == 4 %}
	                <span class="label label-muted">
	                Closed
	                </span>
	                {% elseif status == 5 %}
	                <span class="label label-danger">
	                Cancelled
	                </span>
	                {% elseif status == 6 %}
	                <span class="label label-success">
	                Approved
	                </span>
	                {% elseif status == 7 %}
	                <span class="label label-danger">
	                Rejected
	                </span>
	                {% endif %}
	                </td>
	                <td>
	                {{createdAt}}
	                </td>
	                <td>
	                {{startTime}}
	                </td>
	                <td>
	                <span title="{{organizer.data.email}}">
	                {{organizer.data.fullName}}
	                </span>
	                </td>
	                <td>
	                {% if status == 1 %}
	                <a href="#" class="btn btn-xs btn-info" data-action="approve">
	                <i class="fa fa-check"></i>
	                Approve
	                </a>
	                <a href="#" class="btn btn-xs btn-warning" data-action="reject">
	                <i class="fa fa-times"></i>
	                Reject
	                </a>
	                {% endif %}
	                </td>
	                </tr>
	                */
console.log})},t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t){"use strict";e.exports=function(e){var t=this;return t.showModalRegister=function(n){var a=n.doneCallback,o=n.failCallback;e.emit("window/loading/show"),e.emit("service/countries/list",{doneCallback:function(n){e.emit("window/loading/hide");var i=bootbox.dialog({title:"Register new CME Organizer",message:swig.render(t.templates.modalRegisterContent,{locals:{countries:n}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});i.on("shown.bs.modal",function(t){var n=i.find("form");n.find("select.chosen").chosen({width:"100%",search_contains:!0}),n.validate({ignore:":hidden:not(select)",rules:{name:{required:!0,minlength:1,maxlength:255},official_name:{required:!0,minlength:1,maxlength:255},email:{required:{depends:function(){return $(this).val().length}},validateEmail:""},password:{required:!0,validatePassword:!0},phone_number:{required:!0,number:!0},phone_country_code:{required:!0},country_id:{required:!0}},messages:{email:{required:"",validateEmail:"Invalid email format."},password:{validatePassword:"Invalid password format"}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest(".form-group").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(t,l){if(l.preventDefault(),!parseInt(n.data("is-submitting"))){var r=$(t).serializeObject();manaDrApplication.emit("window/loading/show"),n.data("is-submitting",1),i.find(":input").prop("disabled",!0),e.emit("service/admin/cme/organizers/register",{data:r,doneCallback:function(e){bootbox.alert("New CME Organizer has been registered!",function(){i.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof a&&a(humps.camelizeKeys(e))})},failCallback:function(e,t){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){manaDrApplication.emit("window/loading/hide"),n.data("is-submitting",0),i.find(":input").prop("disabled",!1),"function"==typeof o&&o(e,t)})}})}}})})},failCallback:function(t,n){e.emit("window/loading/hide"),"function"==typeof o&&o(t,n)}})},t.showModalUpdate=function(n){var a=n.id,o=n.doneCallback,i=n.failCallback;e.emit("window/loading/show"),e.emit("service/countries/list",{doneCallback:function(n){e.emit("window/loading/hide"),e.emit("service/admin/cme/organizers/fetch",{id:a,doneCallback:function(l){console.log("response",l);var r=l.data,s=r.user,c=r.organizer,d=bootbox.dialog({title:"Update CME Organizer Information",message:swig.render(t.templates.modalUpdateContent,{locals:{countries:n,user:s,organizer:c}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});d.on("shown.bs.modal",function(t){var n=d.find("form");n.find("select.chosen").chosen({width:"100%",search_contains:!0}),n.validate({ignore:":hidden:not(select)",rules:{name:{required:!0,minlength:1,maxlength:255},official_name:{required:!0,minlength:1,maxlength:255},email:{required:{depends:function(){return $(this).val().length}},validateEmail:""},password:{required:!0,validatePassword:!0},phone_number:{required:!0,number:!0},phone_country_code:{required:!0},country_id:{required:!0}},messages:{email:{required:"",validateEmail:"Invalid email format."},password:{validatePassword:"Invalid password format"}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest(".form-group").append(e)},highlight:function(e){$(e).closest(".form-group").addClass("has-error")},unhighlight:function(e){$(e).closest(".form-group").removeClass("has-error")},submitHandler:function(t,l){if(l.preventDefault(),!parseInt(n.data("is-submitting"))){var r=$(t).serializeObject();manaDrApplication.emit("window/loading/show"),n.data("is-submitting",1),d.find(":input").prop("disabled",!0),e.emit("service/admin/cme/organizers/update",{id:a,data:r,doneCallback:function(e){bootbox.alert("CME Organizer has been updated!",function(){d.modal("hide"),manaDrApplication.emit("window/loading/hide"),"function"==typeof o&&o(humps.camelizeKeys(e))})},failCallback:function(e,t){var a="";a=e&&e.responseJSON&&e.responseJSON.message&&e.responseJSON.message.length?e.responseJSON.message:"The request cannot be processed",bootbox.alert(a,function(){manaDrApplication.emit("window/loading/hide"),n.data("is-submitting",0),d.find(":input").prop("disabled",!1),"function"==typeof i&&i(e,t)})}})}}})})},failCallback:function(t,n){e.emit("window/loading/hide"),"function"==typeof i&&i(t,n)}})},failCallback:function(t,n){e.emit("window/loading/hide"),"function"==typeof i&&i(t,n)}})},t.bindEvents=function(){t.objects.$table.on("click","[data-action=register]",function(e){e.preventDefault(),t.showModalRegister({doneCallback:function(e){var n=e.data,a=n.organizer,o=n.user,i=swig.render(t.templates.row,{locals:{organizer:a,user:o}});t.objects.$table_tbody.append(i)},failCallback:function(e,t){}})}).on("click","[data-action=edit]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr[data-id]"),a=n.data("id");t.showModalUpdate({id:a,doneCallback:function(e){var a=e.data,o=a.organizer,i=a.user,l=swig.render(t.templates.row,{locals:{organizer:o,user:i}});n.replaceWith(l)},failCallback:function(e,t){}})})},t.init=function(e){t.data=e||{},t.objects={},t.objects.$table=$("#table_cme_organizers"),t.objects.$table_tbody=t.objects.$table.find("tbody"),t.templates={modalRegisterContent:multiline(function(){
/*!@preserve
	                <form class="form" id="form_register_organizer">
	                <div class="row">
	                <div class="col-sm-6">
	                <div class="form-group">
	                <label class="control-label">Name</label>
	                <input class="form-control" name="name" />
	                </div>
	                </div>
	                <div class="col-sm-6">
	                <div class="form-group">
	                <label class="control-label">Official name</label>
	                <input class="form-control" name="official_name" />
	                </div>
	                </div>
	                </div>
	                <div class="form-group">
	                <label class="control-label">Email</label>
	                <input class="form-control" name="email" />
	                </div>
	                <div class="form-group">
	                <label class="control-label">Password</label>
	                <input class="form-control" name="password" type="password" />
	                </div>
	                <div class="form-group">
	                <label class="control-label">Country</label>
	                <select class="form-control chosen" name="country_id">
	                <option value="">Select country</option>
	                {% for country in countries %}
	                <option value="{{country.id}}">{{country.niceName}}</option>
	                {% endfor %}
	                </select>
	                </div>
	                <div class="row">
	                <div class="col-sm-6">
	                <div class="form-group">
	                <label class="control-label">Phone number</label>
	                <select class="form-control chosen" name="phone_country_code">
	                <option value="">Select country</option>
	                {% for country in countries %}
	                <option value="{{country.phoneCountryCode}}">{{country.niceName}} ({{country.phoneCountryCode}})</option>
	                {% endfor %}
	                </select>
	                </div>
	                </div>
	                <div class="col-sm-6">
	                <div class="form-group">
	                <label class="control-label">&nbsp;</label>
	                <input class="form-control" name="phone_number" />
	                </div>
	                </div>
	                </div>
	                <div class="form-group">
	                <label class="control-label">Description</label>
	                <textarea class="form-control vertical" name="description">{{organizer.description}}</textarea>
	                </div>
	                </form>
	                */
console.log}),modalUpdateContent:multiline(function(){
/*!@preserve
	                <form class="form" id="form_register_organizer">
	                <div class="row">
	                <div class="col-sm-6">
	                <div class="form-group">
	                <label class="control-label">Name</label>
	                <input class="form-control" name="name" value="{{organizer.name}}" />
	                </div>
	                </div>
	                <div class="col-sm-6">
	                <div class="form-group">
	                <label class="control-label">Official name</label>
	                <input class="form-control" name="official_name" value="{{organizer.officialName}}" />
	                </div>
	                </div>
	                </div>
	                <div class="form-group">
	                <label class="control-label">Country</label>
	                <select class="form-control chosen" name="country_id">
	                <option value="">Select country</option>
	                {% for country in countries %}
	                <option
	                value="{{country.id}}"
	                {% if country.id == user.countryId %}selected{% endif %}
	                >{{country.niceName}}</option>
	                {% endfor %}
	                </select>
	                </div>
	                <div class="row">
	                <div class="col-sm-6">
	                <div class="form-group">
	                <label class="control-label">Phone number</label>
	                <select class="form-control chosen" name="phone_country_code">
	                <option value="">Select country</option>
	                {% for country in countries %}
	                <option
	                value="{{country.phoneCountryCode}}"
	                {% if country.phoneCountryCode == user.phoneCountryCode %}selected{% endif %}
	                >{{country.niceName}} ({{country.phoneCountryCode}})</option>
	                {% endfor %}
	                </select>
	                </div>
	                </div>
	                <div class="col-sm-6">
	                <div class="form-group">
	                <label class="control-label">&nbsp;</label>
	                <input class="form-control" name="phone_number" value="{{user.phoneNumber}}" />
	                </div>
	                </div>
	                </div>
	                <div class="form-group">
	                <label class="control-label">Description</label>
	                <textarea class="form-control vertical" name="description">{{organizer.description}}</textarea>
	                </div>
	                </form>
	                */
console.log}),row:multiline(function(){
/*!@preserve
	                <tr data-id="{{organizer.id}}">
	                <td>
	                {% if organizer.profileImageUrl %}
	                <img
	                class="img-rounded"
	                src="{{organizer.profileImageUrl}}"
	                alt="{{organizer.name}}"
	                style="height:20px;vertical-align:top;"
	                />
	                {% endif %}
	                {{organizer.name}}
	                </td>
	                <td>{{organizer.officialName}}</td>
	                <td>{{user.phoneNumber}}</td>
	                <td>{{user.email}}</td>
	                <td>{{organizer.description}}</td>
	                <td><a class="btn btn-xs btn-default" data-action="edit"><i class="fa fa-edit" /> Update</a></td>
	                </tr>
	                */
console.log})},t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}},function(e,t,n){"use strict";var a=n(15);e.exports=function(e){var t=this;return t.showModalCreateDoctorAccount=function(n){var o=n.id,i=(n.doneCallback,n.failCallback);e.emit("window/loading/show"),e.emit("service/countries/list",{doneCallback:function(n){e.emit("service/superClinicData/fetch",{id:o,doneCallback:function(o){var i=bootbox.dialog({size:"large",title:"Create doctor account",message:swig.render(t.templates.modalCreateDoctorAccount,{locals:{superClinicDatum:o,countries:n}}),buttons:{reset:{label:"Reset",className:"btn",callback:function(e){var t=$(e.delegateTarget).find("form");return t.validate().resetForm(),t[0].reset(),t[0].reset(),!1}},submit:{label:"Submit",className:"btn btn-primary",callback:function(e){return $(e.delegateTarget).find("form").submit(),!1}}}});i.on("shown.bs.modal",function(t){var n=i.find("form");n.find("select[name=phone_country_code]").selectize({placeholder:"Country code"}),n.find("select[name=phone_number]").selectize({placeholder:"Phone number",create:function(e){return{value:e,text:e}}}),n.find("select[name=languages]").selectize({maxItems:null}),n.validate({ignore:":hidden:not(select)",rules:{name:{required:!0},email:{required:!0,validateEmail:""},phone_number:{required:!0,number:!0},phone_country_code:{},website:{},address:{},languages:{},license_no:{},password:{required:!0,validatePassword:!0,minlength:6,maxlength:30},confirm_password:{required:!0,validatePassword:!0,minlength:6,maxlength:30,equalTo:"[name=password]"}},messages:{email:{validateEmail:"Invalid email format."},password:{required:"This field is required",validatePassword:"Invalid format password"},confirm_password:{required:"This field is required",validatePassword:"Invalid format password",equalTo:"Please reenter the same password"}},errorElement:"p",errorClass:"help-block",errorPlacement:function(e,t){t.closest("td,th").append(e)},highlight:function(e){$(e).closest("td,th").addClass("has-error")},unhighlight:function(e){$(e).closest("td,th").removeClass("has-error")},submitHandler:function(t,o){if(o.preventDefault(),!parseInt(n.data("is-submitting"))){var l=$(t).serialize();e.emit("window/loading/show"),n.data("is-submitting",1),i.find(":input").prop("disabled",!0),$.ajax({url:laroute.route("admin.superClinicData.createDoctorAccount"),method:"POST",data:l,dataType:"json"}).done(function(t){var n="Doctor account for <b>"+a(t,"data.doctor.name")+"</b> has been created successfully!";bootbox.alert(n,function(){bootbox.hideAll(),e.emit("window/loading/hide")})}).fail(function(t,a){var o="";o=t&&t.responseJSON&&t.responseJSON.message&&t.responseJSON.message.length?t.responseJSON.message:"The request cannot be processed",bootbox.alert(o,function(){n.data("is-submitting",0),i.find(":input").prop("disabled",!1),e.emit("window/loading/hide")})})}}})}),e.emit("window/loading/hide")},failCallback:function(t,n){e.emit("window/loading/hide")}})},failCallback:function(t,n){e.emit("window/loading/hide"),"function"==typeof i&&i(t,n)}})},t.bindEvents=function(){t.objects.$tableSuperClinicData.on("click","[data-action=createAccount]",function(e){e.preventDefault();var n=$(e.currentTarget).closest("tr[data-id]").data("id");if(!n)return!1;t.showModalCreateDoctorAccount({id:n,doneCallback:function(e){alert("success")},failCallback:function(){alert("error")}})})},t.init=function(e){t.data=e||{},t.objects={},t.objects.$tableSuperClinicData=$("#table_super_clinic_data"),t.templates={},t.templates.modalCreateDoctorAccount=multiline(function(){
/*!@preserve
	            <form class="form" id="form_create_doctor_account">
	            <table class="table table-striped table-bordered">
	            <thead>
	            <tr>
	            <th width="20%"></th>
	            <th width="40%" class="text-center">Raw data</th>
	            <th width="40%"></th>
	            </tr>
	            </thead>
	            <tbody>
	            <tr>
	            <th class="text-right" style="vertical-align:middle;">Name<sup class="text-danger">*</sup></th>
	            <td style="vertical-align:middle;">{{superClinicDatum.name}}</td>
	            <td>
	            <input class="form-control" name="name" value="{{superClinicDatum.name}}"/>
	            </td>
	            </tr>
	            <tr>
	            <th class="text-right" style="vertical-align:middle;">Email<sup class="text-danger">*</sup></th>
	            <td style="vertical-align:middle;">{{superClinicDatum.email}}</td>
	            <td>
	            <input class="form-control" name="email" value="{{superClinicDatum.email}}"/>
	            </td>
	            </tr>
	            <tr>
	            <th class="text-right" style="vertical-align:middle;">Phone number<sup class="text-danger">*</sup></th>
	            <td style="vertical-align:middle;">{{ superClinicDatum.phoneNumbers|join(', ')}}</td>
	            <td>
	            <div class="row">
	            <div class="col-xs-6">
	            <select class="form-control" name="phone_country_code">
	            <option></option>
	            {% for country in countries %}
	            <option value="{{country.phoneCountryCode}}">{{country.niceName}} ({{country.phoneCountryCode}})</option>
	            {% endfor %}
	            </select>
	            </div>
	            <div class="col-xs-6">
	            <select class="form-control" name="phone_number">
	            <option></option>
	            {% for phoneNumber in superClinicDatum.phoneNumbers %}
	            <option value="{{phoneNumber}}">{{phoneNumber}}</option>
	            {% endfor %}
	            </select>
	            </div>
	            </div>
	            </td>
	            </tr>
	            <tr>
	            <th class="text-right" style="vertical-align:middle;">Website</th>
	            <td style="vertical-align:middle;">{{superClinicDatum.website}}</td>
	            <td>
	            <input class="form-control" name="website" value="{{superClinicDatum.website}}"/>
	            </td>
	            </tr>
	            <tr>
	            <th class="text-right" style="vertical-align:middle;">Spoken languages</th>
	            <td style="vertical-align:middle;">{{superClinicDatum.languages}}</td>
	            <td>
	            <select class="form-control" name="languages" multiple>
	            <option></option>
	            {% for language in superClinicDatum.languages|split(', ') %}
	            <option value="{{language}}" selected>{{language}}</option>
	            {% endfor %}
	            </select>
	            </td>
	            </tr>
	            <tr>
	            <th class="text-right" style="vertical-align:middle;">License Number</th>
	            <td style="vertical-align:middle;">{{superClinicDatum.licenseNo}}</td>
	            <td>
	            <input class="form-control" name="license_no" value="{{superClinicDatum.licenseNo}}"/>
	            </td>
	            </tr>
	            <tr>
	            <th class="text-right" style="vertical-align:middle;">Address</th>
	            <td style="vertical-align:middle;">{{superClinicDatum.address}}</td>
	            <td>
	            <input class="form-control" name="address" value="{{superClinicDatum.address}}"/>
	            </td>
	            </tr>
	            </tbody>
	            <tfoot>
	            <tr>
	            <th class="text-right" style="vertical-align:middle;">Password</th>
	            <td></td>
	            <td>
	            <div class="form-group">
	            <input class="form-control" type="password" name="password" placeholder="Password" />
	            </div>
	            <div class="form-group">
	            <input class="form-control" type="password" name="confirm_password" placeholder="Confirm password" />
	            </div>
	            </td>
	            </tr>
	            </tfoot>
	            </table>
	            </form>
	            */
console.log}),t.bindEvents()},t.destroy=function(){},{init:t.init,destroy:t.destroy}}}]);
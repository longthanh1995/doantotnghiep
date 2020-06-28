@extends('legacy.layouts.admin.application')

@section('pageTitle', 'Manage Appointment Types')

@section('bodyClass', 'page-appointment-types page-appointment-types-index')

@section('header', 'Appointment Types')

@section('subheader', ' ')

@push('breadcrumbs')
<li>
    Appointment Types
</li>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="table_appointment_types">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>
                                <a href="#" class="btn btn-xs btn-primary" data-action="add">
                                    <i class="fa fa-plus"></i> Add
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($appointmentTypes)
                        @foreach($appointmentTypes as $appointmentType)
                            <tr data-id="{{$appointmentType->id}}" data-name="{{$appointmentType->name}}" data-category="{{$appointmentType->category}}" data-clinic-id="{{$appointmentType->clinic?$appointmentType->clinic->id:''}}">
                                <td
                                @if(!$appointmentType->is_active)
                                    class="text-muted"
                                @endif
                                >
                                @if($appointmentType->category == \App\Models\AppointmentType::CATEGORY_HOUSE_CALL)
                                    <i class="fa fa-home"></i>
                                @endif
                                    {{$appointmentType->name}}
                                @if($appointmentType->clinic)
                                    <br/><small>Belongs to: <a href="{{route('admin.clinic.details', $appointmentType->clinic->id)}}">{{$appointmentType->clinic->name}}</a></small>
                                @endif
                                </td>
                                <td>
                                @if($appointmentType->is_active)
                                    <a href="#" class="btn btn-xs btn-default" data-action="deactivate">
                                        <i class="fa fa-times"></i>
                                        Deactivate
                                    </a>
                                @else
                                    <a href="#" class="btn btn-xs btn-default" data-action="activate">
                                        <i class="fa fa-check"></i>
                                        Activate
                                    </a>
                                @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-default" data-action="edit">
                                        <i class="fa fa-pencil"></i>
                                        Edit
                                    </a>
                                @if($appointmentType->category === \App\Models\AppointmentType::CATEGORY_HOUSE_CALL)
                                    <a href="#" class="btn btn-xs btn-default" data-action="manageHouseCallReasons">
                                        <i class="fa fa-home"></i>
                                        {{$appointmentType->houseCallReasons->count()}} reasons
                                    </a>
                                @endif
                                @if($appointmentType->canRemove())
                                    <a href="#" class="btn btn-xs btn-danger" data-action="remove">
                                        <i class="fa fa-times"></i>
                                        Remove
                                    </a>
                                @endif
                                </td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
<script type="text/javascript">
$(function(){
    $('#table_appointment_types')
        .on('click', '[data-action=add]', function(event){
            event.preventDefault();

            var template = multiline(function(){/*!@preserve
            <form class="form" data-is-submitting="0">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" name="name" type="text"/>
                </div>
                <div class="form-group">
                    <label for="clinic_id">Clinic</label>
                    <select class="form-control" name="clinic_id">
                        <option value="" selected>System-wide</option>
                    @foreach($clinics as $clinic)
                        <option value="{{$clinic->id}}">{{$clinic->name}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="is_house_call_appointment_type"> House call appointment type
                        </label>
                    </div>
                </div>
            </form>
            */console.log});

            var message = swig.render(template);

            var $modal = bootbox.dialog({
                title: 'Add new appointment type',
                className: 'modal-add-new-appointment-type',
                message: message,
                buttons: {
                    submit: {
                        label: 'Submit',
                        className: 'btn btn-primary',
                        callback: function(){
                            var $form = $(this).find('form');

                            $form.submit();

                            return false;
                        }
                    }
                }
            });

            $modal
                .on('shown.bs.modal', function(){
                    var $form = $modal.find('form');

                    $form.validate({
                        rules: {
                            name: {
                                required: true,
                                minlength: 1
                            }
                        },
                        errorElement: "p",
                        errorClass: "help-block",
                        errorPlacement: function(error, element) {
                            element.closest('div').append(error);
                        },

                        highlight: function(element) {
                            $(element).closest('div').addClass('has-error');
                        },

                        unhighlight: function (element) {
                            $(element).closest('div').removeClass('has-error');
                        },
                        submitHandler: function(form, event){
                            event.preventDefault();

                            var isSubmitting = parseInt($form.data('is-submitting'));

                            if(isSubmitting){
                                return;
                            }

                            var formData = $(form).serialize();

                            showLoading();
                            $form.data('is-submitting', 1);
                            $modal.find(':input').prop('disabled', true);

                            var request = $.ajax({
                                url: laroute.route('admin.appointmentType.store'),
                                method: "POST",
                                data: formData,
                                dataType: "json"
                            });

                            request
                                .done(function(response){
                                    var rowTemplate = multiline(function(){/*!@preserve
                                    <tr data-id="@{{id}}" data-name="@{{ name }}" data-category="@{{ category }}" data-clinic-id="@{{ clinic.id }}">
                                        <td {% if !is_active %}class="text-muted"{% endif %}>
                                        {% if (category == '{{\App\Models\AppointmentType::CATEGORY_HOUSE_CALL}}') %}
                                            <i class="fa fa-home"></i>
                                        {% endif %}
                                            @{{name}}

                                        {% if (clinic.name) %}
                                            <br/><small>Belongs to: <a href="/back-office/clinics/@{{ clinic.id }}">@{{clinic.name}}</a></small>
                                        {% endif %}
                                        </td>
                                        <td>
                                        {% if is_active %}
                                            <a href="#" class="btn btn-xs btn-default" data-action="deactivate">
                                                <i class="fa fa-times"></i>
                                                Deactivate
                                            </a>
                                        {% else %}
                                            <a href="#" class="btn btn-xs btn-default" data-action="activate">
                                                <i class="fa fa-check"></i>
                                                Activate
                                            </a>
                                        {% endif %}
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-xs btn-default" data-action="edit">
                                                <i class="fa fa-pencil"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="btn btn-xs btn-danger" data-action="remove">
                                                <i class="fa fa-times"></i>
                                                Remove
                                            </a>
                                        </td>
                                    </tr>
                                    */console.log});

                                    var html = swig.render(rowTemplate, {
                                        locals: response
                                    });

                                    $('#table_appointment_types tbody').append(html);

                                    var message = '';
                                    if(response
                                    && response.id){
                                        message = 'Appointment Type <b>' + response.name + '</b> has been created.'
                                    } else {
                                        message = 'Request has been processed successfully.';
                                    }
                                    bootbox.alert(message, function(){
                                        $modal.modal('hide');
                                        hideLoading();
                                    });
                                })
                                .fail(function(e, data){
                                    var message = '';
                                    if(e
                                        && e.responseJSON
                                        && e.responseJSON.message
                                        && e.responseJSON.message.length){
                                        message = e.responseJSON.message;
                                    } else {
                                        message = 'The request cannot be processed';
                                    }
                                    bootbox.alert(message, function(){
                                        $form.data('is-submitting', 0);
                                        $modal.find(':input').prop('disabled', false);
                                        hideLoading();
                                    });
                                })
                                .always(function(){

                                })
                            ;
                        }
                    })
                })
        })
        .on('click', '[data-action=edit]', function(event){
            event.preventDefault();

            var $targetRow = $(this).closest('tr[data-id]'),
                targetId = $targetRow.data('id'),
                targetName = $targetRow.data('name'),
                targetCategory = $targetRow.data('category'),
                targetClinicId = $targetRow.data('clinic-id')
            ;

            if(!targetId){
                return false;
            }

            var template = multiline(function(){/*!@preserve
            <form class="form" data-is-submitting="0">
                <input type="hidden" name="id" value="@{{ id }}"/>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" name="name" type="text" value="@{{ name }}"/>
                </div>
                <div class="form-group">
                    <label for="clinic_id">Clinic</label>
                    <select class="form-control" name="clinic_id">
                        <option value="" selected>System-wide</option>
                    @foreach($clinics as $clinic)
                        <option value="{{$clinic->id}}" {% if (clinicId == {{ $clinic->id }}) %}selected="selected"{% endif %}>{{$clinic->name}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="is_house_call_appointment_type" {% if (category == "{{\App\Models\AppointmentType::CATEGORY_HOUSE_CALL}}") %}checked="checked"{% endif %}>House call appointment type
                        </label>
                    </div>
                </div>
            </form>
            */console.log});

            var message = swig.render(template, {
                locals: {
                    id: targetId,
                    name: targetName,
                    category: targetCategory,
                    clinicId: targetClinicId,
                }
            });

            var $modal = bootbox.dialog({
                title: 'Edit appointment type',
                className: 'modal-add-new-appointment-type',
                message: message,
                buttons: {
                    submit: {
                        label: 'Submit',
                        className: 'btn btn-primary',
                        callback: function(){
                            var $form = $(this).find('form');

                            $form.submit();

                            return false;
                        }
                    }
                }
            });

            $modal
                .on('shown.bs.modal', function() {
                    var $form = $modal.find('form');

                    $form.validate({
                        rules: {
                            name: {
                                required: true,
                                minlength: 1
                            }
                        },
                        errorElement: "p",
                        errorClass: "help-block",
                        errorPlacement: function(error, element) {
                            element.closest('div').append(error);
                        },

                        highlight: function(element) {
                            $(element).closest('div').addClass('has-error');
                        },

                        unhighlight: function (element) {
                            $(element).closest('div').removeClass('has-error');
                        },
                        submitHandler: function(form, event){
                            event.preventDefault();

                            var isSubmitting = parseInt($form.data('is-submitting'));

                            if(isSubmitting){
                                return;
                            }

                            var formData = $(form).serialize();

                            showLoading();
                            $form.data('is-submitting', 1);
                            $modal.find(':input').prop('disabled', true);

                            var request = $.ajax({
                                url: laroute.route('admin.appointmentType.update', {appointmentType: targetId}),
                                method: "PUT",
                                data: formData,
                                dataType: "json"
                            });

                            request
                                .done(function(response){
                                    var rowTemplate = multiline(function(){/*!@preserve
                                    <tr data-id="@{{id}}" data-name="@{{ name }}" data-category="@{{ category }}" data-clinic-id="@{{ clinic.id }}">
                                        <td {% if !is_active %}class="text-muted"{% endif %}>
                                        {% if (category == '{{\App\Models\AppointmentType::CATEGORY_HOUSE_CALL}}') %}
                                            <i class="fa fa-home"></i>
                                        {% endif %}
                                            @{{name}}

                                        {% if (clinic.name) %}
                                            <br/><small>Belongs to: <a href="/back-office/clinics/@{{ clinic.id }}">@{{clinic.name}}</a></small>
                                        {% endif %}
                                        </td>
                                        <td>
                                        {% if is_active %}
                                            <a href="#" class="btn btn-xs btn-default" data-action="deactivate">
                                                <i class="fa fa-times"></i>
                                                Deactivate
                                            </a>
                                        {% else %}
                                            <a href="#" class="btn btn-xs btn-default" data-action="activate">
                                                <i class="fa fa-check"></i>
                                                Activate
                                            </a>
                                        {% endif %}
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-xs btn-default" data-action="edit">
                                                <i class="fa fa-pencil"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="btn btn-xs btn-danger" data-action="remove">
                                                <i class="fa fa-times"></i>
                                                Remove
                                            </a>
                                        </td>
                                    </tr>
                                    */console.log});

                                    var html = swig.render(rowTemplate, {
                                        locals: response
                                    });

                                    $targetRow.replaceWith(html);

                                    var message = '';
                                    if(response
                                    && response.id){
                                        message = 'Appointment type <b>' + response.name + '</b> has been updated.'
                                    } else {
                                        message = 'Request has been processed successfully.';
                                    }
                                    bootbox.alert(message, function(){
                                        $modal.modal('hide');
                                        hideLoading();
                                    });
                                })
                                .fail(function(e, data){
                                    var message = '';
                                    if(e
                                        && e.responseJSON
                                        && e.responseJSON.message
                                        && e.responseJSON.message.length){
                                        message = e.responseJSON.message;
                                    } else {
                                        message = 'The request cannot be processed';
                                    }
                                    bootbox.alert(message, function(){
                                        $form.data('is-submitting', 0);
                                        $modal.find(':input').prop('disabled', false);
                                        hideLoading();
                                    });
                                })
                                .always(function(){

                                })
                            ;
                        }
                    })
                })
            ;
        })
        .on('click', '[data-action=remove]', function(event){
            event.preventDefault();

            var $targetRow = $(this).closest('tr[data-id]'),
                targetId = $targetRow.data('id'),
                targetName = $targetRow.data('name')
            ;

            bootbox.confirm('Do you really want to remove appointment type <b>' + targetName + '</b>?', function(result){
                if(result){
                    showLoading();

                    var request = $.ajax({
                        url: laroute.route('admin.appointmentType.destroy', {appointmentType: targetId}),
                        method: "DELETE",
                    });

                    request
                        .done(function(response){
                            $targetRow.remove();

                            var message = '';
                            if(response
                            && response.success){
                                message = 'Appointment type <b>' + targetName + '</b> has been removed.'
                            } else {
                                message = 'Request has been processed successfully.';
                            }
                            bootbox.alert(message, function(){
                                hideLoading();
                            });
                        })
                        .fail(function(e, data){
                            var message = '';
                            if(e
                                && e.responseJSON
                                && e.responseJSON.message
                                && e.responseJSON.message.length){
                                message = e.responseJSON.message;
                            } else {
                                message = 'The request cannot be processed';
                            }
                            bootbox.alert(message, function(){
                                hideLoading();
                            });
                        })
                        .always(function(){

                        })
                    ;
                }
            });
        })
        .on('click', '[data-action=deactivate]', function(event){
            event.preventDefault();

            var $targetRow = $(this).closest('tr[data-id]'),
                targetId = $targetRow.data('id'),
                targetName = $targetRow.data('name')
            ;

            bootbox.confirm('Do you really want to deactivate appointment type <b>' + targetName + '</b>? Patient won\'t be able to book attached timeslots', function(result){
                if(result){
                    showLoading();

                    var request = $.ajax({
                        url: laroute.route('admin.appointmentType.deactivate', {appointmentType: targetId}),
                        method: "POST",
                    });

                    request
                        .done(function(response){
                            var rowTemplate = multiline(function(){/*!@preserve
                            <tr data-id="@{{id}}" data-name="@{{ name }}" data-category="@{{ category }}" data-clinic-id="@{{ clinic.id }}">
                                <td {% if !is_active %}class="text-muted"{% endif %}>
                                {% if (category == '{{\App\Models\AppointmentType::CATEGORY_HOUSE_CALL}}') %}
                                    <i class="fa fa-home"></i>
                                {% endif %}
                                    @{{name}}

                                {% if (clinic.name) %}
                                    <br/><small>Belongs to: <a href="/back-office/clinics/@{{ clinic.id }}">@{{clinic.name}}</a></small>
                                {% endif %}
                                </td>
                                <td>
                                {% if is_active %}
                                    <a href="#" class="btn btn-xs btn-default" data-action="deactivate">
                                        <i class="fa fa-times"></i>
                                        Deactivate
                                    </a>
                                {% else %}
                                    <a href="#" class="btn btn-xs btn-default" data-action="activate">
                                        <i class="fa fa-check"></i>
                                        Activate
                                    </a>
                                {% endif %}
                                </td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-default" data-action="edit">
                                        <i class="fa fa-pencil"></i>
                                        Edit
                                    </a>
                                    <a href="#" class="btn btn-xs btn-danger" data-action="remove">
                                        <i class="fa fa-times"></i>
                                        Remove
                                    </a>
                                </td>
                            </tr>
                            */console.log});

                            var html = swig.render(rowTemplate, {
                                locals: response
                            });

                            $targetRow.replaceWith(html);

                            var message = '';
                            if(response
                                && response.success){
                                message = 'Appointment type <b>' + targetName + '</b> has been deactivated.'
                            } else {
                                message = 'Request has been processed successfully.';
                            }
                            bootbox.alert(message, function(){
                                hideLoading();
                            });
                        })
                        .fail(function(e, data){
                            var message = '';
                            if(e
                                && e.responseJSON
                                && e.responseJSON.message
                                && e.responseJSON.message.length){
                                message = e.responseJSON.message;
                            } else {
                                message = 'The request cannot be processed';
                            }
                            bootbox.alert(message, function(){
                                hideLoading();
                            });
                        })
                        .always(function(){

                        })
                    ;
                }
            });
        })
        .on('click', '[data-action=activate]', function(event){
            event.preventDefault();

            var $targetRow = $(this).closest('tr[data-id]'),
                targetId = $targetRow.data('id'),
                targetName = $targetRow.data('name')
            ;

            bootbox.confirm('Do you really want to activate appointment type <b>' + targetName + '</b>? Patient will be able to book attached timeslots', function(result){
                if(result){
                    showLoading();

                    var request = $.ajax({
                        url: laroute.route('admin.appointmentType.activate', {appointmentType: targetId}),
                        method: "POST",
                    });

                    request
                        .done(function(response){
                            var rowTemplate = multiline(function(){/*!@preserve
                            <tr data-id="@{{id}}" data-name="@{{ name }}" data-category="@{{ category }}" data-clinic-id="@{{ clinic.id }}">
                                <td {% if !is_active %}class="text-muted"{% endif %}>
                                {% if (category == '{{\App\Models\AppointmentType::CATEGORY_HOUSE_CALL}}') %}
                                    <i class="fa fa-home"></i>
                                {% endif %}
                                    @{{name}}

                                {% if (clinic.name) %}
                                    <br/><small>Belongs to: <a href="/back-office/clinics/@{{ clinic.id }}">@{{clinic.name}}</a></small>
                                {% endif %}
                                </td>
                                <td>
                                {% if is_active %}
                                    <a href="#" class="btn btn-xs btn-default" data-action="deactivate">
                                        <i class="fa fa-times"></i>
                                        Deactivate
                                    </a>
                                {% else %}
                                    <a href="#" class="btn btn-xs btn-default" data-action="activate">
                                        <i class="fa fa-check"></i>
                                        Activate
                                    </a>
                                {% endif %}
                                </td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-default" data-action="edit">
                                        <i class="fa fa-pencil"></i>
                                        Edit
                                    </a>
                                    <a href="#" class="btn btn-xs btn-danger" data-action="remove">
                                        <i class="fa fa-times"></i>
                                        Remove
                                    </a>
                                </td>
                            </tr>
                            */console.log});

                            var html = swig.render(rowTemplate, {
                                locals: response
                            });

                            $targetRow.replaceWith(html);

                            var message = '';
                            if(response
                                && response.success){
                                message = 'Appointment type <b>' + targetName + '</b> has been activated.'
                            } else {
                                message = 'Request has been processed successfully.';
                            }
                            bootbox.alert(message, function(){
                                hideLoading();
                            });
                        })
                        .fail(function(e, data){
                            var message = '';
                            if(e
                                && e.responseJSON
                                && e.responseJSON.message
                                && e.responseJSON.message.length){
                                message = e.responseJSON.message;
                            } else {
                                message = 'The request cannot be processed';
                            }
                            bootbox.alert(message, function(){
                                hideLoading();
                            });
                        })
                        .always(function(){

                        })
                    ;
                }
            });
        })
        .on('click', '[data-action=manageHouseCallReasons]', function(event){
            event.preventDefault();

            var $targetRow = $(this).closest('tr[data-id]'),
                targetId = $targetRow.data('id'),
                targetName = $targetRow.data('name'),
                targetClinicId = $targetRow.data('clinic-id')
            ;

            manaDrApplication.emit('window/loading/show');

            manaDrApplication.emit('service/houseCallReason/list', {
                data: {
                    appointment_type_id: targetId,
                    clinic_id: targetClinicId,
                },
                doneCallback: function(response){
                    manaDrApplication.emit('window/loading/hide');

                    var template = multiline(function(){/*!@preserve
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
                                    <td>@{{reason.name}}</td>
                                    <td class="text-right">
                                        <a class="btn btn-xs btn-default" data-id="@{{ reason.id }}" data-action="manageDoctors">
                                            <i class="fa fa-user-md" />
                                        {% if reason.doctors %}
                                            @{{ reason.doctors.length }} doctors
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
                    */console.log});

                    console.log('response', response);

                    bootbox.dialog({
                        title: `Test`,
                        message: swig.render(template, {
                            locals: {
                                reasons: response,
                            }
                        })
                    });
                },
                failCallback: function(e, data){
                    var message = '';
                    if(e
                        && e.responseJSON
                        && e.responseJSON.message
                        && e.responseJSON.message.length){
                        message = e.responseJSON.message;
                    } else {
                        message = 'The request cannot be processed';
                    }
                    bootbox.alert(message, function(){
                        hideLoading();
                    });
                }
            });
        })
    ;
});
</script>
@endpush
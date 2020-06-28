@extends('legacy.layouts.admin.application')

@section('pageTitle', 'Manage Healthcare Providers\' Titles - System Diagnose')

@section('bodyClass', 'page-doctors-titles page-doctors-titles-index')

@section('header', 'Manage Healthcare Providers\' Titles')

@section('subheader', ' ')

@push('breadcrumbs')
<li>
    Healthcare Provider's Titles
</li>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="table_doctor_titles">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>
                                <a href="#" class="btn btn-xs btn-primary" data-action="add">
                                    <i class="fa fa-plus"></i> Add
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($doctorTitles)
                        @foreach($doctorTitles as $doctorTitle)
                            <tr data-id="{{$doctorTitle->id}}" data-title="{{$doctorTitle->title}}">
                                <td>
                                    {{$doctorTitle->title}}
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
    $('#table_doctor_titles')
        .on('click', '[data-action=add]', function(event){
            event.preventDefault();

            var template = multiline(function(){/*!@preserve
            <form class="form" data-is-submitting="0">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" name="title" type="text"/>
                </div>
            </form>
            */console.log});

            var message = swig.render(template);

            var $modal = bootbox.dialog({
                title: 'Add new title',
                className: 'modal-add-new-doctor-title',
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
                            title: {
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
                                url: laroute.route('admin.doctorTitle.store'),
                                method: "POST",
                                data: formData,
                                dataType: "json"
                            });

                            request
                                .done(function(response){
                                    var rowTemplate = multiline(function(){/*!@preserve
                                    <tr data-id="@{{id}}" data-title="@{{ title }}">
                                        <td >@{{title}}</td>
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

                                    $('#table_doctor_titles tbody').append(html);

                                    var message = '';
                                    if(response
                                    && response.id){
                                        message = 'The title <b>' + response.title + '</b> has been created.'
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
                targetTitle = $targetRow.data('title')
            ;

            if(!targetId){
                return false;
            }

            var template = multiline(function(){/*!@preserve
            <form class="form" data-is-submitting="0">
                <input type="hidden" name="id" value="@{{ id }}"/>
                <div class="form-group">
                    <label for="name">Title</label>
                    <input class="form-control" name="title" type="text" value="@{{ title }}"/>
                </div>
            </form>
            */console.log});

            var message = swig.render(template, {
                locals: {
                    id: targetId,
                    title: targetTitle
                }
            });

            var $modal = bootbox.dialog({
                title: 'Edit title',
                className: 'modal-edit-doctor-title',
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
                            title: {
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
                                url: laroute.route('admin.doctorTitle.update', {doctorTitle: targetId}),
                                method: "POST",
                                data: formData,
                                dataType: "json"
                            });

                            request
                                .done(function(response){
                                    var rowTemplate = multiline(function(){/*!@preserve
                                    <tr data-id="@{{id}}" data-title="@{{ title }}">
                                        <td>@{{title}}</td>
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
                                        message = 'The title <b>' + targetTitle + '</b> has been updated.'
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
                targetTitle = $targetRow.data('title')
            ;

            bootbox.confirm('Do you really want to remove the title <b>' + targetTitle + '</b>?', function(result){
                if(result){
                    showLoading();

                    var request = $.ajax({
                        url: laroute.route('admin.doctorTitle.destroy', {doctorTitle: targetId}),
                        method: "DELETE",
                    });

                    request
                        .done(function(response){
                            $targetRow.remove();

                            var message = '';
                            if(response
                            && response.success){
                                message = 'The title <b>' + targetTitle + '</b> has been removed.'
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
    ;
});
</script>
@endpush
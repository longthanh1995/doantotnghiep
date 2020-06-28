@extends('legacy.layouts.admin.application')

@section('pageTitle', 'Manage Languages - System Diagnose')

@section('bodyClass', 'page-languages page-languages-index')

@section('header', 'Manage Languages')

@section('subheader', ' ')

@push('breadcrumbs')
<li>
    Languages
</li>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="table_languages">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>
                                <a href="#" class="btn btn-xs btn-primary" data-action="add">
                                    <i class="fa fa-plus"></i> Add
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($languages)
                        @foreach($languages as $language)
                            <tr data-id="{{$language->id}}" data-name="{{$language->name}}" data-code="{{$language->code}}">
                                <td>
                                    {{$language->name}}
                                </td>
                                <td>
                                    {{$language->code}}
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
    $('#table_languages')
        .on('click', '[data-action=add]', function(event){
            event.preventDefault();

            var template = multiline(function(){/*!@preserve
            <form class="form" data-is-submitting="0">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" name="name" type="text"/>
                </div>
                <div class="form-group">
                    <label for="name">Code</label>
                    <input class="form-control" name="code" type="text"/>
                </div>
            </form>
            */console.log});

            var message = swig.render(template);

            var $modal = bootbox.dialog({
                title: 'Add new language',
                className: 'modal-add-new-language',
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
                            },
                            code: {
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
                                url: laroute.route('admin.language.store'),
                                method: "POST",
                                data: formData,
                                dataType: "json"
                            });

                            request
                                .done(function(response){
                                    var rowTemplate = multiline(function(){/*!@preserve
                                    <tr data-id="@{{id}}" data-name="@{{ name }}" data-code="@{{ code }}">
                                        <td>@{{name}}</td>
                                        <td>@{{code}}</td>
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

                                    $('#table_languages tbody').append(html);

                                    var message = '';
                                    if(response
                                    && response.id){
                                        message = 'Language <b>' + response.name + '</b> has been created.'
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
                targetCode = $targetRow.data('code')
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
                    <label for="name">Code</label>
                    <input class="form-control" name="code" type="text" value="@{{ code }}"/>
                </div>
            </form>
            */console.log});

            var message = swig.render(template, {
                locals: {
                    id: targetId,
                    name: targetName,
                    code: targetCode
                }
            });

            var $modal = bootbox.dialog({
                title: 'Edit language',
                className: 'modal-edit-language',
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
                            },
                            code: {
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
                                url: laroute.route('admin.language.update', {language: targetId}),
                                method: "POST",
                                data: formData,
                                dataType: "json"
                            });

                            request
                                .done(function(response){
                                    var rowTemplate = multiline(function(){/*!@preserve
                                    <tr data-id="@{{id}}" data-name="@{{ name }}" data-code="@{{code}}">
                                        <td>@{{name}}</td>
                                        <td>@{{code}}</td>
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
                                        message = 'The language <b>' + targetName + '</b> has been updated.'
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
                targetName = $targetRow.data('name'),
                targetCode = $targetRow.data('code')
            ;

            bootbox.confirm('Do you really want to remove the language <b>' + targetName + '</b>?', function(result){
                if(result){
                    showLoading();

                    var request = $.ajax({
                        url: laroute.route('admin.language.destroy', {language: targetId}),
                        method: "DELETE",
                    });

                    request
                        .done(function(response){
                            $targetRow.remove();

                            var message = '';
                            if(response
                            && response.success){
                                message = 'The language <b>' + targetName + ' ('+targetCode+')</b> has been removed.'
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
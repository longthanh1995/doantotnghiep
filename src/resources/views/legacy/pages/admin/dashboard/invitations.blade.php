@extends('legacy.layouts.admin.application')

@section('pageTitle', 'Manage Invitations')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Invitations</h3>

                    {{--<div class="box-tools">--}}
                        {{--<div class="input-group input-group-sm" style="width: 150px;">--}}
                            {{--<input name="table_search" class="form-control pull-right" placeholder="Search" type="text">--}}

                            {{--<div class="input-group-btn">--}}
                                {{--<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="table_invitations">
                        <thead>
                            <tr>
                                <th>Email</th>
                                {{--<th>Code</th>--}}
                                <th>Status</th>
                                <th>Expired at</th>
                                {{--<th>Created at</th>--}}
                                {{--<th>Updated at</th>--}}
                                <th>
                                    {{--Actions--}}
                                    <a href="#" class="btn btn-xs btn-primary" id="table_invitations__button_add">
                                        <i class="fa fa-plus"></i> Create
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($invitations as $invitation)
                            <tr data-id="{{$invitation['id']}}" data-email="{{$invitation['email']}}" data-status="{{$invitation['status']}}">
                                <td>{{$invitation['email']}}</td>
                                {{--<td>{{$invitation['code']}}</td>--}}
                                <td>
                                    <span class="label" data-type="invitation-status" data-status="{{$invitation['status']}}">{{$invitation['status']}}</span>
                                </td>
                                <td>
                                    {{$invitation['expiration']}}
                                </td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-danger" data-action="deactivate" title="Deactivate">
                                        <i class="fa fa-times"></i>
                                    </a>
                                    <a href="#" class="btn btn-xs btn-info" data-action="sendEmail" title="Send Email">
                                        <i class="fa fa-envelope"></i>
                                    </a>
                                    <a href="#" class="btn btn-xs btn-primary" data-action="activate" title="Activate">
                                        <i class="fa fa-check"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
<script type="text/javascript">
    var rowTemplate = multiline(function(){/*!@preserve
        <tr data-id="@{{invitation.id}}" data-email="@{{invitation.email}}" data-status="@{{invitation.status}}">
            <td>@{{invitation.email}}</td>
            {{--<td>{{$invitation['code']}}</td>--}}
            <td>
                <span class="label" data-type="invitation-status" data-status="@{{invitation.status']}}">@{{invitation.status}}</span>
            </td>
            <td>
                @{{invitation.expiration}}
            </td>
            <td>
                <a href="#" class="btn btn-xs btn-danger" data-action="deactivate" title="Deactivate">
                    <i class="fa fa-times"></i>
                </a>
                <a href="#" class="btn btn-xs btn-info" data-action="sendEmail" title="Send Email">
                    <i class="fa fa-envelope"></i>
                </a>
                <a href="#" class="btn btn-xs btn-primary" data-action="activate" title="Activate">
                    <i class="fa fa-check"></i>
                </a>
            </td>
        </tr>
    */console.log})

    $('#table_invitations__button_add')
            .on('click', function(event){
                event.preventDefault();

                var $modal = bootbox.dialog({
                    title: 'Create new invitation',
                    className: 'modal-create-new-invitation',
                    backdrop: true,
                    onEscape: true,
                    message: multiline(function(){/*!@preserve
                        <form class="form" data-is-submitting="0">
                            <div class="form-group">
                                <label for="invitation">Email address:</label>
                                <input class="form-control" name="email" type="text"/>
                                <p class="form-control-static"><i>A new invitation will be expired after 7 days.</i></p>
                            </div>
                        </form>
                    */console.log}),
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
                })

                $modal
                    .on('shown.bs.modal', function(){
                        var $form = $modal.find('form');

                        $form.validate({
                            rules: {
                                invitation: {
                                    required: true,
                                    validateEmail: ''
                                }
                            },
                            messages: {
                                invitation: {
                                    validateEmail: 'Invalid invitation format.'
                                }
                            },

                            errorElement: "p",
                            errorClass: "help-block",

                            errorPlacement: function(error, element) {
                                element.closest('div').append(error);
                            },

                            highlight: function(element) {
                                $(element).closest('.form-group').addClass('has-error');
                            },

                            unhighlight: function (element) {
                                $(element).closest('.form-group').removeClass('has-error');
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
                                    url: laroute.route('admin.invitations.store'),
                                    method: "POST",
                                    data: formData,
                                    dataType: "json"
                                });

                                request
                                    .done(function(response) {
                                        var html = swig.render(rowTemplate, {
                                            locals: {
                                                invitation: response
                                            }
                                        })

                                        $('#table_invitations tbody').append(html);

                                        var message = '';
                                        if(response
                                        && response.invitation
                                        && response.invitation.length){
                                            message = 'Email <b>' + response.invitation + '</b> has been invited.'
                                        } else {
                                            message = 'Request has been processed successfully.';
                                        }
                                        bootbox.alert(message, function(){
                                            $modal.modal('hide');
                                            hideLoading();
                                        });
                                    })
                                    .fail(function(e, data) {
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
                    .on('hidden.bs.modal', function(){

                    })
            })
    ;

    $('#table_invitations > tbody > tr')
        .on('click', '[data-action="activate"]', function(event){
            event.preventDefault();
            var $row = $(this).closest('tr'),
                id = $row.data('id'),
                email = $row.data('email')
                ;

            if(id){
                var $modal = bootbox.confirm({
                    message: "Are you sure you want to activate this invitation? An email will be send to corresponding email also.",
                    callback: function(result){
                        if(result){
                            showLoading();

                            var request = $.ajax({
                                url: laroute.route('admin.invitation.activate', {invitation: id}),
                                method: "POST",
                                data: $.param({id: id}),
                                dataType: "json"
                            });

                            request
                                .done(function(response) {
                                    if(response
                                        && response.success){
                                        bootbox.alert('Invitation for <b>' + email +'</b> has been activated!', function(){
//                                            $row
//                                                .attr('data-status', 'unused')
//                                                .find('[data-type="invitation-status"]')
//                                                .attr('data-status', 'unused')
//                                                .text('unused')
//                                            ;

                                            $row.replaceWith(swig.render(rowTemplate, {
                                                locals: {
                                                    invitation: response.data
                                                }
                                            }));

                                            hideLoading();
                                        })
                                    }
                                })
                                .fail(function(e, data) {
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
                    }
                })
            }
        })
        .on('click', '[data-action="deactivate"]', function(event){
            event.preventDefault();
            var $row = $(this).closest('tr'),
                id = $row.data('id'),
                email = $row.data('email')
                ;

            if(id){
                var $modal = bootbox.confirm({
                    message: "Are you sure you want to deactivate this invitation?",
                    callback: function(result){
                        if(result){
                            showLoading();

                            var request = $.ajax({
                                url: laroute.route('admin.invitation.deactivate', {invitation: id}),
                                method: "POST",
                                data: $.param({id: id}),
                                dataType: "json"
                            });

                            request
                                .done(function(response) {
                                    if(response
                                        && response.success){
                                        bootbox.alert('Invitation for <b>' + email +'</b> has been deactivated!', function(){
                                            $row
                                                .attr('data-status', 'deactivated')
                                                .find('[data-type="invitation-status"]')
                                                .attr('data-status', 'deactivated')
                                                .text('deactivated')
                                            ;
                                            hideLoading();
                                        })
                                    }
                                })
                                .fail(function(e, data) {
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
                    }
                })
            }
        })
        .on('click', '[data-action="sendEmail"]', function(event){
            event.preventDefault();
            var $row = $(this).closest('tr'),
                id = $row.data('id'),
                email = $row.data('email')
                ;

            if(id){
                var $modal = bootbox.confirm({
                    message: 'Do you want to re-send an invitation email to <b>' + email +'</b>?',
                    callback: function(result){
                        if(result){
                            showLoading();

                            var request = $.ajax({
                                url: laroute.route('admin.invitation.sendEmail', {invitation: id}),
                                method: "POST",
                                data: $.param({id: id}),
                                dataType: "json"
                            });

                            request
                                .done(function(response) {
                                    if(response
                                        && response.success){
                                        bootbox.alert('An invitation email was sent to <b>' + email +'</b>!', function(){
                                            hideLoading();
                                        })
                                    }
                                })
                                .fail(function(e, data) {
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
                    }
                })
            }
        })
    ;
</script>
@endpush
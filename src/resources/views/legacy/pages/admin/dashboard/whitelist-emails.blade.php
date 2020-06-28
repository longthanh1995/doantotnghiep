@extends('legacy.layouts.admin.application')

@section('pageTitle', 'Manage Whitelist emails')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Whitelist Emails</h3>

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
                    <table class="table table-hover" id="table_whitelist_emails">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>
                                    {{--Actions--}}
                                    <a href="#" class="btn btn-xs btn-primary" id="table_whitelist_emails__button_add">
                                        <i class="fa fa-plus"></i> Add
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($emails as $email)
                            <tr data-id="{{$email->id}}" data-email="{{$email->email}}">
                                <td>{{$email->email}}</td>
                                <td>
                                    {{--<a href="#" class="btn btn-xs btn-warning" data-action="edit">--}}
                                        {{--<i class="fa fa-edit"></i>--}}
                                        {{--Edit--}}
                                    {{--</a>--}}
                                    <a href="#" class="btn btn-xs btn-danger" data-action="remove">
                                        <i class="fa fa-times"></i> Remove
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
    $('#table_whitelist_emails__button_add')
            .on('click', function(event){
                event.preventDefault();

                var $modal = bootbox.dialog({
                    title: 'Add new whitelist email',
                    className: 'modal-add-new-whitelist-email',
                    backdrop: true,
                    onEscape: true,
                    message: multiline(function(){/*!@preserve
                        <form class="form" data-is-submitting="0">
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input class="form-control" name="email" type="text"/>
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
                                email: {
                                    required: true,
                                    validateEmail: ''
                                }
                            },
                            messages: {
                                email: {
                                    validateEmail: 'Invalid email format.'
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
                                    url: laroute.route('admin.whitelistEmail.store'),
                                    method: "POST",
                                    data: formData,
                                    dataType: "json"
                                });

                                request
                                    .done(function(response) {
                                        var html = '';

                                        //@TODO: will be better if we use a better template engine like swig
                                        html += '<tr data-id="'+response.id+'" data-email="'+response.email+'">';
                                        html += "<td>";
                                        html += response.email;
                                        html += "</td>";
                                        html += "<td>";
                                        html += "    <a href=\"#\" class=\"btn btn-xs btn-danger\" data-action=\"remove\">";
                                        html += "        <i class=\"fa fa-times\"><\/i>";
                                        html += "        Remove";
                                        html += "    <\/a>";
                                        html += "<\/td>";
                                        html += "</tr>";

                                        $('#table_whitelist_emails tbody').append(html);

                                        var message = '';
                                        if(response
                                        && response.email
                                        && response.email.length){
                                            message = 'Email <b>' + response.email + '</b> has been added to whitelist.'
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

    $('#table_whitelist_emails > tbody > tr')
        .on('click', '[data-action="remove"]', function(event){
            event.preventDefault();
            var $row = $(this).closest('tr'),
                id = $row.data('id'),
                email = $row.data('email')
            ;

            if(id){
                var $modal = bootbox.confirm({
                    size: 'small',
                    message: "Are you sure you want to remove this email?",
                    callback: function(result){
                        if(result){
                            showLoading();

                            var request = $.ajax({
                                url: laroute.route('admin.whitelistEmail.destroy'),
                                method: "DELETE",
                                data: $.param({id: id}),
                                dataType: "json"
                            });

                            request
                                .done(function(response) {
                                    if(response
                                    && response.success){
                                        bootbox.alert('<b>' + email +'</b> has been removed from whitelist!', function(){
                                            $row.remove();
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
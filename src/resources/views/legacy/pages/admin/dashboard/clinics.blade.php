@extends('legacy.layouts.admin.application')

@section('pageTitle', 'Manage Clinics')

@section('bodyClass', 'page-clinics page-clinics-index')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Clinics</h3>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="table_clinics">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>
                                {{--Actions--}}
                                <a href="#" class="btn btn-xs btn-primary" id="table_clinics__button_add">
                                    <i class="fa fa-plus"></i> Add
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                    @if($clinics)
                        @foreach($clinics as $clinic)
                            <tr
                                data-id="{{$clinic->id}}"
                                data-name="{{$clinic->name}}"
                            @if($clinic->deleted_at)
                                class="text-muted"
                            @endif
                            >
                                <td>{{$clinic->name}}</td>
                                <td>
                                @if($clinic->deleted_at)
                                    <a href="#" class="btn btn-xs btn-default" data-action="enable">
                                        <i class="fa fa-check"></i> Enable
                                    </a>
                                @else
                                    <a href="{{ route('admin.clinic.details', $clinic->id) }}" class="btn btn-xs btn-default" data-action="info">
                                            <i class="fa fa-info"></i> Info
                                        </a>
                                    <a href="#" class="btn btn-xs btn-danger" data-action="disable">
                                            <i class="fa fa-times"></i> Disable
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
    $('#table_clinics__button_add')
        .on('click', function(event){
            event.preventDefault();

            var template = multiline(function(){/*!@preserve
             <form class="form" data-is-submitting="0">
                <input type="hidden" name="admin_user_id" value="{{$authAdminUser->id}}"/>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" name="name" type="text"/>
                </div>
                <div class="form-group">
                    <label for="clinic_type_id">Clinic Type</label>
                    <select class="form-control" name="clinic_type_id">
                    {% for clinicType in clinicTypes %}
                        <option value="@{{clinicType.id}}">@{{clinicType.name|capitalize}}</option>
                    {% endfor %}
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" name="email" type="text"/>
                </div>
                <div class="form-group">
                    <label for="phone_country_code">Phone Number</label>
                    <div class="row">
                        <div class="col-xs-6">
                            <select class="form-control" name="phone_country_code">
                                <option value=""></option>
                            {% for country in countries %}
                                <option value="@{{country.phone_country_code}}">(@{{country.phone_country_code}}) @{{country.nice_name}}</option>
                            {% endfor %}
                            </select>
                        </div>
                        <div class="col-xs-6">
                            <input class="form-control" name="phone_number" type="text"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                            <label for="address">Address</label>
                            <input class="form-control" name="address" type="text"/>
                        </div>
                        <div class="col-xs-6">
                            <label for="location">Location</label>
                            <div class="input-group" id="input_group_map_marker">
                                <input class="form-control" name="locationLat" type="text" placeholder="Lat" style="width:50%"/>
                                <input class="form-control" name="locationLng" type="text" placeholder="Lng" style="width:50%"/>
                                <div class="input-group-addon btn btn-default" data-action="showMapPicker">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                            <label for="city">City</label>
                            <input class="form-control" name="city" type="text"/>
                        </div>
                        <div class="col-xs-6">
                            <label for="zip">Zip</label>
                            <input class="form-control" name="zip" type="text"/>
                        </div>
                    </div>
                </div><div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                            <label for="country_id">Country</label>
                            <select class="form-control" name="country_id">
                                <option value=""></option>
                            {% for country in countries %}
                                <option value="@{{country.id}}">@{{country.nice_name}}</option>
                            {% endfor %}
                            </select>
                        </div>
                        <div class="col-xs-6">
                            <label for="time_zone">Timezone</label>
                        <select class="form-control" name="time_zone">
                            <option value=""></option>
                        {% for timezone in timezones %}
                            <option value="@{{timezone}}">@{{timezone}}</option>
                        {% endfor %}
                        </select>
                        </div>
                    </div>

                </div>

                <legend>Legal Information</legend>
                <div class="form-group">
                    <input type="hidden" name="tax_profile[id]" value="" />
                    <div class="row">
                        <div class="col-xs-6">
                            <label for="input_tax_profile_name">Entity Name</label>
                            <input class="form-control" name="tax_profile[name]" value="" />
                        </div>
                        <div class="col-xs-6">
                            <label for="input_tax_profile_code">GST Registration Number</label>
                            <input class="form-control" name="tax_profile[code]" value="" />
                        </div>
                    </div>
                    <p class="form-control-static text-italic">
                        These information will be used to display &amp; calculate the GST Tax when invoicing patients. Leave both fields blank if you don't want it.
                    </p>
                </div>
            </form>
             */console.log});

            var message = swig.render(template, {
                locals: {
                    timezones: JSON.parse('{!! json_encode(timezone_identifiers_list()) !!}'),
                    countries: {!! $countries->toJson() !!},
                    clinicTypes: JSON.parse('{!! json_encode($clinicTypes, JSON_HEX_APOS) !!}'),
                }
            });

            var $modal = bootbox.dialog({
                title: 'Add new clinic',
                className: 'modal-add-new-clinic',
                backdrop: true,
                onEscape: true,
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
            })

            $modal
                .on('shown.bs.modal', function(){
                    var $form = $modal.find('form');

                    $form.validate({
                        rules: {
                            name: {
                                required: true,
                                minlength: 3
                            },
                            clinic_type_id: {
                                required: true,
                            },
                            email: {
                                required: true,
                                validateEmail: ''
                            },
                            phone_country_code: {
                                required: true
                            },
                            phone_number: {
                                required: true,
                                number: true
                            },
                            address: {
                                required: true
                            },
                            locationLat: {
                                number: true,
                                min: -90,
                                max: 90,
                            },
                            locationLng: {
                                number: true,
                                min: -180,
                                max: 180,
                            },
                            city: {
                                required: true
                            },
                            zip: {
                                required: true,
                                number: true
                            },
                            country_id: {
                                required: true
                            },
                            time_zone: {
                                required: true
                            }
                        },
                        messages: {
                            email: {
                                validateEmail: 'Invalid email format.'
                            },
                            locationLat: {
                                min: 'Please enter a latitude value greater than or equal to -90',
                                max: 'Please enter a latitude value less than or equal to 90',
                            },
                            locationLng: {
                                min: 'Please enter a longitude value greater than or equal to -180',
                                max: 'Please enter a longitude value less than or equal to 180',
                            },
                        },

                        errorElement: "p",
                        errorClass: "text-danger",

                        errorPlacement: function(error, element) {
                            console.log('error', error, $(error).attr('id'));
                            const errorId = $(error).attr('id');
                            console.log('error', errorId);
                            switch(errorId) {
                                case 'locationLat-error':
                                case 'locationLng-error':
                                    return element.closest('div').parent().append(error);
                                default:
                                    return element.closest('div').append(error);
                            }
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
                                url: laroute.route('admin.clinics.store'),
                                method: "POST",
                                data: formData,
                                dataType: "json"
                            });

                            request
                                .done(function(response) {
                                    var html = '';

                                    //@TODO: will be better if we use a better template engine like swig
                                    html += '<tr data-id="'+response.id+'" data-name="'+response.name+'">';
                                    html += "<td>";
                                    html += response.name;
                                    html += "</td>";
                                    html += "<td>";
                                    html += "    <a href=\""+laroute.route('admin.clinic.details', {clinic: response.id})+"\" class=\"btn btn-xs btn-default\" data-action=\"info\">";
                                    html += "        <i class=\"fa fa-info\"><\/i>";
                                    html += "        Info";
                                    html += "    <\/a>";
                                    html += "    <a href=\"#\" class=\"btn btn-xs btn-danger\" data-action=\"disable\">";
                                    html += "        <i class=\"fa fa-times\"><\/i>";
                                    html += "        Disable";
                                    html += "    <\/a>";
                                    html += "<\/td>";
                                    html += "</tr>";

                                    $('#table_clinics tbody').append(html);

                                    var message = '';
                                    if(response
                                        && response.email
                                        && response.email.length){
                                        message = 'Clinic <b>' + response.name + '</b> has been created.'
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

                    $('#input_group_map_marker')
                        .on('click', '[data-action=showMapPicker]', function(event){
                            event.preventDefault();

                            var $this = $(this);

                            //prevent double click
                            $this.prop('disabled', true);

                            setTimeout(function(){
                                $this.prop('disabled', false);
                            }, 1000);

                            var $modalMapPicker = bootbox.dialog({
                                title: 'Please choose your clinic location',
                                message: '<div id="segment_map_picker"></div>',
                                className: 'modal-map-picker',
                                buttons: {
                                    submit: {
                                        label: 'Set',
                                        className: 'btn btn-primary',
                                        callback: function(){
                                            console.log('set');
                                            $('.modal-add-new-clinic [name=locationLat]').val($('[data-lat]').data('lat'));
                                            $('.modal-add-new-clinic [name=locationLng]').val($('[data-lng]').data('lng'));
                                        }
                                    },
                                    cancel: {
                                        label: 'Cancel',
                                        className: 'btn btn-default',
                                        callback: function(){
                                            console.log('cancel');
                                        }
                                    }
                                }
                            });

                            $modalMapPicker
                                .on('shown.bs.modal', function(){
                                    manaDrApplication.emit('pageAdminClinicDetails/modalMapPicker/show', {
                                        lat: parseFloat($('[name=locationLat]').val()) || 0,
                                        lng: parseFloat($('[name=locationLng]').val()) || 0
                                    });
                                })
                        })
                    ;
                })
                .on('hidden.bs.modal', function(){

                })
        })
    ;

    $('#table_clinics')
        .on('click', 'tr [data-action="disable"]', function(event){
            event.preventDefault();
            var $row = $(this).closest('tr'),
                id = $row.data('id'),
                name = $row.data('name')
                ;

            if(id){
                var $modal = bootbox.confirm({
                    size: 'small',
                    message: "Are you sure you want to disable clinic <b>"+name+"</b>?",
                    callback: function(result){
                        if(result){
                            showLoading();

                            var request = $.ajax({
                                url: laroute.route('admin.clinic.destroy'),
                                method: "DELETE",
                                data: $.param({id: id}),
                                dataType: "json"
                            });

                            request
                                .done(function(response) {
                                    if(response
                                        && response.success){
                                        bootbox.alert('Clinic <b>' + name +'</b> has been disabled!', function(){
                                            window.location.reload();
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
        .on('click', 'tr [data-action="enable"]', function(event){
            event.preventDefault();
            var $row = $(this).closest('tr'),
                id = $row.data('id'),
                name = $row.data('name')
            ;

            if(id){
                var $modal = bootbox.confirm({
                    size: 'small',
                    message: "Are you sure you want to enable clinic <b>"+name+"</b>?",
                    callback: function(result){
                        if(result){
                            showLoading();

                            var request = $.ajax({
                                url: laroute.route('admin.clinic.enable'),
                                method: "POST",
                                data: $.param({id: id}),
                                dataType: "json"
                            });

                            request
                                .done(function(response) {
                                    if(response
                                        && response.success){
                                        bootbox.alert('Clinic <b>' + name +'</b> has been enabled!', function(){
                                            window.location.reload();
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
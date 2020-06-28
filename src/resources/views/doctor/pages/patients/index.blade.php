@extends('doctor.layouts.base')

@section('pageTitle'){{$authDoctor->name}} - Manage Patients @stop

@section('bodyClass', 'page-patients page-patients-index')

@section('contentHeader', 'Patients')

@section('contentHeaderSub')
    List all patients records that linked to your clinic
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Patients</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    {{--<h3 class="box-title">Patients</h3>--}}
                </div>

                <div class="box-body">
                    <form action="{{route('doctor.patient.search')}}" class="form" id="form_search_patients">
                        <div class="form-group col-md-4 col-md-offset-3">
                            <input type="text" class="form-control" id="form_search_patients__input_query" name="query" value="" placeholder="Enter patient's name, email..."/>
                        </div>
                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-primary btn-block" id="form_search_patients__submit">Search</button>
                        </div>
                    </form>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-hover" id="table_patients">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>National ID</th>
                            <th>Status</th>
                            <th>
                                {{--Actions--}}
                                {{--<a href="#" class="btn btn-xs btn-primary" id="table_patients__button_add">--}}
                                {{--<i class="fa fa-plus"></i> Add--}}
                                {{--</a>--}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="9">
                                <h4 class="text-center">
                                    Latest {{count($patients)}} patient records
                                </h4>
                            </td>
                        </tr>
                        @foreach($patients as $patient)
                            <tr data-id="{{$patient->id}}" data-name="{{$patient->getFullname()}}">
                                <td>
                                    {{$patient->id}}
                                </td>
                                <td>
                                    @if($patient->profileImage)
                                        <img
                                            class="img-rounded"
                                            src="{{($patient->profileImage)?$patient->profileImage->getThumbnailUrl():$patient->getDefaultAvatarUrl($patient->gender)}}"
                                            alt="{{($patient->profileImage)?$patient->name:"No image"}}"
                                            style="height:20px;vertical-align:top;"
                                        />
                                    @endif
                                    @if($patient->getFullname())
                                        {{$patient->getFullname()}}
                                    @elseif($patient->imported_name)
                                        <span data-toggle="tooltip" title="This value was imported from clinic"><i class="fa fa-sign-in"></i></span>
                                        {{$patient->imported_name}}
                                    @endif
                                </td>
                                <td>{{$patient->gender}}</td>
                                <td>{{$patient->date_of_birth ? $patient->date_of_birth->format('d-m-Y') : ""}}</td>
                                <td>
                                    @if($patient->account && $patient->account->email)
                                        <i class="fa fa-envelope"></i>
                                        {{$patient->account->email}}
                                    @elseif($patient->email)
                                        {{$patient->email}}
                                    @endif
                                </td>
                                <td>
                                    @if($patient->phone_country_code)
                                        ({{$patient->phone_country_code}})
                                    @endif
                                    {{$patient->phone_number}}
                                </td>
                                <td>{{$patient->id_number}}</td>
                                <td>
                                    {{--Linking status--}}
                                    @if($patient->users->count() == 1)
                                        <i class="fa fa-check" data-toggle="tooltip" title="Linked with an user"></i>
                                    @elseif($patient->users->count())
                                        <i class="fa fa-warning" data-toggle="tooltip" title="Linked with multiple users"></i> {{$patient->users->count()}}
                                    @endif
                                    {{--Deceased status--}}
                                    @if($patient->deceased)
                                        <i class="fa fa-user-times" data-toggle="tooltip" title="Deceased"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('doctor.patient.details', $patient->id) }}" class="btn btn-xs btn-default" data-action="info">
                                        <i class="fa fa-info"></i> Info
                                    </a>
                                </td>
                            </tr>
                        @if($patient->user->first())
                            <tr data-patient-id="{{$patient->id}}" class="sub">
                                <td>

                                </td>
                                <td>
                                    <i class="fa fa-mobile"></i>
                                    {{$patient->user->first()->pivot->first_name}}
                                    <b>{{$patient->user->first()->pivot->last_name}}</b>
                                </td>
                                <td>{{$patient->user->first()->pivot->gender}}</td>
                                <td>{{$patient->user->first()->pivot->date_of_birth?\Carbon\Carbon::parse($patient->user->first()->pivot->date_of_birth)->format('d-m-Y'):''}}</td>
                                <td>
                                    {{$patient->user->first()->pivot->email}}
                                </td>
                                <td></td>
                                <td>{{$patient->user->first()->pivot->id_number}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop



@push('customScripts')
<script type="text/javascript">
    $(function(){
//        $('#table_patients').DataTable();
    })

    var tableBodyTemplate = multiline(function(){/*!@preserve
    {% if patients.length > 0 %}
        {% for patient in patients %}
        <tr data-id="@{{patient.id}}">
            <td>
                @{{patient.id}}
            </td>
            <td>
            {% if (patient.profile_image_url && patient.profile_image_url.length) %}
                <img
                    class="img-rounded"
                    src="@{{patient.profile_image_url}}"
                    alt="@{{patient.name}}"
                    style="height:20px;vertical-align:top;"
                />
            {% endif %}
            {% if patient.full_name %}
                @{{ patient.full_name }}
            {% if patient.imported_name %}
                <span data-toggle="tooltip" title="Clinic imported value: @{{ patient.imported_name }}"><i class="fa fa-sign-in"></i></span>
            {% endif %}
            {% elseif patient.imported_name %}
                <span data-toggle="tooltip" title="This value was imported from clinic"><i class="fa fa-sign-in"></i></span>
                @{{patient.imported_name}}
            {% endif %}
            </td>
            <td>@{{patient.gender}}</td>
            <td>@{{patient.date_of_birth}}</td>
            <td>
            {% if patient.email || (patient.account && patient.account.email) %}
                {% if patient.account && patient.account.email %}
                    <i class="fa fa-envelope"></i>
                    @{{ patient.account.email }}
                {% else %}
                    @{{patient.email}}
                {% endif %}
                {% if patient.imported_email %}
                    <span data-toggle="tooltip" title="Clinic imported value: @{{patient.imported_email}}"><i class="fa fa-sign-in"></i></span>
                {% endif %}
            {% elseif patient.imported_email %}
                <span data-toggle="tooltip" title="This value was imported from clinic"><i class="fa fa-sign-in"></i></span>
                @{{patient.imported_email}}
            {% endif %}
            </td>
            <td>
            {% if (patient.phone_country_code && patient.phone_country_code.length) %}
                (@{{patient.phone_country_code}})
            {% endif %}
            {% if patient.phone_number %}
                @{{patient.phone_number}}
                {% if patient.imported_phone %}
                    <span data-toggle="tooltip" title="Clinic imported value: @{{patient.imported_phone}}"><i class="fa fa-sign-in"></i></span>
                {% endif %}
            {% elseif patient.imported_phone %}
                <span data-toggle="tooltip" title="This value was imported from clinic"><i class="fa fa-sign-in"></i></span>
                @{{patient.imported_phone}}
            {% endif %}

            </td>
            <td>@{{patient.id_number}}</td>
            <td>
            {% if (patient.users.length == 1) %}
                <i class="fa fa-check" data-toggle="tooltip" title="Linked with an user"></i>
            {% elseif (patient.users.length > 1) %}
                <i class="fa fa-warning" data-toggle="tooltip" title="Linked with multiple users"></i> @{{patient.users.length}}
            {% endif %}

            {% if (patient.deceased) %}
                <i class="fa fa-user-times" data-toggle="tooltip" title="Deceased"></i>
            {% endif %}
            </td>
            <td>
                <a href="@{{patientDetailsUrlBase}}/@{{ patient.id }}" class="btn btn-xs btn-default" data-action="info">
                    <i class="fa fa-info"></i> Info
                </a>
                <!--<a href="#" class="btn btn-xs btn-danger" data-action="remove">
                    <i class="fa fa-times"></i> Remove
                </a>-->
            </td>
        </tr>
        {% if patient.user %}
        <tr>
            <td></td>
            <td>
                <i class="fa fa-mobile"></i>
                @{{ patient.user.first_name }}
                <b>@{{ patient.user.last_name }}</b>
            </td>
            <td>
                @{{ patient.user.gender }}
            </td>
            <td>
                @{{ patient.user.date_of_birth | formatTimestamp4}}
            </td>
            <td>
                @{{ patient.user.email }}
            </td>
            <td>
                @{{ patient.user.phone_number }}
            </td>
            <td>
                @{{ patient.user.id_number }}
            </td>
            <td></td>
            <td></td>
        </tr>
        {% endif %}
        {% endfor %}
    {% else %}
        <tr>
            <td colspan="9">
                <h4 class="text-center">No results. Please use other query</h4>
            </td>
        </tr>
    {% endif %}
    */console.log});

    $(function(){
        $('#form_search_patients')
            .on('submit', function(event){
                event.preventDefault();

                var $form = $(this);

                var isSubmitting = parseInt($form.data('is-submitting'));

                if(isSubmitting){
                    return;
                }

                var formData = $form.serialize();

                manaDrApplication.emit('window/loading/show');

                $form.data('is-submitting', 1);
                $form.find(':input').prop('disabled', true);

                var request = $.ajax({
                    url: laroute.route('doctor.patient.search'),
                    method: "POST",
                    data: {
                        query: encodeURIComponent($('#form_search_patients__input_query').val())
                    },
                    dataType: "json"
                });

                request
                    .done(function(response) {
                        var html = swig.render(tableBodyTemplate, {
                            locals: {
                                patients: response.data,
                                patientDetailsUrlBase: '/patients'
                            }
                        });

                        $('#table_patients tbody').html(html);

                        $form.data('is-submitting', 0);
                        $form.find(':input').prop('disabled', false);
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
                            $form.find(':input').prop('disabled', false);
                        });
                    })
                    .always(function(){
                        manaDrApplication.emit('window/loading/hide');
                    })
                ;
            })
        ;
    })
</script>
@endpush
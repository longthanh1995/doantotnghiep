@extends('legacy.layouts.admin.application')

@section('pageTitle'){{$doctor->name}}@stop

@section('bodyClass', 'page-doctors page-doctors-details')

@section('header')
    {{$doctor->name}}
@stop

@section('subheader')
{{--    {{ucfirst($doctor->clinicType->name)}}--}}
@stop

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="box box-solid" id="box_info">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="box-title">Basic Information <small><a href="#" data-action="showModalUpdateBasicInformation"><i class="fa fa-pencil"></i></a></small></h4>
                            <dl class="dl-horizontal">
                                <dt>Title</dt>
                                <dd>{{$doctor->title?$doctor->title->title:''}}</dd>

                                <dt>Fullname</dt>
                                <dd><b>{{$doctor->name}}</b></dd>

                                <dt>Date of Birth</dt>
                                <dd>
                                    {{($doctor->date_of_birth)?$doctor->date_of_birth->format('d/m/Y'):''}}
                                </dd>

                                <dt>Gender</dt>
                                <dd>{{$doctor->gender}}</dd>

                                <dt>Languages</dt>
                                <dd>
                                    @foreach($doctor->languages as $language)
                                        {{$language->name}},
                                    @endforeach
                                </dd>

                                <dt>Profession IDs</dt>
                                <dd>
                                    @foreach($doctor->professions as $profession)
                                        <b>Name:</b> {{$profession->name}} - <b>License No:</b> {{$profession->license_no}}<br/>
                                    @endforeach
                                </dd>
                            </dl>
                        </div>

                        <div class="col-md-6">
                            <h4 class="box-title">Personal Contact <small><a href="#" data-action="showModalUpdatePersonalContact"><i class="fa fa-pencil"></i></a></small></h4>
                            <dl class="dl-horizontal">
                                <dt>Phone Number</dt>
                                <dd>
                                    {{$doctor->phone_country_code?'('.$doctor->phone_country_code.')':''}}
                                    {{$doctor->phone_number}}
                                </dd>

                                <dt>Contact Email</dt>
                                <dd class="text-overflow">
                                @if($doctor->account)
                                    <a href="mailto:{{$doctor->account->email}}">{{$doctor->account->email}}</a>
                                @elseif($doctor->email)
                                    <a href="mailto:{{$doctor->email}}">{{$doctor->email}}</a>
                                @else
                                    &nbsp;
                                @endif
                                </dd>

                                <dt>Website</dt>
                                <dd class="text-overflow">
                                    <a href="{{$doctor->website}}">{{$doctor->website}}</a>
                                </dd>

                                <dt>Address</dt>
                                <dd>
                                    {{$doctor->address}}
                                </dd>

                                <dt>Country</dt>
                                <dd>
                                    {{$doctor->country?$doctor->country->nice_name:''}}
                                </dd>

                                <dt>Office Hours</dt>
                                <dd>{!! $doctor->office_hours?nl2br(e($doctor->office_hours)):'' !!}</dd>
                            </dl>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="box-title">Medical Schools <small><a href="#" data-action="showModalUpdateMedicalSchools"><i class="fa fa-pencil"></i></a></small></h4>
                            <dl class="dl-horizontal">
                                @foreach($doctor->medicalSchools as $medicalSchool)
                                    <dt>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$medicalSchool->pivot->date_of_graduation)->format('d/m/Y')}}</dt>
                                    <dd>{{$medicalSchool->name}}</dd>
                                @endforeach
                            </dl>
                        </div>

                        <div class="col-md-6">
                            <h4 class="box-title">Qualifications <small><a href="#" data-action="showModalUpdateQualifications"><i class="fa fa-pencil"></i></a></small></h4>
                            <dl class="dl-horizontal">
                                @foreach($doctor->qualifications as $qualification)
                                    <dt>{{$qualification->issued_time->format('Y')}}</dt>
                                    <dd>{{$qualification->issuer}}</dd>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-3">
            <div class="box box-warning" id="box_clinics">
                <div class="box-header">
                    <h3 class="box-title">Working clinics</h3>
                </div>

                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                    @foreach($doctor->clinics as $clinic)
                        <li class="item" data-id="{{$clinic->id}}" data-name="{{$clinic->name}}">
                            <div class="product-img">
                                <img
                                    src="{{(sizeof($clinic->images))?$clinic->images[0]->getThumbnailUrl():''}}"
                                    {{--alt="{{($doctor->profileImage)?$doctor->name:"No image"}}"--}}
                                />
                            </div>
                            <div class="product-info">
                                <a class="product-title">{{$clinic->name}}</a>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>

            <div class="box box-primary" id="box_operations">
                <div class="box-header">
                    {{--<div class="box-tools pull-right">--}}
                        {{--<div class="btn-group">--}}
                            {{--<button aria-expanded="false" type="button" class="btn btn-box-tool dropdown-toggle"--}}
                                    {{--data-toggle="dropdown">--}}
                                {{--<i class="fa fa-plus"></i></button>--}}
                            {{--<ul class="dropdown-menu" role="menu">--}}
                                {{--<li><a href="#" data-action="assign">Assign</a></li>--}}
                                {{--<li><a href="#" data-action="register">Register</a></li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <h3 class="box-title">User-related Operations</h3>
                </div>

                <div class="box-body">
                @if($doctor->account && ($authAdminUser->hasRole('super_admin') || sizeof(array_intersect($doctor->clinics ? $doctor->clinics->pluck('id')->all() : [], $authAdminUser->clinics ? $authAdminUser->clinics->pluck('id')->all() : [])) > 0))
                    <ul class="products-list product-list-in-box">
                        <li class="item">
                            <a href="#" data-action="showModalChangePassword">Change password</a>
                        </li>
                        <li class="item">
                            <a href="#" data-action="showModalChangeAuthenticationPhoneNumber">Change authentication phone number</a>
                        </li>
                    </ul>
                @else
                    <p class="text-muted">This doctor hasn't been linked to any user record yet.</p>
                @endif
                </div>
            </div>

            <div class="box box-danger" id="box_working_calendar">
                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        <li class="item">
                            <a href="{{route('admin.doctor.workingCalendar.index', $doctor->id)}}">View Working Calendar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info" id="box_appointments">
                <div class="box-header">
                    <h3 class="box-title">Appointments</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-hover" id="table_appointments">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Doctor</th>
                            <th>Clinic</th>
                            <th>Status</th>
                            <th>
                                <span data-toggle="tooltip" data-title="Last status change time">
                                    <i class="fa fa-history"></i> Last status change time
                                </span>
                            </th>
                            <th>Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop



@push('scripts')
<script>
    $(function(){
        $('#table_appointments').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"{{$doctor->id}}/appointments",
                "dataFilter": function(data){
                    var json = jQuery.parseJSON( data );
                    json.recordsTotal = json.total;
                    json.recordsFiltered = json.total;
                    json.data = json.data;
                    return JSON.stringify( json );
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "appointment_type.name", "searchable": false, "defaultContent": "" },
                { "data": "doctor.name", "searchable": false },
                { "data": "clinic.name", "searchable": false },
                { "data": "appointment_status.name", "searchable": false },
                { "data": "last_updated_status_at", "searchable": false, "defaultContent": "" },
                { "data": "formated_time", "searchable": false },
            ],
            "columnDefs": [ 
                {
                "targets": 4,
                "data": "appointment_status_name",
                "render": function ( data, type, row, meta ) {
                        return '<span class="label" data-type="appointment-type" data-name="' + data + '">' + data + '</span>';
                    }
                },
                {
                    "targets": 0,
                    "data": "id",
                    "render": function ( data, type, row, meta ) {
                        return '<a href="/back-office/appointments/'+data+'">' + data +'</a>';
                    }
                },
            ]
        });

        $.fn.dataTable.ext.errMode = 'throw';
    })
</script>
@endpush

@push('dataScripts')
<script>
    //@TODO: Convert below to single conversion
    globalData.context.pageAdminDoctorDetails = {!! $pageData?$pageData:'{}' !!};
</script>
@endpush
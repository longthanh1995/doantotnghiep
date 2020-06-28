@extends('legacy.layouts.admin.application')

@section('pageTitle'){{$clinic->name}}@stop

@section('bodyClass', 'page-clinics page-clinics-details')

@section('header')
    {{$clinic->name}}
@stop

@section('subheader')
    {{ucfirst($clinic->clinicType->name)}}
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="box box-solid" id="box_info">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_information" data-toggle="tab">Information</a>
                        </li>
                        <li>
                            <a href="#tab_booking_fee_settings" data-toggle="tab">Booking Fee Settings</a>
                        </li>
                        <li>
                            <a href="#tab_appointment_types_settings" data-toggle="tab">Appointment Types Settings</a>
                        </li>
                        <li>
                            <a href="#tab_working_days_settings" data-toggle="tab">Working Days Settings</a>
                        </li>
                        <li>
                            <a href="#tab_other_settings" data-toggle="tab">Other Settings</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_information">
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-action="edit">
                                    <i href="#" class="fa fa-edit"></i>
                                </button>
                            </div>

                            <dl class="dl-horizontal">
                                <dt>Contact Email</dt>
                                <dd><a href="mailto:{{$clinic->email}}">{{$clinic->email}}</a></dd>
                                <dt>Phone Number</dt>
                                <dd>
                                    {{$clinic->phone_country_code?'('.$clinic->phone_country_code.')':''}}
                                    {{$clinic->phone_number}}
                                </dd>
                                <dt>Address</dt>
                                <dd>{{$clinic->address}}</dd>
                                <dt>City</dt>
                                <dd>{{$clinic->city}}</dd>
                                <dt>Country</dt>
                                <dd>{{$clinic->country?$clinic->country->nice_name:''}}</dd>
                                <dt>Zip Code</dt>
                                <dd>{{$clinic->zip}}</dd>
                                <dt>Timezone</dt>
                                <dd>{{$clinic->time_zone}}</dd>
                            </dl>

                            <h4>Legal Information</h4>
                            <dl class="dl-horizontal">
                                <dt>Entity Name</dt>
                                <dd>{{$clinic->taxProfile ? $clinic->taxProfile->name : ''}}</dd>

                                <dt>GST Registration Number</dt>
                                <dd>{{$clinic->taxProfile ? $clinic->taxProfile->code : ''}}</dd>
                            </dl>
                        </div>

                        <div class="tab-pane" id="tab_booking_fee_settings">
                            <form class="form" id="form_booking_fee_settings" data-is-submitting="0">
                                <div class="table-responsive">
                                    <table class="table" id="table_booking_fee_settings">
                                        <thead>
                                        <tr>
                                            <th>Appointment Type</th>
                                            @foreach($clinic->doctors as $doctor)
                                                <th>{{$doctor->name}}</th>
                                            @endforeach
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <tr>
                                            <td>Default <span data-toggle="tooltip" data-title="If a doctor's booking fee of individual appointment type is unset, this default value will be used instead."><i class="fa fa-info-circle"></i></span></td>
                                        @foreach($clinic->doctors as $doctor)
                                            <td class="cell cell-default">
                                                <div class="input-group">
                                                    <input type="text"
                                                           class="form-control"
                                                           placeholder="" value="{{isset($bookingFeeSettings[$doctor->id . '_' . 0 . '_amount'])?$bookingFeeSettings[$doctor->id . '_' . 0 . '_amount']:''}}"
                                                           name="booking_fee[{{$doctor->id}}][0][amount]"
                                                           autocomplete="off"
                                                           style="min-width:80px;"/>
                                                    <div class="input-group-btn" style="font-size:inherit">
                                                        <select class="form-control select2"
                                                                name="booking_fee[{{$doctor->id}}][0][currency]"
                                                                style="width: 100%;">
                                                            @foreach($MinSettingFees as $currency=>$minfee)
                                                                <option value="{{$currency}}"
                                                                    @if(isset($bookingFeeSettings[$doctor->id . '_' . 0 . '_currency']) && $bookingFeeSettings[$doctor->id . '_' . 0 . '_currency'] === $currency)
                                                                        selected="selected"
                                                                    @endif
                                                                >{{$currency}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>
                                        @endforeach
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td colspan="{{count($clinic->doctors)}}">Clinic-specific appointment types</td>
                                        </tr>
                                        @foreach($clinic->appointmentTypes as $appointmentType)
                                            <tr>
                                                <td>{{$appointmentType->name}}</td>
                                                @foreach($clinic->doctors as $doctor)
                                                    <td class="cell"
                                                    @if($bookingFeeSettings->has($doctor->id . '_' . $appointmentType->id . '_id'))
                                                        data-id="{{$bookingFeeSettings->get($doctor->id . '_' . $appointmentType->id . '_id')}}"
                                                    @endif
                                                    >
                                                    @if($bookingFeeSettings->has($doctor->id . '_' . $appointmentType->id . '_id'))
                                                        <input type="hidden" name="booking_fee[{{$doctor->id}}][{{$appointmentType->id}}][id]" value="{{$bookingFeeSettings->get($doctor->id . '_' . $appointmentType->id . '_id')}}" />
                                                    @endif
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <input type="checkbox"
                                                                       autocomplete="off"
                                                                       name="booking_fee[{{$doctor->id}}][{{$appointmentType->id}}][checkbox]"
                                                                   @if(isset($bookingFeeSettings[$doctor->id . '_' . $appointmentType->id . '_amount']))
                                                                       checked="checked"
                                                                   @endif
                                                                />
                                                            </span>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   placeholder=""
                                                                   value="{{isset($bookingFeeSettings[$doctor->id . '_' . $appointmentType->id . '_amount'])?$bookingFeeSettings[$doctor->id . '_' . $appointmentType->id . '_amount']:''}}"
                                                                   autocomplete="off"
                                                                   name="booking_fee[{{$doctor->id}}][{{$appointmentType->id}}][amount]"
                                                               @if(!isset($bookingFeeSettings[$doctor->id . '_' . $appointmentType->id . '_amount']))
                                                                   disabled="disabled"
                                                               @endif
                                                                   style="min-width:80px;"/>
                                                            <div class="input-group-btn" style="font-size:inherit">
                                                                <select class="form-control select2"
                                                                        name="booking_fee[{{$doctor->id}}][{{$appointmentType->id}}][currency]"
                                                                    @if(!isset($bookingFeeSettings[$doctor->id . '_' . $appointmentType->id . '_amount']))
                                                                       disabled="disabled"
                                                                   @endif
                                                                        style="width: 100%;">
                                                                    @foreach($MinSettingFees as $currency=>$minfee)
                                                                        <option value="{{$currency}}"
                                                                            @if(isset($bookingFeeSettings[$doctor->id . '_' . $appointmentType->id . '_currency']) && $bookingFeeSettings[$doctor->id . '_' . $appointmentType->id . '_currency'] === $currency)
                                                                                selected="selected"
                                                                            @endif
                                                                        >{{$currency}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @if($appointmentType->category == \App\Models\AppointmentType::CATEGORY_HOUSE_CALL)
                                                        <p class="form-control-static">
                                                            <a href="#"
                                                               data-action="manageSurchargeSettings"
                                                           @if(!$bookingFeeSettings->has($doctor->id . '_' . $appointmentType->id . '_id'))
                                                               class="text-muted"
                                                           @endif
                                                            >
                                                                <i class="fa fa-flash"></i> Surcharge settings
                                                            @if($bookingFeeSettings->has($doctor->id . '_' . $appointmentType->id . '_surcharge_settings'))
                                                                ({{$bookingFeeSettings[$doctor->id . '_' . $appointmentType->id . '_surcharge_settings']->count()}})
                                                            @endif
                                                            </a>
                                                        </p>
                                                    @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td colspan="{{count($clinic->doctors)}}">MaNaDr appointment types</td>
                                        </tr>
                                        @foreach($clinic->getGlobalAppointmentTypes() as $appointmentType)
                                            <tr>
                                                <td>{{$appointmentType->name}}</td>
                                                @foreach($clinic->doctors as $doctor)
                                                    <td class="cell">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <input type="checkbox"
                                                                       autocomplete="off"
                                                                       name="booking_fee[{{$doctor->id}}][{{$appointmentType->id}}][checkbox]"
                                                                   @if(isset($bookingFeeSettings[$doctor->id . '_' . $appointmentType->id . '_amount']))
                                                                       checked="checked"
                                                                   @endif
                                                                />
                                                            </span>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   placeholder=""
                                                                   value="{{isset($bookingFeeSettings[$doctor->id . '_' . $appointmentType->id . '_amount'])?$bookingFeeSettings[$doctor->id . '_' . $appointmentType->id . '_amount']:''}}"
                                                                   autocomplete="off"
                                                                   name="booking_fee[{{$doctor->id}}][{{$appointmentType->id}}][amount]"
                                                               @if(!isset($bookingFeeSettings[$doctor->id . '_' . $appointmentType->id . '_amount']))
                                                                   disabled="disabled"
                                                               @endif
                                                                   style="min-width:80px;"/>
                                                            <div class="input-group-btn" style="font-size:inherit">
                                                                <select class="form-control select2"
                                                                        name="booking_fee[{{$doctor->id}}][{{$appointmentType->id}}][currency]"
                                                                    @if(!isset($bookingFeeSettings[$doctor->id . '_' . $appointmentType->id . '_amount']))
                                                                       disabled="disabled"
                                                                   @endif
                                                                        style="width: 100%;">
                                                                    @foreach($MinSettingFees as $currency=>$minfee)
                                                                        <option value="{{$currency}}"
                                                                            @if(isset($bookingFeeSettings[$doctor->id . '_' . $appointmentType->id . '_currency']) && $bookingFeeSettings[$doctor->id . '_' . $appointmentType->id . '_currency'] === $currency)
                                                                                selected="selected"
                                                                            @endif
                                                                        >{{$currency}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        </tbody>

                                        <tfoot>
                                        <tr>
                                            <td class="text-right">
                                                <button type="reset" class="btn btn-default">Reset</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </td>
                                            <td colspan="{{count($clinic->doctors)}}"></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="tab_appointment_types_settings">

                            <h4>
                                Clinic-specific appointment types<br/>
                                <small>Timeslots of these appointment types can be created for your clinic only</small>
                            </h4>
                            <table class="table table-responsive" id="table_clinic_appointment_types">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th width="100" class="text-right">
                                        <a href="#" class="btn-box-tool" data-action="createAppointmentType" data-toggle="tooltip" data-title="Create new appointment type">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clinic->appointmentTypes as $appointmentType)
                                    <tr data-id="{{$appointmentType->id}}" data-name="{{$appointmentType->name}}" class="{{$appointmentType->is_active?'':'text-muted'}}">
                                        <td>
                                        @if($appointmentType->category == \App\Models\AppointmentType::CATEGORY_HOUSE_CALL)
                                            <i class="fa fa-home"></i>
                                        @endif
                                            {{$appointmentType->name}}
                                        </td>
                                        <td class="text-right">
                                        @if($appointmentType->category == \App\Models\AppointmentType::CATEGORY_HOUSE_CALL)
                                            <a href="#" class="btn-box-tool" data-action="manageHouseCallReasons" data-toggle="tooltip" data-title="Manage reasons">
                                                <i class="fa fa-list"></i>
                                            </a>
                                        @endif
                                            <a href="#" class="btn-box-tool" data-action="updateAppointmentType" data-toggle="tooltip" data-title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @if($appointmentType->is_active)
                                            <a href="#" class="btn-box-tool" data-action="deactivateAppointmentType" data-toggle="tooltip" data-title="Deactivate">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        @else
                                            <a href="#" class="btn-box-tool" data-action="activateAppointmentType" data-toggle="tooltip" data-title="Activate">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <h4>MaNaDr appointment types</h4>
                            <small></small>

                            <table class="table" id="table_global_appointment_types">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th width="70"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clinic->getGlobalAppointmentTypes() as $appointmentType)
                                    <tr>
                                        <td>
                                        @if($appointmentType->category == \App\Models\AppointmentType::CATEGORY_HOUSE_CALL)
                                            <i class="fa fa-home"></i>
                                        @endif
                                            {{$appointmentType->name}}
                                        </td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="tab_working_days_settings">
                            <h4>Notice</h4>
                            <p>
                                On Patient App, Patient can not see timeslot on your days off.<br/>
                                You still can book appointment on these days off from Dashboard.
                            </p>
                            <p>
                                <span class="pull-right">
                                    <a href="#" data-action="editWorkingWeekDays" data-working-week-days='{!! json_encode($clinic->working_week_days ? $clinic->working_week_days : []) !!}'>
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </span>
                                <b>Weekly working days:</b>
                            </p>
                            <ul class="list-inline" id="list_working_week_days">
                            @foreach([1, 2, 3, 4, 5, 6, 7] as $weekDayIndex)
                                <li>
                                @if(in_array($weekDayIndex, $clinic->working_week_days?$clinic->working_week_days:[]))
                                    <i class="fa fa-check"></i>
                                @else
                                    <i class="fa fa-times"></i>
                                @endif
                                    {{DateTimeHelper::getDayNameFromInteger($weekDayIndex)}}
                                </li>
                            @endforeach
                            </ul>

                            <h4>Holidays</h4>
                            <form class="form-form-horizontal" id="form_add_holiday">
                                <input type="hidden" name="clinic_id" value="{{$clinic->id}}" />
                                <div class="form-group">
                                    <div class="input-group" style="width:200px;">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input class="form-control" type="text" name="date">
                                        <span class="input-group-btn">
                                          <button type="submit" class="btn btn-primary">Add</button>
                                        </span>
                                      </div>
                                </div>
                            </form>
                            <ul class="list-inline" id="list_holidays">
                            @foreach($clinic->holidays as $holiday)
                                <li data-id="{{$holiday->id}}" data-date="{{$holiday->date->format('d/m/Y')}}">
                                    <h4>
                                        <span class="label label-default">
                                            {{$holiday->date->format('d/m/Y')}}
                                            <a href="#" data-action="removeHoliday">
                                                <i class="fa fa-times text-muted"></i>
                                            </a>
                                        </span>
                                    </h4>
                                </li>
                            @endforeach
                            </ul>
                        </div>

                        <div class="tab-pane" id="tab_other_settings">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"
                                           data-action="toggleQueueFeature"
                                       @if($clinic->isQueueFeatureEnabled())
                                           checked
                                       @endif
                                    />
                                    Show estimate delay time on Patient application
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box box-primary" id="box_doctors">
                <div class="box-header">
                    <div class="box-tools pull-right">
                        <div class="btn-group">
                            <button aria-expanded="false" type="button" class="btn btn-box-tool dropdown-toggle"
                                    data-toggle="dropdown">
                                <i class="fa fa-plus"></i></button>
                            <ul class="dropdown-menu" role="menu">
                            @if($authAdminUser->hasRole('super_admin'))
                                <li><a href="#" data-action="assign">Assign</a></li>
                            @endif
                                <li><a href="#" data-action="register">Register</a></li>
                            </ul>
                        </div>
                    </div>
                    <h3 class="box-title">Doctors/Dentists</h3>
                </div>

                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                    @foreach($clinic->doctors as $doctor)
                        <li class="item" data-id="{{$doctor->id}}" data-name="{{$doctor->name}}">
                            <div class="product-img">
                              <img
                                  src="{{($doctor->profileImage)?$doctor->profileImage->getThumbnailUrl():$doctor->getDefaultAvatarUrl($doctor->gender)}}"
                                  {{--alt="{{($doctor->profileImage)?$doctor->name:"No image"}}"--}}
                              >
                            </div>
                            <div class="product-info">
                                <a class="product-title" href="{{route('admin.doctor.details', $doctor->id)}}">{{$doctor->name}}
                                @if($doctor->title)
                                    <span class="label label-warning pull-right">{{$doctor->title->title}}</span>
                                @endif
                                </a>
                                <div class="product-description" style="overflow: visible">
                                    <div class="pull-right">
                                        <a href="{{route('admin.doctor.workingCalendar.index', $doctor->id)}}" target="_blank" class="btn btn-box-tool" data-toggle="tooltip" data-title="View Working Calendar">
                                            <i class="fa fa-calendar"></i>
                                        </a>
                                        <div class="btn-group">
                                            <button aria-expanded="false" type="button" class="btn btn-box-tool dropdown-toggle"
                                                    data-toggle="dropdown">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <ul class="dropdown-menu" role="menu" style="right:0;left:auto;">
                                                <li><a href="#" data-action="unassign">Unassign from Clinic</a></li>
                                                <li><a href="#" data-action="editSettings">Edit Settings</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="text-overflow" title="{{$doctor->email}}">{{$doctor->email}}</div>
                                </div>
                            </div>
                        </li>
                        <!-- /.item -->
                    @endforeach
                    </ul>
                </div>
            </div>

            <div class="box box-info" id="box_images">
                <div class="box-header">
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-action="add">
                            <i class="fa fa-plus"></i>
                        </button>

                    </div>
                    <h3 class="box-title">
                        Clinic Images
                        <small>(Recommend: PNG, Ratio: 3:2)</small>
                    </h3>
                </div>

                <div class="box-body">
                    <div class="row">
                    @foreach($clinic->images as $image)
                        <div class="col-xs-6 col-sm-3">
                            <div class="manadr card
                                @if($image->id == $clinic->profile_image_id)
                                    active
                                @endif
                                "
                                 data-id="{{$image->id}}">
                                <img class="img-responsive" src="{{$image->getThumbnailUrl()}}" alt=""/>
                                <div class="hover overlay">
                                    <div class="tools pull-right">
                                        <div class="btn-group">
                                            <button aria-expanded="false" type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <ul class="dropdown-menu" role="menu" style="right:0;left:auto;">
                                                <li><a href="#" data-action="remove">Remove</a></li>
                                                <li><a href="#" data-action="setThumbnail">Set as thumbnail</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>

        @if(
            ($clinic->name == 'Super Clinic' && $clinic->clinic_type_id == 4) &&
            ($authAdminUser->hasRole('super_admin') || $authAdminUser->clinics()->where(['name' => 'Super Clinic', 'clinic_type_id' => 4])->count() > 0)
        )
            <div class="box box-danger" id="box_super_clinic_data">
                <div class="box-body">
                    <a href={{ route('admin.superClinic') }}>
                        <i class="fa fa-user-secret"></i>
                        <span>Super Clinic Data</span>
                    </a>
                </div>
            </div>
        @endif

        </div>
    </div>

    <div id="segment_map_picker2" style="width: 500px; height: 300px"></div>
@stop

@push('dataScripts')
<script>
    //@TODO: Convert below to single conversion
    globalData.context.pageAdminClinicDetails = {!! $pageData?$pageData:'{}' !!};
</script>
@endpush

@push('scripts')
<script type="text/javascript">
    var modalUpdateBookingFeeSettingTemplate = multiline(function(){/*!@preserve
    <form class="form">
        <input type="hidden" name="clinic_id" value="@{{clinicId}}" />
        <input type="hidden" name="doctor_id" value="@{{ doctorId }}" />
        <div class="form-group">
            <label class="control-label">Doctor</label>
            <p class="form-control-static">@{{doctorName}}</p>
        </div>
        <div class="form-group">
            <label class="control-label">Amount</label>
            <input class="form-control" name="fee_amount" value="@{{ feeAmount }}"/>
        </div>
        <div class="form-group">
            <label class="control-label">Currency</label>
            <input class="form-control" name="fee_currency" value="@{{ feeCurrency }}"/>
        </div>
    </form>
    */console.log});

    $(function(){
        $('#box_info')
            .on('click', '[data-action=edit]', function(event){
                event.preventDefault();

                var template = multiline(function(){/*!@preserve
                 <form class="form" data-is-submitting="0">
                 <input type="hidden" name="admin_user_id" value="{{$authAdminUser->id}}"/>
                 <input type="hidden" name="id" value="{{$clinic->id}}"/>
                 <div class="form-group">
                 <label for="name">Name</label>
                 <input class="form-control" name="name" type="text" value="{{$clinic->name}}"/>
                 </div>
                 <div class="form-group">
                 <label for="clinic_type_id">Clinic Type</label>
                 <select class="form-control" name="clinic_type_id">
                 {% for clinicType in clinicTypes %}
                 <option
                 value="@{{clinicType.id}}"
                 {% if (clinicType.id == {{$clinic->clinic_type_id}}) %}
                 selected
                 {% endif %}
                 >@{{clinicType.name|capitalize}}</option>
                 {% endfor %}
                 </select>
                 </div>
                 <div class="form-group">
                 <label for="email">Email</label>
                 <input class="form-control" name="email" type="text" value="{{$clinic->email}}"/>
                 </div>
                 <div class="form-group">
                 <label for="phone_country_code">Phone Number</label>
                 <div class="row">
                 <div class="col-xs-6">
                 <select class="form-control" name="phone_country_code">
                 <option value=""></option>
                 {% for country in countries %}
                 <option
                 value="@{{country.phone_country_code}}"
                 {% if (country.phone_country_code == {{$clinic->phone_country_code}}) %}
                 selected
                 {% endif %}
                 >(@{{country.phone_country_code}}) @{{country.nice_name}}</option>
                 {% endfor %}
                 </select>
                 </div>
                 <div class="col-xs-6">
                 <input class="form-control" name="phone_number" type="text" value="{{$clinic->phone_number}}"/>
                 </div>
                 </div>
                 </div>
                 <div class="form-group">
                 <div class="row">
                 <div class="col-xs-6">
                 <label for="address">Address</label>
                 <input class="form-control" name="address" type="text" value="{{$clinic->address}}"/>
                 </div>
                 <div class="col-xs-6">
                 <label for="location">Location</label>
                 <div class="input-group" id="input_group_map_marker">
                    <input class="form-control" name="locationLat" type="text" placeholder="Lat" value="{{array_key_exists(1,$clinic->location)?$clinic->location[1]:''}}" style="width:50%"/>
                    <input class="form-control" name="locationLng" type="text" placeholder="Lng" value="{{array_key_exists(0,$clinic->location)?$clinic->location[0]:''}}" style="width:50%"/>
                    <div class="input-group-addon btn btn-default" data-action="showMapPicker">
                        <i class="fa fa-map-marker"></i>
                    </div>
                 </div>
                 </div>
                 </div>
                 </div>
                 </div>

                 <div class="form-group">
                 <div class="row">
                 <div class="col-xs-6">
                 <label for="city">City</label>
                 <input class="form-control" name="city" type="text" value="{{$clinic->city}}"/>
                 </div>
                 <div class="col-xs-6">
                 <label for="zip">Zip</label>
                 <input class="form-control" name="zip" type="text" value="{{$clinic->zip}}"/>
                 </div>
                 </div>
                 </div><div class="form-group">
                 <div class="row">
                 <div class="col-xs-6">
                 <label for="country_id">Country</label>
                 <select class="form-control" name="country_id">
                 <option value=""></option>
                 {% for country in countries %}
                 <option
                 value="@{{country.id}}"
                 {% if (country.id == {{$clinic->country_id}}) %}
                 selected
                 {% endif %}
                 >@{{country.nice_name}}</option>
                 {% endfor %}
                 </select>
                 </div>
                 <div class="col-xs-6">
                 <label for="time_zone">Timezone</label>
                 <select class="form-control" name="time_zone">
                 <option value=""></option>
                 {% for timezone in timezones %}
                 <option
                 value="@{{timezone}}"
                 {% if (timezone == '{{$clinic->time_zone}}') %}
                 selected
                 {% endif %}
                 >@{{timezone}}</option>
                 {% endfor %}
                 </select>
                 </div>
                 </div>
                 </div>
                    <legend>Legal Information</legend>
                    <div class="form-group">
                        <input type="hidden" name="tax_profile[id]" value="{{$clinic->tax_profile_id}}" />
                        <div class="row">
                            <div class="col-xs-6">
                                <label for="input_tax_profile_name">Entity Name</label>
                                <input class="form-control" name="tax_profile[name]" value="{{$clinic->taxProfile ? $clinic->taxProfile->name : ''}}" />
                            </div>
                            <div class="col-xs-6">
                                <label for="input_tax_profile_code">GST Registration Number</label>
                                <input class="form-control" name="tax_profile[code]" value="{{$clinic->taxProfile ? $clinic->taxProfile->code : ''}}" />
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
                    title: 'Update clinic information',
                    className: 'modal-update-clinic-information',
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
                });

                $modal
                    .on('shown.bs.modal', function() {
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
                                    url: laroute.route('admin.clinic.update'),
                                    method: "POST",
                                    data: formData,
                                    dataType: "json"
                                });

                                request
                                    .done(function(response) {
                                        var message = '';
                                        if(response
                                            && response.name){
                                            message = 'Information of clinic <b>' + response.name + '</b> has been updated.'
                                        } else {
                                            message = 'Request has been processed successfully.';
                                        }
                                        bootbox.alert(message, function(){
//                                        $modal.modal('hide');
//                                        hideLoading();
                                            window.location.reload();
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
                                                $('.modal-update-clinic-information [name=locationLat]').val($('[data-lat]').data('lat'));
                                                $('.modal-update-clinic-information [name=locationLng]').val($('[data-lng]').data('lng'));
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
                ;
            })
            .on('click', '[data-action=updateBookingFeeSetting]', function(event){
                event.preventDefault();

                var $targetRow = $(this).closest('tr'),
                    targetDoctorId = $targetRow.data('doctor-id'),
                    targetDoctorName = $targetRow.data('doctor-name'),
                    targetFeeAmount = $targetRow.data('fee-amount'),
                    targetFeeCurrency = $targetRow.data('fee-currency')
                ;


                if(!targetDoctorId){
                    return false;
                }

                var message = swig.render(modalUpdateBookingFeeSettingTemplate, {
                    locals: {
                        clinicId: "{{$clinic->id}}",
                        doctorId: targetDoctorId,
                        doctorName: targetDoctorName,
                        feeAmount: targetFeeAmount,
                        feeCurrency: targetFeeCurrency
                    }
                });

                var $modal = bootbox.dialog({
                    title: 'Update Booking Fee Setting',
                    className: 'modal-update-booking-fee-setting',
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
                });

                $modal
                    .on('shown.bs.modal', function(){
                        var $form = $modal.find('form');

                        $form.validate({
                            rules: {
                                doctor_id: {
                                    required: true,
                                    min: 1
                                },
                                clinic_id: {
                                    required: true,
                                    min: 1
                                },
                                fee_amount: {
                                    required: true,
                                    number: true
                                },
                                fee_currency: {
                                    required: true
                                }
                            },
                            messages: {
                                doctor_id: {
                                    min: 'You have to choose a doctor'
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
                                    url: laroute.route('admin.clinic.updateBookingFeeSetting'),
                                    method: "POST",
                                    data: formData,
                                    dataType: "json"
                                });

                                request
                                    .done(function(response){
                                        var message = '';
                                        if(response
                                            && response.data){
                                            message = 'Fee setting for doctor <b>' + targetDoctorName + '</b> updated!'
                                        } else {
                                            message = 'Request has been processed successfully.';
                                        }
                                        bootbox.alert(message, function(){
                                            window.location.reload();
                                            /*$modal.modal('hide');
                                             hideLoading();*/
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
                    .on('hidden.bs.modal', function(){})
                ;
            })
        ;
    });
</script>
<script type="text/javascript">
    $(function(){
        $('#box_doctors')
            .on('click', '[data-action=assign]', function(event){
                event.preventDefault();

                var template = multiline(function(){/*!@preserve
                 <form class="form" data-is-submitting="0">
                 <div class="form-group">
                 <label for="doctor_id">Clinic</label>
                 <p class="form-control-static">
                    {{$clinic->name}}
                    </p>
                     </div>
                     <div class="form-group">
                     <label for="doctor_id">Doctor</label>
                     <select class="form-control" name="doctor_id">
                     <option value="0" selected>Select a doctor</option>
                     {% for doctor in unassignedDoctors %}
                     <option value="@{{doctor.id}}">@{{doctor.name}}</option>
                     {% endfor %}
                     </select>
                     </div>
                     <input type="hidden" name="clinic_id" value="{{ $clinic->id }}"/>
                     </form>
                     */console.log});

                var message = swig.render(template, {
                    locals: {
                        unassignedDoctors: {!! json_encode($unassignedDoctors, JSON_HEX_APOS) !!}
                    }
                });

                var $modal = bootbox.dialog({
                    title: 'Assign new doctor to this clinic',
                    className: 'modal-assign-doctor',
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
                });

                $modal
                    .on('shown.bs.modal', function(){
                        var $form = $modal.find('form');

                        $form.find('[name=doctor_id]').chosen({
                            search_contains: true
                        });

                        $form.validate({
                            rules: {
                                doctor_id: {
                                    required: true,
                                    min: 1
                                }
                            },
                            messages: {
                                doctor_id: {
                                    min: 'You have to choose a doctor'
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
                                    url: laroute.route('admin.clinic.assignDoctor'),
                                    method: "POST",
                                    data: formData,
                                    dataType: "json"
                                });

                                request
                                    .done(function(response){
                                        var template = multiline(function(){/*!@preserve
                                         <li class="item">
                                         <div class="product-img">
                                         <img
                                         src="@{{doctor.profileImage.fullUrl}}"
                                         >
                                         </div>
                                         <div class="product-info">
                                         <a href="/back-office/doctors/@{{ doctor.id }}" class="product-title">@{{doctor.name}}
                                            <span class="label label-warning pull-right">@{{doctor.title.title}}</span>
                                             </a>
                                             <span class="product-description">
                                             <div class="pull-right">
                                             <div class="btn-group">
                                             <button aria-expanded="false" type="button" class="btn btn-box-tool dropdown-toggle"
                                             data-toggle="dropdown">
                                             <i class="fa fa-pencil"></i></button>
                                             <ul class="dropdown-menu" role="menu" style="right:0;left:auto;">
                                             <li><a href="#" data-action="unassign">Unassign from Clinic</a></li>
                                             <li><a href="#" data-action="editSettings">Edit Settings</a></li>
                                             </ul>
                                             </div>
                                             </div>
                                            @{{doctor.email}}
                                            </span>
                                             </div>
                                             </li>
                                             */console.log});

                                        var html = swig.render(template, {
                                            locals: response.data
                                        })

                                        $('#box_doctors .box-body .products-list').append(html);

                                        var message = '';
                                        if(response
                                            && response.data){
                                            var doctor = response.data.doctor;
                                            message = 'Doctor <b>' + doctor.name + '</b> has been assigned to clinic {{$clinic->name}}.'
                                        } else {
                                            message = 'Request has been processed successfully.';
                                        }
                                        bootbox.alert(message, function(){
                                            window.location.reload();
                                            /*$modal.modal('hide');
                                             hideLoading();*/
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
                    .on('hidden.bs.modal', function(){})
                ;
            })
            .on('click', '[data-action=register]', function(event){
                event.preventDefault();

                var template = multiline(function(){/*!@preserve
                 <form class="form" data-is-submitting="0">
                 <div class="form-group">
                 <label for="doctor_id">Clinic</label>
                 <p class="form-control-static">
                    {{$clinic->name}}
                    </p>
                     </div>
                     <div class="form-group">
                     <label for="name">Name</label>
                     <input class="form-control" name="name" type="text"/>
                     </div>
                     <div class="form-group">
                     <label for="email">Email</label>
                     <input class="form-control" name="email" type="text"/>
                     </div>
                     <div class="form-group">
                     <label for="password">Password</label>
                     <input class="form-control" name="password" type="password"/>
                     </div>
                     <input type="hidden" name="clinic_id" value="{{ $clinic->id }}"/>
                     </form>
                     */console.log});

                var message = swig.render(template, {
                    locals: {

                    }
                });
                var $modal = bootbox.dialog({
                    title: 'Register new doctor for this clinic',
                    className: 'modal-register-new-doctor',
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
                });

                $modal
                    .on('shown.bs.modal', function(){
                        var $form = $modal.find('form');

                        $form.validate({
                            rules: {
                                name: {
                                    required: true,
                                    minlength: 3,
                                    maxlength: 255
                                },

                                email: {
                                    required: true,
                                    email: true
                                },

                                password: {
                                    required: true,
                                    minlength: 6,
                                    maxlength: 255
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
                                    url: laroute.route('admin.clinic.registerDoctor'),
                                    method: "POST",
                                    data: formData,
                                    dataType: "json"
                                });

                                request
                                    .done(function(response){
                                        var template = multiline(function () {/*!@preserve
                                         <li class="item" data-id="@{{doctor.id}}">
                                         <div class="product-img">
                                         <img
                                         src="@{{doctor.profileImage.fullUrl}}"
                                         >
                                         </div>
                                         <div class="product-info">
                                         <a href="/back-office/doctors/@{{ doctor.id }}" class="product-title">@{{doctor.name}}
                                            <span class="label label-warning pull-right">@{{doctor.title.title}}</span>
                                             </a>
                                             <span class="product-description">
                                             <div class="pull-right">
                                             <div class="btn-group">
                                             <button aria-expanded="false" type="button" class="btn btn-box-tool dropdown-toggle"
                                             data-toggle="dropdown">
                                             <i class="fa fa-pencil"></i></button>
                                             <ul class="dropdown-menu" role="menu" style="right:0;left:auto;">
                                             <li><a href="#" data-action="unassign">Unassign from Clinic</a></li>
                                             <li><a href="#" data-action="editSettings">Edit Settings</a></li>
                                             </ul>
                                             </div>
                                             </div>
                                            @{{doctor.email}}
                                            </span>
                                             </div>
                                             </li>
                                             */console.log});

                                        var html = swig.render(template, {
                                            locals: response.data
                                        })

                                        $('#box_doctors .box-body .products-list').append(html);

                                        var message = '';
                                        if(response
                                            && response.data){
                                            var doctor = response.data.doctor;
                                            message = 'Doctor <b>' + doctor.name + '</b> has been registered & assigned to clinic {{$clinic->name}}.'
                                        } else {
                                            message = 'Request has been processed successfully.';
                                        }
                                        bootbox.alert(message, function(){
                                            window.location.reload();
                                            /*$modal.modal('hide');
                                             hideLoading();*/
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
                    .on('hidden.bs.modal', function(){})
                ;
            })
            .on('click', '[data-action=edit]', function(event){
                event.preventDefault();

                var template = multiline(function(){/*!@preserve
                 Edit
                 */console.log});

                var message = swig.render(template, {
                    locals: {

                    }
                });

                var $modal = bootbox.dialog({
                    title: 'Edit doctor details'
                });
            })
            .on('click', '[data-action=unassign]', function(event){
                event.preventDefault();

                var $item = $(this).closest('.item[data-id]'),
                    doctorId = $item.data('id'),
                    doctorName = $item.data('name')
                    ;

                if(!doctorId){
                    return;
                }

                var message = 'Do you really want to remove <b>' + doctorName + '</b> from {{$clinic->name}}?';

                var $modal = bootbox.confirm(message, function(result){
                    if(!result){
                        return;
                    }

                    showLoading();

                    var requestData = $.param({
                        doctor_id: doctorId,
                        clinic_id: '{{$clinic->id}}'
                    });

                    var request = $.ajax({
                        url: laroute.route('admin.clinic.unassignDoctor'),
                        method: "POST",
                        data: requestData,
                        dataType: "json"
                    });

                    request
                        .done(function(response){
                            console.log('unassignDoctor response', response);

                            $('#box_doctors .box-body .products-list .item[data-id="'+doctorId+'"]').remove();

                            var message = '';
                            if(response
                                && response.success){
                                message = 'Doctor <b>' + doctorName + '</b> has been unassigned to clinic {{$clinic->name}}.'
                            } else {
                                message = 'Request has been processed successfully.';
                            }
                            bootbox.alert(message, function(){
                                window.location.reload();
                                /*$modal.modal('hide');
                                 hideLoading();*/
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
                });
            })
            .on('click', '[data-action=editSettings]', function(event){
                event.preventDefault();

                var $item = $(this).closest('.item[data-id]'),
                    doctorId = $item.data('id'),
                    doctorName = $item.data('name')
                    ;

                if(doctorId){
                    showLoading();
                    var requestData = $.param({
                        doctor_id: doctorId,
                        clinic_id: '{{$clinic->id}}'
                    });

                    var requestDoctorAppointmentTypesSettings = $.ajax({
                        url: laroute.route('admin.clinic.fetchDoctorsAppointmentTypeSettings'),
                        method: "POST",
                        data: requestData,
                        dataType: "json"
                    });

                    requestDoctorAppointmentTypesSettings
                        .done(function(response){
                            console.log('test', response);

                            var template = multiline(function(){/*!@preserve
                             <form class="form" data-is-submitting="0" id="form_edit_appointment_type_settings">
                             <input type="hidden" name="clinic_id" value="{{ $clinic->id }}"/>
                             <input type="hidden" name="doctor_id" value="@{{ doctor.id }}"/>
                             <div class="form-group">
                             <label>Doctor</label>
                             <p class="form-control-static">
                                @{{doctor.name}}
                                </p>
                                 </div>
                                 <div class="form-group">
                                 <div class="row">
                                 <div class="col-xs-5">
                                 <label>Appointment Type</label>
                                 </div>
                                 <div class="col-xs-4">
                                 <label>Duration (minute)</label>
                                 </div>
                                 </div>
                                 </div>
                                 {% for appointmentTypeSetting in doctorAppointmentTypeSettings %}
                                 <div class="form-group">
                                 <div class="row">
                                 <div class="col-xs-5">
                                 <p class="form-control-static">
                                @{{appointmentTypeSetting.name}}
                                </p>
                                 </div>
                                 <div class="col-xs-4">
                                 <select name="appointmentTypes[@{{ appointmentTypeSetting.id }}]" class="form-control" data-appointment-type-id="@{{ appointmentTypeSetting.id }}">
                                 <option value="0">0 (Disable)</option>
                                 {% for duration in Array(60) %}
                                 <option
                                 value="@{{loop.index}}"
                                 {% if (loop.index == appointmentTypeSetting.pivot.duration) %}
                                 selected
                                 {% endif %}
                                 >@{{loop.index}}</option>
                                 {% endfor %}
                                 </select>
                                 </div>
                                 <!--<div class="col-xs-3">
                                 <button class="btn btn-danger" data-action="remove">
                                 <i class="fa fa-times"></i>
                                 Remove
                                 </button>
                                 </div>-->
                                 </div>
                                 </div>
                                 {% endfor %}
                                 </form>
                                 <form class="form" id="form_add_appointment_type_setting">
                                 <div class="form-group">
                                 <label>Set other appointment type</label>
                                 </div>
                                 <div class="form-group">
                                 <div class="row">
                                 <div class="col-xs-5">
                                 <select class="form-control" name="appointmentTypeId">
                                 <option value=""></option>
                                 {% for appointmentType in appointmentTypes %}
                                 <option value="@{{appointmentType.id}}">@{{appointmentType.name}}</option>
                                 {% endfor %}
                                 </select>
                                 </div>
                                 <div class="col-xs-4">
                                 <select class="form-control" name="duration">
                                 <option value="0">0 (Disable)</option>
                                 {% for duration in Array(60) %}
                                 <option
                                 value="@{{loop.index}}"
                                 >@{{loop.index}}</option>
                                 {% endfor %}
                                 </select>
                                 </div>
                                 <div class="col-xs-3">
                                 <button class="btn btn-primary" type="submit">
                                 <i class="fa fa-plus"></i>
                                 Add
                                 </button>
                                 </div>
                                 </div>
                                 </div>
                                 </form>
                                 */console.log});

                            var templateSingleOption = multiline(function(){/*!@preserve
                             <div class="form-group">
                             <div class="row">
                             <div class="col-xs-5">
                             <p class="form-control-static">
                                @{{appointmentTypeSetting.name}}
                                </p>
                                 </div>
                                 <div class="col-xs-4">
                                 <select name="appointmentTypes[@{{ appointmentTypeSetting.id }}]" class="form-control" data-appointment-type-id="@{{ appointmentTypeSetting.id }}">
                                 {% for duration in Array(60) %}
                                 <option
                                 value="@{{loop.index}}"
                                 {% if (loop.index == appointmentTypeSetting.duration) %}
                                 selected
                                 {% endif %}
                                 >@{{loop.index}}</option>
                                 {% endfor %}
                                 </select>
                                 </div>
                                 <!--<div class="col-xs-3">
                                 <a class="btn btn-danger" data-action="remove">
                                 <i class="fa fa-times"></i>
                                 Remove
                                 </a>
                                 </div>-->
                                 </div>
                                 </div>
                                 */console.log});

                            var message = swig.render(template, {
                                locals: $.extend({},response.data, {
                                    doctor: {
                                        id: doctorId,
                                        name: doctorName
                                    }
                                })
                            });

                            var $modal = bootbox.dialog({
                                title: 'Edit doctor\'s appointment types\' settings',
                                className: 'modal-edit-doctor-appointment-type-settings',
                                backdrop: true,
                                onEscape: true,
                                message: message,
                                buttons: {
                                    submit: {
                                        label: 'Submit',
                                        className: 'btn btn-primary',
                                        callback: function(){
                                            var $form = $('#form_edit_appointment_type_settings');

                                            $form.submit();

                                            return false;
                                        }
                                    }
                                }
                            });

                            $modal
                                .on('shown.bs.modal', function(){
                                    hideLoading();

                                    var $formEditSettings = $('#form_edit_appointment_type_settings'),
                                        $formAddSettings = $('#form_add_appointment_type_setting')
                                        ;

                                    //hide existed appointment type settings
                                    function hideExistedAppointmentTypeSettings(){
                                        $formAddSettings.find('[name=appointmentTypeId] option.hide').removeClass('hide');

                                        $formEditSettings.find('select[data-appointment-type-id]')
                                            .each(function(){
                                                var id = $(this).data('appointment-type-id'),
                                                    $removingOption = $formAddSettings.find('[name=appointmentTypeId] option[value="'+id+'"]')
                                                    ;

                                                if($removingOption.length){
                                                    $removingOption
                                                        .addClass('hide')
                                                        .prop('selected', false)
                                                    ;
                                                }
                                            })
                                        ;
                                    }

                                    hideExistedAppointmentTypeSettings();

                                    $formAddSettings
                                        .on('submit', function(event){
                                            event.preventDefault();

                                            var $selectedAppointmentType = $formAddSettings.find('[name=appointmentTypeId] :selected'),
                                                selectedAppointmentTypeId = $selectedAppointmentType.val(),
                                                selectedAppointmentTypeName = $selectedAppointmentType.text(),
                                                $selectedDuration = $formAddSettings.find('[name=duration] :selected'),
                                                selectedDuration = $selectedDuration.val()
                                                ;

                                            //validate

                                            if(!selectedAppointmentTypeId){
                                                return;
                                            }

                                            var html = swig.render(templateSingleOption, {
                                                locals: {
                                                    appointmentTypeSetting: {
                                                        id: selectedAppointmentTypeId,
                                                        name: selectedAppointmentTypeName,
                                                        duration: selectedDuration
                                                    }
                                                }
                                            });

                                            $formEditSettings.append(html);

                                            hideExistedAppointmentTypeSettings();
                                        })
                                    ;

                                    $formEditSettings
                                        .on('click', '[data-action=remove]', function(event){
                                            event.preventDefault();

                                            $(this).closest('.form-group').remove();

                                            hideExistedAppointmentTypeSettings();
                                        })
                                        .on('submit', function(event){
                                            event.preventDefault();

                                            var $form = $formEditSettings;

                                            var isSubmitting = parseInt($form.data('is-submitting'));

                                            if(isSubmitting){
                                                return;
                                            }

                                            var formData = $form.serialize();

                                            showLoading();
                                            $form.data('is-submitting', 1);
                                            $modal.find(':input').prop('disabled', true);

                                            var request = $.ajax({
                                                url: laroute.route('admin.clinic.updateDoctorsAppointmentTypeSettings'),
                                                method: "POST",
                                                data: formData,
                                                dataType: "json"
                                            });

                                            request
                                                .done(function(updateResponse) {
                                                    var message = '';
                                                    if(updateResponse){
                                                        message = 'Appointment type settings of doctor <b>' + doctorName + '</b> has been updated.'
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
                                                .always(function(){})
                                            ;
                                        })
                                    ;
                                })
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
            })
        ;
    });
</script>
<script type="text/javascript">
    var clinicImageTemplate = multiline(function(){/*!@preserve
        <div class="col-md-3">
            <div class="manadr card" data-id="@{{image.id}}">
                <img class="img-responsive" src="@{{image.fullUrl}}" alt=""/>
                <div class="hover overlay">
                    <div class="tools pull-right">
                        <div class="btn-group">
                    <button aria-expanded="false" type="button" class="btn btn-box-tool dropdown-toggle"
                            data-toggle="dropdown">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu" style="right:0;left:auto;">
                        <li><a href="#" data-action="remove">Remove</a></li>
                        <li><a href="#" data-action="setThumbnail">Set as thumbnail</a></li>
                    </ul>
                </div>
                    </div>
                </div>
            </div>
        </div>
    */console.log});
    $(function(){
        $('#box_images [data-action=add]')
            .dropzone({
                acceptedFiles: '.jpg, .jpeg, .png',
                paramName: 'image',
                previewsContainer: false,
                clickable: true,
                url: laroute.route('admin.clinic.addImage', {clinic: {{$clinic->id}}}),
                autoProcessQueue: true,
                params: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                processing: function(){
                    manaDrApplication.emit('window/loading/show');
                },
                complete: function(){
                    manaDrApplication.emit('window/loading/hide');
                },
                error: function(file, errorMessage){
                    bootbox.alert('Error occurred: ' + errorMessage)
                },
                success: function(file, response){
                    var html = swig.render(clinicImageTemplate, {
                        locals: {
                            image: {
                                id: response.newImageId,
                                fullUrl: response.newImageUrl
                            }
                        }
                    });

                    $('#box_images .box-body > .row').append(html);
                    $.notify({message: 'Clinic image added successfully'},{ type: 'success'});
                }
            })
        ;

        $('#box_images')
            .on('click', '[data-action=add] i', function(event){
                $(this).parent().click();
                return false;
            })
            .on('click', '[data-action=remove]', function(event){
                event.preventDefault();

                var $imageCard = $(this).closest('.manadr.card'),
                    $imageBlock = $imageCard.parent(),
                    imageId = $imageCard.data('id')
                ;

                if(!imageId
                    || !imageId.length){
                    return;
                }

                bootbox.confirm('Do you really want to remove this image?', function(result){
                    if(result){

                        manaDrApplication.emit('window/loading/show');

                        var request = $.ajax({
                            url: laroute.route('admin.clinic.removeImage', {clinic: {{$clinic->id}}}),
                            method: "POST",
                            data: {
                                imageId: imageId
                            }
                        });

                        request
                            .done(function(response) {
                                message = 'Request has been processed successfully.';
                                bootbox.alert(message, function(){
//                                        $modal.modal('hide');
//                                        hideLoading();
                                    $imageBlock.remove();
                                    manaDrApplication.emit('window/loading/hide');
//                                    window.location.reload();
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
                                    manaDrApplication.emit('window/loading/hide')
                                });
                            })
                            .always(function(){

                            })
                        ;
                    }
                })
            })
            .on('click', '[data-action=setThumbnail]', function(event){
                event.preventDefault();

                var $imageCard = $(this).closest('.manadr.card'),
                    $imageBlock = $imageCard.parent(),
                    imageId = $imageCard.data('id')
                ;

                if(!imageId
                    || !imageId.length){
                    return;
                }

                bootbox.confirm('Do you really want to set this image as clinic\'s thumbnail?', function(result){
                    if(result){

                        manaDrApplication.emit('window/loading/show');

                        var request = $.ajax({
                            url: laroute.route('admin.clinic.setThumbnail', {clinic: {{$clinic->id}}}),
                            method: "POST",
                            data: {
                                imageId: imageId
                            }
                        });

                        request
                            .done(function(response) {
                                message = 'Request has been processed successfully.';
                                bootbox.alert(message, function(){
//                                        $modal.modal('hide');
//                                        hideLoading();
                                    $imageCard.addClass('active');
                                    $imageBlock.siblings().find('.active').removeClass('active');
                                    manaDrApplication.emit('window/loading/hide');
//                                    window.location.reload();
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
                                    manaDrApplication.emit('window/loading/hide')
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
</script>
@endpush
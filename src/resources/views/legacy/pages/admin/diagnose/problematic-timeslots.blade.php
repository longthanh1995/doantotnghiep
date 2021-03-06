@extends('legacy.layouts.admin.application')

@section('pageTitle', 'Find problem timeslots - System Diagnose')

@section('header', 'Reactivate timeslots with cancelled appointment')

@section('subheader', ' ')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default" id="box_timeslots">
                    <div class="box-header">
                        <h3 class="box-title">Booked timeslots but still available</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th></th>
                                <th>#ID</th>
                                <th>Doctor</th>
                                <th>Start - End</th>
                                <th>Other values</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bookedButAvailableTimeslots as $doctorTimetable)
                                <tr data-id="{{$doctorTimetable->id}}">
                                    <td rowspan="2">
                                        <input type="checkbox"/>
                                    </td>
                                    <td rowspan="2">
                                        {{$doctorTimetable->id}}
                                    </td>
                                    <td>
                                        {{$doctorTimetable->doctor?$doctorTimetable->doctor->name:'?'}}
                                    </td>
                                    <td>
                                        {{$doctorTimetable->start_at->format('d/m/Y')}}
                                        {{$doctorTimetable->start_at->tz('UTC')->setTimezone(($doctorTimetable->clinic)?$doctorTimetable->clinic->time_zone:'UTC')->format('H:i')}}
                                        -
                                        {{$doctorTimetable->end_at->setTimezone(($doctorTimetable->clinic)?$doctorTimetable->clinic->time_zone:'UTC')->format('H:i P')}}
                                    </td>
                                    <td rowspan="2">
                                        <ul>
                                            <li>
                                                <code>available</code>: <code>{{$doctorTimetable->available}}</code>
                                            </li>
                                            <li>
                                                <code>is_booked</code>: <code>{{$doctorTimetable->is_booked}}</code>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="no-padding">
                                        <table class="table no-margin">
                                            <tbody>
                                            @foreach($doctorTimetable->appointments as $appointment)
                                                <tr>
                                                    <td class="col-xs-1">
                                                        {{$appointment->id}}
                                                    </td>
                                                    <td class="col-xs-7">
                                                        {{$appointment->patient?$appointment->patient->getFullname():''}}
                                                    </td>
                                                    <td class="col-xs-4">
                                                    @if($appointment->appointmentStatus)
                                                        <span class="label" data-type="appointment-type" data-name="{{$appointment->appointmentStatus->name}}">{{$appointment->appointmentStatus->name}}</span>
                                                    @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="#" class="btn btn-default" data-action="block">Block selected timeslots</a>
                        </div>
                    </div>
                </div>

                <div class="box box-primary hide" id="box_selected_patients">
                    <div class="box-header">
                        <h3 class="box-title">

                        </h3>
                    </div>
                    <div class="box-body"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $('#box_timeslots')
        .on('click', '[data-action=block]', function(event){
            event.preventDefault();

            var timeslotIds = _.map($('#box_timeslots table tr[data-id] input:checked'), function(input){
                return $(input).closest('tr').data('id');
            });

            if(!timeslotIds.length){
                return;
            }

            bootbox.confirm('Are you sure you want to lock selected timeslots?', function(result){
                if(result){
                    showLoading();

                    var request = $.ajax({
                        url: laroute.route('admin.diagnose.blockTimeslots'),
                        method: "POST",
                        data: {
                            ids: timeslotIds
                        },
                        dataType: "json"
                    });

                    request
                        .done(function(response){
                            console.log(response);
                        })
                        .always(function(){
//                            hideLoading();
                            window.location.reload();
                        })
                    ;
                }
            });
        })
</script>
@endpush
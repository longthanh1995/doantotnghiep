@extends('legacy.layouts.admin.application')

@section('pageTitle', 'Reactivate timeslots with cancelled appointments - System Diagnose')

@section('header', 'Reactivate timeslots with cancelled appointments')

@section('subheader', ' ')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default" id="box_timeslots">
                    <div class="box-header">
                        <h3 class="box-title">List all doctor timeslots with cancelled appointments</h3>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>#ID</th>
                                <th>Doctor</th>
                                <th>Start - End</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($doctorTimetables as $doctorTimetable)
                                <tr data-id="{{$doctorTimetable->id}}">
                                    <td>
                                        <input type="checkbox"/>
                                    </td>
                                    <td>
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
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="#" class="btn btn-default" data-action="unblock">Unblock selected timeslots</a>
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
        .on('click', '[data-action=unblock]', function(event){
            event.preventDefault();

            var timeslotIds = _.map($('#box_timeslots table tr[data-id] input:checked'), function(input){
                return $(input).closest('tr').data('id');
            });

            if(!timeslotIds.length){
                return;
            }

            bootbox.confirm('Are you sure you want to unlock selected timeslots?', function(result){
                if(result){
                    showLoading();

                    var request = $.ajax({
                        url: laroute.route('admin.diagnose.unblockTimeslots'),
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
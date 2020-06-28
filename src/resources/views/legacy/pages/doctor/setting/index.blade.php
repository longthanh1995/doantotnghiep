@extends('legacy.layouts.doctor.appLayout')

@section('pageHeader')
    <h1>Settings</h1>
@stop

@section('content')
    <div id="profileSection" class="SettingIndexPage">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-profile">
                    <div class="panel-heading">
                        <i class="fa fa-fw fa-bar-chart"></i>

                        Appointment Type
                    </div>

                    <div class="panel-body">
                        @if (session('errorWhenSubmit'))
                            <div class="alert alert-warning" role="alert">
                                {{ session('errorWhenSubmit') }}
                            </div>
                        @endif

                        @if (session('appointmentTypeSuccess'))
                            <div class="alert alert-success" role="alert">
                                {{ session('appointmentTypeSuccess') }}
                            </div>
                        @endif

                        {!! Form::open(['route' => 'setting.appointmentTypeSubmit']) !!}
                            <table class="table table-no-borered" id="table-appointment-type">
                                <thead>
                                    <tr>
                                        <th width="50%">Appointment Type</th>
                                        <th width="50%">Duration</th>
                                        {{--<th width="33%">Action</th>--}}
                                    </tr>
                                </thead>

                                <tbody>
                                    @if (count($doctorAppointmentTypes) > 0)
                                        @foreach ($doctorAppointmentTypes as $doctorAppointmentType)
                                            <tr>
                                                <td>
                                                    {!! Form::hidden('appointment_type_id[]', $doctorAppointmentType->pivot->appointment_type_id) !!}
                                                    {{$doctorAppointmentType->name}}
                                                </td>

                                                <td>
                                                    {!! Form::select('appointment_type_duration[]', $listDurations, $doctorAppointmentType->pivot->duration, [
                                                        'class' => 'form-control'
                                                    ]) !!}
                                                </td>

                                                {{--<td>--}}
                                                    {{--<button type="button" class="btn btn-danger btn-sm btn-delete-appointment-type">Delete</button>--}}
                                                {{--</td>--}}
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                            <button type="button" class="btn btn-sm btn-primary btn-add-new-appointment-type">
                                                <i class="fa fa-fw fa-plus"></i> Add
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>

                            <hr />

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts-template')
<script id="appointment-create-template" type="x-tmpl-mustache">
    <tr>
        <td>
            {!! Form::select('appointment_type_id[]', $appointmentTypesArr, null, [
                'class' => 'form-control'
            ]) !!}
        </td>

        <td>
            {!! Form::select('appointment_type_duration[]', $listDurations, null, [
                'class' => 'form-control'
            ]) !!}
        </td>
    </tr>
</script>
@endpush

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".btn-add-new-appointment-type").on('click', function (e) {
                e.preventDefault();

                var template = $("#appointment-create-template").html();

                $("#table-appointment-type").find("tbody").append(template);
            });

            if ($("#table-appointment-type").find("tbody tr").length == 0) {
                $(".btn-add-new-appointment-type").trigger('click');
            }

            $("#table-appointment-type").on('click', '.btn-delete-appointment-type', function (e) {
                e.preventDefault();

                $(this).closest('tr').remove();
            });
        });
    </script>
@endpush
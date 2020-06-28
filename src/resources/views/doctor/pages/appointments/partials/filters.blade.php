<div class="box box-primary" id="box_filters">
    <div class="box-header">
        <div class="box-tools pull-right no-print">
            @if(request()->get('appointmentBooking'))
                @if(!request()->get('print'))
                    <a class="btn btn-box-tool" data-toggle="tooltip" data-placement="bottom" title="Print mode" href="{{route(Route::currentRouteName(), \Request::all() + ['print' => 1])}}">
                        <i class="fa fa-print"></i>
                    </a>
                @endif
            @else
                <a class="btn btn-box-tool" data-toggle="tooltip" data-placement="bottom" title="Print mode only available when you filter by a specific date">
                <span class="fa-stack">
                    <i class="fa fa-print fa-stack-1x"></i>
                    <i class="fa fa-ban fa-stack-2x"></i>
                </span>
                </a>
            @endif
        </div>
        <h3 class="box-title">
            Filters
        </h3>
    </div>

    <form role="form" id="form_appointments_list_filters" action="{{ URL::current() }}" method="GET">
        <div class="box-body">
            <div class="form-group">
                <label for="form_appointments_list_filters__patient_name">Patient's Name:</label>
                {!! Form::text('patientName', request()->get('patientName'), [
                    'id' => 'form_appointments_list_filters__patient_name',
                    'class' => 'form-control',
                    'placeholder' => 'Patient\'s Name'
                ]) !!}
            </div>
            <div class="form-group">
                <label for="form_appointments_list_filters__patient_id_number">Patient's ID Number:</label>
                {!! Form::text('patientNationalIdNumber', request()->get('patientNationalIdNumber'), [
                    'id' => 'form_appointments_list_filters__patient_id_number',
                    'class' => 'form-control',
                    'placeholder' => 'Patient\'s National ID Number'
                ]) !!}
            </div>
            <div class="form-group">
                <label for="form_appointments_list_filters__clinic">Clinic</label>
                {!! Form::select('clinic', $doctorClinicsOption, request()->get('clinic', 'default'), [
                    'class' => 'form-control',
                    'id' => 'form_appointments_list_filters__clinic'
                ]) !!}
            </div>
            <div class="form-group">
                <label for="form_appointments_list_filters__date">Date</label>
                {!! Form::text('appointmentBooking', request()->get('appointmentBooking'), [
                    'class' => 'datepicker form-control',
                    'id' => 'form_appointments_list_filters__date',
                    'placeholder' => 'Click to pick a date',
                    'readonly' => 'readonly'
                ]) !!}
            </div>
            <div class="form-group no-print">
                @if(request()->get('print'))
                    <a class="btn btn-block btn-success" href="javascript:window.print()">Print</a>
                @else
                    <button type="submit" class="btn btn-block btn-primary">Apply</button>
                @endif
            </div>
        </div>
    </form>
</div>

@push('customScripts')
<script>
    $(function(){
        $('#form_appointments_list_filters')
            .on('submit', function(){
                $('.box-appointments-list .overlay')
                    .removeClass('hide')
                ;
            })
        ;

        $('#form_appointments_list_filters__date')
            .datepicker({
                format: 'dd/mm/yyyy',
                weekStart: 1,
                disableTouchKeyboard: true,
                autoclose: true,
                orientation: "bottom",
                todayBtn: 'linked',
                clearBtn: true
            })
        ;
    });
</script>
@endpush
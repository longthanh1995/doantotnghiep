<div id="appointment-search">
    <form id="formSearch" method="GET" action="{{ URL::current() }}">
        <table class="table table-bordered appointment-search-form">
            <tbody>
                <tr>
                    <td class="appointment-search-form-content">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group @if ($errors->has('patientName')) has-error @endif">
                                    <label for="name">Patient's name</label>

                                    {!! Form::text('patientName', request()->get('patientName'), [
                                        'id' => 'patientName',
                                        'class' => 'form-control',
                                        'placeholder' => 'Patient Name'
                                    ]) !!}

                                    @if ($errors->has('patientName'))
                                        @foreach ($errors->get('patientName') as $error)
                                            <p class="help-block">{{ $error }}</p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group @if ($errors->has('patientNationalIdNumber')) has-error @endif">
                                    <label for="patientNationalIdNumber">Patient's National ID Number</label>

                                    {!! Form::text('patientNationalIdNumber', request()->get('patientNationalIdNumber'), [
                                        'id' => 'patientNationalIdNumber',
                                        'class' => 'form-control',
                                        'placeholder' => 'Patient\'s National ID Number'
                                    ]) !!}

                                    @if ($errors->has('patientNationalIdNumber'))
                                        @foreach ($errors->get('patientNationalIdNumber') as $error)
                                            <p class="help-block">{{ $error }}</p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group @if ($errors->has('clinic')) has-error @endif">
                                    <label for="clinic">Clinic</label>

                                    {!! Form::select('clinic', $doctorClinicsOption, request()->get('clinic', 'default'), ['class' => 'form-control']) !!}

                                    @if ($errors->has('clinic'))
                                        @foreach ($errors->get('clinic') as $error)
                                            <p class="help-block">{{ $error }}</p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group @if ($errors->has('appointmentBooking')) has-error @endif">
                                    <label for="appointmentBooking">Appointment Booking</label>

                                    {!! Form::text('appointmentBooking', request()->get('appointmentBooking'), [
                                        'class' => 'datepicker form-control',
                                        'id' => 'appointmentBooking',
                                        'placeholder' => 'Click to pick a date',
                                        'readonly' => 'readonly'
                                    ]) !!}

                                    @if ($errors->has('appointmentBooking'))
                                        @foreach ($errors->get('appointmentBooking') as $error)
                                            <p class="help-block">{{ $error }}</p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table appointment-search-buttons">
            <tbody>
                <tr>
                    <td class="text-left">
                        With those filters, we have <b>{{ $appointments->total() }} records</b>.

                        (<a href="{{ URL::current() }}">Clear all filters.</a>)
                    </td>

                    <td class="text-right">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".datepicker").datepicker({
                format: 'dd/mm/yyyy',
                weekStart: 1,
                disableTouchKeyboard: true,
                autoclose: true,
                orientation: "bottom",
            });
        });
    </script>
@endpush
<div class="box box-solid box-appointments-list">
    <div class="box-header">
        <div class="box-tools pull-right">
        @if($type === 'confirmedBooking')
            <form class="form form-inline" style="display: inline-block;width: auto;">
                <select class="form-control" name="sortOption">
                    <option value="1">Latest booking time</option>
                    <option value="2" {{ app('request')->input('sortOption') == 2 ? "selected" : null }}>Oldest booking time</option>
                    <option value="3" {{ app('request')->input('sortOption') == 3 ? "selected" : null }}>Latest appointment time</option>
                    <option value="4" {{ app('request')->input('sortOption') == 4 ? "selected" : null }}>Oldest appointment time</option>
                </select>
            </form>
        @endif
            <div class="btn-group">
                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-download"></i> Download
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="{{route('appointment.export.xls', $queries)}}">
                            <i class="fa fa-file-excel-o"></i>
                            As Excel (.xls)
                        </a>
                    </li>
                    <li>
                        <a href="{{route('appointment.export.pdf', $queries)}}">
                            <i class="fa fa-file-pdf-o"></i>
                            As PDF (.pdf)
                        </a>
                    </li>
                </ul>
            </div>

        </div>
        <h3 class="box-title">
            Results
            @if($appointments->total())
                <small>
                    ({{$appointments->total()}} records)
                </small>
            @endif
        </h3>
    </div>

    <div class="box-body">
        @if (count($appointments) > 0)
            <ul class="products-list product-list-in-box">
                @foreach ($appointments as $appointment)
                    {!! Form::open([
                        'route' => ['appointment.cancelSubmit', $appointment->id],
                        'id' => 'appointment-cancel-'.$appointment->id
                    ]) !!}
                    <input type="hidden" id="cancelReasonField" name="cancel_reason"/>
                    {!! Form::close() !!}

                    {!! Form::open([
                        'route' => ['appointment.markAsLateSubmit', $appointment->id],
                        'id' => 'appointment-mark-as-late-'.$appointment->id
                    ]) !!}
                    {!! Form::close() !!}

                    {!! Form::open([
                            'route' => ['appointment.markAsNoShowSubmit', $appointment->id],
                            'id' => 'appointment-mark-as-no-show-'.$appointment->id
                        ]) !!}
                    {!! Form::close() !!}

                    {!! Form::open([
                        'route' => ['appointment.visitSubmit', $appointment->id],
                        'id' => 'appointment-visit-'.$appointment->id
                    ]) !!}
                    {!! Form::close() !!}

                    @include('doctor.pages.appointments.partials.appointmentsList-item', [
                        'appointment' => $appointment,
                        'type' => $type
                    ])


                @endforeach
            </ul>

            <div class="clearfix text-center">
                {!! $appointments->appends(\Request::except('page'))->render() !!}
            </div>
        @else
            <p class="text-center">
                There's no appointment with these criterias
            </p>
        @endif
    </div>

    <div class="overlay hide">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
</div>

@push('customScripts')
<script>
    $(function () {
        $('.box-appointments-list')
            .on('click', '[data-action=markVisited]', function (e) {
                e.preventDefault();

                var appointmentId = $(this).data('appointment-id'),
                    hasHealthSummary = parseInt($(this).data('has-health-summary'));

                bootbox.confirm("Are you sure that the patient has already visited?", function (result) {
                    if (result) {
                        if (!hasHealthSummary) {
                            manaDrApplication.emit('modalHealthSummary/showAdd', {
                                appointmentId: appointmentId,
                                doneCallback: function () {
                                    var $form = $("#appointment-visit-" + appointmentId);

                                    $form.submit();
                                }
                            });
                        } else {
                            var $form = $("#appointment-visit-" + appointmentId);

                            $form.submit();
                        }
                    }
                });


            })
            .on('click', '[data-action=cancel]', function (e) {
                e.preventDefault();

                var appointmentId = $(this).data('appointment-id');

                var box = bootbox.dialog({
                    message: 'Are you sure to cancel this appointment? This action cannot undo. <hr />' +
                    '<form class="form-horizontal">' +
                    '<div class="form-group"> ' +
                    '<label class="col-md-3 control-label" for="name">Reason</label> ' +
                    '<div class="col-md-8"> ' +
                    '<textarea class="form-control" id="cancelReasonTextArea"></textarea> ' +
                    '<span class="help-block">Please give me your reason.</span> </div> ' +
                    '</div> ' +
                    '</form>',
                    title: "Cancel Appointment",
                    buttons: {
                        danger: {
                            label: "Yes, I'm sure",
                            className: "btn-danger",
                            callback: function () {
                                var $form = $("#appointment-cancel-" + appointmentId);
                                var cancelReason = $('#cancelReasonTextArea').val();

                                $form.find('#cancelReasonField').val(cancelReason);
                                $form.submit();
                            }
                        },
                        cancel: {
                            label: "No, I'm not sure",
                            className: "btn-default"
                        }
                    }
                });

                box.on("shown.bs.modal", function () {
                    $('#cancelReasonTextArea').focus();
                });
            })
            .on('click', '[data-action=markAsLate]', function(event) {
                event.preventDefault();

                var $this = $(this),
                    appointmentId = $this.data('appointment-id'),
                    patientName = $this.data('patient-name'),
                    appointmentTime = $this.data('appointment-time')
                ;

                var box = bootbox.dialog({
                    message: 'Patient name: ' + patientName + '<br/>'
                    + 'Appointment time: ' + appointmentTime,
                    title: "You are going to mark this appointment as <b>Late</b>",
                    buttons: {
                        cancel: {
                            label: "Cancel",
                            className: "btn-default"
                        },
                        confirm: {
                            label: "Confirm",
                            className: "btn-primary",
                            callback: function() {
                                var $form = $("#appointment-mark-as-late-" + appointmentId);
                                $form.submit();
                            }
                        }
                    }
                });
            })
            .on('click', '[data-action=markAsNoShow]', function(event) {
                event.preventDefault();

                var $this = $(this),
                    appointmentId = $this.data('appointment-id'),
                    patientName = $this.data('patient-name'),
                    appointmentTime = $this.data('appointment-time')
                ;

                var box = bootbox.dialog({
                    message: 'Patient name: ' + patientName + '<br/>'
                    + 'Appointment time: ' + appointmentTime,
                    title: "You are going to mark this appointment as <b>No Show</b>",
                    buttons: {
                        cancel: {
                            label: "Cancel",
                            className: "btn-default"
                        },
                        confirm: {
                            label: "Confirm",
                            className: "btn-primary",
                            callback: function() {
                                var $form = $("#appointment-mark-as-no-show-" + appointmentId);
                                $form.submit();
                            }
                        }
                    }
                });
            })
            .on('click', '[data-action=reschedule]', function (event) {
                event.preventDefault();

                var $this = $(this);

                manaDrApplication.emit('modal/rescheduleAppointment/show', {
                    appointmentId: $this.data('appointment-id'),
                    appointmentTypeId: $this.data('appointment-type-id'),
                    appointmentTypeName: $this.data('appointment-type-name'),
                    appointmentTypeCategory: $this.data('appointment-type-category'),
                })
            })
        ;

        $('[name="sortOption"]')
            .on('change', function(event) {
                window.location.href = (new URI()).setQuery({
                    sortOption: $(this).val(),
                }).toString();
            })
        ;
    });
</script>
@endpush
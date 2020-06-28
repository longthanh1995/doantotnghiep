<script type="text/javascript">
    $(document).ready(function () {
        $(".btn-cancel-appointment").on('click', function (e) {
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
                        callback: function() {
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

            box.on("shown.bs.modal", function() {
                $('#cancelReasonTextArea').focus();
            });
        });

        $(".btn-visit-appointment").on('click', function (e) {
            e.preventDefault();

            var appointmentId = $(this).data('appointment-id');

            bootbox.confirm("Are you sure that the patient has already visited?", function(result) {
                if (result) {
                    var $form = $("#appointment-visit-" + appointmentId);

                    $form.submit();
                }
            });
        });

        $('#appointmentSection [data-toggle=tooltip]').tooltip();
    });
</script>
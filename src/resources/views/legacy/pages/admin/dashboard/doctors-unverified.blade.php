@extends('legacy.layouts.admin.application')

@section('pageTitle', 'Unverified Providers List')

@section('bodyClass', 'page-doctors page-doctors-index')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Unverified Providers</h3>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-hover" id="table_doctors">
                        <thead>
                        <tr>
                            <th>Provider Name</th>
                            <th>Phone number</th>
                            <th>Email</th>
                            <th>Invited By</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($doctors as $doctor)
                            <tr data-id="{{$doctor->id}}" data-name="{{$doctor->name}}">
                                <td>{{$doctor->name}}</td>
                                <td>{{$doctor->phone_country_code.$doctor->phone_number}}</td>
                                <td>{{$doctor->email}}</td>
                                <td>
                                    @if ($doctor->inviter)
                                        <a href="{{ route('admin.doctor.details', $doctor->inviter->id) }}">{{$doctor->inviter->name}}</a>
                                    @endif
                                </td>
                                <td>
                                    <span class="table-remove"><button type="button"
                                        class="btn btn-primary btn-rounded btn-sm my-0">Verify</button></span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop



<!----modal starts here--->
<div id="confirmModal" class="modal fade" role='dialog'>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Are you sure want to verify this Provider ?</h4>
        </div>
        <div class="modal-body">
            <p>Once a Provider is verified, that Provider will become a normal Provider and can be added to Clinic</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            <span id='confirmButton'></span>
        </div>
        
    </div>
    </div>
</div>
<!--Modal ends here--->


@push('scripts')
<script type="text/javascript">
    $(function(){

        $('#table_doctors').DataTable();
        $('#table_doctors').on('click', '.table-remove', function($event) {

            var $id = $(this).closest('tr').data('id');
            var $tr =  $(this);

            confirmFunction = function() {
                $('#confirmModal').modal('hide');

                $.ajax({
                    url: laroute.route('admin.doctor.verify', {doctor: $id}),
                    method: "POST",
                    data: $.param({id: $id}),
                    dataType: "json"
                })
                .done(function(response) {
                    alert("The provider " + response.name + " has been verified");
                    $tr.parents('tr').detach();
                })
                .fail(function(e, data) {
                    alert(e.responseJSON.message);
                })
            };

            $('#confirmModal').modal();
	        $('#confirmButton').html('<a class="btn btn-primary" onclick="confirmFunction()">Yes</a>');
            return;
        });
    })
</script>
@endpush
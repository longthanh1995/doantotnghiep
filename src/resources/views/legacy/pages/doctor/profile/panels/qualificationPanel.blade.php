<div class="panel panel-profile">
    <div class="panel-heading">
        <i class="fa fa-fw fa-medkit"></i>

        Qualification

        <div class="pull-right">
            <a href="#" class="btn-caret btn-trigger-edit" data-form="qualificationPanel">
                <i class="fa fa-fw fa-edit"></i> Edit
            </a>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="panel-body" id="qualificationPanel">
        @if (count($qualifications) > 0)
            <table class="table list-qualifications">
                <tbody>
                    @foreach ($qualifications as $qualification)
                        <tr id="doctor-qualification-{{ $qualification->id }}">
                            <td class="qualification-date-graduated" data-source="{{ $qualification->issued_time->format('Y') }}">
                                {{ $qualification->issued_time->format('Y') }}
                            </td>

                            <td class="qualification-info">
                                <div class="clearfix">
                                    <div class="pull-left">

                                    </div>

                                    <div class="pull-left">
                                        <div class="qualification-name" data-source="{{ $qualification->name }}">
                                            {{ $qualification->name }}
                                        </div>

                                        <div class="qualification-address" data-source="{{ $qualification->issuer }}">
                                            {{ $qualification->issuer }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="qualification-action text-right hide">
                                {!! Form::open(['route' => ['profile.qualification.destroy', $qualification->id], 'method' => 'DELETE']) !!}
                                    <button type="button" class="btn btn-primary btn-qualification-edit" data-id="{{ $qualification->id }}"><i class="fa fa-fw fa-edit"></i> Edit</button>
                                    <button type="button" class="btn btn-danger btn-qualification-delete"><i class="fa fa-fw fa-remove"></i> Delete</button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-warning" role="alert">
                <strong>Oh snap!</strong>

                There is no qualifications.
            </div>
        @endif

        <div class="hide">
            <hr />

            <h4>Create new record</h4>

            {!! Form::open(['route' => 'profile.qualification.store', 'class' => 'form-horizontal qualification-form-add', 'id' => 'qualificationForm']) !!}
                <div class="form-group @if ($errors->getBag('qualificationForm')->has('name')) has-error @endif">
                    {!! Form::label('name', 'Name', ['class' => 'col-sm-3 col-xs-12 control-label']) !!}

                    <div class="col-sm-9 col-xs-12">
                        {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}

                        @if ($errors->getBag('qualificationForm')->has('name'))
                            @foreach ($errors->getBag('qualificationForm')->get('name') as $error)
                                <p class="help-block">{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group @if ($errors->getBag('qualificationForm')->has('issuer')) has-error @endif">
                    {!! Form::label('issuer', 'Issuer', ['class' => 'col-sm-3 col-xs-12 control-label']) !!}

                    <div class="col-sm-9 col-xs-12">
                        {!! Form::text('issuer', old('issuer'), ['class' => 'form-control']) !!}

                        @if ($errors->getBag('qualificationForm')->has('issuer'))
                            @foreach ($errors->getBag('qualificationForm')->get('issuer') as $error)
                                <p class="help-block">{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group @if ($errors->getBag('qualificationForm')->has('issued_time')) has-error @endif">
                    {!! Form::label('issued_time', 'Issued Time', [
                        'class' => 'col-sm-3 col-xs-12 control-label'
                    ]) !!}

                    <div class="col-sm-9 col-xs-12">
                        {!! Form::selectYear('issued_time', 1971, date('Y'), old('issued_time', date('Y')), [
                            'class' => 'form-control'
                        ]) !!}

                        @if ($errors->getBag('qualificationForm')->has('issued_time'))
                            @foreach ($errors->getBag('qualificationForm')->get('issued_time') as $error)
                                <p class="help-block">{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group form-control-submit">
                    <div class="col-sm-9 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-primary">Save</button>

                        &nbsp; &nbsp;

                        <button type="button" class="btn btn-normal btn-form-cancel">Cancel</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('modals')
    <div class="modal fade" id="editQualificationModal" tabindex="-1" role="dialog" aria-labelledby="editQualificationModalLabel">
        <div class="modal-dialog" role="document">
            <form method="POST" class="form-horizontal qualification-form-edit">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="editQualificationModalLabel">Edit Qualifcation</h4>
                    </div>
    
                    <div class="modal-body">
                        {!! Form::token() !!}

                        <div class="form-group">
                            {!! Form::label('name', 'Name', ['class' => 'col-sm-3 col-xs-12 control-label']) !!}

                            <div class="col-sm-9 col-xs-12">
                                {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('issuer', 'Issuer', ['class' => 'col-sm-3 col-xs-12 control-label']) !!}

                            <div class="col-sm-9 col-xs-12">
                                {!! Form::text('issuer', old('issuer'), ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('issued_time', 'Issued Time', [
                                'class' => 'col-sm-3 col-xs-12 control-label'
                            ]) !!}

                            <div class="col-sm-9 col-xs-12">
                                {!! Form::selectYear('issued_time', 1971, date('Y'), old('issued_time', date('Y')), [
                                    'class' => 'form-control'
                                ]) !!}
                            </div>
                        </div>
                    </div>
    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endpush

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            @if ($errors->hasBag('qualificationForm'))
                openEditForm('qualificationPanel');
            @endif
        });
    </script>

    <script type="text/javascript">
        var qualificationValidate = {
            rules: {
                name: {
                    required: true,
                    minlength: 1,
                    maxlength: 32
                },

                issuer: {
                    required: true,
                    minlength: 1,
                    maxlength: 255
                },

                issued_time: {
                    required: true
                }
            },

            errorElement: "p",
            errorClass: "help-block",

            errorPlacement: function(error, element) {
                element.closest('div').append(error);
            },

            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },

            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            }
        };

        $(document).ready(function () {
            $(".qualification-form-add").validate(qualificationValidate);

            $(".btn-qualification-edit").on('click', function () {
                var id = $(this).data('id');
                var data = $("#doctor-qualification-" + id);

                var modal = $("#editQualificationModal");

                modal.on('shown.bs.modal', function () {
                    modal.find('[name="name"]').val(data.find('.qualification-name').data('source'));
                    modal.find('[name="issuer"]').val(data.find('.qualification-address').data('source'));
                    modal.find('[name="issued_time"]').val(data.find('.qualification-date-graduated').data('source'));

                    modal.find(".qualification-form-edit").attr('action', laroute.route('profile.qualification.update', {'doctorQualification': id})).validate(qualificationValidate);
                    modal.find('[name="name"]').focus();
                });

                modal.modal();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $(".btn-qualification-delete").on('click', function (e) {
                e.preventDefault();

                var $this = $(this);

                bootbox.confirm("Are you sure to delete this record?", function(result) {
                    if (result) {
                        $this.closest('form').submit();
                    }
                });
            });
        });
    </script>
@endpush
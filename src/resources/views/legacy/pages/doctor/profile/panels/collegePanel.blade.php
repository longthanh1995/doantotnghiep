<div class="panel panel-profile">
    <div class="panel-heading">
        <i class="fa fa-fw fa-suitcase"></i>

        College

        <div class="pull-right">
            <a href="#" class="btn-caret btn-trigger-edit" data-form="collegePanel">
                <i class="fa fa-fw fa-edit"></i> Edit
            </a>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="panel-body" id="collegePanel">
        @if (count($medicalSchools) > 0)
            <table class="table list-qualifications">
                <tbody>
                    @foreach ($medicalSchools as $medicalSchool)
                        <tr id="medical-school-{{ $medicalSchool->id }}">
                            <td class="qualification-date-graduated" data-graduation="{{ $medicalSchool->getGraduationDate() }}">
                                {{ $medicalSchool->getGraduationMonthYear() }}
                            </td>

                            <td class="qualification-info">
                                <div class="clearfix">
                                    <div class="pull-left">

                                    </div>

                                    <div class="pull-left">
                                        <div class="qualification-name" data-name="{{ $medicalSchool->name }}">
                                            {{ $medicalSchool->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="qualification-action text-right hide">
                                {!! Form::open(['route' => ['profile.college.destroy', $medicalSchool->id], 'method' => 'DELETE']) !!}
                                    <button type="button" class="btn btn-primary btn-college-edit" data-id="{{ $medicalSchool->id }}"><i class="fa fa-fw fa-edit"></i>Edit</button>

                                    &nbsp;&nbsp;

                                    <button type="button" class="btn btn-danger btn-college-delete"><i class="fa fa-fw fa-remove"></i>Delete</button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="mndr-show">
                <div class="alert alert-warning" role="alert">
                    <strong>Oh snap!</strong>

                    There is no medical schools.
                </div>
            </div>
        @endif

        <div class="hide">
            <hr />

            <h4>Create new record</h4>

            {!! Form::open(['route' => 'profile.college.store', 'class' => 'form-horizontal college-form-add', 'id' => 'collegeForm']) !!}
                <div class="form-group @if ($errors->getBag('collegeForm')->has('name')) has-error @endif">
                    {!! Form::label('name', 'School Name', ['class' => 'col-sm-3 col-xs-12 control-label']) !!}

                    <div class="col-sm-9 col-xs-12">
                        {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}

                        @if ($errors->getBag('collegeForm')->has('name'))
                            @foreach ($errors->getBag('collegeForm')->get('name') as $error)
                                <p class="help-block">{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group @if ($errors->getBag('collegeForm')->has('date_of_graduation')) has-error @endif">
                    {!! Form::label('date_of_graduation', 'Date of graduation', [
                        'class' => 'col-sm-3 col-xs-12 control-label',
                        'placeholder' => 'Click to pick a date'
                    ]) !!}

                    <div class="col-sm-9 col-xs-12">
                        {!! Form::text('date_of_graduation', old('date_of_graduation'), [
                            'class' => 'form-control',
                            'id' => 'date_of_graduation',
                            'readonly' => 'readonly',
                            'placeholder' => 'Click to pick a date'
                        ]) !!}

                        @if ($errors->getBag('collegeForm')->has('date_of_graduation'))
                            @foreach ($errors->getBag('collegeForm')->get('date_of_graduation') as $error)
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
    <div class="modal fade" id="editCollegeModal" tabindex="-1" role="dialog" aria-labelledby="editCollegeModalLabel">
        <div class="modal-dialog" role="document">
            <form method="POST" class="form-horizontal college-form-edit">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="editCollegeModalLabel">Edit College</h4>
                    </div>

                    <div class="modal-body">
                        {!! Form::token() !!}

                        <div class="form-group">
                            {!! Form::label('name', 'School Name', ['class' => 'col-sm-3 col-xs-12 control-label']) !!}

                            <div class="col-sm-9 col-xs-12">
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('date_of_graduation', 'Date of graduation', [
                                'class' => 'col-sm-3 col-xs-12 control-label',
                                'placeholder' => 'Click to pick a date'
                            ]) !!}

                            <div class="col-sm-9 col-xs-12">
                                {!! Form::text('date_of_graduation', null, [
                                    'class' => 'form-control',
                                    'id' => 'date_of_graduation',
                                    'readonly' => 'readonly',
                                    'placeholder' => 'Click to pick a date'
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
            @if ($errors->hasBag('collegeForm'))
                openEditForm('collegePanel');
            @endif
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $(".btn-college-delete").on('click', function (e) {
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

    <script type="text/javascript">
        var collegeValidate = {
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },

                date_of_graduation: {
                    required: true,
                    dateFormatDMY: true
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

        var dateOfGraduationConfig = {
            format: 'dd/mm/yyyy',
            weekStart: 1,
            minViewMode: "month",
            maxViewMode: "years",
            orientation: "bottom",
            disableTouchKeyboard: true,
            autoclose: true,
            defaultViewDate: {
                year: 2010,
                month: 0,
                day: 1
            },
            startView: "years",
            startDate: "01/01/1930"
        };

        $(document).ready(function () {
            $('#date_of_graduation').datepicker(dateOfGraduationConfig);
            $(".college-form-add").validate(collegeValidate);

            $(".btn-college-edit").on('click', function () {
                var id = $(this).data('id');
                var data = $("#medical-school-" + id);

                var modal = $("#editCollegeModal");

                modal.on('shown.bs.modal', function () {
                    modal.find('[name="name"]').val(data.find('.qualification-name').data('name'));
                    modal.find('[name="date_of_graduation"]').val(data.find('.qualification-date-graduated').data('graduation'));

                    modal.find('#date_of_graduation').datepicker(dateOfGraduationConfig);
                    modal.find(".college-form-edit").attr('action', laroute.route('profile.college.update', {'id': id})).validate(collegeValidate);
                    modal.find('[name="name"]').focus();
                });

                modal.modal();
            });
        });
    </script>
@endpush
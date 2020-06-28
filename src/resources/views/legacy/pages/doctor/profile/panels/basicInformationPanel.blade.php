<div class="panel panel-profile">
    <div class="panel-heading">
        <i class="fa fa-fw fa-user"></i> Basic Information

        <div class="pull-right">
            <a href="#" class="btn-caret btn-trigger-edit" data-form="basicInformationForm">
                <i class="fa fa-fw fa-edit"></i> Edit
            </a>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                {!! Form::open(['route' => 'profile.basicInformationSubmit', 'class' => 'form-horizontal', 'id' => 'basicInformationForm']) !!}
                    <div class="form-group @if ($errors->getBag('basicInformationForm')->has('title')) has-error @endif">
                        {!! Form::label('title', 'Title', ['class' => 'col-sm-3 col-xs-12 control-label']) !!}

                        <div class="col-sm-9 col-xs-12">
                            <p class="form-control-static">
                                @if ($authDoctor->doctor_title_id)
                                    {{ $titlesOption[$authDoctor->doctor_title_id] }}
                                @else
                                    <span class="text-danger">N/A</span>
                                @endif
                            </p>

                            {!! Form::select('title', $titlesOption, old('title', $authDoctor->doctor_title_id), ['class' => 'form-control hide']) !!}

                            @if ($errors->getBag('basicInformationForm')->has('title'))
                                @foreach ($errors->getBag('basicInformationForm')->get('title') as $error)
                                    <p class="help-block">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if ($errors->getBag('basicInformationForm')->has('name')) has-error @endif">
                        {!! Form::label('name', 'Full Name', ['class' => 'col-sm-3 col-xs-12 control-label']) !!}

                        <div class="col-sm-9 col-xs-12">
                            <p class="form-control-static">{{ $authDoctor->name }}</p>

                            <div class="input-group hide">
                                <div class="input-group-addon">Dr</div>

                                {!! Form::text('name', old('name', $authDoctor->name), ['class' => 'form-control']) !!}
                            </div>

                            @if ($errors->getBag('basicInformationForm')->has('name'))
                                @foreach ($errors->getBag('basicInformationForm')->get('name') as $error)
                                    <p class="help-block">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if ($errors->getBag('basicInformationForm')->has('date_of_birth')) has-error @endif">
                        {!! Form::label('date_of_birth', 'Date of Birth', ['class' => 'col-sm-3 col-xs-12 control-label']) !!}

                        <div class="col-sm-9 col-xs-12">
                            <?php $dateOfBirth = $authDoctor->date_of_birth ? $authDoctor->date_of_birth->format('d/m/Y') : '';?>

                            <p class="form-control-static">
                                @if ($dateOfBirth)
                                    {{ $dateOfBirth }}
                                @else
                                    <span class="text-danger">N/A</span>
                                @endif
                            </p>

                            {!! Form::text('date_of_birth', old('date_of_birth', $dateOfBirth), [
                                'class' => 'form-control hide datepicker',
                                'readonly' => 'readonly',
                                'placeholder' => 'Click to pick a date'
                            ]) !!}

                            @if ($errors->getBag('basicInformationForm')->has('date_of_birth'))
                                @foreach ($errors->getBag('basicInformationForm')->get('date_of_birth') as $error)
                                    <p class="help-block">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if ($errors->getBag('basicInformationForm')->has('gender')) has-error @endif">
                        {!! Form::label('gender', 'Gender', ['class' => 'col-sm-3 col-xs-12 control-label']) !!}

                        <div class="col-sm-9 col-xs-12">
                            <p class="form-control-static">
                                @if ($authDoctor->gender)
                                    {{ $gendersOption[$authDoctor->gender] }}
                                @else
                                    <span class="text-danger">N/A</span>
                                @endif
                            </p>

                            {!! Form::select('gender', $gendersOption, old('gender', $authDoctor->gender), ['class' => 'form-control hide']) !!}

                            @if ($errors->getBag('basicInformationForm')->has('gender'))
                                @foreach ($errors->getBag('basicInformationForm')->get('gender') as $error)
                                    <p class="help-block">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="languages" class="col-sm-3 col-xs-12 control-label">Languages</label>

                        <div class="col-sm-9 col-xs-12">
                            <p class="form-control-static">
                                @if (count($doctorLanguages) > 0)
                                    @foreach ($doctorLanguages as $language)
                                        <span>{{ $language->name }}</span> |
                                    @endforeach
                                @else
                                    <span class="text-danger">N/A</span>
                                @endif
                            </p>

                            <div class="hide">
                                <select name="languages[]" id="languages" class="form-control" style="width: 100%;">
                                    @foreach ($languagesOption as $languageKey => $languageName)
                                        <option value="{{ $languageKey }}" @if ($doctorLanguages->has($languageKey)) data-selected="selected" @endif>
                                            {{ $languageName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @if ($errors->getBag('basicInformationForm')->has('languages'))
                                @foreach ($errors->getBag('basicInformationForm')->get('languages') as $error)
                                    <p class="help-block">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('professions', 'Professions ID', ['class' => 'col-sm-3 col-xs-12 control-label']) !!}

                        <div class="col-sm-9 col-xs-12">
                            @if (count($doctorProfessions) > 0)
                                @foreach ($doctorProfessions as $doctorProfession)
                                    <p class="form-control-static">
                                        <span>
                                            <b>Name:</b> {{ $doctorProfession->name }}

                                            &nbsp; | &nbsp;

                                            <b>License No:</b> {{ $doctorProfession->license_no }}
                                        </span>
                                    </p>
                                @endforeach
                            @else
                                <p class="form-control-static">
                                    <span class="text-danger">N/A</span>
                                </p>
                            @endif

                            <div class="hide">
                                <table class="table table-bordered table-striped" id="professionTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>License</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $k = 0;?>

                                        @foreach ($doctorProfessions as $doctorProfession)
                                            <tr>
                                                <td>
                                                    {!! Form::text('professions['.$k.'][name]', $doctorProfession->name, ['class' => 'form-control hide']) !!}

                                                </td>

                                                <td>
                                                    {!! Form::text('professions['.$k.'][license]', $doctorProfession->license_no, ['class' => 'form-control hide']) !!}
                                                </td>

                                                <td class="v-middle text-center">
                                                    <a href="#" class="btn btn-xs btn-danger btn-remove-profession">
                                                        Remove
                                                    </a>
                                                </td>
                                            </tr>

                                            <?php $k++;?>
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td colspan="3">
                                                <a href="#" class="btn btn-sm btn-primary btn-add-profession">
                                                    <i class="fa fa-fw fa-plus"></i> Add
                                                </a>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-control-submit hide">
                        <div class="col-sm-9 col-xs-12 col-md-offset-3">
                            <br />

                            <button type="submit" class="btn btn-primary">Save</button>

                            &nbsp; &nbsp;

                            <button type="button" class="btn btn-normal btn-form-cancel">Cancel</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@push('scripts-template')
    <script id="addProfessionTemplate" type="x-tmpl-mustache">
        <tr>
            <td>
                <input type="text" class="form-control" name="professions[@{{ index }}][name]" placeholder="Name"/>
            </td>

            <td>
                <input type="text" class="form-control" name="professions[@{{ index }}][license]" placeholder="License"/>
            </td>

            <td class="v-middle text-center">
                <a href="#" class="btn btn-xs btn-danger btn-remove-profession">
                    Remove
                </a>
            </td>
        </tr>
    </script>
@endpush

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            @if ($errors->hasBag('basicInformationForm'))
                openEditForm('basicInformationForm');
            @endif
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                weekStart: 1,
                minViewMode: "month",
                maxViewMode: "years",
                orientation: "bottom",
                disableTouchKeyboard: true,
                autoclose: true,
                defaultViewDate: {
                    year: 1980,
                    month: 0,
                    day: 1
                },
                startView: "years",
                startDate: "01/01/1930",
                endDate: "01/01/2000"
            });

            var languagesDOM = $("#languages");

            languagesDOM.attr('multiple', 'multiple');
            languagesDOM.val([]);

            languagesDOM.find('[data-selected]').each(function () {
                var key = $(this).attr('value');
                var value = $(this).html();

                $(this).remove();
                languagesDOM.append($("<option></option>").attr("value", key).attr('selected', 'selected').text(value));
            });

            languagesDOM.select2({
                theme: "bootstrap"
            });
        });
    </script>

    <script type="text/javascript">
        var professionIndex = 1000;

        $(document).ready(function () {
            $("#professionTable")
                .on('click', ".btn-remove-profession", function (e) {
                    e.preventDefault();

                    var $this = $(this);

                    bootbox.confirm("Are you sure?", function(result) {
                        if (result) {
                            $this.closest('tr').remove();
                        }
                    });
                })
                .on('click', ".btn-add-profession", function (e) {
                    e.preventDefault();

                    var template = $("#addProfessionTemplate").html();
                    var rendered = Mustache.render(template, {
                        index: professionIndex
                    });

                    professionIndex ++;

                    $("#professionTable tbody").append(rendered);
                });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#basicInformationForm").validate({
                rules: {
                    title: {
                        required: true,
                    },

                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },

                    date_of_birth: {
                        required: true,
                        dateFormatDMY: true
                    },

                    gender: {
                        required: true
                    },

                    "languages[]": {
                        required: true,
                        minlength: 1
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
            });
        });
    </script>
@endpush
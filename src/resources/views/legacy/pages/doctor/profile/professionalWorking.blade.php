@extends('legacy.pages.doctor.profile.layout', ['childPage' => 'professionalWorking'])

@section('pageHeader')
    <h1>Professional Working</h1>
@stop

@section('childContent')
    <div class="panel panel-profile">
        <div class="panel-heading">
            <i class="fa fa-fw fa-hospital-o"></i>

            Professional Working
        </div>

        <div class="panel-body">
            @if (count($doctorClinics) > 0)
                <table class="table list-clinics">
                    <tbody>
                        @foreach ($doctorClinics as $clinic)
                            <tr class="clearfix clinic-row">
                                <td class="clinic-image hidden-xs">
                                    @if (count($clinic->images) > 0)
                                        <a href="{{ $clinic->images->first()->getThumbnailUrl() }}" target="_blank">
                                            <img src="{{ $clinic->images->first()->getThumbnailUrl() }}" width="140" height="140"/>
                                        </a>
                                    @endif
                                </td>

                                <td class="clinic-info-section">
                                    <div class="clinic-name">
                                        {{ $clinic->name }}
                                    </div>

                                    <div class="clinic-info">
                                        <div class="clinic-address">
                                            <i class="fa fa-fw fa-map-marker"></i>

                                            {{ $clinic->address }}
                                        </div>

                                        <div class="clinic-phone-number">
                                            <i class="fa fa-fw fa-phone"></i>

                                            ({{ $clinic->phone_country_code }}) {{ $clinic->phone_number }}
                                        </div>

                                        <div class="clinic-email">
                                            <i class="fa fa-fw fa-mail-forward"></i>

                                            {{ $clinic->email }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-warning" role="alert">
                    <strong>Oh snap!</strong>

                    There is no clinic.
                </div>
            @endif
        </div>
    </div>

    <div class="panel panel-profile">
        <div class="panel-heading">
            <i class="fa fa-fw fa-stethoscope"></i>

            Specialities

            <div class="pull-right">
                <a href="#" class="btn-caret btn-trigger-edit" data-form="specialityForm">
                    <i class="fa fa-fw fa-edit"></i> Edit
                </a>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            @if (count($doctorClinics) > 0)
                {!! Form::open(['route' => ['profile.specialitySubmit'], 'id' => 'specialityForm']) !!}
                    <div class="row list-specialities mndr-show">
                        @foreach ($doctorClinics as $clinic)
                            <div class="col-md-6 speciality-row">
                                <div class="speciality-heading">
                                    {{ $clinic->name }}
                                </div>

                                <div class="row speciality-conditions">
                                    @foreach ($patientConditions as $condition)
                                        <div class="condition-row col-md-6">
                                            <i class="fa fa-fw fa-check"></i>

                                            {{ $condition->name }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="hide">
                        <div class="form-horizontal">
                            <div class="form-group @if ($errors->getBag('specialityForm')->has('conditions')) has-error @endif">
                                <label for="conditions" class="col-sm-3 col-xs-12 control-label">Conditions</label>

                                <div class="col-sm-9 col-xs-12">
                                    <select name="conditions[]" id="conditions" class="form-control" style="width: 100%;">
                                        @foreach ($patientConditionOptions as $conditionKey => $conditionName)
                                            <option value="{{ $conditionKey }}" @if ($patientConditions->has($conditionKey)) data-selected="selected" @endif>
                                                {{ $conditionName }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->getBag('specialityForm')->has('conditions'))
                                        @foreach ($errors->getBag('specialityForm')->get('conditions') as $error)
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
                        </div>
                    </div>
                {!! Form::close() !!}
            @else
                <div class="alert alert-warning" role="alert">
                    <strong>Oh snap!</strong>

                    There is no specialities.
                </div>
            @endif
        </div>
    </div>
@stop

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            @if ($errors->hasBag('specialityForm'))
                openEditForm('specialityForm');
            @endif
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            var conditionsDOM = $("#conditions");

            conditionsDOM.attr('multiple', 'multiple');
            conditionsDOM.val([]);

            conditionsDOM.find('[data-selected]').each(function () {
                var key = $(this).attr('value');
                var value = $(this).html();

                $(this).remove();
                conditionsDOM.append($("<option></option>").attr("value", key).attr('selected', 'selected').text(value));
            });

            conditionsDOM.select2({
                theme: "bootstrap"
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#specialityForm").validate({
                rules: {
                    "conditions[]": {
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
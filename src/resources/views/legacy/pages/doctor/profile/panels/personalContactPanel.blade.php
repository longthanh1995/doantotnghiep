<div class="panel panel-profile">
    <div class="panel-heading">
        <i class="fa fa-fw fa-info-circle"></i> Personal Contact

        <div class="pull-right">
            <a href="#" class="btn-caret btn-trigger-edit" data-form="personalContactForm">
                <i class="fa fa-fw fa-edit"></i> Edit
            </a>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                {!! Form::open(['route' => 'profile.personalContactSubmit', 'class' => 'form-horizontal', 'id' => 'personalContactForm']) !!}
                    <div class="form-group @if ($errors->getBag('personalContactForm')->has('phone_country_code') || $errors->getBag('personalContactForm')->has('phone_number')) has-error @endif">
                        {!! Form::label('phone_country_code', 'Phone Number', ['class' => 'col-sm-3 col-xs-12 control-label']) !!}

                        <div class="col-sm-9 col-xs-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="form-control-static">
                                        @if (isset($phoneCountriesOption[$authDoctor->phone_country_code]))
                                            {{ $phoneCountriesOption[$authDoctor->phone_country_code] }}
                                        @else
                                            <span class="text-danger">N/A</span>
                                        @endif
                                    </p>

                                    {!! Form::select('phone_country_code', $phoneCountriesOption, old('phone_country_code', $authDoctor->phone_country_code), [
                                        'class' => 'form-control hide'
                                    ]) !!}

                                    @if ($errors->getBag('personalContactForm')->has('phone_country_code'))
                                        @foreach ($errors->getBag('personalContactForm')->get('phone_number') as $error)
                                            <p class="help-block">{{ $error }}</p>
                                        @endforeach
                                    @endif
                                </div>

                                <div class="visible-sm-block visible-xs-block clearfix">
                                    <br />
                                </div>

                                <div class="col-md-6">
                                    <p class="form-control-static">{{ $authDoctor->phone_number }}</p>

                                    {!! Form::text('phone_number', old('phone_number', $authDoctor->phone_number), [
                                        'class' => 'form-control hide'
                                    ]) !!}

                                    @if ($errors->getBag('personalContactForm')->has('phone_country_code'))
                                        @foreach ($errors->getBag('personalContactForm')->get('phone_number') as $error)
                                            <p class="help-block">{{ $error }}</p>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group @if ($errors->getBag('personalContactForm')->has('email')) has-error @endif">
                        {!! Form::label('email', 'Email', ['class' => 'col-sm-3 col-xs-12 control-label']) !!}

                        <div class="col-sm-9 col-xs-12">
                            <p class="form-control-static">{{ $authDoctor->email }}</p>

                            {!! Form::email('email', old('email', $authDoctor->email), ['class' => 'form-control hide']) !!}

                            @if ($errors->getBag('personalContactForm')->has('email'))
                                @foreach ($errors->getBag('personalContactForm')->get('email') as $error)
                                    <p class="help-block">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if ($errors->getBag('personalContactForm')->has('website')) has-error @endif">
                        {!! Form::label('website', 'Website', ['class' => 'col-sm-3 col-xs-12 control-label']) !!}

                        <div class="col-sm-9 col-xs-12">
                            <p class="form-control-static">
                                @if ($authDoctor->website)
                                    {{ $authDoctor->website }}
                                @else
                                    <span class="text-danger">N/A</span>
                                @endif
                            </p>

                            {!! Form::text('website', old('website', $authDoctor->website), ['class' => 'form-control hide']) !!}

                            @if ($errors->getBag('personalContactForm')->has('website'))
                                @foreach ($errors->getBag('personalContactForm')->get('website') as $error)
                                    <p class="help-block">{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if ($errors->getBag('personalContactForm')->has('address')) has-error @endif">
                        {!! Form::label('address', 'Address', ['class' => 'col-sm-3 col-xs-12 control-label']) !!}

                        <div class="col-sm-9 col-xs-12">
                            <p class="form-control-static">
                                @if ($authDoctor->address)
                                    {{ $authDoctor->address }}
                                @else
                                    <span class="text-danger">N/A</span>
                                @endif
                            </p>

                            {!! Form::text('address', old('address', $authDoctor->address), ['class' => 'form-control hide']) !!}

                            @if ($errors->getBag('personalContactForm')->has('address'))
                                @foreach ($errors->getBag('personalContactForm')->get('address') as $error)
                                    <p class="help-block">{{ $error }}</p>
                                @endforeach
                            @endif
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

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            @if ($errors->hasBag('personalContactForm'))
                openEditForm('personalContactForm');
            @endif
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#personalContactForm").validate({
                rules: {
                    phone_number: {
                        required: true,
                        minlength: 4,
                        maxlength: 15
                    },

                    email: {
                        required: true,
                        email: true
                    },

                    website: {
                        url: true
                    },

                    address: {
                        required: true,
                        minlength: 6,
                        maxlength: 255
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